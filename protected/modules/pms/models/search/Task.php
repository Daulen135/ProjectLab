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
namespace app\modules\pms\models\search;

use app\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pms\models\Task as TaskModel;

/**
 * Task represents the model behind the search form about `app\modules\pms\models\Task`.
 */
class Task extends TaskModel
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
                    'project_id',
                    'type_id',
                    'state_id',
                    'created_by_id'
                ],
                'integer'
            ],
            [
                [
                    'title',
                    'description',
                    'start_date',
                    'end_date',
                    'image_file',
                    'created_on'
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
        $query = TaskModel::find();
        if (! User::isAdmin()) {
            $query = $query->andWhere([
                'project_id' => $params['id'],
                'created_by_id' => \Yii::$app->user->id
            ]);
           
        }
        else{
            $query = $query->andWhere([
                'project_id' => $params['id']
            ]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC
                ]
            ]
        ]);

        if (! ($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'project_id' => $this->project_id,
            'type_id' => $this->type_id,
            'state_id' => $this->state_id,
            'created_by_id' => $this->created_by_id
        ]);

        $query->andFilterWhere([
            'like',
            'id',
            $this->id
        ])
            ->andFilterWhere([
            'like',
            'title',
            $this->title
        ])
            ->andFilterWhere([
            'like',
            'description',
            $this->description
        ])
            ->andFilterWhere([
            'like',
            'start_date',
            $this->start_date
        ])
            ->andFilterWhere([
            'like',
            'end_date',
            $this->end_date
        ])
            ->andFilterWhere([
            'like',
            'image_file',
            $this->image_file
        ])
            ->andFilterWhere([
            'like',
            'created_on',
            $this->created_on
        ]);

        return $dataProvider;
    }
}
