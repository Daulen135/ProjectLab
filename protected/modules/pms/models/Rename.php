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
 * This is the model class for table "tbl_rename".
 *
 * @property integer $id
 * @property string $title
 * @property string $type_id
 * @property integer $state_id
 * @property integer $created_by_id
 * @property string $created_on
 */
class Rename extends \app\components\TActiveRecord
{

    public function __toString()
    {
        return (string) $this->title;
    }

    public static function getTypeOptions()
    {
        return [
            self::TYPE_PROJECT_NAME => Yii::t('app', "Project Name"),

            self::TYPE_CLIENT => Yii::t('app', "Client"),

            self::TYPE_PROJECT_MANAGER => Yii::t('app', "Project Manager"),

            self::TYPE_PROJECT_DESIGNATION => Yii::t('app', "Project Designation"),

            self::TYPE_PLANNED_START_DATE => Yii::t('app', "Planned Start Date"),

            self::TYPE_PLANNED_END_DATE => Yii::t('app', "Planned End Date"),

            self::TYPE_CURRENCY => Yii::t('app', "Currency"),

            self::TYPE_CREATED_BY => Yii::t('app', "Created By"),

            self::TYPE_PROJECT_DESCRIPTION => Yii::t('app', 'Project Description'),

            self::TYPE_SUCCESS_CRITERIA => Yii::t('app', "Success Criteria"),

            self::TYPE_MILESTONE => Yii::t('app', "Project Milestone"),

            self::TYPE_END_DATE => Yii::t('app', "End Date"),

            self::TYPE_PROJECT_DELIVERABLES => Yii::t('app', "Project Deliverables"),

            self::TYPE_TASK => Yii::t('app', "Task"),

            self::TYPE_BUDGET => Yii::t('app', "Budget"),

            self::TYPE_RISK => Yii::t('app', "Risk Description"),

            self::TYPE_LIKE => Yii::t('app', "Likelihood"),

            self::TYPE_CONSE => Yii::t('app', "Consequense"),

            self::TYPE_STATUS => Yii::t('app', "Risk Status"),

            self::TYPE_PROJECT_START_DATE => Yii::t('app', "Project Start Date"),

            self::TYPE_PROJECT_COMPLETION_DATE => Yii::t('app', "Project Completion Date"),

            self::TYPE_PROJECT_OVERALL => Yii::t('app', "Overall Project"),

            self::TYPE_INCOME => Yii::t('app', "Income"),

            self::TYPE_OPEX => Yii::t('app', "Opex"),

            self::TYPE_PERIOD => Yii::t('app', "T(Period)"),

            self::TYPE_REPORT => Yii::t('app', "Report Name"),

            self::TYPE_PDF => Yii::t('app', "PDF"),

            self::TYPE_PRINT => Yii::t('app', "Print"),

            self::TYPE_CALCULATION => Yii::t('app', "Calculation"),

            self::TYPE_CF => Yii::t('app', "CF"),

            self::TYPE_Actions => Yii::t('app', "Actions"),

            self::TYPE_NPV => Yii::t('app', "NPV"),

            self::TYPE_TASK_TITLE => Yii::t('app', "Task Title"),

            self::TYPE_START_DATE => Yii::t('app', "Start Date"),

            self::TYPE_DURATION => Yii::t('app', "Duration"),

            self::TYPE_COMPLETE => Yii::t('app', "% Complete"),

            self::TYPE_PROJECT_STATUS => Yii::t('app', "Status"),

            self::TYPE_NOTES => Yii::t('app', "Notes"),

            self::TYPE_CAPEX => Yii::t('app', "CAPEX"),

            self::TYPE_CAPEX_PER_TASK => Yii::t('app', "CAPEX per task"),

            self::TYPE_TOTAL => Yii::t('app', "Total"),

            self::TYPE_PROJECT_EXPENSE => Yii::t('app', "Project Expense"),

            self::TYPE_GENERAL_EXPENSE => Yii::t('app', "General Expense"),

            self::TYPE_PAYROLL => Yii::t('app', "Payroll"),

            self::TYPE_TOTAL_PROJECT => Yii::t('app', "Total Project Expense"),

            self::TYPE_PROJECT_BUDGET => Yii::t('app', "Project Budget"),

            self::TYPE_CAPEX_PROJECT => Yii::t('app', "CAPEX+Project Expense"),

            self::TYPE_ACTIVITIES => Yii::t('app', "Activities*"),

            self::TYPE_PROJECT_PASSPORT => Yii::t('app', "Project Passport*"),

            self::TYPE_WBS => Yii::t('app', "WBS*"),

            self::TYPE_RISK_MATRIX => Yii::t('app', "Risk Matrix*"),

            self::TYPE_PROJECTS_BUDGET => Yii::t('app', "Budget*"),

            self::TYPE_PROJECT_SCHEDULE => Yii::t('app', "Schedule*"),

            self::TYPE_PROJECT_CALCULATION => Yii::t('app', "Calculation*"),

            self::TYPE_PROJECT_REPORT => Yii::t('app', "Report*"),

            self::TYPE_ROI => Yii::t('app', "ROI")
        ];
    }

