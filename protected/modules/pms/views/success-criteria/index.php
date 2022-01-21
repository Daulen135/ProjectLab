<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pms\models\search\SuccessCriteria */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pms'), 'url' => ['/pms']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Success Criterias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
$title = Yii::t('app', 'Success Criterias');
?>
<div class="wrapper">
		<div class="card">
			<div class="success-criteria-index">
				<?=  \app\components\PageHeader::widget(['title' => $title]); ?>
			</div>
			
		</div>
		<div class="card">
			<header class="card-header"> 
			  <?php echo strtoupper(Yii::$app->controller->action->id); ?> 
			</header>
			<div class="card-body">
				<div class="content-section clearfix">
					<?php echo $this->render('_grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>
				</div>
			</div>
		</div>
</div>

