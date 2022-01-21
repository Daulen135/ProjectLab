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
	<div class="block-header">
		<div class="row">
			<div class="col-lg-5 col-md-8 col-sm-12">
				<h2>
					<a href="javascript:void(0);"
						class="btn btn-xs btn-link btn-toggle-fullwidth"><i
						class="fa fa-arrow-left"></i></a><?= Yii::t('app', 'My Projects')?>
				</h2>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php Url::toRoute(['/']);?>"><i
							class="icon-home"></i></a></li>
					<li class="breadcrumb-item active"><?= Yii::t('app', 'Projects')?></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-lg-3 col-md-6">
			<div class="card top_counter">
				<a href="<?= Url::toRoute(['/dashboard/my-project'])?>"
					class="completed_proj">
					<div class="body">
						<div class="icon text-info">
							<i class="fa fa-user"></i>
						</div>
						<div class="content">
							<div class="text"><?= Yii::t('app', 'Total Completed Projects')?></div>
							<h5 class="number">530</h5>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="card top_counter">
				<a href="#0" class="completed_proj">
					<div class="body">
						<div class="icon text-warning">
							<i class="fa fa-tags"></i>
						</div>
						<div class="content">
							<div class="text"><?= Yii::t('app', 'Total Pending Projects')?></div>
							<h5 class="number">7</h5>
						</div>
					</div>
				</a>
			</div>
		</div>


	</div>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="header">
					<h2>My Projects</h2>
					<ul class="header-dropdown">
						<li class="dropdown"><a href="javascript:void(0);"
							class="dropdown-toggle" data-toggle="dropdown" role="button"
							aria-haspopup="true" aria-expanded="false"></a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li><a href="javascript:void(0);">Action</a></li>
								<li><a href="javascript:void(0);">Another Action</a></li>
								<li><a href="javascript:void(0);">Something else</a></li>
							</ul></li>
					</ul>
				</div>

				<div class="body">
					<div class="table-responsive">
						<table class="table table-hover m-b-0">
							<thead class="thead-dark">
								<tr>
									<th>S.No</th>
									<th>Project Name</th>
									<th>Client Name</th>
									<th>Project Manager Name</th>
									<th>Project Start Date</th>
									<th>Project Description</th>
									<th>Project Deliverables</th>
									<th>Project Success Criterias</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td><span class="list-name">Joseph</span></td>
									<td>Marky</td>
									<td>Christ</td>
									<td>7th July 2023</td>
									<td>Lorem Ipsum lorem ipsum lorem ipsum ...</td>
									<td>Lorem Ipsum</td>
									<td>SDLC</td>
									<td><span class="badge badge-success bg-success text-white">Completed</span></td>
									<td><a href="<?= Url::toRoute(['project-view'])?>"
										class="eye text-theme"><i class="fa fa-eye mr-2 text-theme"></i></a><a
										href="#2" class="eye  text-primary"><i
											class="fa fa-edit mr-2 text-primary"></i></a><a href="#2"
										class="eye  text-danger"><i
											class="fa fa-trash mr-2 text-danger"></i></a></td>

								</tr>
								<tr>
									<td>2</td>
									<td><span class="list-name">Joseph</span></td>
									<td>Marky</td>
									<td>Christ</td>
									<td>7th July 2023</td>
									<td>Lorem Ipsum lorem ipsum lorem ipsum ...</td>
									<td>Lorem Ipsum</td>
									<td>SDLC</td>
									<td><span class="badge badge-success bg-success text-white">Completed</span></td>
									<td><a href="<?= Url::toRoute(['project-view'])?>"
										class="eye text-theme"><i class="fa fa-eye mr-2 text-theme"></i></a><a
										href="#2" class="eye  text-primary"><i
											class="fa fa-edit mr-2 text-primary"></i></a><a href="#2"
										class="eye  text-danger"><i
											class="fa fa-trash mr-2 text-danger"></i></a></td>
								</tr>
								<tr>
									<td>3</td>
									<td><span class="list-name">Joseph</span></td>
									<td>Marky</td>
									<td>Christ</td>
									<td>7th July 2023</td>
									<td>Lorem Ipsum lorem ipsum lorem ipsum ...</td>
									<td>Lorem Ipsum</td>
									<td>SDLC</td>
									<td><span class="badge badge-success bg-success text-white">Completed</span></td>
									<td><a href="<?= Url::toRoute(['project-view'])?>"
										class="eye text-theme"><i class="fa fa-eye mr-2 text-theme"></i></a><a
										href="#2" class="eye  text-primary"><i
											class="fa fa-edit mr-2 text-primary"></i></a><a href="#2"
										class="eye  text-danger"><i
											class="fa fa-trash mr-2 text-danger"></i></a></td>
								</tr>
								<tr>
									<td>4</td>
									<td><span class="list-name">Joseph</span></td>
									<td>Marky</td>
									<td>Christ</td>
									<td>7th July 2023</td>
									<td>Lorem Ipsum lorem ipsum lorem ipsum ...</td>
									<td>Lorem Ipsum</td>
									<td>SDLC</td>
									<td><span class="badge badge-success bg-success text-white">Completed</span></td>
									<td><a href="<?= Url::toRoute(['project-view'])?>"
										class="eye text-theme"><i class="fa fa-eye mr-2 text-theme"></i></a><a
										href="#2" class="eye  text-primary"><i
											class="fa fa-edit mr-2 text-primary"></i></a><a href="#2"
										class="eye  text-danger"><i
											class="fa fa-trash mr-2 text-danger"></i></a></td>
								</tr>
								<tr>
									<td>5</td>
									<td><span class="list-name">Joseph</span></td>
									<td>Marky</td>
									<td>Christ</td>
									<td>7th July 2023</td>
									<td>Lorem Ipsum lorem ipsum lorem ipsum ...</td>
									<td>Lorem Ipsum</td>
									<td>SDLC</td>
									<td><span class="badge badge-success bg-success text-white">Completed</span></td>
									<td><a href="<?= Url::toRoute(['project-view'])?>"
										class="eye text-theme"><i class="fa fa-eye mr-2 text-theme"></i></a><a
										href="#2" class="eye  text-primary"><i
											class="fa fa-edit mr-2 text-primary"></i></a><a href="#2"
										class="eye  text-danger"><i
											class="fa fa-trash mr-2 text-danger"></i></a></td>
								</tr>
								<tr>
									<td>6</td>
									<td><span class="list-name">Joseph</span></td>
									<td>Marky</td>
									<td>Christ</td>
									<td>7th July 2023</td>
									<td>Lorem Ipsum lorem ipsum lorem ipsum ...</td>
									<td>Lorem Ipsum</td>
									<td>SDLC</td>
									<td><span class="badge badge-success bg-success text-white">Completed</span></td>
									<td><a href="<?= Url::toRoute(['project-view'])?>"
										class="eye text-theme"><i class="fa fa-eye mr-2 text-theme"></i></a><a
										href="#2" class="eye  text-primary"><i
											class="fa fa-edit mr-2 text-primary"></i></a><a href="#2"
										class="eye  text-danger"><i
											class="fa fa-trash mr-2 text-danger"></i></a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>