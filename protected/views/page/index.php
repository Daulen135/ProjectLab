<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Page */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Pages'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
$title = Yii::t('app', 'Pages');
?>
<div class="wrapper">
	<div class="card">
		<div class="page-index">
				<?=\app\components\PageHeader::widget(['title' => $title]);?>
			</div>

	</div>
	<div class="card">
		<header class="card-header"> 
			  <?php

echo Yii::t('app', strtoupper(Yii::$app->controller->action->id));
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

