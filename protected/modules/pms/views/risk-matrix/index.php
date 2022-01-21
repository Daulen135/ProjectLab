<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pms\models\search\RiskMatrix */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pms'), 'url' => ['/pms']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Risk Matrices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
?>
<div class="wrapper">
	<div class="container-fluid">
			<div class="block-header">
			<div class="row">
				<div class="col-lg-5 col-md-8 col-sm-12">
					<h2>
						<a href="javascript:void(0);"
							class="btn btn-xs btn-link btn-toggle-fullwidth"><i
							class="fa fa-arrow-left"></i></a>Risk Matrix
					</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?= Url::toRoute(['/pms/risk-matrix'])?>"><i
								class="icon-home"></i></a></li>
						<li class="breadcrumb-item active">Risk Matrix</li>
					</ul>
				</div>
			</div>
		</div>
			<div class="card">
		<div class="header my-2">
			<h2>Risk Matrix</h2>
		</div>
			<div class="card-body">
				<div class="content-section clearfix">
					<?php echo $this->render('_grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>
				</div>
			</div>
		</div>
</div>
</div>
