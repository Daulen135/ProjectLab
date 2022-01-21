<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Services'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
$title = Yii::t('app', 'Services');
?>

<div class="wrapper">
	<div class="card">
		<div class="service-create">
			<?=  \app\components\PageHeader::widget(['title' => $title]); ?>
		</div>
	</div>

	<div class="content-section clearfix card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>


