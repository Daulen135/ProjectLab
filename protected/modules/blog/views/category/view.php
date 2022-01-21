<?php
use app\components\useraction\UserAction;
/* @var $this yii\web\View */
/* @var $model app\models\BlogCategory */
/* $this->title = $model->label() .' : ' . $model->title; */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Blogs'),
    'url' => [
        'post/index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Categories'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = (string) $model;
?>
<div class="wrapper">
	<div class="card">
		<div class="blog-category-view">
			<?php

echo \app\components\PageHeader::widget([
    'model' => $model
]);
?>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
    <?php
    
    echo \app\components\TDetailView::widget([
        'id' => 'blog-category-detail-view',
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'state_id',
                'format' => 'raw',
                'value' => $model->getStateBadge()
            ],
            /* [
                'attribute' => 'type_id',
                'value' => $model->getType()
            ],
            'created_on:datetime',
            'updated_on:datetime', */
            [
                'attribute' => 'created_by_id',
                'format' => 'raw',
                'value' => isset($model->createUser) ? $model->createUser->full_name : $model->createUser->first_name
            ]
        ]
    ])?>
<?php

?>
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
