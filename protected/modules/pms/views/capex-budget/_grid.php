<?php

use app\components\grid\TGridView;
use yii\helpers\Html;
use yii\helpers\Url;

use app\models\User;

use yii\grid\GridView;
use yii\widgets\Pjax;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\pms\models\search\CapexBudget $searchModel
 */

?>
<?php if (User::isAdmin()) echo Html::a('','#',['class'=>'multiple-delete glyphicon glyphicon-trash','id'=>"bulk_delete_capex-budget-grid"])?>
<?php Pjax::begin(['id'=>'capex-budget-pjax-grid']); ?>
    <?php echo TGridView::widget([
    	'id' => 'capex-budget-grid-view',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-bordered'],
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn','header'=>'<a>S.No.<a/>'],
           [ 
								'name' => 'check',
								'class' => 'yii\grid\CheckboxColumn',
								'visible' => User::isAdmin () 
						],

            'id',
            [
				'attribute' => 'project_id',
				'format'=>'raw',
				'value' => function ($data) { return $data->getRelatedDataLink('project_id');  },
				],
            [
				'attribute' => 'milestone_id',
				'format'=>'raw',
				'value' => function ($data) { return $data->getRelatedDataLink('milestone_id');  },
				],
            'amount',
            /* 'description:html',*/
            [
			'attribute' => 'state_id','format'=>'raw','filter'=>isset($searchModel)?$searchModel->getStateOptions():null,
			'value' => function ($data) { return $data->getStateBadge();  },],
            /* ['attribute' => 'type_id','filter'=>isset($searchModel)?$searchModel->getTypeOptions():null,
			'value' => function ($data) { return $data->getType();  },],*/
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
<script> 
$('#bulk_delete_capex-budget-grid').click(function(e) {
	e.preventDefault();
	 var keys = $('#capex-budget-grid-view').yiiGridView('getSelectedRows');

	 if ( keys != '' ) {
		var ok = confirm("Do you really want to delete these items?");

		if( ok ) {
			$.ajax({
				url  : '<?php echo Url::toRoute(['capex-budget/mass','action'=>'delete','model'=>get_class($searchModel)])?>', 
				type : "POST",
				data : {
					ids : keys,
				},
				success : function( response ) {
					if ( response.status == "OK" ) {
						 $.pjax.reload({container: '#capex-budget-pjax-grid'});
					}
				}
		     });
		}
	 } else {
		alert('Please select items to delete');
	 }
});

</script>

