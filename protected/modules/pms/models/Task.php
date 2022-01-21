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
use PhpParser\Node\Expr\Print_;

/**
 * This is the model class for table "tbl_pms_task".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $project_id
 * @property string $start_date
 * @property string $end_date
 * @property string $image_file
 * @property integer $type_id
 * @property integer $state_id
 * @property string $created_on
 * @property integer $created_by_id === Related data ===
 * @property User $createdBy
 * @property Project $project
 */
class Task extends \app\components\TActiveRecord
{

    public function __toString()
    {
        return (string) $this->title;
    }

    const PROGRESS_MIN = 0;

    const PROGRESS_MAX = 100;

    public static function getProjectOptions()
    {
        return self::listData(Project::find()->all());
    }

    public static function getTypeOptions()
    {
        return [
            "High",
            "Medium",
            "Low"
        ];
    }

    public function getType()
    {
        $list = self::getTypeOptions();
        return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';
    }

    const STATE_NSY = 0;

    const STATE_INPROGRESS = 1;

    const STATE_COMPLETED = 2;

    const STATE_HOLD = 4;

    const STATE_OVERDUE = 5;

    public static function getStateOptions()
    {
        return [
            self::STATE_NSY => Yii::t('app', "Not Started"),
            self::STATE_INPROGRESS => Yii::t('app', "Inprogress"),
            self::STATE_COMPLETED => Yii::t('app', "Completed"),
            self::STATE_HOLD => Yii::t('app', "Hold"),
            self::STATE_OVERDUE => Yii::t('app', "Overdue")
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
            self::STATE_NSY => "secondary",
            self::STATE_INPROGRESS => "primary",
            self::STATE_COMPLETED => "success",
            self::STATE_HOLD => "warning",
            self::STATE_OVERDUE => "danger"
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
        return '{{%pms_task}}';
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
                    'amount',
                    'created_on',
                    'created_by_id'
                ],
                'required'
            ],
            [
                [
                    'description',
                    'notes'
                ],
                'string'
            ],
            [
                [
                    'project_id',
                    'progress_id',
                    'type_id',
                    'state_id',
                    'created_by_id',
                    'amount'
                ],
                'integer'
            ],
            [
                [
                    'start_date',
                    'end_date',
                    'created_on',
                    'amount',
                    'currency'
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
                    'image_file'
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
                    'image_file'
                ],
                'trim'
            ],
            [
                [
                    'image_file'
                ],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg,jpeg'
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
            'title' => Yii::t('app', 'Task'),
            'description' => Yii::t('app', 'Description'),
            'project_id' => Yii::t('app', 'Project'),
            'amount' => Yii::t('app', 'Budget'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'progress_id' => Yii::t('app', '% Complete'),
            'notes' => Yii::t('app', 'Notes'),
            'image_file' => Yii::t('app', 'Attachment'),
            'type_id' => Yii::t('app', 'Priority'),
            'state_id' => Yii::t('app', 'Status'),
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
        $json['description'] = $this->description;
        $json['project_id'] = $this->project_id;
        $json['amount'] = $this->amount;
        $json['start_date'] = $this->start_date;
        $json['end_date'] = $this->end_date;
        if (isset($this->image_file))
            $json['image_file'] = \Yii::$app->createAbsoluteUrl('task/download', array(
                'file' => $this->image_file
            ));
        $json['type_id'] = $this->type_id;
        $json['state_id'] = $this->state_id;
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
            $model->description = $faker->text;
            $model->project_id = 1;
            $model->amount = $faker->text(10);
            $model->start_date = \date('Y-m-d');
            $model->end_date = \date('Y-m-d');
            $model->image_file = $faker->text(10);
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

            $model->project_id = isset($item['project_id']) ? $item['project_id'] : 1;

            $model->amount = isset($item['amount']) ? $item['amount'] : $faker->text(10);

            $model->start_date = isset($item['start_date']) ? $item['start_date'] : \date('Y-m-d');

            $model->end_date = isset($item['end_date']) ? $item['end_date'] : \date('Y-m-d');

            $model->image_file = isset($item['image_file']) ? $item['image_file'] : $faker->text(10);

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

    public function getDays()
    {
        $start_date = strtotime($this->start_date);
        $end_date = strtotime($this->end_date);
        $dates = abs($end_date - $start_date);
        $numberDays = $dates / 86400;
        return $numberDays;
    }

    public function getProgressContext()
    {
        $per = $this->progress_id;
        if (date('Y-m-d') >= $this->end_date && $per >= Task::PROGRESS_MIN && $per < Task::PROGRESS_MAX) {
            return Task::STATE_OVERDUE;
        }
        if ($per >= Task::PROGRESS_MAX) {
            $this->state_id = Task::STATE_COMPLETED;
            $context = $this->state_id;
        } elseif ($per > Task::PROGRESS_MIN && $per < Task::PROGRESS_MAX) {
            $this->state_id = Task::STATE_INPROGRESS;
            $context = $this->state_id;
        } else {
            $this->state_id = Task::STATE_NSY;
            $context = $this->state_id;
        }
        return $context;
    }

    public static function getTaskSum()
    {
        $task = self::find()->where([
            'project_id' => Yii::$app->request->queryParams['id']
        ]);
        if (! User::isAdmin()) {
            $task = $task->andWhere([
                'created_by_id' => yii::$app->user->id
            ]);
        }
        $taskModel = $task->sum('amount');
        $model = $task->one();
        if (! empty($model->project)) {
            $result = $model->project->currency . ($taskModel);
        } else {
            $result = $taskModel;
        }
        return $result;
    }
}
