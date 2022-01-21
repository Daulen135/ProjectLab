<?php

/* @var $this yii\web\View */
/* @var $model app\models\User */

/*
 * $this->title = Yii::t('app', 'Update {modelClass}: ', [
 * 'modelClass' => 'User',
 * ]) . ' ' . $model->id;
 */
use yii\helpers\Url;

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Users'),
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
?>
<div class="wrapper">
<div class="container-fluid">
	<div class="block-header">
    <div class="row">
      <div class="col-lg-5 col-md-8 col-sm-12">                        
        <h2><a href="<?= Url::toRoute(['/'])?>" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a><?= Yii::t('app', 'User')?></h2>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= Url::toRoute(['/'])?>"><i class="icon-home"></i></a></li>                            
          <li class="breadcrumb-item active"><?= Yii::t('app', 'Update User')?></li>
        </ul>
      </div> 
    </div>
  </div>
    <div class="content-section card">
      <?= $this->render ( '_form', [ 'model' => $model ] )?></div>
  </div>

</div>