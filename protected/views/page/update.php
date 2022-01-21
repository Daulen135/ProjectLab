<?php

/* @var $this yii\web\View */
/* @var $model app\models\Page */
use yii\helpers\Url;

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Pages'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->title,
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
					<h2>
						<a href="<?= Url::toRoute(['/page/index'])?>"
							class="btn btn-xs btn-link btn-toggle-fullwidth"><i
							class="fa fa-arrow-left"></i></a><?= Yii::t('app', 'Page')?>
					</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a
							href="<?= Url::toRoute(['/page/index'])?>"><i class="icon-home"></i></a></li>
						<li class="breadcrumb-item active"><?= Yii::t('app', 'Update Page')?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
		</div>
	</div>
</div>

