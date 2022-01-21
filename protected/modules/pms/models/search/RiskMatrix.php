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
use app\modules\pms\models\RiskMatrix as RiskMatrixModel;

/**
 * RiskMatrix represents the model behind the search form about `app\modules\pms\models\RiskMatrix`.
 */
class RiskMatrix extends RiskMatrixModel
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
                    'title',
                    'factor',
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
        $query = RiskMatrixModel::find();
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
                    'id' => SORT_DESC
                ]
            ]
        ]);

        if (! ($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'project_id' => $this->project_id,
            'severity' => $this->severity,
            'impact' => $this->impact,
            'state_id' => $this->state_id,
            'type_id' => $this->type_id,
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
            'factor',
            $this->factor
        ])
            ->andFilterWhere([
            'like',
            'created_on',
            $this->created_on
        ]);

        return $dataProvider;
    }
}
