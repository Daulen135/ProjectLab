<?php
namespace app\modules\blog\models;

use app\models\User;

/**
 * This is the model class for table "tbl_blog_category".
 *
 * @property integer $id
 * @property string $title
 * @property integer $state_id
 * @property string $created_on
 * @property string $updated_on
 * @property integer $created_by_id
 */
class Category extends \app\components\TActiveRecord
{

    public $count;

    public function __toString()
    {
        return (string) $this->title;
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
            self::STATE_INACTIVE => "primary",
            self::STATE_ACTIVE => "success",
            self::STATE_DELETED => "danger"
        ];
        return isset($list[$this->state_id]) ? \yii\helpers\Html::tag('span', $this->getState(), [
            'class' => 'badge badge-' . $list[$this->state_id]
        ]) : 'Not Defined';
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if (! isset($this->created_on))
                $this->created_on = date('Y-m-d H:i:s');
            if (! isset($this->updated_on))
                $this->updated_on = date('Y-m-d H:i:s');
            if (! isset($this->created_by_id))
                $this->created_by_id = self::getCurrentUser();
        } else {
            $this->updated_on = date('Y-m-d H:i:s');
        }
        return parent::beforeValidate();
    }

    /**
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_category}}';
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
                    'state_id',
                    'created_on',
                    'updated_on',
                    'created_by_id'
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
                    'created_on',
                    'updated_on'
                ],
                'safe'
            ],
            [
                [
                    'title'
                ],
                'string',
                'max' => 256
            ],
            [
                [
                    'title'
                ],
                'trim'
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
            'id' => \Yii::t('app', 'ID'),
            'title' => \Yii::t('app', 'Title'),
            'state_id' => \Yii::t('app', 'State'),
            'created_on' => \Yii::t('app', 'Created On'),
            'updated_on' => \Yii::t('app', 'Updated On'),
            'created_by_id' => \Yii::t('app', 'Created By')
        ];
    }

    public static function getHasManyRelations()
    {
        $relations = [];
        $relations['type_id'] = [
            'posts',
            'Post',
            'id'
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

    public function getPosts()
    {
        return $this->hasMany(Post::class, [
            'type_id' => 'id'
        ])->cache(10);
    }

    public function getPostCount()
    {
        return $this->getPosts()->count();
    }

    public function getCreateUser()
    {
        return $this->hasOne(User::class, [
            'id' => 'created_by_id'
        ])->cache(10);
    }

    public function getControllerID()
    {
        return '/blog/' . parent::getControllerID();
    }

    public function asJson($with_relations = false)
    {
        $json = [];
        $json['id'] = $this->id;
        $json['title'] = $this->title;
        $json['state_id'] = $this->state_id;
        $json['created_on'] = $this->created_on;
        $json['created_by_id'] = $this->created_by_id;
        if ($with_relations) {}
        return $json;
    }

    public static function addCategory($datas = [])
    {
        if (self::find()->count() != 0)
            return;

        foreach ($datas as $key => $data) {
            $model = new self();
            // $model->id = $data['id'];
            $model->title = $data['title'];
            $model->state_id = $data['state_id'];
            $model->save();
        }
    }

    public static function addTestData($count = 1)
    {
        $faker = \Faker\Factory::create();
        $states = array_keys(self::getStateOptions());
        for ($i = 0; $i < $count; $i ++) {
            $model = new self();
            $model->title = $faker->title;
            $model->state_id = $states[rand(0, count($states) - 1)];
            $model->created_by_id = User::getCurrentUser();
            $model->save();
        }
    }

    public static function addData($data)
    {
        $faker = \Faker\Factory::create();
        if (self::find()->count() != 0)
            return;
        foreach ($data as $item) {
            $model = new self();

            $model->title = isset($item['title']) ? $item['title'] : $faker->title;
            $model->state_id = self::STATE_ACTIVE;
            $model->created_by_id = User::getCurrentUser();
            $model->save();
        }
    }
}
