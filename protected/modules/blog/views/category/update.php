<?php
/* @var $this yii\web\View */
/* @var $model app\models\BlogCategory */
/*
 * $this->title = Yii::t('app', 'Update {modelClass}: ', [
 * 'modelClass' => 'Blog Category',
 * ]) . ' ' . $model->title;
 */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Blog'),
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
$this->params['breadcrumbs'][] = [
    'label' => $model->title,
    'url' => [
        'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wrapper">
	<div class="card">
		<div class="blog-category-update">
	<?=  \app\components\PageHeader::widget(['model' => $model]); ?>
	</div>
	</div>
	<div class="content-section clearfix card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?></div>
</div>
