<?php
use app\components\grid\TGridView;
use yii\helpers\Html;
use yii\helpers\Url;

use app\models\User;

use yii\grid\GridView;
use yii\widgets\Pjax;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\pms\models\search\Project $searchModel
 */

?>

<?php
// if (User::isAdmin()) echo Html::a('','#',['class'=>'multiple-delete glyphicon glyphicon-trash','id'=>"bulk_delete_project-grid"]) ?>
<?php

Pjax::begin([
    'id' => 'project-pjax-grid'
]);
?>

    <?php

    echo TGridView::widget([
        'summary' => false,
        'id' => 'project-grid-view',
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table custom-table'
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => yii::t('app', 'S.No')
            ],
            /*
             * [
             * 'name' => 'check',
             * 'class' => 'yii\grid\CheckboxColumn',
             * 'visible' => User::isAdmin()
             * ],
             */

            //'id',
            'title',
            /* 'description:html',*/
            'manager_name',
            'client_name',
            'start_date:date',
            'end_date:date',
            [
                'label' => yii::t('app', 'Total Deliverables'),
                'value' => function ($data) {
                    return $data->getDeliverables()->count();
                }
            ],
            [
                'label' => yii::t('app', 'Total Milestones'),
                'value' => function ($data) {
                    return $data->getMilestones()->count();
                }
            ],
            [
                'label' => yii::t('app', 'Total Success Criteria'),
                'value' => function ($data) {
                    return $data->getSuccessCriteria()->count();
                }
            ],
            /* ['attribute' => 'type_id','filter'=>isset($searchModel)?$searchModel->getTypeOptions():null,
			'value' => function ($data) { return $data->getType();  },],*/
            /* [
                'attribute' => 'state_id',
                'format' => 'raw',
                'filter' => isset($searchModel) ? $searchModel->getStateOptions() : null,
                'value' => function ($data) {
                    return $data->getStateBadge();
                }
            ], */
            //'created_on:datetime',
            [
                'attribute' => 'created_by_id',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->getRelatedDataLink('created_by_id');
                }
            ],

            [
                'class' => 'app\components\TActionColumn',
                'template' => '{view}{delete}',
                'header' => yii::t('app', 'Actions')
            ]
        ]
    ]);
    ?>
<?php

Pjax::end();
?>

<script> 
$('#bulk_delete_project-grid').click(function(e) {
	e.preventDefault();
	 var keys = $('#project-grid-view').yiiGridView('getSelectedRows');

	 if ( keys != '' ) {
		var ok = confirm("Do you really want to delete these items?");

		if( ok ) {
			$.ajax({

				url  : '<?php

    echo Url::toRoute([
        'project/mass',
        'action' => 'delete',
        'model' => get_class($searchModel)
    ])?>', 

				type : "POST",
				data : {
					ids : keys,
				},
				success : function( response ) {
					if ( response.status == "OK" ) {
						 $.pjax.reload({container: '#project-pjax-grid'});
					}
				}
		     });
		}
	 } else {
		alert('Please select items to delete');
	 }
});

</script>

