<?php
use app\components\grid\TGridView;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\feature\models\search\Vote $searchModel
 */

?>
<?php if (User::isAdmin()) echo Html::a('','#',['class'=>'multiple-delete glyphicon glyphicon-trash','id'=>"bulk_delete_vote-grid"])?>
<?php Pjax::begin(['id'=>'vote-pjax-grid','enablePushState'=>false,'enableReplaceState'=>false]); ?>
    <?php
    
echo TGridView::widget([
        'id' => 'vote-grid-view',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'name' => 'check',
                'class' => 'yii\grid\CheckboxColumn',
                'visible' => User::isAdmin()
            ],
            
            'id',
            [
                'attribute' => 'feature_id',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->getRelatedDataLink('feature_id');
                }
            ],
            [
                'attribute' => 'state_id',
                'format' => 'raw',
                'filter' => isset($searchModel) ? $searchModel->getStateOptions() : null,
                'value' => function ($data) {
                    return $data->getStateBadge();
                }
            ],
            'created_on:datetime',
            [
                'attribute' => 'created_by_id',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->getRelatedDataLink('created_by_id');
                }
            ],
            
            [
                'class' => 'app\components\TActionColumn',
                'header' => '<a>Actions</a>'
            ]
        ]
    ]);
    ?>
<?php Pjax::end(); ?>
<script> 
$('#bulk_delete_vote-grid').click(function(e) {
	e.preventDefault();
	 var keys = $('#vote-grid-view').yiiGridView('getSelectedRows');

	 if ( keys != '' ) {
		var ok = confirm("Do you really want to delete these items?");

		if( ok ) {
			$.ajax({
				url  : '<?php echo Url::toRoute(['vote/mass','action'=>'delete','model'=>get_class($searchModel)])?>', 
				type : "POST",
				data : {
					ids : keys,
				},
				success : function( response ) {
					if ( response.status == "OK" ) {
						 $.pjax.reload({container: '#vote-pjax-grid'});
					}
				}
		     });
		}
	 } else {
		alert('Please select items to delete');
	 }
});

</script>

