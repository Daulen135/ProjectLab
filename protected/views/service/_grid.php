<?php
use app\components\grid\TGridView;
use yii\widgets\Pjax;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\Service $searchModel
 */

?>
<?php

Pjax::begin([
    'id' => 'service-pjax-grid'
]);
?>
    <?php

    echo TGridView::widget([
        'id' => 'service-grid-view',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table custom-table mt-3'
        ],
        'columns' => [

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
                'class' => 'app\components\TActionColumn',
                'header' => yii::t('app', 'Actions')
            ]
        ]
    ]);
    ?>
<?php

Pjax::end();
?>

