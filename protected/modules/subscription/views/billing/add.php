<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\subscription\models\Billing */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Subscriptions'),
    'url' => [
        '/subscription'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Billings'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
$title = Yii::t('app', 'Subscriptions');
?>

<div class="wrapper">
	<div class="card">
		<div class="billing-create">
			<?=  \app\components\PageHeader::widget(['title' => $title]); ?>
		</div>
	</div>

	<div class="content-section clearfix card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>


