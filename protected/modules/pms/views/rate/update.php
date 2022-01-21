<?php


/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Rate */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pms'), 'url' => ['/pms']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wrapper">
	<div class="card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>

