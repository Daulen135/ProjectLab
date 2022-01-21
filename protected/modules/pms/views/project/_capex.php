<?php
use app\components\grid\TGridView;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
use app\modules\pms\models\Task;
use app\modules\pms\models\Project;
use app\modules\pms\models\OpexBudget;
use app\modules\pms\models\Rename;
use yii\helpers\VarDumper;
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\pms\models\search\Task $searchModel
 */
?>
<?php

$this->render('variable.php');
?>

<style type="text/css">
table {
	border-spacing: 0;
	font-family: sans-serif;
	color: #333333;
}

td {
	padding: 0;
}

img {
	border: 0;
}

.wrapper {
	width: 100%;
	table-layout: fixed;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
}

.webkit {
	max-width: 700px;
	padding: 30px;
	border-top: 3px solid #ff5a00;
	margin-top: 30px;
	background: #fff;
	margin-bottom: 30px;
	border-bottom: 3px solid #ff5a00;
}

.outer {
	Margin: 0 auto;
	width: 100%;
	max-width: 700px;
}

.inner {
	padding: 10px;
}

.contents {
	width: 100%;
}

/* One column layout */
.one-column .contents {
	text-align: left;
}

.one-column p {
	font-size: 14px;
	Margin-bottom: 10px;
	color: #5a5a5a;
}

.table-new {
	border-collapse: collapse;
	width: 100%;
	margin-top: 20px;
}

.table-new td, .table-new th {
	border: 1px solid #ddd;
	padding: 8px;
	font-size: 12px;
}

.table-new tr:nth-child(even) {
	background-color: #f2f2f2;
}

.table-new tr:hover {
	background-color: #ddd;
}

.table-new th {
	padding-top: 12px;
	padding-bottom: 12px;
	text-align: left;
	font-weight: bold;
	background: #0482ce;
	color: #fff !important;
}

.one-border {
	border-bottom: 1px solid #eee;
}

.d-flex {
	display: flex !important;
}
</style>
<div class="w-100 d-flex justify-content-center banner-imgs">
<?php

echo Html::img(yii::$app->view->theme->getUrl('admin/img/budget.jpg'), []);
?>
</div>
<h5 class="my-2"><?=empty($capex) ? Yii::t('app', 'CAPEX') : $capex?></h5>
<span data-toggle="tooltip"
	title="Capital expenditures consist of the funds that the project consumes to purchase major physical goods or services that will use to tasks execution during the project."
	class="ques-mark ml-2"><i class="fa fa-info-circle vt-top text-primary"></i></span>

 <?php

Pjax::begin([
    'id' => 'task-pjax-ajax-grid',
    'enablePushState' => false,
    'enableReplaceState' => false
]);
?>
 
        <?php

        echo TGridView::widget([
            'summary' => false,
            'id' => 'task-ajax-grid-view',
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            /*
             * 'showFooter' => true,
             * 'footerRowOptions' => [
             * 'style' => 'font-weight:bold;color:#ff44ff;font-size:150%'
             * ],
             */
            'tableOptions' => [
                'class' => 'table custom-table mt-3'
            ],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => Yii::t('app', 'S.No')
                ],
                // 'title',
                [
                    'attribute' => 'title',

                    'label' => empty($task) ? Yii::t('app', 'Task') : $task
                ],
                // 'description:html',
                [
                    'attribute' => 'description',

                    'label' => empty($description) ? Yii::t('app', 'Description') : $description
                ],
                [
                    // 'class' => 'app\components\TSumColumn',

                    'value' => function ($data) {
                        return $data->project->currency . $data->amount;
                    },
                    'label' => empty($capextask) ? Yii::t('app', 'Capex Per Task') : $capextask
                ],
                [
                    'class' => 'app\components\TActionColumn',
                    'template' => '{delete}',
                    'header' => Yii::t('app', 'Actions')
                ]
            ]
        ]);
        ?>

<div class="value pb-3">
	<div class="row align-items-center">
		<div class="col-lg-1 ">
			<h5 class=" py-2  m-0"><?=empty($total->title) ? Yii::t('app', 'Total') : $total->title?></h5>
		</div>
		<div class="col-lg-1 text-center ">
			<h4 style="font-weight: bold; color: #ff44ff;"
				class=" py-2 font-weight-bold d-block m-0">
    			<?php

    echo Task::getTaskSum();
    ?>           </h4>
		</div>
	</div>
</div>


<h5 class="my-2"><?=empty($exp) ? Yii::t('app', 'Project Expense') : $exp?></h5>
<span data-toggle="tooltip"
	title="Project expenditures are the ordinary and necessary expenses that a project spends to conduct its activities."
	class="ques-mark ml-2"><i class="fa fa-info-circle vt-top text-primary"></i></span>
<?php

Pjax::begin([
    'id' => 'opex-pjax-grid'
]);
?>
            
           <?php

        echo \app\components\TToolButtons::widget();
        ?>
        
         <?php

        echo TGridView::widget([
            'summary' => false,
            'id' => 'opex-budget-grid-view',
            'dataProvider' => $opexDataProvider,
            // 'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table custom-table mt-3'
            ],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => Yii::t('app', 'S.No')
                ],
                [
                    'attribute' => 'expense',
                    'value' => function ($data) {
                        return $data->project->currency . $data->expense;
                    },
                    'label' => empty($general) ? Yii::t('app', 'General Expense') : $general
                ],
                [
                    'attribute' => 'payroll',
                    'value' => function ($data) {
                        return $data->project->currency . $data->payroll;
                    },
                    'label' => empty($payroll) ? Yii::t('app', 'Payroll') : $payroll
                ],
                [
                    'attribute' => 'item_name',
                    'value' => function ($data) {
                        return $data->project->currency . $data->item_name;
                    },
                    'label' => empty($other) ? Yii::t('app', 'Others') : $other
                ],
                [
                    'attribute' => 'amount',
                    'value' => function ($data) {
                        return $data->project->currency . $data->amount;
                    },
                    'label' => empty($totalproject) ? Yii::t('app', 'Total Project Expense') : $totalproject
                ],
                [
                    'class' => 'app\components\TActionColumn',
                    'header' => Yii::t('app', 'Actions')
                ]
            ]
        ]);
        ?>

        <?php

        Pjax::end();
        ?>



<h5 class="my-2" style=""><?=empty($projectbudget) ? Yii::t('app', 'Total Project Expense') : $projectbudget?></h5>
<div class="value py-3 ">
	<div class="row align-items-center">
		<div class="col-lg-3 ">
			<h5 class=" py-2 text-white m-0"><?=empty($projectbudget) ? Yii::t('app', 'CAPEX + Project Expenses') : $projectbudget?></h5>

		</div>
		<div class="col-lg-2 ">
			<h5 class=" py-2 bg-transparent text-pink d-block m-0">
			<?php
echo Project::getBudget();
?>
            </h5>
		</div>
	</div>
</div>