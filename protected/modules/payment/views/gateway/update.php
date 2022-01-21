<?php

/* @var $this yii\web\View */
/* @var $model app\models\PaymentGateway */

/*
 * $this->title = Yii::t('app', 'Update {modelClass}: ', [
 * 'modelClass' => 'Payment Gateway',
 * ]) . ' ' . $model->title;
 */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Payment Gateways'),
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
$title = Yii::t('app', 'Payment Gateways');
?>
<div class="wrapper">
	<div class="card">
		<div class="payment-gateway-update">
	<?=  \app\components\PageHeader::widget(['title' => $title]); ?>
	</div>
	</div>


	<div class="content-section clearfix card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?></div>
</div>

