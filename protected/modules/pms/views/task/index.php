<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pms\models\search\Task */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pms'), 'url' => ['/pms']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
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
							class="fa fa-arrow-left"></i></a>My Tasks
					</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?= Url::toRoute(['/pms/task'])?>"><i
								class="icon-home"></i></a></li>
						<li class="breadcrumb-item active">My Tasks</li>
					</ul>
				</div>
			</div>
		</div>
			<div class="card">
		<div class="header my-2">
			<h2>My Tasks</h2>
		</div>
		<div class="body">
			<div class="table-responsive">
					<?php echo $this->render('_grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>		
		</div>
	</div>
				</div>
			</div>
			</div>