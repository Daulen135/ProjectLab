<?php
use app\components\grid\TGridView;
use app\models\User;
use app\modules\pms\models\Project;
use app\modules\pms\models\Task;
use yii\widgets\Pjax;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\pms\models\search\Task $searchModel
 */

?>


<!DOCTYPE html>
<html>
<head>
	<title><?=Yii::t('app', 'Email template')?></title>
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
									<img alt="ProjectLabs" style="width: 110px;" src="<?php

echo Yii::$app->urlManager->createAbsoluteUrl('/');
        ?>/themes/new/admin/img/logo.png" target="_blank">
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
											<td style="color: #fff;text-align: center;background: #ed7d31;padding: 10px 0;"><h2 style="margin: 0;font-size: 18px;"><?=Yii::t('app', 'Capex')?></h2></td>
										</tr>
										<tr>
											<td style="vertical-align: top;">
												<table cellspacing="0" cellpadding="0" style="background: #fff;width: 100%;table-layout: fixed;margin:30px 0 0 0">
													<thead>
														<tr>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?=Yii::t('app', 'Task')?></th>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?=Yii::t('app', 'Desciption')?></th>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?=Yii::t('app', 'Capex Per Task')?></th>
														</tr>
													</thead>
													<tbody>
														<?php
            $data = $dataProvider->getModels();
            foreach ($data as $value) {
                ?>
															<tr>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><?=$value->title;?></td>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><?=$value->description;?></td>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><?=$value->project->currency . $value->amount;?></td>
															</tr>
														<?php

}
            ?>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td style="vertical-align: top;">
												<table cellspacing="0" cellpadding="0" style="background: #fff;width: 100%;table-layout: fixed;margin:30px 0 0 0">
													<thead>
														<tr>
															<td colspan="5"><h4 style="font-weight: bold; margin-top:10px; margin-bottom: 20px;"><span style=""><?=Yii::t('app', 'Project Expenses')?></span></h4></td>
														</tr>
														<tr>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?=Yii::t('app', 'S.No')?>.</th>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?=Yii::t('app', 'General Expenses')?></th>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?=Yii::t('app', 'Payroll')?></th>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?=Yii::t('app', 'Others')?></th>
															<th style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;color:#fff;text-align: left;background: #004660;"><?=Yii::t('app', 'Total Project Expenses')?></th>
														</tr>
													</thead>
													<tbody>
														<?php
            $data = $opexDataProvider->getModels();
            foreach ($data as $value) {
                ?>
															<tr>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;">1</td>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><?=$value->project->currency . $value->expense;?></td>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><?=$value->project->currency . $value->payroll;?></td>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><?=$value->project->currency . $value->item_name;?></td>
																<td style="border-bottom: 1px solid #bdc8d7;padding: 12px 10px;"><?=$value->getTotalExpenses();?></td>
															</tr>
														<?php

}
            ?>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td style="vertical-align: top;">
												<table cellspacing="0" cellpadding="0" style="background: #fff;width: 100%;table-layout: fixed;margin:30px 0 0 0">
													<thead>
														<tr>
															<td class="2"><h4 style="font-weight: bold; margin-top: 30px; margin-bottom: 20px;"><span style=""><?=Yii::t('app', 'Project Budget')?></span></h4></td>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td style="font-weight: bold;"><?=Yii::t('app', 'Capex + Project Expenses')?></td>
															<td style="font-weight: bold;"><?php
            echo Project::getBudget();
            ?></td>
														</tr>
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

<?php

if (isset(Yii::$app->request->queryParams['print'])) {
    ?>
	<script>
	window.print();
	</script>
<?php

}
?>
