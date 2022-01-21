<?php

/* @var $this yii\web\View */
/* @var $model app\models\Provider */

/* $this->title = Yii::t('app', 'Add'); */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Social Providers'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
$title = Yii::t('app', 'Social Providers');
?>

<div class="wrapper">
	<div class="card">

		<div class="social-provider-create">
	<?=\app\components\PageHeader::widget(['title' => $title]);?>
</div>

	</div>

	<div class="content-section clearfix card">

		<?=$this->render('_form', ['model' => $model])?></div>
</div>