    public function getType()
    {
        $list = self::getTypeOptions();
        return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';
    }

    const STATE_INACTIVE = 0;

    const STATE_ACTIVE = 1;

    const STATE_DELETED = 2;

    const TYPE_PROJECT_NAME = 0;

    const TYPE_CLIENT = 1;

    const TYPE_PROJECT_MANAGER = 2;

    const TYPE_PROJECT_DESIGNATION = 3;

    const TYPE_PLANNED_START_DATE = 4;

    const TYPE_PLANNED_END_DATE = 5;

    const TYPE_CURRENCY = 6;

    const TYPE_CREATED_BY = 7;

    const TYPE_PROJECT_DESCRIPTION = 8;

    const TYPE_SUCCESS_CRITERIA = 9;

    const TYPE_MILESTONE = 10;

    const TYPE_END_DATE = 11;

    const TYPE_PROJECT_DELIVERABLES = 12;

    const TYPE_TASK = 13;

    const TYPE_BUDGET = 14;

    const TYPE_RISK = 15;

    const TYPE_LIKE = 16;

    const TYPE_CONSE = 17;

    const TYPE_STATUS = 18;

    const TYPE_PROJECT_START_DATE = 19;

    const TYPE_PROJECT_COMPLETION_DATE = 20;

    const TYPE_PROJECT_OVERALL = 21;

    const TYPE_INCOME = 22;

    const TYPE_OPEX = 23;

    const TYPE_PERIOD = 24;

    const TYPE_REPORT = 25;

    const TYPE_PDF = 26;

    const TYPE_PRINT = 27;

    const TYPE_CALCULATION = 28;

    const TYPE_NPV = 29;

    const TYPE_CF = 30;

    const TYPE_Actions = 31;

    const TYPE_TASK_TITLE = 32;

    const TYPE_START_DATE = 33;

    const TYPE_DURATION = 34;

    const TYPE_COMPLETE = 35;

    const TYPE_PROJECT_STATUS = 36;

    const TYPE_NOTES = 37;

    const TYPE_CAPEX = 38;

    const TYPE_CAPEX_PER_TASK = 39;

    const TYPE_TOTAL = 40;

    const TYPE_PROJECT_EXPENSE = 41;

    const TYPE_GENERAL_EXPENSE = 42;

    const TYPE_PAYROLL = 43;

    const TYPE_OTHERS = 44;

    const TYPE_TOTAL_PROJECT = 45;

    const TYPE_PROJECT_BUDGET = 46;

    const TYPE_CAPEX_PROJECT = 47;

    const TYPE_ACTIVITIES = 48;

    const TYPE_PROJECT_PASSPORT = 49;

    const TYPE_WBS = 50;

    const TYPE_RISK_MATRIX = 51;

    const TYPE_PROJECTS_BUDGET = 52;

    const TYPE_PROJECT_SCHEDULE = 53;

    const TYPE_PROJECT_CALCULATION = 54;

    const TYPE_PROJECT_REPORT = 55;

    const TYPE_ROI = 56;

    public static function getStateOptions()

    {
        return [
            self::STATE_INACTIVE => yii::t('app', "New"),
            self::STATE_ACTIVE => yii::t('app', "Active"),
            self::STATE_DELETED => yii::t('app', "Deleted")
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
            self::STATE_INACTIVE => yii::t('app', "Deactivate"),
            self::STATE_ACTIVE => yii::t('app', "Activate"),
            self::STATE_DELETED => yii::t('app', "Delete")
        ];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if (empty($this->created_by_id)) {
                $this->created_by_id = self::getCurrentUser();
            }
            if (empty($this->created_on)) {
                $this->created_on = \date('Y-m-d H:i:s');
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
        return '{{%rename}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['add'] = [
            'type_id',
            'title'
        ];
        return $scenarios;
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
                    'created_by_id',
                    'created_on'
                ],
                'required'
            ],
            [
                [
                    'state_id',
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
                    'type_id'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'title',
                    'type_id'
                ],
                'trim'
            ],
            [
                [
                    'type_id'
                ],
                'unique',
                'on' => [
                    'add'
                ],
                'message' => 'This Attribute has already been taken.'
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
            'title' => Yii::t('app', 'Title'),
            'type_id' => Yii::t('app', 'Type'),
            'state_id' => Yii::t('app', 'State'),
            'created_by_id' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On')
        ];
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
        $json['type_id'] = $this->type_id;
        $json['state_id'] = $this->state_id;
        $json['created_by_id'] = $this->created_by_id;
        $json['created_on'] = $this->created_on;
        if ($with_relations) {}
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
}
