<?php
use app\components\grid\TGridView;
use app\models\User;
use yii\widgets\Pjax;
use yii\helpers\Html;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\User $searchModel
 */

?>
<?php

Pjax::begin([
    "enablePushState" => false,
    "enableReplaceState" => false,
    'id' => 'user-pjax-grid'
]);
?>

    <?php

    echo TGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table custom-table mt-3'
        ],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn','header'=>'<a>S.No.<a/>'],
            /*
             * [
             * 'name' => 'check',
             * 'class' => 'yii\grid\CheckboxColumn',
             * 'visible' => User::isAdmin()
             * ],
             */

            [
                'attribute' => 'id',
                'value' => function ($data) {
                    return $data->id;
                },
                'label' => Yii::t('app', 'ID')
            ],
            // 'full_name',
            // 'first_name',
            [
                'attribute' => 'first_name',
                'format' => 'html',
                'value' => function ($data) {
                    if (($data->is_verify == 1)) {
                        return $data->first_name . '  ' . '<span class="glyphicon glyphicon-star"></span>';
                    } else {
                        return $data->first_name;
                    }
                },
                'label' => Yii::t('app', 'First Name')
            ],

            [
                'attribute' => 'last_name',
                'format' => 'html',
                'value' => function ($data) {

                    return $data->last_name;
                },
                'label' => Yii::t('app', 'Last Name')
            ],

            [
                'attribute' => 'email',

                'value' => function ($data) {

                    return $data->email;
                },
                'label' => Yii::t('app', 'Email')
            ],
            [
                'attribute' => 'contact_no',

                'value' => function ($data) {

                    return $data->contact_no;
                },
                'label' => Yii::t('app', 'Contact No')
            ],
            /* 'password',*/
            /* 'date_of_birth:date',*/
            /* 'gender',*/
            /* 'about_me',*/
            /* 'contact_no',*/
            /* 'address',*/
            /* 'latitude',*/
            /* 'longitude',*/
            /* 'city',*/
            /* 'country',*/
            /* 'zipcode',*/
            /* 'language',*/
            /* ['attribute' => 'profile_file','filter'=>$searchModel->getFileOptions(),
			'value' => function ($data) { return $data->getFileOptions($data->profile_file);  },],*/
            /* 'tos',*/
           // 'role_id',
        		
        		[
                'attribute' => 'role_id',
                'filter' => $searchModel->getRoleOptions(),
                'value' => function ($data) {
                    return $data->getRoleOptions($data->role_id);
                },
                'label' => yii::t('app', 'Role')
            ],
            [
                'attribute' => 'state_id',
                'format' => 'raw',
                'filter' => isset($searchModel) ? $searchModel->getStateOptions() : null,
                'value' => function ($data) {
                    return $data->getStateBadge();
                },
                'label' => yii::t('app', 'State')
            ],
            /* ['attribute' => 'type_id','filter'=>isset($searchModel)?$searchModel->getTypeOptions():null,
			'value' => function ($data) { return $data->getType();  },],*/
            /* 'last_visit_time:datetime',*/
            /* 'last_action_time:datetime',*/
            /* 'last_password_change:datetime',*/
            /* 'login_error_count',*/
            /* 'activation_key',*/
            /* 'timezone',*/
            [
                'attribute' => 'created_on',
                'filter' => \yii\jui\DatePicker::widget([
                    'inline' => false,
                    'clientOptions' => [
                        'autoclose' => true
                    ],
                    'model' => $searchModel,
                    'attribute' => 'created_on',

                    'options' => [
                        'id' => 'created_on',
                        'class' => 'form-control',
                        'autoComplete' => 'off'
                    ]
                ]),
                'value' => function ($data) {
                    return date('Y-m-d h:m:s A', strtotime($data->created_on));
                },
                'label' => yii::t('app', 'Created On')
            ],
            [
                'attribute' => 'created_by_id',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->getRelatedDataLink('created_by_id');
                }
            ],

            [
                'class' => 'app\components\TActionColumn',
                'template' => '{view} {update} {delete}',
                'header' => yii::t('app', 'Actions')
            ]
        ]
    ]);
    ?>
<?php

Pjax::end();
?>

