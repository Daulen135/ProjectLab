<?php
use app\components\grid\TGridView;
use app\models\User;
use yii\widgets\Pjax;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\EmailQueue $searchModel
 */

?>
<?php

Pjax::begin([
    'id' => 'email-queue-pjax-grid'
]);
?>
    <?php

    echo TGridView::widget([
        'id' => 'email-queue-grid-view',
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

            'id',

            [
                'attribute' => 'from_email',
                'format' => 'email',
                'value' => function ($data) {
                    return $data->from_email;
                }
            ],

            [
                'attribute' => 'to_email',
                'format' => 'email',
                'value' => function ($data) {
                    return $data->to_email;
                }
            ],
            /* 'message:html',*/
           
            [
                'attribute' => 'subject',

                'value' => function ($data) {
                    return $data->subject;
                }
            ],
            /* 'date_published:datetime',*/
            /* 'last_attempt:datetime',*/
            [
                'attribute' => 'date_sent',
                'filter' => \yii\jui\DatePicker::widget([
                    'inline' => false,
                    'clientOptions' => [
                        'autoclose' => true
                    ],
                    'model' => $searchModel,
                    'attribute' => 'date_sent',

                    'options' => [
                        'id' => 'date_sent',
                        'class' => 'form-control',
                        'autoComplete' => 'off'
                    ]
                ]),
                'value' => function ($data) {
                    return date('Y-m-d h:m:s A', strtotime($data->date_sent));
                }
            ],
            /* 'attempts',*/
            [
                'attribute' => 'state_id',
                'format' => 'raw',
                'filter' => isset($searchModel) ? $searchModel->getStateOptions() : null,
                'value' => function ($data) {
                    return $data->getStateBadge();
                }
            ],
            /* 'model_id',*/
            /* 'model_type',*/
            /* 'email_account_id:email',*/
            /* 'message_id',*/
            [
                'attribute' => 'files',
                'header' => Yii::t('app', 'Files'),
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->getfiles()->count();
                }
            ],
            [
                'class' => 'app\components\TActionColumn',
                'header' => Yii::t('app', 'Actions'),
                'template' => '{view}{delete}'
            ]
        ]
    ]);
    ?>
<?php

Pjax::end();
?>


