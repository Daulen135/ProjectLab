<?php

use app\components\grid\TGridView;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\favorite\models\search\QuickLink $searchModel
 */

?>

<?php
if (! empty($menu))
    echo Html::a($menu['label'], $menu['url'], $menu['htmlOptions']);
?>



<?php Pjax::begin(['id'=>'quick-link-pjax-ajax-grid','enablePushState'=>false,'enableReplaceState'=>false]); ?>
    <?php echo TGridView::widget([
    	'id' => 'quick-link-ajax-grid-view',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn','header'=>'<a>S.No.<a/>'],

            'id',
            'title',
            'url:url',
            /* 'explore_option:html',*/
            ['attribute' => 'type_id','filter'=>isset($searchModel)?$searchModel->getTypeOptions():null,
			'value' => function ($data) { return $data->getType();  },],
            [
			'attribute' => 'state_id','format'=>'raw','filter'=>isset($searchModel)?$searchModel->getStateOptions():null,
			'value' => function ($data) { return $data->getStateBadge();  },],
             'created_on:datetime',
            [
				'attribute' => 'created_by_id',
				'format'=>'raw',
				'value' => function ($data) { return $data->getRelatedDataLink('created_by_id');  },
				],

            ['class' => 'app\components\TActionColumn','header'=>'<a>Actions</a>'],
        ],
    ]); ?>
<?php Pjax::end(); ?>

