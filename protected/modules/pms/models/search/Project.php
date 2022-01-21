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

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pms\models\Project as ProjectModel;
use app\models\User;

/**
 * Project represents the model behind the search form about `app\modules\pms\models\Project`.
 */
class Project extends ProjectModel
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
                    'manager_name',
                    'client_name',
                    'start_date',
                    'end_date',
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
        $query = ProjectModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC
                ]
            ]
        ]);
        if (isset($params['state_id'])) {

            $query->andWhere([

                'state_id' => $params['state_id']
            ]);
        }
        if (! User::isAdmin()) {
            $query = $query->andWhere([
                'created_by_id' => Yii::$app->user->id
            ]);
        }

        if (! ($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
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
            'client_name',
            $this->client_name
        ])
        ->andFilterWhere([
            'like',
            'manager_name',
            $this->manager_name
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
            'created_on',
            $this->created_on
        ]);

        return $dataProvider;
    }
}
