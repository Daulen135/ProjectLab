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
namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Notice as NoticeModel;

/**
 * Notice represents the model behind the search form about `app\models\Notice`.
 */
class Notice extends NoticeModel
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
                    'model_id',
                    'state_id',
                    'type_id',
                ],
                'integer'
            ],
            [
                [
                    'title',
                    'content',
                    'model_type',
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
        $query = NoticeModel::find()->alias('n')->joinWith('createdBy as c');

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
            'n.id' => $this->id,
            'n.model_id' => $this->model_id,
            'n.state_id' => $this->state_id,
            'n.type_id' => $this->type_id,
            'n.created_on' => $this->created_on
            // 'created_by_id' => $this->created_by_id,
        ]);

        $query->andFilterWhere([
            'like',
            'n.title',
            $this->title
        ])
            ->andFilterWhere([
            'like',
            'n.content',
            $this->content
        ])
            ->andFilterWhere([
            'like',
            'c.full_name',
            $this->created_by_id
        ])
            ->andFilterWhere([
            'like',
            'model_type',
            $this->model_type
        ])
            ->andFilterWhere([
            'like',
            'created_on',
            $this->created_on
        ]);

        return $dataProvider;
    }
}
