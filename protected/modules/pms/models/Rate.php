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
 * This is the model class for table "tbl_pms_rate".
 *
 * @property integer $id
 * @property string $title
 * @property integer $project_id
 * @property string $rate
 * @property integer $state_id
 * @property integer $type_id
 * @property string $created_on
 * @property integer $created_by_id === Related data ===
 * @property User $createdBy
 * @property Project $project
 */
class Rate extends \app\components\TActiveRecord
{

    public function __toString()
    {
        return (string) $this->title;
    }

    public static function getProjectOptions()
    {
        return [
            "TYPE1",
            "TYPE2",
            "TYPE3"
        ];
        // return self::listData ( Project::findActive ()->all () );
    }

    const STATE_INACTIVE = 0;

    const STATE_ACTIVE = 1;

    const STATE_DELETED = 2;

    public static function getStateOptions()
    {
        return [
            self::STATE_INACTIVE => "New",
            self::STATE_ACTIVE => "Active",
            self::STATE_DELETED => "Deleted"
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
            self::STATE_INACTIVE => "secondary",
            self::STATE_ACTIVE => "success",
            self::STATE_DELETED => "danger"
        ];
        return isset($list[$this->state_id]) ? \yii\helpers\Html::tag('span', $this->getState(), [
            'class' => 'badge badge-' . $list[$this->state_id]
        ]) : 'Not Defined';
    }

    public static function getActionOptions()
    {
        return [
            self::STATE_INACTIVE => "Deactivate",
            self::STATE_ACTIVE => "Activate",
            self::STATE_DELETED => "Delete"
        ];
    }

    const TYPE_YEAR = 1;
    
    const TYPE_MONTH = 12;
    
    const TYPE_DAYS = 365;
    
    public static function getTypeOptions()
    {
        return [
            self::TYPE_YEAR => "Year",
            self::TYPE_MONTH => "Month",
            self::TYPE_DAYS => "Days"
        ];
    }

    public function getType()
    {
        $list = self::getTypeOptions();
        return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';
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
        return '{{%pms_rate}}';
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
                    'project_id',
                    'rate',
                    'created_on',
                    'created_by_id'
                ],
                'required'
            ],
            [
                [
                    'project_id',
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
                    'title'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'rate'
                ],
                'string',
                'max' => 255
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
                    'rate'
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
            'title' => Yii::t('app', 'Title'),
            'project_id' => Yii::t('app', 'Project'),
            'rate' => Yii::t('app', 'Rate'),
            'state_id' => Yii::t('app', 'State'),
            'type_id' => Yii::t('app', 'Period'),
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
        $json['rate'] = $this->rate;
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
            $model->rate = $faker->text(10);
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

            $model->rate = isset($item['rate']) ? $item['rate'] : $faker->text(10);
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
}
