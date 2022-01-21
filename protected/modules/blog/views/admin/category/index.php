<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BlogCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* $this->title = Yii::t('app', 'Index'); */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Blog'),
    'url' => [
        'post/index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Categories'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
?>
<div class="wrapper">
	<div class="card">
			<div class="blog-category-index">
<?=  \app\components\PageHeader::widget(); ?>
  </div>
		</div>
		<div class="content-section clearfix card" id="category-form"
			style="display: none">
			<div class="card ">
		<?= $this->render ( '_form', ['model' => $model])?>
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


<script type="text/javascript">
$('#tool-btn-add').on('click',function(){
	$('#category-form').toggle('slow');
});
</script>