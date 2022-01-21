<?php


use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Finance */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pms'), 'url' => ['/pms']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Finances'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wrapper">
	<div class="container-fluid">
	<div class="block-header">
    <div class="row">
      <div class="col-lg-5 col-md-8 col-sm-12">                        
        <h2><a href="<?= Url::toRoute(['/pms/project'])?>" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> NPV</h2>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= Url::toRoute(['/pms/project'])?>"><i class="icon-home"></i></a></li>                            
          <li class="breadcrumb-item active">Update NPV</li>
        </ul>
      </div> 
    </div>
  </div>
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>
