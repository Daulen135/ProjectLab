<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\seo\models\Seo */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Seo'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
$title = Yii::t('app', 'Managers');
?>
<div class="wrapper">
	<div class="card">
		<div class="seo-index"><?=  \app\components\PageHeader::widget(['title' => $title]); ?></div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="content-section clearfix">
				<?php echo $this->render('_grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>
					
				</div>

		</div>

	</div>
</div>

