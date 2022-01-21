<?php
use app\components\grid\TGridView;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\pms\models\Task;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\pms\models\search\Task $searchModel
 */

?>
<div class="w-100 d-flex justify-content-center banner-imgs">

<?php

echo Html::img(yii::$app->view->theme->getUrl('admin/img/wbs.jpg'), []);
?>

</div>
<?php
if (! empty($menu))
    echo Html::a($menu['label'], $menu['url'], [
        'class' => ' btn btn-success pull-right'
    ]);
?>

<?php

Pjax::begin([
    'id' => 'task-pjax-ajax-grid',
    'enablePushState' => false,
    'enableReplaceState' => false
]);
?>
    <?php

    echo TGridView::widget([
        'summary' => false,
        'id' => 'task-ajax-grid-view',
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table custom-table mt-3'
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => Yii::t('app', 'S.No')
            ],
            'title',

            [
                'attribute' => 'description',
                'label' => Yii::t('app', 'Description'),
                'value' => function ($data) {
                    return $data->description;
                }
            ],

            [
                'attribute' => 'amount',
                'value' => function ($data) {
                    return $data->project->currency . $data->amount;
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

