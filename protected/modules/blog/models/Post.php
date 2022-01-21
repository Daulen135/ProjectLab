<?php
namespace app\modules\blog\models;

use app\models\Feed;
use app\models\User;
use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "tbl_blog_post".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $keywords
 * @property string $image_file
 * @property integer $view_count
 * @property integer $state_id
 * @property integer $type_id
 * @property string $created_on
 * @property string $updated_on
 * @property integer $created_by_id
 */
class Post extends \app\components\TActiveRecord
{

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

    public static function getTypeOptions()
    {
        return self::listData(Category::findActive()->all());
    }

    public function getType()
    {
        return $this->hasOne(Category::class, [
            'id' => 'type_id'
        ])->cache(10);
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
            if (! isset($this->view_count))
                $this->view_count = 0;
        } else {
            $this->updated_on = date('Y-m-d H:i:s');
            if (! isset($this->view_count))
                $this->view_count = 0;
        }
        return parent::beforeValidate();
    }

    /**
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_post}}';
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
                    'content',
                    'state_id',
                    'type_id',
                    'created_on',
                    'updated_on',
                    'created_by_id'
                ],
                'required'
            ],
            [
                [
                    'content'
                ],
                'string'
            ],
            [
                [
                    'view_count',
                    'state_id',
                    'type_id',
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
                    'keywords'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'image_file'
                ],
                'string',
                'max' => 1024
            ],
            [
                [
                    'title',
                    'keywords'
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
                    'state_id'
                ],
                'in',
                'range' => array_keys(self::getStateOptions())
            ],
            [
                'title',
                'unique',
                'targetAttribute' => [
                    'title'
                ],
                'message' => 'Title must be unique.'
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
            'content' => Yii::t('app', 'Content'),
            'keywords' => Yii::t('app', 'Keywords'),
            'image_file' => Yii::t('app', 'Image File'),
            'view_count' => Yii::t('app', 'View Count'),
            'state_id' => Yii::t('app', 'State'),
            'type_id' => Yii::t('app', 'Category'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'created_by_id' => Yii::t('app', 'Created By')
        ];
    }

    public function getCreateUser()
    {
        return $this->hasOne(User::class, [
            'id' => 'created_by_id'
        ])->cache(10);
    }

    public static function getHasManyRelations()
    {
        $relations = [];
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
        $relations['type_id'] = [
            'type',
            'Category',
            'id'
        ];
        return $relations;
    }

    public function beforeDelete()
    {
        if (! parent::beforeDelete()) {
            return false;
        }
        $this->deleteImage();
        return true;
    }

    public function deleteImage()
    {
        $file = UPLOAD_PATH . $this->image_file;
        if (is_file($file))
            FileHelper::unlink($file);
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
        $json['content'] = $this->content;
        $json['keywords'] = $this->keywords;
        if (isset($this->image_file))
            $json['image_file'] = $this->imageUrl;
        $json['view_count'] = $this->view_count;
        $json['state_id'] = $this->state_id;
        $json['type_id'] = $this->type_id;
        $json['created_on'] = $this->created_on;
        $json['created_by_id'] = $this->created_by_id;
        if ($with_relations) {}
        return $json;
    }

    public function getImageUrl($thumbnail = false)
    {
        $params = [
            $this->getControllerID() . '/image'
        ];
        $params['id'] = $this->id;

        $params['file'] = $this->image_file;
        if ($thumbnail)
            $params['thumbnail'] = is_numeric($thumbnail) ? $thumbnail : 150;

        return Yii::$app->getUrlManager()->createUrl($params);
    }

    public function isAllowed()
    {
        if (User::isManager())
            return true;

        if ($this->hasAttribute('created_by_id'))
            return ($this->created_by_id == Yii::$app->user->id);

        return $this->isActive();
    }

    public function getFeeds()
    {
        return $this->hasMany(Feed::class, [
            'model_id' => 'id'
        ])->andWhere([
            'model_type' => self::class
        ]);
    }

    public static function addTestData($count = 1)
    {
        $faker = \Faker\Factory::create();
        $types = array_keys(self::getTypeOptions());

        $states = array_keys(self::getStateOptions());

        for ($i = 0; $i < $count; $i ++) {
            $model = new self();
            $model->title = $faker->title;
            $model->type_id = $types[rand(0, count($types) - 1)];
            $model->state_id = $states[rand(0, count($states) - 1)];
            $model->content = $faker->text;
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
            $model->type_id = isset($item['type_id']) ? $item['type_id'] : 1;
            $model->state_id = self::STATE_ACTIVE;
            $model->content = isset($item['content']) ? $item['content'] : $faker->text;
            $model->created_by_id = User::getCurrentUser();
            $model->save();
        }
    }
}
