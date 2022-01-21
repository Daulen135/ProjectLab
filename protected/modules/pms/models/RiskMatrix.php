<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author    : Shiv Charan Panjeta < shiv@toxsl.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 *
 */
namespace app\modules\pms\models;

use Yii;
use app\models\Feed;
use app\models\User;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_pms_risk_matrix".
 *
 * @property integer $id
 * @property string $title
 * @property integer $project_id
 * @property integer $severity
 * @property integer $impact
 * @property string $factor
 * @property integer $state_id
 * @property integer $type_id
 * @property string $created_on
 * @property integer $created_by_id === Related data ===
 * @property User $createdBy
 * @property Project $project
 */
class RiskMatrix extends \app\components\TActiveRecord
{

    public function __toString()
    {
        return (string) $this->title;
    }

    public static function getProjectOptions()
    {
        return self::listData(Project::find()->all());
    }

    const STATE_EXTREME = 0;

    const STATE_HIGH = 1;

    const STATE_MODERATE = 2;

    const STATE_LOW = 3;

    public static function getStateOptions()
    {
        return [
            self::STATE_EXTREME => Yii::t('app', "Extreme"),
            self::STATE_HIGH => Yii::t('app', "High"),
            self::STATE_MODERATE => Yii::t('app', "Moderate"),
            self::STATE_LOW => Yii::t('app', "Low")
        ];
    }

    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }

    public function getStateBadge()
    {
        $list = [
            self::STATE_EXTREME => "danger",
            self::STATE_HIGH => "primary",
            self::STATE_MODERATE => "warning",
            self::STATE_LOW => "success"
        ];
        return isset($list[$this->state_id]) ? \yii\helpers\Html::tag('span', $this->getState(), [
            'class' => 'badge badge-' . $list[$this->state_id]
        ]) : 'Not Defined';
    }

    public static function getActionOptions()
    {
        return [
            self::STATE_EXTREME => Yii::t('app', "Extreme"),
            self::STATE_HIGH => Yii::t('app', "High"),
            self::STATE_MODERATE => Yii::t('app', "Moderate"),
            self::STATE_LOW => Yii::t('app', "Low")
        ];
    }

    public static function getTypeOptions()
    {
        return [
            "TYPE1",
            "TYPE2",
            "TYPE3"
        ];
    }

    public function getType()
    {
        $list = self::getTypeOptions();
        return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';
    }

    const ALMOST_CERTAIN = 0;

    const LIKELY = 1;

    const MODERATE = 2;

    const UNLIKELY = 3;

    const RARE = 4;

    public static function getSeverityOptions()
    {
        return [
            self::ALMOST_CERTAIN => Yii::t('app', 'Almost Certain'),
            self::LIKELY => Yii::t('app', "Likely"),
            self::MODERATE => Yii::t('app', "Moderate"),
            self::UNLIKELY => Yii::t('app', "Unlikely"),
            self::RARE => Yii::t('app', "Rare")
        ];
    }

    public function getSeverity()
    {
        $list = self::getSeverityOptions();
        return isset($list[$this->severity]) ? $list[$this->severity] : 'Not Defined';
    }

    const IMPACT_INSIGNIFICANT = 0;

    const IMPACT_MINOR = 1;

    const IMPACT_MODERATE = 2;

    const IMPACT_MAJOR = 3;

    const IMPACT_CATASTROPHIC = 4;

    public static function getImpactOptions()
    {
        return [
            self::IMPACT_INSIGNIFICANT => Yii::t('app', "Insignificant"),
            self::IMPACT_MINOR => Yii::t('app', "Minor"),
            self::IMPACT_MODERATE => Yii::t('app', "Moderate"),
            self::IMPACT_MAJOR => Yii::t('app', "Major"),
            self::IMPACT_CATASTROPHIC => Yii::t('app', "Catastrophic")
        ];
    }

    public function getImpact()
    {
        $list = self::getImpactOptions();
        return isset($list[$this->impact]) ? $list[$this->impact] : 'Not Defined';
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if (empty($this->created_on)) {
                $this->created_on = \date('Y-m-d H:i:s');
            }
            if (empty($this->created_by_id)) {
                $this->created_by_id = self::getCurrentUser();
            }
        } else {}
        return parent::beforeValidate();
    }

    /**
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pms_risk_matrix}}';
    }

    /**
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'title',
                    'project_id',
                    'severity',
                    'impact',
                    // 'factor',
                    'created_on',
                    'created_by_id'
                ],
                'required'
            ],
            [
                [
                    'project_id',
                    'severity',
                    'impact',
                    'state_id',
                    'type_id',
                    'created_by_id'
                ],
                'integer'
            ],
            [
                [
                    'created_on'
                ],
                'safe'
            ],
            [
                [
                    'title',
                    'factor'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'created_by_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => [
                    'created_by_id' => 'id'
                ]
            ],
            [
                [
                    'project_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Project::className(),
                'targetAttribute' => [
                    'project_id' => 'id'
                ]
            ],
            [
                [
                    'title',
                    'factor'
                ],
                'trim'
            ],
            [
                [
                    'state_id'
                ],
                'in',
                'range' => array_keys(self::getStateOptions())
            ],
            [
                [
                    'type_id'
                ],
                'in',
                'range' => array_keys(self::getTypeOptions())
            ]
        ];
    }

    /**
     *
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Risk Description'),
            'project_id' => Yii::t('app', 'Project'),
            'severity' => Yii::t('app', 'Likelihood'),
            'impact' => Yii::t('app', 'Consequense'),
            'factor' => Yii::t('app', 'Factor'),
            'state_id' => Yii::t('app', 'Risk Status'),
            'type_id' => Yii::t('app', 'Type'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by_id' => Yii::t('app', 'Created By')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), [
            'id' => 'created_by_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), [
            'id' => 'project_id'
        ]);
    }

    public static function getHasManyRelations()
    {
        $relations = [];

        $relations['feeds'] = [
            'feeds',
            'Feed',
            'model_id'
        ];
        return $relations;
    }

    public static function getHasOneRelations()
    {
        $relations = [];
        $relations['created_by_id'] = [
            'createdBy',
            'User',
            'id'
        ];
        $relations['project_id'] = [
            'project',
            'Project',
            'id'
        ];
        return $relations;
    }

    public function beforeDelete()
    {
        if (! parent::beforeDelete()) {
            return false;
        }
        // TODO : start here
        return true;
    }

    public function beforeSave($insert)
    {
        if (! parent::beforeSave($insert)) {
            return false;
        }
        // TODO : start here

        return true;
    }

    public function asJson($with_relations = false)
    {
        $json = [];
        $json['id'] = $this->id;
        $json['title'] = $this->title;
        $json['project_id'] = $this->project_id;
        $json['severity'] = $this->severity;
        $json['impact'] = $this->impact;
        $json['factor'] = $this->factor;
        $json['state_id'] = $this->state_id;
        $json['type_id'] = $this->type_id;
        $json['created_on'] = $this->created_on;
        $json['created_by_id'] = $this->created_by_id;
        if ($with_relations) {
            // createdBy
            $list = $this->createdBy;

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['createdBy'] = $relationData;
            } else {
                $json['createdBy'] = $list;
            }
            // project
            $list = $this->project;

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['project'] = $relationData;
            } else {
                $json['project'] = $list;
            }
        }
        return $json;
    }

    public function getControllerID()
    {
        return '/pms/' . parent::getControllerID();
    }

    public static function addTestData($count = 1)
    {
        $faker = \Faker\Factory::create();
        $states = array_keys(self::getStateOptions());
        for ($i = 0; $i < $count; $i ++) {
            $model = new self();
            $model->loadDefaultValues();
            $model->title = $faker->text(10);
            $model->project_id = 1;
            $model->severity = $faker->text(10);
            $model->impact = $faker->text(10);
            $model->factor = $faker->text(10);
            $model->state_id = $states[rand(0, count($states))];
            $model->type_id = 0;
            $model->save();
        }
    }

    public static function addData($data)
    {
        if (self::find()->count() != 0) {
            return;
        }

        $faker = \Faker\Factory::create();
        foreach ($data as $item) {
            $model = new self();
            $model->loadDefaultValues();

            $model->title = isset($item['title']) ? $item['title'] : $faker->text(10);

            $model->project_id = isset($item['project_id']) ? $item['project_id'] : 1;

            $model->severity = isset($item['severity']) ? $item['severity'] : $faker->text(10);

            $model->impact = isset($item['impact']) ? $item['impact'] : $faker->text(10);

            $model->factor = isset($item['factor']) ? $item['factor'] : $faker->text(10);
            $model->state_id = self::STATE_ACTIVE;

            $model->type_id = isset($item['type_id']) ? $item['type_id'] : 0;
            $model->save();
        }
    }

    public function isAllowed()
    {
        if (User::isAdmin())
            return true;
        if ($this->hasAttribute('created_by_id') && $this->created_by_id == Yii::$app->user->id) {
            return true;
        }

        return User::isUser();
    }

    public function afterSave($insert, $changedAttributes)
    {
        return parent::afterSave($insert, $changedAttributes);
    }

    public function getRiskStatus()
    {
        if (($this->severity == self::ALMOST_CERTAIN && ($this->impact == self::IMPACT_INSIGNIFICANT || $this->impact == self::IMPACT_MINOR)) || ($this->severity == self::LIKELY && ($this->impact == self::IMPACT_MINOR || $this->impact == self::IMPACT_MODERATE)) || ($this->severity == self::MODERATE && $this->impact == self::IMPACT_MODERATE) || ($this->severity == self::UNLIKELY && $this->impact == self::IMPACT_MAJOR) || ($this->severity == self::RARE && ($this->impact == self::IMPACT_MAJOR || $this->impact == self::IMPACT_CATASTROPHIC))) {
            return self::STATE_HIGH;
        } else if (($this->severity == self::ALMOST_CERTAIN && ($this->impact == self::IMPACT_MODERATE || $this->impact == self::IMPACT_MAJOR || $this->impact == self::IMPACT_CATASTROPHIC)) || ($this->severity == self::LIKELY && ($this->impact == self::IMPACT_MAJOR || $this->impact == self::IMPACT_CATASTROPHIC)) || ($this->severity == self::MODERATE && ($this->impact == self::IMPACT_MAJOR || $this->impact == self::IMPACT_CATASTROPHIC)) || ($this->severity == self::UNLIKELY && $this->impact == self::IMPACT_CATASTROPHIC)) {
            return self::STATE_EXTREME;
        } else if (($this->severity == self::LIKELY && $this->impact == self::IMPACT_INSIGNIFICANT) || ($this->severity == self::MODERATE && $this->impact == self::IMPACT_MINOR) || ($this->severity == self::UNLIKELY && $this->impact == self::IMPACT_MODERATE) || ($this->severity == self::RARE && ($this->impact == self::IMPACT_MODERATE))) {
            return self::STATE_MODERATE;
        } else if (($this->severity == self::MODERATE && $this->impact == self::IMPACT_INSIGNIFICANT) || ($this->severity == self::UNLIKELY && ($this->impact == self::IMPACT_INSIGNIFICANT || $this->impact == self::IMPACT_MINOR)) || ($this->severity == self::RARE && ($this->impact == self::IMPACT_INSIGNIFICANT || $this->impact == self::IMPACT_MINOR))) {
            return self::STATE_LOW;
        }
    }
}
