<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\subscription\models\search\Plan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Subscriptions'),
    'url' => [
        '/subscription'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Plans'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
$title = Yii::t('app', 'Subscriptions');
?>
<div class="wrapper">
	<div class="card">
		<div class="plan-index">
				<?=\app\components\PageHeader::widget(['title' => Yii::t('app', 'Plans')]);?>
			</div>

	</div>
	<div class="card">
		<header class="card-header"> 
			  <?php

    echo yii::t('app', strtoupper(Yii::$app->controller->action->id));
    ?> 
			</header>
		<div class="card-body">
			<div class="content-section clearfix">
					<?php

    echo $this->render('_grid', [
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel
    ]);
    ?>
				</div>
		</div>
	</div>
</div>

