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
 * This is the model class for table "tbl_pms_project".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $manager_name
 * @property string $client_name
 * @property string $start_date
 * @property string $end_date
 * @property integer $type_id
 * @property integer $state_id
 * @property string $created_on
 * @property integer $created_by_id === Related data ===
 * @property CapexBudget[] $capexBudgets
 * @property User $createdBy
 * @property Deliverable[] $deliverables
 * @property Finance[] $finances
 * @property User $manager
 * @property Milestone[] $milestones
 * @property OpexBudget[] $opexBudgets
 * @property RiskMatrix[] $riskMatrices
 */
class Project extends \app\components\TActiveRecord
{

    public function __toString()
    {
        return (string) $this->title;
    }

    public static function getManagerOptions()
    {
        return ArrayHelper::Map(User::findActive()->all(), 'id', 'full_name');
    }

    public static function getTypeOptions()
    {
        return [
            Yii::t('app', "Education"),
            Yii::t('app', "Investment"),
            Yii::t('app', "Project Execution")
        ];
    }

    public function getType()
    {
        $list = self::getTypeOptions();
        return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';
    }

    const STATE_PLANNING = 0;

    const STATE_COMPLETED = 1;

    const STATE_INPROGRESS = 2;

    public static function getStateOptions()
    {
        return [
            self::STATE_PLANNING => Yii::t('app', "Planning"),
            self::STATE_COMPLETED => Yii::t('app', "Completed"),
            self::STATE_INPROGRESS => Yii::t('app', "Inprogress")
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
            self::STATE_PLANNING => "success",
            self::STATE_COMPLETED => "success",
            self::STATE_INPROGRESS => "primary"
        ];
        return isset($list[$this->state_id]) ? \yii\helpers\Html::tag('span', $this->getState(), [
            'class' => 'badge badge-' . $list[$this->state_id]
        ]) : 'Not Defined';
    }

