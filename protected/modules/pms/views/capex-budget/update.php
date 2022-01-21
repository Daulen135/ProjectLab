<?php

/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\CapexBudget */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Pms'),
    'url' => [
        '/pms'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Capex Budgets'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->id,
    'url' => [
        'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$title = Yii::t('app', 'Capex Budgets');
?>
<div class="wrapper">
	<div class="card">
		<div class="capex-budget-update">
			<?=  \app\components\PageHeader::widget(['title' => $title]); ?>
		</div>
	</div>
	<div class="card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>

