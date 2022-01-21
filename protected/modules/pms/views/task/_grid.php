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
 * @var app\modules\pms\models\search\Task $searchModel
 */

?>
<?php
if (! empty($menu))
    echo Html::a($menu['label'], $menu['url'], $menu['htmlOptions']);
?>
<?php

Pjax::begin([
    'id' => 'task-pjax-grid'
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
                'header' => '<a>S.No.<a/>'
            ],
            'title',
            'description:html',
            [
                'attribute' => 'amount',
                'value' => function ($data) {
                    return $data->project->currency . $data->amount;
                }
            ],
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

<script> 
$('#bulk_delete_task-grid').click(function(e) {
	e.preventDefault();
	 var keys = $('#task-grid-view').yiiGridView('getSelectedRows');

	 if ( keys != '' ) {
		var ok = confirm("Do you really want to delete these items?");

		if( ok ) {
			$.ajax({
				url  : '<?php

    echo Url::toRoute([
        'task/mass',
        'action' => 'delete',
        'model' => get_class($searchModel)
    ])?>', 

				type : "POST",
				data : {
					ids : keys,
				},
				success : function( response ) {
					if ( response.status == "OK" ) {
						 $.pjax.reload({container: '#task-pjax-grid'});
					}
				}
		     });
		}
	 } else {
		alert('Please select items to delete');
	 }
});

</script>

