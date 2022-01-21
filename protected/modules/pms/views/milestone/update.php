<?php


/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Milestone */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pms'), 'url' => ['/pms']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Milestones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$title = Yii::t('app','Milestones');
?>
<div class="wrapper">
	<div class="card">
		<div class="milestone-update">
			<?=  \app\components\PageHeader::widget(['title' => $title]); ?>
		</div>
	</div>
	<div class="card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>

