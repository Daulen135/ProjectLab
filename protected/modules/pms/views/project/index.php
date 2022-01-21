<?php
use app\modules\pms\models\Project;
use yii\helpers\Url;
use app\models\User;
$user = Yii::$app->user->identity;
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
<?php
$params = '';
$title = yii::t('app', 'My Projects');
if (isset(Yii::$app->request->queryParams['state_id'])) {
    $params = Yii::$app->request->queryParams['state_id'];
    if ($params == Project::STATE_COMPLETED) {
        $title = 'Completed Project Details';
    } else if ($params == Project::STATE_PLANNING) {

        $title = Yii::t('app', 'Pending Project Details');
    } else {
        $title = Yii::t('app', 'My Projects');
    }
}
Yii::t('app', 'Are you sure you want to delete this item? All related data is deleted')?>
<div class="container-fluid">
	<div class="wrapper">
		<div class="block-header">
			<div class="row">
				<div class="col-lg-5 col-md-8 col-sm-12">
					<h2><?=Yii::t('app', 'My Projects')?></h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a
							href="<?=Url::toRoute(['/pms/project'])?>"><i class="icon-home"></i></a></li>
						<li class="breadcrumb-item active"><?=$title;?></li>
					</ul>
				</div>
			</div>
		</div>
                <?php
                if (empty(Yii::$app->request->queryParams)) {
                    ?>
                <div class="row clearfix">
			<div class="col-lg-3 col-md-6">
				<div class="card top_counter">
					<div class="body">
						<div class="icon text-info">
							<i class="fa fa-user"></i>
						</div>
						<div class="content">
							<div class="text"><?=Yii::t('app', 'Total Projects')?></div>
							<h5 class="number"><?=Project::getTotalProjects()->count();?></h5>
						</div>
					</div>
				</div>
			</div>
			<?php
                    if (User::isAdmin()) {
                        ?>
			<div class="col-lg-3 col-md-6">
				<div class="card top_counter">

					<div class="body">
						<div class="icon text-info">
							<i class="fa fa-user"></i>
						</div>
						<div class="content">
							<div class="text"><?=Yii::t('app', 'Total Users')?></div>
							<h5 class="number"><?=User::find()->count();?></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
                    }
                }
                ?>
</div>
	<div class="card">
		<div class="header my-2">
			<h2><?=Yii::t('app', 'My Projects')?></h2>
		</div>
		<div class="body">
			<div class="table-responsive">
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


</div>