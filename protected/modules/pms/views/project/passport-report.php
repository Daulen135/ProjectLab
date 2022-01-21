<?php
use app\modules\pms\models\Project;

?>
<!DOCTYPE html>
<html>
<head>
	<title><?= Yii::t('app', 'Email template')?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
	body {
		font-family: arial;
	}
	@media only screen and (max-device-width: 480px), only screen and (max-width: 480px) {
		td[class='column'],
		td[class='column'] { float: left !important; display: block !important;border-right: 0 !important; }
		td[class='td'] { width: 100% !important; min-width: 100% !important; }
		table  {
			margin: auto;
			width: 100%;
		}
	}
</style>
</head>
<body style="background-color: #e1ebf8;font-family: 'arial';color: #333;font-size: 15px;line-height: 24px;">
	<table cellspacing="0" cellpadding="0" style="background: #fff;max-width:1200px;width: 100%;table-layout: fixed;margin:10px auto">
		<tbody>
			<!--- body start-->
			<tr>
				<td style="padding:30px 40px 40px 40px">
					<table width="100%" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td style="padding: 0 0 15px 0;" align="center">
									<img alt="ProjectLabs" style="width: 110px;" src="<?php echo Yii::$app->urlManager->createAbsoluteUrl('/');  ?>/themes/new/admin/img/logo.png" target="_blank">
								</td>
							</tr>
						</tbody>
					</table>
					<table style="border:2px solid #004660" width="100%">
						<tbody>
							<tr>
								<td style="padding:20px;">
									<table style="border-collapse: collapse;" cellpadding="0" width="100%">
										<tr>
											<td colspan="2" style="color: #fff;text-align: center;background: #ed7d31;padding: 10px 0;"><h2 style="margin: 0;font-size: 18px;"><?= Yii::t('app', 'Project Passport')?></h2></td>
										</tr>
										<tr>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#004660"><p style="display: inline-block;white-space: nowrap;margin:0px;font-weight: bold;"><?= Yii::t('app', 'Project Name')?></p></td>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><p style="display: inline-block;margin:0px;"><?= $model->title;?></p></td>
										</tr>
										<tr>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#004660"><p style="display: inline-block;white-space: nowrap;margin:0px;font-weight: bold;"><?= Yii::t('app', 'Client')?></p></td>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><p style="display: inline-block;margin:0px;"><?= $model->client_name;?></p></td>
										</tr>
										<tr>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#004660"><p style="display: inline-block;white-space: nowrap;margin:0px;font-weight: bold;"><?= Yii::t('app', 'Project Manager')?></p></td>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><p style="display: inline-block;margin:0px;"><?= $model->manager_name;?></p></td>
										</tr>
										<tr>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#004660"><p style="display: inline-block;white-space: nowrap;margin:0px;font-weight: bold;"><?= Yii::t('app', 'Project Designation')?></p></td>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><p style="display: inline-block;margin:0px;"><?= $model->getType();?></p></td>
										</tr>
										<tr>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#004660"><p style="display: inline-block;white-space: nowrap;margin:0px;font-weight: bold;"><?= Yii::t('app', 'Planned Start Date')?></p></td>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><p style="display: inline-block;margin:0px;"><?= $model->start_date;?></p></td>
										</tr>
										<tr>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#004660"><p style="display: inline-block;white-space: nowrap;margin:0px;font-weight: bold;"><?= Yii::t('app', 'Planned End Date')?></p></td>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><p style="display: inline-block;margin:0px;"><?= $model->end_date;?></p></td>
										</tr>
										<tr>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#004660"><p style="display: inline-block;white-space: nowrap;margin:0px;font-weight: bold;"><?= Yii::t('app', 'Created By')?></p></td>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><p style="display: inline-block;margin:0px;"><?= $model->createdBy->full_name;?></p></td>
										</tr>
										<tr>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#004660"><p style="display: inline-block;white-space: nowrap;margin:0px;font-weight: bold;"><?= Yii::t('app', 'Project Description')?></p></td>
											<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><p style="display: inline-block;margin:0px;"><?= $model->description;?></p></td>
										</tr>
										<tr>
											<td style="vertical-align: top;">
												<table cellspacing="0" cellpadding="0" style="background: #fff;width: 100%;table-layout: fixed;margin:30px 0 0 0">
													<thead>
														<tr>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?= Yii::t('app', 'Project Deliverables')?></th>
														</tr>
													</thead>
													<tbody>
														<?php $data = $model->deliverables; foreach ($data as $value) { ?>
															<tr>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><p style="display: inline-block;margin:0px;"><?= $value->title;?></p></td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											</td>
											<td style="vertical-align: top;">
												<table cellspacing="0" cellpadding="0" style="background: #fff;width: 100%;table-layout: fixed;margin:30px 0 0 0">
													<thead>
														<tr>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?= Yii::t('app', 'Project Success Criteria')?></th>
														</tr>
													</thead>
													<tbody>
														<?php $data = $model->successCriteria; foreach ($data as $value) { ?>
															<tr>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><p style="display: inline-block;margin:0px;"><?= $value->title;?></p></td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="vertical-align: top;">
												<table cellspacing="0" cellpadding="0" style="background: #fff;width: 100%;table-layout: fixed;margin:30px 0 0 0">
													<thead>
														<tr>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?= Yii::t('app', 'Project Milestone')?></th>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?= Yii::t('app', 'End Date')?></th>
														</tr>
													</thead>
													<tbody>
														<?php $data = $model->milestones; foreach ($data as $value) { ?>
															<tr>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><?= $value->title;?></td>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><?= $value->end_date;?></td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table style="background:#004660;" width="100%" cellspacing="0" cellpadding="0">
						<tbody style="text-align: center;">
							<!--- footer start-->
							<tr>
								<td style="padding: 10px 0 15px 0;" align="center">
									<p style="color: #fff;margin: 0;"> Click here to visit <a href="projectlabexpert.com" style="color: #fff"> projectlabexpert.com</a> | All Rights Reserved.</p>
								</td>
							</tr>
							<!--- footer end-->
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
		<!--- body end-->
	</table>
</body>
</html>
<?php if(isset(Yii::$app->request->queryParams['print'])){ ?>
	<script>
	window.print();
</script>
<?php } ?>
