<?php

/* @var $this yii\web\View */
/* @var $model app\modules\faq\models\Faq */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Faqs'),
    'url' => [
        '/faq'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Faqs'),
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
$title = Yii::t('app', 'Faqs');
?>
<div class="wrapper">
	<div class="card">
		<div class="faq-update">
			<?=  \app\components\PageHeader::widget(['title' => $title]); ?>
		</div>
	</div>
	<div class="card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>

