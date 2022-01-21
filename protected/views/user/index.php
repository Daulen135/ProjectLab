<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* $this->title = Yii::t('app', 'Index'); */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Users'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
$title = Yii::t('app', 'Users');
?>
<div class="wrapper" style="margin-top: 60px">
	<div class="card">
		<?=\app\components\PageHeader::widget(['title' => $title]);?>
	</div>
	<div class="card">
		<header class="card-header">   <?php

echo Yii::t('app', strtoupper(Yii::$app->controller->action->id));
?> </header>
		<div class="card-body">
			<?php

echo $this->render('_grid', [
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel
]);
?>
		</div>
	</div>
</div>


