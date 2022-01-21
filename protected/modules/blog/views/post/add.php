<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */

/* @var $this yii\web\View */

/* $this->title = Yii::t('app', 'Add'); */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Blog'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Post'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
?>
<div class="wrapper">
	<div class="card">
        <div class="blog-add">
        <?=  \app\components\PageHeader::widget(); ?>
    </div>
</div>
	<div class="content-section clearfix card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?></div>
</div>

