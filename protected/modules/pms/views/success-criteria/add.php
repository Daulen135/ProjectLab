<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\SuccessCriteria */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pms'), 'url' => ['/pms']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Success Criterias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
$title = Yii::t('app', 'Success Criterias');
?>

<div class="wrapper">
	<div class="card">
		<div class="success-criteria-create">
			<?=  \app\components\PageHeader::widget(['title' => $title]); ?>
		</div>
	</div>

	<div class="content-section clearfix card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>


