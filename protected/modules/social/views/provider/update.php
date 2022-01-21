<?php

/* @var $this yii\web\View */
/* @var $model app\models\Provider */

/*
 * $this->title = Yii::t('app', 'Update {modelClass}: ', [
 * 'modelClass' => 'Social Provider',
 * ]) . ' ' . $model->title;
 */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Social Providers'),
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
$title = Yii::t('app', 'Social Providers');
?>
<div class="wrapper">
	<div class="card">
		<div class="social-provider-update">
	<?=  \app\components\PageHeader::widget(['title' => $title]); ?>
	</div>
	</div>


	<div class="content-section clearfix card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?></div>
</div>

