<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PaymentGateway */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* $this->title = Yii::t('app', 'Index'); */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Payment Gateways'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Index');
$title = Yii::t('app', 'Payment Gateways');

?>
<div class="wrapper">
	<div class="user-index">
		<div class="card">
			
<?=  \app\components\PageHeader::widget(['title' => $title]); ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  
		</div>
		<div class="card">
			<header class="card-header">   <?php echo strtoupper(Yii::$app->controller->action->id); ?> </header>
			<div class="card-body">
		<?php echo $this->render('_grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>
			</div>
		</div>
	</div>

</div>

