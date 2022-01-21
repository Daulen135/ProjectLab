<?php
use app\components\TDashBox;
use app\components\notice\Notices;
use app\models\EmailQueue;
use app\models\LoginHistory;
use app\modules\logger\models\Log;
use yii\helpers\Url;
use app\models\User;
use app\models\search\User as UserSearch;
use miloschuman\highcharts\Highcharts;
use yii\widgets\ListView;
use app\models\Feed;
use yii\helpers\Html;

/**
 *
 * @copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 * @author : Shiv Charan Panjeta < shiv@toxsl.com >
 */
/* @var $this yii\web\View */
// $this->title = Yii::t ( 'app', 'Dashboard' );
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Dashboard')
];
?>

<div class="container-fluid">
<div class="tab-pane active show" id="Home">
						<div data-key="2941836">
	<?php
/*
 * Pjax::begin([
 * 'id' => 'feed-list-view-project',
 * 'enablePushState' => false,
 * 'enableReplaceState' => false
 * ]);
 */
echo ListView::widget([
    'summary' => false,
    'dataProvider' => Feed::getRecentFeeds($model->id, true),
    'layout' => "{summary}\n\n{items}",
    'itemView' => '//feed/_list'
]);
// Pjax::end();
?>	
				</div>
				<br /> <span><?=Html::a(Yii::t('app', 'Show More') . '... ', Url::toRoute(['/feed/more','id' => $model->id]), ['class' => 'btn btn-success']);?></span>
				
	</div>
	</div>
