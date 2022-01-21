<?php
/* @var $this yii\web\View */
/* @var $model app\models\BlogCategory */
/* $this->title = Yii::t('app', 'Add'); */
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
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
?>
<div class="wrapper">
	<div class="card">
		<div class="blog-category-create">
	<?=  \app\components\PageHeader::widget(); ?>
</div>
	</div>
	<div class="content-section clearfix card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?></div>
</div>
