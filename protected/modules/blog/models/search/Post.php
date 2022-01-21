<?php

/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\modules\blog\models\search;

use app\models\User;
use app\modules\blog\models\Post as PostModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Post represents the model behind the search form about `app\models\Post`.
 */
class Post extends PostModel
{

    /**
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'view_count',
                    'state_id'
                ],
                'integer'
            ],
            [
                [
                    'title',
                    'content',
                    'keywords',
                    'image_file',
                    'created_on',
                    'updated_on',
                    'type_id',
                    'created_by_id'
                ],
                'safe'
            ]
        ];
    }

    /**
     *
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function beforeValidate()
    {
        return true;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PostModel::find();
        if (! (User::isManager())) {
            $query->andWhere([
                'p.state_id' => PostModel::STATE_ACTIVE
            ]);
        }
        $query->alias('p')
            ->joinWith('createUser as u')
            ->joinWith('type as c');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_on' => SORT_DESC
                ]
            ]
        ]);
        if (! ($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'p.id' => $this->id,
            'p.view_count' => $this->view_count,
            'p.state_id' => $this->state_id
        ]);
        
        $query->andFilterWhere([
            'like',
            'p.title',
            $this->title
        ])
            ->andFilterWhere([
            'like',
            'p.content',
            $this->content
        ])
            ->andFilterWhere([
            'like',
            'p.keywords',
            $this->keywords
        ])
            ->andFilterWhere([
            'like',
            'p.image_file',
            $this->image_file
        ])
            ->andFilterWhere([
            'like',
            'u.full_name',
            $this->created_by_id
        ])
            ->andFilterWhere([
            'like',
            'c.title',
            $this->type_id
            ])
            ->andFilterWhere([
                'like',
                'c.created_on',
                $this->created_on
            ])
            ->andFilterWhere([
                'like',
                'c.updated_on',
                $this->updated_on
            ]);
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchCategory($id)
    {
        if (User::isAdmin()) {
            $query = PostModel::find()->where([
                'type_id' => $id
            ]);
        } else {
            $query = PostModel::find()->where([
                'type_id' => $id,
                'state_id' => self::STATE_ACTIVE
            ]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        return $dataProvider;
    }
}
