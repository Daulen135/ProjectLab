<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentGateway */

/* $this->title = Yii::t('app', 'Add'); */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Payment Gateways'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
$title = Yii::t('app', 'Payment Gateways');
?>

<div class="wrapper">
	<div class="card">

		<div class="payment-gateway-create">
	<?=  \app\components\PageHeader::widget(['title' => $title]); ?>
</div>

	</div>

	<div class="content-section clearfix card">

		<?= $this->render ( '_form', [ 'model' => $model ] )?></div>
</div>


