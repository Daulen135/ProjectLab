<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pms\models\search\Rename */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
?>
<div class="wrapper">
		<div class="card">
			<div class="rename-index">
				<?=\app\components\PageHeader::widget(['title' => Yii::t('app', 'Renames')]);?>
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

