<?php

/* @var $this yii\web\View */
/* @var $model app\models\Service */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Services'),
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
$title = Yii::t('app', 'Services');
?>
<div class="wrapper">
	<div class="card">
		<div class="service-update">
			<?=  \app\components\PageHeader::widget(['title' => $title]); ?>
		</div>
	</div>
	<div class="card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>