    public static function getActionOptions()
    {
        return [
            self::STATE_PLANNING => "Deactivate",
            self::STATE_COMPLETED => "Activate",
            self::STATE_INPROGRESS => "Delete"
        ];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if (empty($this->start_date)) {
                $this->start_date = date('Y-m-d');
            }
            if (empty($this->end_date)) {
                $this->end_date = date('Y-m-d');
            }
            if (empty($this->created_on)) {
                $this->created_on = \date('Y-m-d H:i:s');
            }
            if (empty($this->created_by_id)) {
                $this->created_by_id = self::getCurrentUser();
            }
        } else {}
        return parent::beforeValidate();
    }

    public static function getTotalProjects()
    {
        $query = Project::find();
        if (User::isUser()) {
            $query = $query->andWhere([
                'created_by_id' => \Yii::$app->user->id
            ]);
        }

        return $query;
    }

    /**
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pms_project}}';
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
                    'created_on',
                    'created_by_id'
                ],
                'required'
            ],
            [
                [
                    'description'
                ],
                'string'
            ],
            [
                [
                    'type_id',
                    'state_id',
                    'created_by_id'
                ],
                'integer'
            ],
            [
                [
                    'start_date',
                    'end_date',
                    'created_on',
                    'currency'
                ],
                'safe'
            ],
            [
                [
                    'title',
                    'manager_name',
                    'client_name',
                    'currency'
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
                    'title',
                    'manager_name',
                    'client_name'
                ],
                'trim'
            ],
            [
                [
                    'type_id'
                ],
                'in',
                'range' => array_keys(self::getTypeOptions())
            ],
            [
                [
                    'state_id'
                ],
                'in',
                'range' => array_keys(self::getStateOptions())
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
            'title' => Yii::t('app', 'Project Name'),
            'description' => Yii::t('app', 'Description'),
            'manager_name' => Yii::t('app', 'Project Manager'),
            'client_name' => Yii::t('app', 'Client'),
            'start_date' => Yii::t('app', 'Planned Start Date'),
            'end_date' => Yii::t('app', 'Planned End Date'),
            'currency' => Yii::t('app', 'Currency'),
            'type_id' => Yii::t('app', 'Project Designation'),
            'state_id' => Yii::t('app', 'State'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by_id' => Yii::t('app', 'Created By')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCapexBudgets()
    {
        return $this->hasMany(CapexBudget::className(), [
            'project_id' => 'id'
        ]);
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
    public function getTasks()
    {
        return $this->hasMany(Task::className(), [
            'project_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeliverables()
    {
        return $this->hasMany(Deliverable::className(), [
            'project_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuccessCriteria()
    {
        return $this->hasMany(SuccessCriteria::className(), [
            'project_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRate()
    {
        return $this->hasOne(Rate::className(), [
            'project_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinances()
    {
        return $this->hasMany(Finance::className(), [
            'project_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMilestones()
    {
        return $this->hasMany(Milestone::className(), [
            'project_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpexBudgets()
    {
        return $this->hasMany(OpexBudget::className(), [
            'project_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRiskMatrices()
    {
        return $this->hasMany(RiskMatrix::className(), [
            'project_id' => 'id'
        ]);
    }

    public static function getHasManyRelations()
    {
        $relations = [];

        $relations['CapexBudgets'] = [
            'capexBudgets',
            'CapexBudget',
            'id',
            'project_id'
        ];
        $relations['Deliverables'] = [
            'deliverables',
            'Deliverable',
            'id',
            'project_id'
        ];
        $relations['Finances'] = [
            'finances',
            'Finance',
            'id',
            'project_id'
        ];
        $relations['Milestones'] = [
            'milestones',
            'Milestone',
            'id',
            'project_id'
        ];
        $relations['OpexBudgets'] = [
            'opexBudgets',
            'OpexBudget',
            'id',
            'project_id'
        ];
        $relations['RiskMatrices'] = [
            'riskMatrices',
            'RiskMatrix',
            'id',
            'project_id'
        ];
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
        return $relations;
    }

    public function beforeDelete()
    {
        if (! parent::beforeDelete()) {
            return false;
        }
        // TODO : start here
        Task::deleteRelatedAll([
            'project_id' => $this->id
        ]);
        CapexBudget::deleteRelatedAll([
            'project_id' => $this->id
        ]);
        Deliverable::deleteRelatedAll([
            'project_id' => $this->id
        ]);
        Finance::deleteRelatedAll([
            'project_id' => $this->id
        ]);
        Milestone::deleteRelatedAll([
            'project_id' => $this->id
        ]);
        OpexBudget::deleteRelatedAll([
            'project_id' => $this->id
        ]);
        RiskMatrix::deleteRelatedAll([
            'project_id' => $this->id
        ]);
        SuccessCriteria::deleteRelatedAll([
            'project_id' => $this->id
        ]);
        Rate::deleteRelatedAll([
            'project_id' => $this->id
        ]);
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
        $json['description'] = $this->description;
        $json['manager_name'] = $this->manager_name;
        $json['client_name'] = $this->client_name;
        $json['start_date'] = $this->start_date;
        $json['end_date'] = $this->end_date;
        $json['type_id'] = $this->type_id;
        $json['state_id'] = $this->state_id;
        $json['created_on'] = $this->created_on;
        $json['created_by_id'] = $this->created_by_id;
        if ($with_relations) {
            // capexBudgets
            $list = $this->capexBudgets;

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['capexBudgets'] = $relationData;
            } else {
                $json['capexBudgets'] = $list;
            }
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
            // deliverables
            $list = $this->deliverables;

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['deliverables'] = $relationData;
            } else {
                $json['deliverables'] = $list;
            }
            // finances
            $list = $this->finances;

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['finances'] = $relationData;
            } else {
                $json['finances'] = $list;
            }
            // manager
            $list = $this->manager;

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['manager'] = $relationData;
            } else {
                $json['manager'] = $list;
            }
            // milestones
            $list = $this->milestones;

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['milestones'] = $relationData;
            } else {
                $json['milestones'] = $list;
            }
            // opexBudgets
            $list = $this->opexBudgets;

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['opexBudgets'] = $relationData;
            } else {
                $json['opexBudgets'] = $list;
            }
            // riskMatrices
            $list = $this->riskMatrices;

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['riskMatrices'] = $relationData;
            } else {
                $json['riskMatrices'] = $list;
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
            $model->description = $faker->text;
            $model->manager_name = $faker->name;
            $model->client_name = $faker->name;
            $model->start_date = \date('Y-m-d');
            $model->end_date = \date('Y-m-d');
            $model->type_id = 0;
            $model->state_id = $states[rand(0, count($states))];
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

            $model->description = isset($item['description']) ? $item['description'] : $faker->text;

            $model->manager_name = isset($item['manager_name']) ? $item['manager_name'] : $faker->name;

            $model->client_name = isset($item['client_name']) ? $item['client_name'] : $faker->name;

            $model->start_date = isset($item['start_date']) ? $item['start_date'] : \date('Y-m-d');

            $model->end_date = isset($item['end_date']) ? $item['end_date'] : \date('Y-m-d');

            $model->type_id = isset($item['type_id']) ? $item['type_id'] : 0;
            $model->state_id = self::STATE_ACTIVE;
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

    public function getAverage()
    {
        $query = Task::find()->where([
            'project_id' => $this->id
        ]);
        if (! User::isAdmin()) {
            $query = $query->andWhere([
                'created_by_id' => yii::$app->user->id
            ]);
        }
        $avg_rate = $query->average('progress_id');
        return round($avg_rate, 2);
    }

    public function getProgressContext()
    {
        $per = $this->getAverage();
        switch ($per) {
            case $per >= 100:
                $context = 'progress-bar-success';
                break;
            case $per >= 40 && $per < 100:
                $context = 'progress-bar-primary';
                break;
            case $per > 0 && $per < 40:
                $context = 'progress-bar-warning';
                break;
            default:
                $context = 'progress-bar-danger';
                break;
        }
        return $context;
    }

    public static function getBudget($currency = true)
    {
        $task = Task::find()->where([
            'project_id' => Yii::$app->request->queryParams['id']
        ]);
        if (! User::isAdmin()) {
            $task = $task->andWhere([
                'created_by_id' => yii::$app->user->id
            ]);
        }
        $taskModel = $task->sum('amount');

        $opex = OpexBudget::find()->where([
            'project_id' => Yii::$app->request->queryParams['id']
        ]);
        if (! User::isAdmin()) {
            $opex = $opex->andWhere([
                'created_by_id' => yii::$app->user->id
            ]);
        }
        $opex = $opex->sum('amount');
        $model = $task->one();
        if ($currency && ! empty($model->project)) {
            $result = $model->project->currency . ($taskModel + $opex);
        } else {
            $result = $taskModel + $opex;
        }
        return $result;
    }

    public static function getTitle()
    {
        $project = Project::findOne(Yii::$app->request->queryParams['id']);
        if (! empty($project)) {
            return $project->title;
        }
    }
}
