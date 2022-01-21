<?php
use app\components\useraction\UserAction;
use app\modules\comment\widgets\CommentsWidget;
use yii\helpers\Html;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Blog */
/* $this->title = $model->label() .' : ' . $model->title; */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Blog'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Post'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = (string) $model;
?>
<div class="wrapper">
	<div class="card">
		<div class="blog-view">
			<?php

echo \app\components\PageHeader::widget([
    'model' => $model
]);
?>
			
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="row">
			<div class="col-md-4">
			<?php
echo Html::img($model->getImageUrl(250), [
    // 'height' => '250',
    'width' => '250'
])?>
					<br /> <br />
				
					<?php //No need to display download button if image is not uploaded
                    if(! empty($model->image_file)){?>
				<p>	<?=Html::a('Download image ', $model->imageUrl, ['class' => 'btn btn-success']); ?>     </p> 
				<?php } ?>

			</div>
			<div class="col-md-8">
    <?php
    
    echo \app\components\TDetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
           
            /*'content:html',*/
            'view_count',
            
            [
                'attribute' => 'type_id',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->getRelatedDataLink('type_id');
                }
            ],
            'created_on:datetime',
            'updated_on:datetime',
            [
                'attribute' => 'created_by_id',
                'format' => 'raw',
                'value' => isset($model->createUser) ? $model->createUser->full_name : "Not set"
            ]
        ]
    ])?>
				</div></div>
				
				<?=$model->content;?>
 
 <div>
		<?php

echo UserAction::widget([
    'model' => $model,
    'attribute' => 'state_id',
    'states' => $model->getStateOptions()
]);
?>	
		
		</div>
		</div>
	</div>
	
	<div class = "card">
		<div class="card-body">
			<div class=" link-panel ">
			<?php 
			$this->context->startPanel();
			if (User::isAdmin()){
			    $this->context->addPanel('Feeds', 'feeds', 'Feed', $model);
			}
			$this->context->endPanel();
			
			
			?>
			
			
			</div>
			</div>
			</div>
	
	
<?php

echo CommentsWidget::widget([
    'model' => $model
]);
?>

</div>