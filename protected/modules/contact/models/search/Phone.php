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
namespace app\modules\contact\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\contact\models\Phone as PhoneModel;

/**
 * Phone represents the model behind the search form about `app\modules\contact\models\Phone`.
 */
class Phone extends PhoneModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'state_id', 'created_by_id'], 'integer'],
            [['title', 'contact_no', 'type_chat', 'skype_chat', 'gtalk_chat', 'country', 'created_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function beforeValidate(){
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
        $query = PhoneModel::find();

		        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
						'defaultOrder' => [
								'id' => SORT_DESC
						]
				]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'type_id' => $this->type_id,
            'state_id' => $this->state_id,
            'created_by_id' => $this->created_by_id,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'type_chat', $this->type_chat])
            ->andFilterWhere(['like', 'skype_chat', $this->skype_chat])
            ->andFilterWhere(['like', 'gtalk_chat', $this->gtalk_chat])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'created_on', $this->created_on]);

        return $dataProvider;
    }
}
