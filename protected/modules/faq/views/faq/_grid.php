<?php
use app\components\grid\TGridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\faq\models\search\Faq $searchModel
 */

?>
<?php

Pjax::begin([
    'id' => 'faq-pjax-grid'
]);
?>
    <?php

    echo TGridView::widget([
        'id' => 'faq-grid-view',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table custom-table mt-3'
        ],
        'columns' => [
            'id',
            'question',
            'answer',
            [
                'attribute' => 'created_by_id',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->getRelatedDataLink('created_by_id');
                }
            ],

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

