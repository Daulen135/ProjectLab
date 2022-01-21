<?php
use app\components\grid\TGridView;
use app\components\MassAction;
use yii\helpers\Url;
use app\models\User;
use yii\widgets\Pjax;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\BlogCategory $searchModel
 */
?>
<?php Pjax::begin(['id'=>'category-pjax-grid']); ?>
 <?php

echo TGridView::widget([
    'id' => 'category-grid-data',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        // ['class' => 'yii\grid\SerialColumn','header'=>'<a>S.No.<a/>'],
        'id',
        'title',
        [
            'attribute' => 'state_id',
            'format' => 'raw',
            'filter' => isset($searchModel) ? $searchModel->getStateOptions() : null,
            'value' => function ($data) {
                return $data->getStateBadge();
            }
        ],
        [
            'attribute' => 'count',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->getPostCount();
            }
        ],
    /*     [
            'attribute' => 'type_id',
            'filter' => isset($searchModel) ? $searchModel->getTypeOptions() : null,
            'value' => function ($data) {
                return $data->getType();
            }
        ], */
        'created_on:datetime',
            /* 'updated_on:datetime',*/
           /*  [
            'attribute' => 'created_by_id',
            'format' => 'raw',
            'value' => function ($data) {
                return $data->getRelatedDataLink('created_by_id');
            }
        ], */
        [
            'class' => 'app\components\TActionColumn',
            'header' => '<a>Actions</a>'
        ]
    ]
]);
?>
<?php

Pjax::end();
?>
