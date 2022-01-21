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
						class="fa fa-arrow-left"></i></a>My Projects
				</h2>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php"><i
							class="icon-home"></i></a></li>
					<li class="breadcrumb-item active">Completed Project Details</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="body nav-tags">
				<ul class="nav nav-tabs">
					<li class="nav-item"><a class="nav-link active show"
						data-toggle="tab" href="#Home">Activities</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab"
						href="#Profile">Project Passport</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab"
						href="#Contact">WBS</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab"
						href="#risk">Risk Matrix</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab"
						href="#budget">Budget</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab"
						href="#finance">Calculations</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab"
						href="#plan">Project Schedule</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab"
						href="#report">Report</a></li>

				</ul>
				<div class="tab-content">
					<div class="tab-pane active show" id="Home">
						<h6>Activities</h6>
						<div data-key="2941836">
							<li class="list-group-item">
								<ul class="list-unstyled d-flex">
									<li class="my-2">
										<div class="comment-image ">
											<img class="img-responsive rounded-circle"
												src="/project-lab/themes/new/admin/img/user.png" width="50" height="50">
										</div>
									</li>
									<li class="ml-2">
										<div id="2941836" class="mic-info activity">
											Modified Project Status <a
												href="/pms/project-status/view/165301/project-1395-uinone-2020-07-30-thursday-by-dinky-arora-web-python">Project-01:Test-01
												: 2020-07-30 [ Thursday ] by Joseph </a>
										</div>
										<div class="mic-info">
											By <a href="/user/view/744/rajat-sharma-pc">Kelly</a> an hour
											ago
										</div>
									</li>

								</ul>

							</li>
							<li class="list-group-item">
								<ul class="list-unstyled d-flex">
									<li class="my-2">
										<div class="comment-image ">
											<img class="img-responsive rounded-circle"
												src="/project-lab/themes/new/admin/img/user.png" width="50" height="50">
										</div>
									</li>
									<li class="ml-2">
										<div id="2941836" class="mic-info activity">
											Modified Project Status <a
												href="/pms/project-status/view/165301/project-1395-uinone-2020-07-30-thursday-by-dinky-arora-web-python">Project-01:Test-01
												: 2020-07-30 [ Thursday ] by Joseph </a>
										</div>
										<div class="mic-info">
											By <a href="/user/view/744/rajat-sharma-pc">Kelly</a> an hour
											ago
										</div>
									</li>

								</ul>

							</li>
							<li class="list-group-item">
								<ul class="list-unstyled d-flex">
									<li class="my-2">
										<div class="comment-image ">
											<img class="img-responsive rounded-circle"
												src="/project-lab/themes/new/admin/img/user.png" width="50" height="50">
										</div>
									</li>
									<li class="ml-2">
										<div id="2941836" class="mic-info activity">
											Modified Project Status <a
												href="/pms/project-status/view/165301/project-1395-uinone-2020-07-30-thursday-by-dinky-arora-web-python">Project-01:Test-01
												: 2020-07-30 [ Thursday ] by Joseph </a>
										</div>
										<div class="mic-info">
											By <a href="/user/view/744/rajat-sharma-pc">Kelly</a> an hour
											ago
										</div>
									</li>

								</ul>

							</li>
							<li class="list-group-item">
								<ul class="list-unstyled d-flex">
									<li class="my-2">
										<div class="comment-image ">
											<img class="img-responsive rounded-circle"
												src="/project-lab/themes/new/admin/img/user.png" width="50" height="50">
										</div>
									</li>
									<li class="ml-2">
										<div id="2941836" class="mic-info activity">
											Modified Project Status <a
												href="/pms/project-status/view/165301/project-1395-uinone-2020-07-30-thursday-by-dinky-arora-web-python">Project-01:Test-01
												: 2020-07-30 [ Thursday ] by Joseph </a>
										</div>
										<div class="mic-info">
											By <a href="/user/view/744/rajat-sharma-pc">Kelly</a> an hour
											ago
										</div>
									</li>

								</ul>

							</li>
							<li class="list-group-item">
								<ul class="list-unstyled d-flex">
									<li class="my-2">
										<div class="comment-image ">
											<img class="img-responsive rounded-circle"
												src="/project-lab/themes/new/admin/img/user.png" width="50" height="50">
										</div>
									</li>
									<li class="ml-2">
										<div id="2941836" class="mic-info activity">
											Modified Project Status <a
												href="/pms/project-status/view/165301/project-1395-uinone-2020-07-30-thursday-by-dinky-arora-web-python">Project-01:Test-01
												: 2020-07-30 [ Thursday ] by Joseph </a>
										</div>
										<div class="mic-info">
											By <a href="/user/view/744/rajat-sharma-pc">Kelly</a> an hour
											ago
										</div>
									</li>

								</ul>

							</li>
							<li class="list-group-item">
								<ul class="list-unstyled d-flex">
									<li class="my-2">
										<div class="comment-image ">
											<img class="img-responsive rounded-circle"
												src="/project-lab/themes/new/admin/img/user.png" width="50" height="50">
										</div>
									</li>
									<li class="ml-2">
										<div id="2941836" class="mic-info activity">
											Modified Project Status <a
												href="/pms/project-status/view/165301/project-1395-uinone-2020-07-30-thursday-by-dinky-arora-web-python">Project-01:Test-01
												: 2020-07-30 [ Thursday ] by Joseph </a>
										</div>
										<div class="mic-info">
											By <a href="/user/view/744/rajat-sharma-pc">Kelly</a> an hour
											ago
										</div>
									</li>

								</ul>

							</li>
							<li class="list-group-item">
								<ul class="list-unstyled d-flex">
									<li class="my-2">
										<div class="comment-image ">
											<img class="img-responsive rounded-circle"
												src="/project-lab/themes/new/admin/img/user.png" width="50" height="50">
										</div>
									</li>
									<li class="ml-2">
										<div id="2941836" class="mic-info activity">
											Modified Project Status <a
												href="/pms/project-status/view/165301/project-1395-uinone-2020-07-30-thursday-by-dinky-arora-web-python">Project-01:Test-01
												: 2020-07-30 [ Thursday ] by Joseph </a>
										</div>
										<div class="mic-info">
											By <a href="/user/view/744/rajat-sharma-pc">Kelly</a> an hour
											ago
										</div>
									</li>

								</ul>

							</li>
						</div>
					</div>
					<div class="tab-pane" id="Profile">
						<div class="table-responsive">
							<table id="project-detail-view"
								class="table table-striped table-bordered detail-view">
								<tbody>
									<tr>
										<th>Project Name</th>
										<td colspan="1">Test-01</td>
										<th>Client Name</th>
										<td colspan="1">Joseph</td>
									</tr>
									<tr>
										<th>Project Manager Name</th>
										<td colspan="1">Kelly E.</td>
									</tr>
									<tr>
										<th>Planned Start Date</th>
										<td colspan="1">2020-06-10</td>
										<th>Planned Completion Date</th>
										<td colspan="1">2020-06-30</td>
									</tr>
									<tr>
										<th>Project Deliverable</th>
										<td colspan="1">Deliverable 1</td>
										<th>Milestone</th>
										<td colspan="1">Milestone 1</td>
									</tr>
									<tr>
										<th>Success Criteria</th>
										<td colspan="1">Criteria 1</td>
										<th>Status</th>
										<td colspan="1"><span class="badge bg-success text-white">Completed</span></td>
									</tr>
									<tr>
										<th>Created By</th>
										<td colspan="1">Kelly-01</td>
									</tr>
								</tbody>
							</table>
							<table class="table table-striped table-bordered detail-view">
								<tbody>
									<tr>
										<th>Project Description</th>
										<td colspan="1">Manage Daily Operations. One of the Manage
											Daily Operations. One of the Manage Daily Operations. One of
											the Manage Daily Operations. One of the</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane" id="Contact">
						<div class="table-responsive">
							<table class="table table-hover m-b-0">
								<thead class="thead-dark">
									<tr>
										<th>S.No</th>
										<th>Task</th>
										<th>Description</th>
										<th>Budget</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td><span class="list-name">Task 1</span></td>
										<td>Manage Daily Operations. One of the key functions of a
											manager is simply ensuring that the organization operates
											smoothly on a daily basis...</td>
										<td>$456.76</td>
										<td><a href="#2" data-toggle="modal" data-target="#edit-wbs"
											class="eye text-theme"><i class="fa fa-edit mr-2 text-theme"></i></a>
									
									</tr>
									<tr>
										<td>2</td>
										<td><span class="list-name">Task 1</span></td>
										<td>Manage Daily Operations. One of the key functions of a
											manager is simply ensuring that the organization operates
											smoothly on a daily basis...</td>
										<td>$456.76</td>
										<td><a href="#2" data-toggle="modal" data-target="#edit-wbs"
											class="eye text-theme"><i class="fa fa-edit mr-2 text-theme"></i></a>
									
									</tr>
									<tr>
										<td>3</td>
										<td><span class="list-name">Task 1</span></td>
										<td>Manage Daily Operations. One of the key functions of a
											manager is simply ensuring that the organization operates
											smoothly on a daily basis...</td>
										<td>$456.76</td>
										<td><a href="#2" data-toggle="modal" data-target="#edit-wbs"
											class="eye text-theme"><i class="fa fa-edit mr-2 text-theme"></i></a>
									
									</tr>
									<tr>
										<td>4</td>
										<td><span class="list-name">Task 1</span></td>
										<td>Manage Daily Operations. One of the key functions of a
											manager is simply ensuring that the organization operates
											smoothly on a daily basis...</td>
										<td>$456.76</td>
										<td><a href="#2" data-toggle="modal" data-target="#edit-wbs"
											class="eye text-theme"><i class="fa fa-edit mr-2 text-theme"></i></a>
									
									</tr>
									<tr>
										<td>5</td>
										<td><span class="list-name">Task 1</span></td>
										<td>Manage Daily Operations. One of the key functions of a
											manager is simply ensuring that the organization operates
											smoothly on a daily basis...</td>
										<td>$456.76</td>
										<td><a href="#2" data-toggle="modal" data-target="#edit-wbs"
											class="eye text-theme"><i class="fa fa-edit mr-2 text-theme"></i></a>
									
									</tr>
									<tr>
										<td>6</td>
										<td><span class="list-name">Task 1</span></td>
										<td>Manage Daily Operations. One of the key functions of a
											manager is simply ensuring that the organization operates
											smoothly on a daily basis...</td>
										<td>$456.76</td>
										<td><a href="#2" data-toggle="modal" data-target="#edit-wbs"
											class="eye text-theme"><i class="fa fa-edit mr-2 text-theme"></i></a>
									
									</tr>
									<tr>
										<td>7</td>
										<td><span class="list-name">Task 1</span></td>
										<td>Manage Daily Operations. One of the key functions of a
											manager is simply ensuring that the organization operates
											smoothly on a daily basis...</td>
										<td>$456.76</td>
										<td><a href="#2" data-toggle="modal" data-target="#edit-wbs"
											class="eye text-theme"><i class="fa fa-edit mr-2 text-theme"></i></a>
									
									</tr>
									<tr>
										<td>8</td>
										<td><span class="list-name">Task 1</span></td>
										<td>Manage Daily Operations. One of the key functions of a
											manager is simply ensuring that the organization operates
											smoothly on a daily basis...</td>
										<td>$456.76</td>
										<td><a href="#2" data-toggle="modal" data-target="#edit-wbs"
											class="eye text-theme"><i class="fa fa-edit mr-2 text-theme"></i></a>
									
									</tr>
									<tr>
										<td>9</td>
										<td><span class="list-name">Task 1</span></td>
										<td>Manage Daily Operations. One of the key functions of a
											manager is simply ensuring that the organization operates
											smoothly on a daily basis...</td>
										<td>$456.76</td>
										<td><a href="#2" data-toggle="modal" data-target="#edit-wbs"
											class="eye text-theme"><i class="fa fa-edit mr-2 text-theme"></i></a>
									
									</tr>
									<tr>
										<td>10</td>
										<td><span class="list-name">Task 1</span></td>
										<td>Manage Daily Operations. One of the key functions of a
											manager is simply ensuring that the organization operates
											smoothly on a daily basis...</td>
										<td>$456.76</td>
										<td><a href="#2" data-toggle="modal" data-target="#edit-wbs"
											class="eye text-theme"><i class="fa fa-edit mr-2 text-theme"></i></a>
									
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane" id="risk">
						<div class="table-responsive">
							<table class="table table-hover m-b-0">
								<thead class="thead-dark">
									<tr>
										<th>S.No</th>
										<th>Risk Description</th>
										<th>Liklihood</th>
										<th>Conseqense</th>
										<th>Risk Status</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td><span class="list-name">Manage Daily Operations. One of t</span></td>
										<td>Almost Certain</td>
										<td>Insinigificant</td>
										<td><span class="badge badge-danger text-white bg-danger">Extreme</span></td>
									</tr>
									<tr>
										<td>2</td>
										<td><span class="list-name">Manage Daily Operations. One of t</span></td>
										<td>Almost Certain</td>
										<td>Insinigificant</td>
										<td><span class="badge badge-success bg-success text-white">Low</span></td>
									</tr>
									<tr>
										<td>3</td>
										<td><span class="list-name">Manage Daily Operations. One of t</span></td>
										<td>Almost Certain</td>
										<td>Insinigificant</td>
										<td><span class="badge bg-danger text-white badge-danger">Extreme</span></td>
									</tr>
									<tr>
										<td>4</td>
										<td><span class="list-name">Manage Daily Operations. One of t</span></td>
										<td>Almost Certain</td>
										<td>Insinigificant</td>
										<td><span class="badge badge-success bg-success text-white">Low</span></td>
									</tr>
									<tr>
										<td>5</td>
										<td><span class="list-name">Manage Daily Operations. One of t</span></td>
										<td>Almost Certain</td>
										<td>Insinigificant</td>
										<td><span class="badge bg-danger text-white badge-danger">Extreme</span></td>
									</tr>
									<tr>
										<td>6</td>
										<td><span class="list-name">Manage Daily Operations. One of t</span></td>
										<td>Almost Certain</td>
										<td>Insinigificant</td>
										<td><span class="badge badge-warning bg-warning text-white">Moderate</span></td>
									</tr>
									<tr>
										<td>7</td>
										<td><span class="list-name">Manage Daily Operations. One of t</span></td>
										<td>Almost Certain</td>
										<td>Insinigificant</td>
										<td><span class="badge bg-danger text-white badge-danger">Extreme</span></td>
									</tr>
									<tr>
										<td>8</td>
										<td><span class="list-name">Manage Daily Operations. One of t</span></td>
										<td>Almost Certain</td>
										<td>Insinigificant</td>
										<td><span class="badge badge-warning bg-warning text-white">Moderate</span></td>
									</tr>
									<tr>
										<td>9</td>
										<td><span class="list-name">Manage Daily Operations. One of t</span></td>
										<td>Almost Certain</td>
										<td>Insinigificant</td>
										<td><span class="badge bg-danger text-white badge-danger">Extreme</span></td>
									</tr>
									<tr>
										<td>10</td>
										<td><span class="list-name">Manage Daily Operations. One of t</span></td>
										<td>Almost Certain</td>
										<td>Insinigificant</td>
										<td><span class="badge badge-warning bg-warning text-white">Moderate</span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane" id="plan">
						<div class="row clearfix">
							<div class="col-md-12">
								<div class="card">
									<div class="header text-theme">
										<h2 class="text-theme">Project Plan</h2>
									</div>
									<div class="body">
										<form id="basic-form" method="post" novalidate="">
											<div class="form-row">
												<div class="form-group col-md">
													<label>Project Name</label> <input type="text"
														class="form-control" required="">
												</div>
												<div class="form-group col-md">
													<label>Project Manager</label> <input type="text"
														class="form-control" required="">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md">
													<label>Start Date</label> <input type="Date"
														class="form-control" required="">
												</div>
												<div class="form-group col-md">
													<label>End Date</label> <input type="Date"
														class="form-control" required="">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md">
													<label>Overall Project Progress</label>
													<div class="progress">
														<div class="progress-bar" style="width: 70%">70%</div>
													</div>
												</div>
											</div>

											<div class="body my-3">
												<div class="table-responsive">
													<table class="table table-hover m-b-0">
														<thead class="thead-dark">
															<tr>
																<th>Task Name</th>
																<th>Assigned to</th>
																<th>Start Date</th>
																<th>End Date</th>
																<th>Duration In Days</th>
																<th>% Complete</th>
																<th>Status</th>
																<th>Notes</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Sprint 1</td>
																<td><span class="list-name">Kelly E.</span></td>
																<td>06/28</td>
																<td>07/02</td>
																<td>5</td>
																<td>100%</td>
																<td><span class="badge badge-success">Completed</span></td>
																<td><input type="text" name="notes"></td>

															</tr>
															<tr>
																<td>Sprint 1</td>
																<td><span class="list-name">Kelly E.</span></td>
																<td>06/28</td>
																<td>07/02</td>
																<td>5</td>
																<td>100%</td>
																<td><span class="badge badge-success">Completed</span></td>
																<td><input type="text" name="notes"></td>

															</tr>
															<tr>
																<td>Sprint 1</td>
																<td><span class="list-name">Kelly E.</span></td>
																<td>06/28</td>
																<td>07/02</td>
																<td>5</td>
																<td>100%</td>
																<td><span class="badge badge-success">Completed</span></td>
																<td><input type="text" name="notes"></td>

															</tr>
															<tr>
																<td>Sprint 1</td>
																<td><span class="list-name">Kelly E.</span></td>
																<td>06/28</td>
																<td>07/02</td>
																<td>5</td>
																<td>100%</td>
																<td><span class="badge badge-success">Completed</span></td>
																<td><input type="text" name="notes"></td>

															</tr>
															<tr>
																<td>Sprint 1</td>
																<td><span class="list-name">Kelly E.</span></td>
																<td>06/28</td>
																<td>07/02</td>
																<td>5</td>
																<td>100%</td>
																<td><span class="badge badge-success">Completed</span></td>
																<td><input type="text" name="notes"></td>

															</tr>
															<tr>
																<td>Sprint 1</td>
																<td><span class="list-name">Kelly E.</span></td>
																<td>06/28</td>
																<td>07/02</td>
																<td>5</td>
																<td>100%</td>
																<td><span class="badge badge-success">Completed</span></td>
																<td><input type="text" name="notes"></td>

															</tr>
															<tr>
																<td>Sprint 1</td>
																<td><span class="list-name">Kelly E.</span></td>
																<td>06/28</td>
																<td>07/02</td>
																<td>5</td>
																<td>100%</td>
																<td><span class="badge badge-success">Completed</span></td>
																<td><input type="text" name="notes"></td>

															</tr>
															<tr>
																<td>Sprint 1</td>
																<td><span class="list-name">Kelly E.</span></td>
																<td>06/28</td>
																<td>07/02</td>
																<td>5</td>
																<td>100%</td>
																<td><span class="badge badge-success">Completed</span></td>
																<td><input type="text" name="notes"></td>

															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<br>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="finance">
						<div class="row">
							<div class="col-lg-6">
								<h5 class="my-2">NPV</h5>
								<div class="table-responsive">
									<table class="table table-hover m-b-0">
										<thead class="thead-dark">
											<tr>
												<th>S.No</th>
												<th>Rate</th>
												<th>T (Period)</th>
												<th>CF</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>Input Data</td>
												<td>0</td>
												<td>Input Data</td>
												<td><a href="#2" data-toggle="modal" data-target="#edit-npv"><i
														class="fa fa-edit"></i> <span></span></a></td>
											</tr>
											<tr>
												<td>1</td>
												<td>Input Data</td>
												<td>0</td>
												<td>Input Data</td>
												<td><a href="#2" data-toggle="modal" data-target="#edit-npv"><i
														class="fa fa-edit"></i> <span></span></a></td>
											</tr>
											<tr>
												<td>1</td>
												<td>Input Data</td>
												<td>0</td>
												<td>Input Data</td>
												<td><a href="#2" data-toggle="modal" data-target="#edit-npv"><i
														class="fa fa-edit"></i> <span></span></a></td>
											</tr>
											<tr>
												<td>1</td>
												<td>Input Data</td>
												<td>0</td>
												<td>Input Data</td>
												<td><a href="#2" data-toggle="modal" data-target="#edit-npv"><i
														class="fa fa-edit"></i> <span></span></a></td>
											</tr>
											<tr>
												<td>1</td>
												<td>Input Data</td>
												<td>0</td>
												<td>Input Data</td>
												<td><a href="#2" data-toggle="modal" data-target="#edit-npv"><i
														class="fa fa-edit"></i> <span></span></a></td>
											</tr>
											<tr>
												<td>1</td>
												<td>Input Data</td>
												<td>0</td>
												<td>Input Data</td>
												<td><a href="#2" data-toggle="modal" data-target="#edit-npv"><i
														class="fa fa-edit"></i> <span></span></a></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-lg-6">
								<h5 class="my-2">Finance Reports</h5>
								<div class="table-responsive">
									<table class="table table-hover m-b-0">
										<thead class="thead-dark">
											<tr>
												<th></th>
												<th>Value</th>
												<th>Description</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>Project Budget</th>
												<td>Calculation From Formulae</td>
												<td>CAPEX + OPEX</td>
											</tr>
											<tr>
												<th>NPV</th>
												<td>Calculation From Formulae</td>
												<td>NPV is the present value of future cash flows</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="budget">
						<div class="row">
							<div class="col-lg-12">
								<h5 class="my-2">CAPEX</h5>
								<div class="table-responsive">
									<table class="table table-hover m-b-0">
										<thead class="thead-dark">
											<tr>
												<th>S.No</th>
												<th>Task Name</th>
												<th>Task Description</th>
												<th>CAPEX Per Task</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>Manage Leads</td>
												<td>Manage Daily Operations. One of the key functions ...</td>
												<td></td>
											</tr>
											<tr>
												<td>2</td>
												<td>Manage Leads</td>
												<td>Manage Daily Operations. One of the key functions ...</td>
												<td></td>
											</tr>
											<tr>
												<td>3</td>
												<td>Manage Leads</td>
												<td>Manage Daily Operations. One of the key functions ...</td>
												<td></td>
											</tr>
											<tr>
												<td>4</td>
												<td>Manage Leads</td>
												<td>Manage Daily Operations. One of the key functions ...</td>
												<td></td>
											</tr>
											<tr>
												<td>5</td>
												<td>Manage Leads</td>
												<td>Manage Daily Operations. One of the key functions ...</td>
												<td></td>
											</tr>
											<tr>
												<td>6</td>
												<td>Manage Leads</td>
												<td>Manage Daily Operations. One of the key functions ...</td>
												<td></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-lg-12">
								<h5 class="my-2">OPEX</h5>
								<div class="table-responsive">
									<table class="table table-hover m-b-0">
										<thead class="thead-dark">
											<tr>
												<th>General Expeses</th>
												<th>Payroll</th>
												<th>Others</th>
												<th>Total OPEX</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th></th>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<th></th>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<th></th>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<th></th>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="report">
						<div class="table-responsive">
							<table class="table table-hover m-b-0">
								<thead class="thead-dark">
									<tr>
										<th>S.No</th>
										<th>Report Name</th>
										<th>Report Description</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td><span class="list-name">Activities</span></td>
										<td>Manage Daily Operations. One of the...</td>
										<td><a href="<?= Url::toRoute(['report-view'])?>" class="eye text-theme"><i
												class="fa fa-eye mr-2 text-theme"></i></a><a href="#2"
											class="eye  text-primary"><i
												class="fa fa-print mr-2 text-primary"></i></a></td>

									</tr>
									<tr>
										<td>3</td>
										<td><span class="list-name">Project Passport</span></td>
										<td>Manage Daily Operations. One of the...</td>
										<td><a href="<?= Url::toRoute(['report-view'])?>" class="eye text-theme"><i
												class="fa fa-eye mr-2 text-theme"></i></a><a href="#2"
											class="eye  text-primary"><i
												class="fa fa-print mr-2 text-primary"></i></a>
									
									</tr>
									<tr>
										<td>4</td>
										<td><span class="list-name">WBS</span></td>
										<td>Manage Daily Operations. One of the...</td>
										<td><a href="<?= Url::toRoute(['report-view'])?>" class="eye text-theme"><i
												class="fa fa-eye mr-2 text-theme"></i></a><a href="#2"
											class="eye  text-primary"><i
												class="fa fa-print mr-2 text-primary"></i></a>
									
									</tr>
									<tr>
										<td>5</td>
										<td><span class="list-name">Risk Matrix</span></td>
										<td>Manage Daily Operations. One of the...</td>
										<td><a href="<?= Url::toRoute(['report-view'])?>" class="eye text-theme"><i
												class="fa fa-eye mr-2 text-theme"></i></a><a href="#2"
											class="eye  text-primary"><i
												class="fa fa-print mr-2 text-primary"></i></a>
									
									</tr>
									<tr>
										<td>6</td>
										<td><span class="list-name">Budget</span></td>
										<td>Manage Daily Operations. One of the...</td>
										<td><a href="<?= Url::toRoute(['report-view'])?>" class="eye text-theme"><i
												class="fa fa-eye mr-2 text-theme"></i></a><a href="#2"
											class="eye  text-primary"><i
												class="fa fa-print mr-2 text-primary"></i></a>
									
									</tr>
									<tr>
										<td>7</td>
										<td><span class="list-name">Calculations</span></td>
										<td>Manage Daily Operations. One of the...</td>
										<td><a href="<?= Url::toRoute(['report-view'])?>" class="eye text-theme"><i
												class="fa fa-eye mr-2 text-theme"></i></a><a href="#2"
											class="eye  text-primary"><i
												class="fa fa-print mr-2 text-primary"></i></a>
									
									</tr>
									<tr>
										<td>8</td>
										<td><span class="list-name">Project Scedule</span></td>
										<td>Manage Daily Operations. One of the...</td>
										<td><a href="<?= Url::toRoute(['report-view'])?>" class="eye text-theme"><i
												class="fa fa-eye mr-2 text-theme"></i></a><a href="#2"
											class="eye  text-primary"><i
												class="fa fa-print mr-2 text-primary"></i></a>
									
									</tr>
									<tr>
										<td>9</td>
										<td><span class="list-name">Activities</span></td>
										<td>Manage Daily Operations. One of the...</td>
										<td><a href="<?= Url::toRoute(['report-view'])?>" class="eye text-theme"><i
												class="fa fa-eye mr-2 text-theme"></i></a><a href="#2"
											class="eye  text-primary"><i
												class="fa fa-print mr-2 text-primary"></i></a>
									
									</tr>
									<tr>
										<td>10</td>
										<td><span class="list-name">WBS</span></td>
										<td>Manage Daily Operations. One of the...</td>
										<td><a href="<?= Url::toRoute(['report-view'])?>" class="eye text-theme"><i
												class="fa fa-eye mr-2 text-theme"></i></a><a href="#2"
											class="eye  text-primary"><i
												class="fa fa-print mr-2 text-primary"></i></a>
									
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--  <div class="row clearfix">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2>Exam Toppers</h2>
                            </div>
                            <div class="body table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>First Name</th>
                                            <th>Charts</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Dean Otto</td>
                                            <td>
                                                <span class="sparkbar">5,8,6,3,-5,9,2</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>K. Thornton</td>
                                            <td>
                                                <span class="sparkbar">10,-8,-9,3,5,8,5</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kane D.</td>
                                            <td>
                                                <span class="sparkbar">7,5,9,3,5,2,5</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jack Bird</td>
                                            <td>
                                                <span class="sparkbar">10,8,1,-3,-3,-8,7</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Hughe L.</td>
                                            <td>
                                                <span class="sparkbar">2,8,9,8,5,1,5</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jack Bird</td>
                                            <td>
                                                <span class="sparkbar">1,8,2,3,9,8,5</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Hughe L.</td>
                                            <td>
                                                <span class="sparkbar">10,8,-1,-3,2,8,-5</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2>Timeline</h2>
                                <ul class="header-dropdown">
                                    <li class="remove">
                                        <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="new_timeline">
                                    <div class="header">
                                        <div class="color-overlay">
                                            <div class="day-number">8</div>
                                            <div class="date-right">
                                                <div class="day-name">Monday</div>
                                                <div class="month">February 2018</div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="bullet pink"></div>
                                            <div class="time">11am</div>
                                            <div class="desc">
                                                <h3>Attendance</h3>
                                                <h4>Computer Class</h4>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="bullet green"></div>
                                            <div class="time">12pm</div>
                                            <div class="desc">
                                                <h3>Design Team</h3>
                                                <h4>Hangouts</h4>
                                                <ul class="list-unstyled team-info margin-0 p-t-5">
                                                    <li><img src="http://via.placeholder.com/35x35" alt="Avatar"></li>
                                                    <li><img src="http://via.placeholder.com/35x35" alt="Avatar"></li>
                                                    <li><img src="http://via.placeholder.com/35x35" alt="Avatar"></li>
                                                    <li><img src="http://via.placeholder.com/35x35" alt="Avatar"></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="bullet orange"></div>
                                            <div class="time">1:30pm</div>
                                            <div class="desc">
                                                <h3>Lunch Break</h3>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="bullet green"></div>
                                            <div class="time">2pm</div>
                                            <div class="desc">
                                                <h3>Finish</h3>
                                                <h4>Go to Home</h4>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2>Attendance</h2>
                            </div>
                            <div class="body">
                                <ul class=" list-unstyled basic-list">
                                    <li>Mark Otto <span class="badge badge-primary">21%</span></li>
                                    <li>Jacob Thornton <span class="badge-purple badge">50%</span></li>
                                    <li>Jacob Thornton<span class="badge-success badge">90%</span></li>
                                    <li>M. Arthur <span class="badge-info badge">75%</span></li>
                                    <li>Jacob Thornton <span class="badge-warning badge">60%</span></li>
                                    <li>M. Arthur <span class="badge-success badge">91%</span></li>
                                    <li>Jacob Thornton<span class="badge-success badge">90%</span></li>
                                    <li>M. Arthur <span class="badge-info badge">75%</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->
