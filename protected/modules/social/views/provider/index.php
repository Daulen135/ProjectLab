<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Provider */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* $this->title = Yii::t('app', 'Index'); */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Social Providers'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
$title = Yii::t('app', 'Social Providers');
?>
<div class="wrapper">
	<div class="user-index">
		<div class="card">

			<div class="social-provider-index">

<?=  \app\components\PageHeader::widget(['title' => $title]); ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

			</div>
		</div>
		<div class="card">
			<header class="card-header head-border">   <?php echo strtoupper(Yii::$app->controller->action->id); ?> </header>
			<div class="card-body">
				<div class="content-section clearfix">
				
		<?php echo $this->render('_grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>
</div>
			</div>
		</div>
	</div>
</div>

