<?php

/* @var $this yii\web\View */
/* @var $model app\modules\subscription\models\Plan */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Subscriptions'),
    'url' => [
        '/subscription'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Plans'),
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
$title = Yii::t('app', 'Subscriptions');
?>
<div class="wrapper">
	<div class="card">
		<div class="plan-update">
			<?=\app\components\PageHeader::widget(['title' => Yii::t('app', 'Plans')]);?>
		</div>
	</div>
	<div class="card">
		<?=$this->render('_form', ['model' => $model])?>
	</div>
</div>

