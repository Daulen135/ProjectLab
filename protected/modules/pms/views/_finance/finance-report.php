<?php
use app\components\grid\TGridView;
use app\modules\pms\models\Finance;
use app\modules\pms\models\Project;
use yii\helpers\Html;
use yii\widgets\Pjax;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\pms\models\search\Finance $searchModel
 */
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

@media only screen and (max-device-width: 480px) , only screen and
	(max-width: 480px) {
	td[class='column'], td[class='column'] {
		float: left !important;
		display: block !important;
		border-right: 0 !important;
	}
	td[class='td'] {
		width: 100% !important;
		min-width: 100% !important;
	}
	table {
		margin: auto;
		width: 100%;
	}
}
</style>
</head>
<body
	style="background-color: #e1ebf8; font-family: 'arial'; color: #333; font-size: 15px; line-height: 24px;">
	<table cellspacing="0" cellpadding="0"
		style="background: #fff; max-width: 1200px; width: 100%; table-layout: fixed; margin: 10px auto">
		<tbody>
			<!--- body start-->
			<tr>
				<td style="padding: 30px 40px 40px 40px">
					<table width="100%" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td style="padding: 0 0 15px 0;" align="center"><img
									alt="ProjectLabs" style="width: 110px;"
									src="<?php echo Yii::$app->urlManager->createAbsoluteUrl('/');  ?>/themes/new/admin/img/logo.png"
									target="_blank"></td>
							</tr>
						</tbody>
					</table>
					<table style="border: 2px solid #004660" width="100%">
						<tbody>
							<tr>
								<td style="padding: 20px;">
									<table style="border-collapse: collapse;" cellpadding="0"
										width="100%">
										<tr>
											<td
												style="color: #fff; text-align: center; background: #ed7d31; padding: 10px 0;"><h2
													style="margin: 0; font-size: 18px;"><?= Yii::t('app', 'Finance')?></h2></td>
										</tr>
										<tr>
											<td style="vertical-align: top;">
												<table cellspacing="0" cellpadding="0"
													style="background: #fff; width: 100%; table-layout: fixed; margin: 30px 0 0 0">
													<thead>
														<tr>
															<th
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; color: #fff; text-align: left; background: #004660;">
																<?= Yii::t('app', 'Annual Discount Rate')?>:</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px;"><?php
                $model = \app\modules\pms\models\Rate::find()->where([
                    'project_id' => Yii::$app->request->queryParams['id']
                ])->one();
                if (! empty($model)) {
                    echo $model->rate;
                    $title = "Update Rate";
                    $url = [
                        'rate/update',
                        'id' => $model->id
                    ];
                } else {
                    $title = "Add Rate";
                    $url = [
                        'rate/add',
                        'id' => Yii::$app->request->queryParams['id']
                    ];
                }
                ?></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td style="vertical-align: top;">
												<table cellspacing="0" cellpadding="0"
													style="background: #fff; width: 100%; table-layout: fixed; margin: 30px 0 0 0">
													<thead>
														<tr>
															<td><h4
																	style="font-weight: bold; margin-top: 10px; margin-bottom: 20px;">
																	<span style=""><?= Yii::t('app', 'NPV')?></span>
																</h4></td>
														</tr>
														<tr>
															<th
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; color: #fff; text-align: left; background: #004660;"><?= Yii::t('app', 'T(Period)')?></th>
															<th
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; color: #fff; text-align: left; background: #004660;"><?= Yii::t('app', 'Income')?></th>
															<th
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; color: #fff; text-align: left; background: #004660;"><?= Yii::t('app', 'Opex')?></th>
															<th
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; color: #fff; text-align: left; background: #004660;"><?= Yii::t('app', 'CF')?></th>
														</tr>
													</thead>
													<tbody>
															<?php
            $data = $dataProvider->getModels();
            foreach ($data as $value) {
                ?>
																<tr>
															<td
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px;"><?=  $value->time;?></td>
															<td
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px;"><?=  $value->project->currency . $value->income;?></td>
															<td
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px;"><?=  $value->project->currency . $value->opex;?></td>
															<td
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px;"><?=  $value->project->currency . $value->getTotalCashFlow();?></td>
														</tr>
															<?php } ?>
														</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td style="vertical-align: top;">
												<table cellspacing="0" cellpadding="0"
													style="background: #fff; width: 100%; table-layout: fixed; margin: 30px 0 0 0">
													<thead>
														<tr>
															<td><h4
																	style="font-weight: bold; margin-top: 10px; margin-bottom: 20px;">
																	<span style=""><?= Yii::t('app', 'Calculation Results')?></span>
																</h4></td>
														</tr>
														<tr>
															<th
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; color: #fff; text-align: left; background: #004660;"></th>
															<th
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; color: #fff; text-align: left; background: #004660;"><?= Yii::t('app', 'Description')?></th>
															<th
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; color: #fff; text-align: left; background: #004660; text-align: center;"><?= Yii::t('app', 'Value')?></th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td
																style="font-weight: bold; border-bottom: 1px solid #bdc8d7; padding: 12px 10px;"><?= Yii::t('app', 'NPV')?></td>
															<td
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; width: 60%;"><?=Yii::t('app', 'A
																positive net present value indicates that the project
																earnings generated by a project or investment - in
																present dollars - exceeds the anticipated costs, also in
																present dollars. It is assumed that an investment with a
																positive NPV will be profitable, and an investment with
																a negative NPV will result in a net loss')?>.</td>
															<td
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; text-align: center;"><?php 	$model = new Finance(); echo $model->getNpv(); ?></td>
														</tr>
														<tr>
															<td
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px;"><?= Yii::t('app', 'ROI')?></td>
															<td
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; width: 60%;"><?=Yii::t('app', 'Return
																on investment (ROI) is a financial metric that is widely
																used to measure the probability of gaining a return from
																an investment. It is a ratio that compares the gain or
																loss from an investment relative to its cost.It is as
																useful in evaluating the potential return from a
																stand-alone investment as it is in comparing returns
																from several investments')?>.
																<br /> <?= Yii::t('app', 'For example') ?>,<br /><?= Yii::t('app', 'If ROI = 140%, you will make 40$ from 100$ of Investment') ?><br />
																<?= Yii::t('app', 'If ROI =80%, you will lose 20$ from 100$ of Investment') ?>
															</td>
															<td
																style="border-bottom: 1px solid #bdc8d7; padding: 12px 10px; text-align: center;"><?php $model = new Finance(); echo $model->getRoi(); ?></td>
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
					<table style="background: #004660;" width="100%" cellspacing="0"
						cellpadding="0">
						<tbody style="text-align: center;">
							<!--- footer start-->
							<tr>
								<td style="padding: 10px 0 15px 0;" align="center">
									<p style="color: #fff; margin: 0;">
										Click here to visit <a href="projectlabexpert.com"
											style="color: #fff"> projectlabexpert.com</a> | All Rights
										Reserved.
									</p>
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
