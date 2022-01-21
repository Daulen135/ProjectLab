<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Blog */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* $this->title = Yii::t('app', 'Index'); */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Blog'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Post'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
;
?>

<div class="wrapper">
	<div class="blog-index card">
			<?=  \app\components\PageHeader::widget(); ?>
		</div>
		<div class="card">
			<div class="card-body">
				<div class="content-section clearfix">
				<?php echo $this->render('_grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>
				</div>
			</div>
		</div>
	</div>
