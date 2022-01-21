<?php


/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Rename */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pms'), 'url' => ['/pms']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Renames'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wrapper">
	<div class="card">
		<div class="rename-update">
			<?=  \app\components\PageHeader::widget(['model' => $model]); ?>
		</div>
	</div>
	<div class="card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>

