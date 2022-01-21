<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\models\search;

use app\models\User as UserModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * User represents the model behind the search form about `app\models\User`.
 */
class User extends UserModel
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
                    'gender',
                    'tos',
                    'role_id',
                    'state_id',
                    'type_id',
                    'login_error_count'
                ],
                'integer'
            ],
            [
                [
                    'full_name',
                    'first_name',
                    'last_name',
                    'email',
                    'password',
                    'date_of_birth',
                    'about_me',
                    'contact_no',
                    'address',
                    'latitude',
                    'longitude',
                    'city',
                    'country',
                    'zipcode',
                    'language',
                    'profile_file',
                    'last_visit_time',
                    'last_action_time',
                    'last_password_change',
                    'activation_key',
                    'timezone',
                    'created_on',
                    'updated_on',
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
        $query = UserModel::find()->alias('u')->joinWith('createdBy as cr');
        
        $query->andWhere(['<>','u.role_id',UserModel::ROLE_ADMIN]);

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
            'u.about_me' => $this->about_me,
            'u.contact_no' => $this->contact_no,
            'u.date_of_birth' => $this->date_of_birth,
            'u.address' => $this->address,
            'u.latitude' => $this->latitude,
            'u.longitude' => $this->longitude,
            'u.city' => $this->city,
            'u.gender' => $this->gender,
            'u.tos' => $this->tos,
            'u.role_id' => $this->role_id,
            'u.state_id' => $this->state_id,
            'u.type_id' => $this->type_id,
            'u.last_visit_time' => $this->last_visit_time,
            'u.last_action_time' => $this->last_action_time,
            'u.last_password_change' => $this->last_password_change,
            'u.login_error_count' => $this->login_error_count
        ]);

        $query->andFilterWhere([
            'like',
            'u.id',
            $this->id
        ])
            ->andFilterWhere([
            'like',
            'u.email',
            $this->email
        ])
            ->andFilterWhere([
            'like',
            'u.first_name',
                $this->first_name
        ])
            ->andFilterWhere([
            'like',
            'u.last_name',
                $this->last_name
        ])
            ->andFilterWhere([
            'like',
            'u.country',
            $this->country
        ])
            ->andFilterWhere([
            'like',
            'u.zipcode',
            $this->zipcode
        ])
            ->andFilterWhere([
            'like',
            'u.language',
            $this->language
        ])
            ->andFilterWhere([
            'like',
            'u.created_on',
            $this->created_on
        ])
        ->andFilterWhere([
            'like',
            'cr.full_name',
            $this->created_by_id
        ])
            ->andFilterWhere([
            'like',
            'u.timezone',
            $this->timezone
        ]);
        return $dataProvider;
    }
}
