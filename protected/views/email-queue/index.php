<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EmailQueue */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Email Queues'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
$title = Yii::t('app', 'Email Queues');
?>
<div class="wrapper">
	<div class="card">
		<div class="email-queue-index">
				<?=\app\components\PageHeader::widget(['title' => $title]);?>
			</div>

	</div>
	<div class="card">
		<header class="card-header"> 
			  <?php

echo yii::t('app', strtoupper(Yii::$app->controller->action->id));
    ?> 
			</header>
		<div class="card-body">
			<div class="content-section">
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

