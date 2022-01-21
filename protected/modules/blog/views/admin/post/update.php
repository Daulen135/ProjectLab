<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
$this->params ['breadcrumbs'] [] = [
    'label' => Yii::t ( 'app', 'Blog' ),
    'url' => [
        'index'
    ]
];
$this->params ['breadcrumbs'] [] = [ 
		'label' => Yii::t ( 'app', 'post' ),
		'url' => [ 
				'index' 
		] 
];

$this->params ['breadcrumbs'] [] = Yii::t ( 'app', 'Update' );
?>
<div class="wrapper">
	<div class="card">
		<?=  \app\components\PageHeader::widget(['model' => $model]); ?>
		</div>

	<div class="content-section clearfix card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?></div>
</div>

