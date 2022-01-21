<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\faq\models\Faq */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'FAQs'),
    'url' => [
        '/faq'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'FAQs'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
$title = Yii::t('app', 'FAQs');
?>

<div class="wrapper">
	<div class="card">
		<div class="faq-create">
			<?=  \app\components\PageHeader::widget(['title'=>$title]); ?>
		</div>
	</div>

	<div class="content-section clearfix card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>


