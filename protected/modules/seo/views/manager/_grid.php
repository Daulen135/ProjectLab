<?php
use yii\helpers\Html;
use app\components\grid\TGridView;
use yii\grid\GridView;
use yii\widgets\Pjax;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\Seo $searchModel
 */

?>
<?php

Pjax::begin([
    'id' => 'manager-pjax-grid',
    'enablePushState' => false,
    'enableReplaceState' => false
]);
?>
    <?php

echo TGridView::widget([
        'id' => 'seo-grid-view',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-bordered'
        ],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn','header'=>'<a>S.No.<a/>'],

            'id',
            'route',
            'title',
            'keywords',
            'data',
            [
                'attribute' => 'state_id',
                'format' => 'raw',
                'filter' => isset($searchModel) ? $searchModel->getStateOptions() : null,
                'value' => function ($data) {
                    return $data->getStateBadge();
                }
            ],
            /*'created_on:datetime',*/
            /* 'updated_on:datetime',*/

            [
                'class' => 'app\components\TActionColumn',
                'header' => Yii::t('app', 'Actions')
            ]
        ]
    ]);
    ?>
<?php

Pjax::end();
?>