</div>
</div>
</div>

<div class="modal fade" id="edit-npv" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">NPV</h5>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="form-group col-md">
						<label for="exampleInputEmail1">Rate</label> <input type="email"
							class="form-control" id="exampleInputEmail1"
							aria-describedby="emailHelp"></input>
					</div>
					<div class="form-group col-md">
						<label for="exampleInputEmail1">T (Period)</label> <input
							type="email" class="form-control" id="exampleInputEmail1"
							aria-describedby="emailHelp"></input>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md">
						<label for="exampleInputEmail1">CF</label> <input type="email"
							class="form-control" id="exampleInputEmail1"
							aria-describedby="emailHelp"></input>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a type="button" href="#2" class="btn bg-theme btn-secondary">Save
					Changes</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="edit-wbs" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">WBS</h5>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="form-group col-md">
						<label for="exampleInputEmail1">Task</label> <input type="email"
							class="form-control" id="exampleInputEmail1"
							aria-describedby="emailHelp"></input>
					</div>
					<div class="form-group col-md">
						<label for="exampleInputEmail1">Budget</label> <input type="email"
							class="form-control" id="exampleInputEmail1"
							aria-describedby="emailHelp"></input>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md">
						<label for="exampleInputEmail1">Description</label>
						<textarea class="form-control" rows="5"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a type="button" href="#2" class="btn bg-theme btn-secondary">Save
					Changes</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1"
	role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Logout</h5>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">Do you want to Logout ?</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">No</button>
				<a type="button" href="login.php" class="btn btn-secondary">Yes</a>
			</div>
		</div>
		</div>
		</div>