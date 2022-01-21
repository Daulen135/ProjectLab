<?php
use app\components\grid\TGridView;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\pms\models\Rename;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\pms\models\search\RiskMatrix $searchModel
 */

?>
<div class="w-100 d-flex justify-content-center banner-imgs">
<?php

echo Html::img(yii::$app->view->theme->getUrl('admin/img/abc.jpg'), []);
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
    'id' => 'risk-matrix-pjax-ajax-grid',
    'enablePushState' => false,
    'enableReplaceState' => false
]);
$desc = Rename::find()->Where([
    'type_id' => Rename::TYPE_RISK
])
    ->select('title')
    ->one();
$LikeliHood = Rename::find()->Where([
    'type_id' => Rename::TYPE_LIKE
])
    ->select('title')
    ->one();
$Consequence = Rename::find()->Where([
    'type_id' => Rename::TYPE_CONSE
])
    ->select('title')
    ->one();

?>
    <?php

    echo TGridView::widget([
        'summary' => false,
        'id' => 'risk-matrix-ajax-grid-view',
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table custom-table mt-3'
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',

                'header' => Yii::t('app', 'S.No')
            ],

            // 'id',

            [
                'attribute' => 'title',

                'label' => empty($desc) ? Yii::t('app', 'Risk Description') : $desc,

                'value' => function ($data) {
                    return $data->title;
                }
            ],
            [
                'attribute' => 'severity',

                'label' => empty($LikeliHood) ? Yii::t('app', 'Likelihood') : $LikeliHood,

                'value' => function ($data) {
                    return $data->getSeverity();
                }
            ],
            [
                'attribute' => 'impact',

                'label' => empty($Consequence) ? Yii::t('app', 'Consequence') : $Consequence,

                'value' => function ($data) {
                    return $data->getImpact();
                }
            ],
            // 'factor',
            [
                'attribute' => 'state_id',
                'format' => 'raw',
                'filter' => isset($searchModel) ? $searchModel->getStateOptions() : null,
                'value' => function ($data) {
                    return $data->getStateBadge();
                }
            ],
            /* ['attribute' => 'type_id','filter'=>isset($searchModel)?$searchModel->getTypeOptions():null,
			'value' => function ($data) { return $data->getType();  },],*/
            //'created_on:datetime',
            /* [
				'attribute' => 'created_by_id',
				'format'=>'raw',
				'value' => function ($data) { return $data->getRelatedDataLink('created_by_id');  },
				],*/

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

