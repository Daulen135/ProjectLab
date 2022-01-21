<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Rename */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Pms'),
    'url' => [
        '/pms'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Renames'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
?>

<div class="wrapper">
	<div class="card">
		<div class="rename-create">
			<?=\app\components\PageHeader::widget(['title' => Yii::t('app', 'Renames')]);?>
		</div>
	</div>

	<div class="content-section clearfix card">
		<?=$this->render('_form', ['model' => $model])?>
	</div>
</div>


