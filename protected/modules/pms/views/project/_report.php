<?php
use app\components\TDashBox;
use app\components\notice\Notices;
use app\models\EmailQueue;
use app\models\LoginHistory;
use app\modules\logger\models\Log;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;
use app\models\search\User as UserSearch;
use miloschuman\highcharts\Highcharts;
use app\modules\pms\models\search\Task;
use app\modules\pms\models\Project;
use app\modules\pms\models\Rename;

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

$report = Rename::find()->Where([
    'type_id' => Rename::TYPE_REPORT
])
    ->select('title')
    ->one();

$pdf = Rename::find()->Where([
    'type_id' => Rename::TYPE_PDF
])
    ->select('title')
    ->one();

$print = Rename::find()->Where([
    'type_id' => Rename::TYPE_PRINT
])
    ->select('title')
    ->one();
?>

<div class="w-100 d-flex justify-content-center banner-imgs">
<?php

echo Html::img(yii::$app->view->theme->getUrl('admin/img/report.jpg'), []);
?>
</div>

<div class="tab-pane" id="report">
	<div class="table-responsive">
		<table class="table table-hover m-b-0">
			<thead class="thead-dark">
				<tr>

					<th><?=Yii::t('app', 'S.No')?></th>
					<th><?=empty($report) ? Yii::t('app', 'Report') : $report?></th>
					<th ><?=empty($pdf) ? Yii::t('app', 'PDF') : $pdf?></th>
					<th ><?=empty($print) ? Yii::t('app', 'Print') : $print?></th>

				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td><span class="list-name"><?=Yii::t('app', 'Project Passport')?></span></td>
					<td><a target="_blank"

						href="<?php

    echo Url::toRoute([
        'view',
        'download' => true,
        'id' => $model->id
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'PDF')?>
					</a>

				<td><a target="_blank" href="<?php

    echo Url::toRoute([
        'view',
        'print' => true,
        'id' => Yii::$app->request->queryParams['id']
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'Print')?>
							</a>
							</td>
				</tr>
				<tr>
					<td>2</td>
					<td><span class="list-name"><?=Yii::t('app', 'WBS')?></span></td>
					<td><a target="_blank"

						href="<?php

    echo Url::toRoute([
        'task/index',
        'download' => true,
        'id' => Yii::$app->request->queryParams['id']
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'PDF')?>
					</a>
					</td>

						<td><a target="_blank" href="<?php

    echo Url::toRoute([
        'task/index',
        'print' => true,
        'id' => Yii::$app->request->queryParams['id']
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'Print')?>
							</a>
							</td>
				</tr>
				<tr>
					<td>3</td>
					<td><span class="list-name"><?=Yii::t('app', 'Risk Matrix')?></span></td>
					<td><a target="_blank"

						href="<?php

    echo Url::toRoute([
        'risk-matrix/index',
        'download' => true,
        'id' => Yii::$app->request->queryParams['id']
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'PDF')?>
					</a>
					</td>

						<td><a target="_blank" href="<?php

    echo Url::toRoute([
        'risk-matrix/index',
        'print' => true,
        'id' => Yii::$app->request->queryParams['id']
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'Print')?>
					</a>
					</td>
				</tr>

				<tr>
					<td>4</td>
					<td><span class="list-name"><?=Yii::t('app', 'Budget')?></span></td>
					<td><a target="_blank"

						href="<?php

    echo Url::toRoute([
        'capex',
        'download' => true,
        'id' => Yii::$app->request->queryParams['id']
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'PDF')?>
					</a>
					</td>

					<td><a target="_blank" href="<?php

    echo Url::toRoute([
        'capex',
        'print' => true,
        'id' => Yii::$app->request->queryParams['id']
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'Print')?>
							</a>
							</td>
				</tr>
				<tr>
					<td>5</td>
					<td><span class="list-name"><?=Yii::t('app', 'Project Scedule')?></span></td>
					<td><a target="_blank" href="<?php

    echo Url::toRoute([
        'plan',
        'download' => true,
        'id' => $model->id
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'PDF')?>
					</a>
					</td>

							<td><a target="_blank" href="<?php

    echo Url::toRoute([
        'plan',
        'print' => true,
        'id' => Yii::$app->request->queryParams['id']
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'Print')?>
							</a>
							</td>
				</tr>
				<tr>
					<td>6</td>
					<td><span class="list-name"><?=Yii::t('app', 'Calculations')?></span></td>
					<td><a target="_blank" href="<?php

    echo Url::toRoute([
        'finance/index',
        'download' => true,
        'id' => Yii::$app->request->queryParams['id']
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'PDF')?>
					</a>
				</td>

						<td><a target="_blank" href="<?php

    echo Url::toRoute([
        'finance/index',
        'print' => true,
        'id' => Yii::$app->request->queryParams['id']
    ])?>"

						class="btn btn-success mt-4"> <i
							class="fa fa-download append-icon"></i> <?=Yii::t('app', 'Print')?>
							</a>
							</td>
				</tr>
				</tbody>
				</table>
				</div>
				</div>
