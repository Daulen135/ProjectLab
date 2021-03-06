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
 * @var app\modules\subscription\models\search\Billing $searchModel
 */

?>
<?php

if (User::isAdmin())
    echo Html::a('', '#', [
        'class' => 'multiple-delete glyphicon glyphicon-trash',
        'id' => "bulk_delete_billing-grid"
    ])?>
<?php

Pjax::begin([
    'id' => 'billing-pjax-grid'
]);
?>
    <?php

    echo TGridView::widget([
        'id' => 'billing-grid-view',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-bordered'
        ],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn','header'=>'<a>S.No.<a/>'],
            [
                'name' => 'check',
                'class' => 'yii\grid\CheckboxColumn',
                'visible' => User::isAdmin()
            ],

            'id',
            [
                'attribute' => 'subscription_id',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->getRelatedDataLink('subscription_id');
                }
            ],
            'start_date:datetime',
            'end_date:datetime',
            [
                'attribute' => 'state_id',
                'format' => 'raw',
                'filter' => isset($searchModel) ? $searchModel->getStateOptions() : null,
                'value' => function ($data) {
                    return $data->getStateBadge();
                }
            ],
           
            /* 'created_on:datetime',*/
             [
                'attribute' => 'created_by_id',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->getRelatedDataLink('created_by_id');
                }
            ],

            [
                'class' => 'app\components\TActionColumn',
                'header' => '<a>Actions</a>',
                'template' => '{view}{delete}'
            ]
        ]
    ]);
    ?>
<?php

Pjax::end();
?>
<script> 
$('#bulk_delete_billing-grid').click(function(e) {
	e.preventDefault();
	 var keys = $('#billing-grid-view').yiiGridView('getSelectedRows');

	 if ( keys != '' ) {
		var ok = confirm("Do you really want to delete these items?");

		if( ok ) {
			$.ajax({
				url  : '<?php

echo Url::toRoute([
        'billing/mass',
        'action' => 'delete',
        'model' => get_class($searchModel)
    ])?>', 
				type : "POST",
				data : {
					ids : keys,
				},
				success : function( response ) {
					if ( response.status == "OK" ) {
						 $.pjax.reload({container: '#billing-pjax-grid'});
					}
				}
		     });
		}
	 } else {
		alert('Please select items to delete');
	 }
});

</script>

