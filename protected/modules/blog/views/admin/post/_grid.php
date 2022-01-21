<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
use app\components\MassAction;
use app\components\grid\TGridView;
use app\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\Blog $searchModel
 */

?>
<?php Pjax::begin(['id'=>'post-pjax-grid']); ?>
    <?php
    
    echo TGridView::widget([
        'id' => 'post-grid-data',
        'dataProvider' => $dataProvider,
        
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn','header'=>'<a>S.No.<a/>'],
            'id',
            'title',
            /* 'content:html',*/
            /* 'keywords',*/
            /* ['attribute' => 'image_file','filter'=>$searchModel->getFileOptions(),
			'value' => function ($data) { return $data->getFileOptions($data->image_file);  },],*/
             'view_count',
            [
                'attribute' => 'state_id',
                'format' => 'raw',
                'filter' => isset($searchModel) ? $searchModel->getStateOptions() : null,
                'value' => function ($data) {
                    return $data->getStateBadge();
                }
            ],
            [
                'attribute' => 'type_id',
                'value' => function ($model) {
                    return $model->type;
                }
            ],
            'created_on:datetime',
			'updated_on:datetime', 
								[
                'attribute' => 'created_by_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return isset($model->createUser) ? $model->createUser->full_name : "Not set";
                }
            ],
            [
                'class' => 'app\components\TActionColumn',
                'header' => '<a>Actions</a>'
            ]
        ]
    ]);
    ?>
<?php Pjax::end();?>
