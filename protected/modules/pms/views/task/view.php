<?php
use app\components\useraction\UserAction;
use app\modules\comment\widgets\CommentsWidget;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Task */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Pms'),
    'url' => [
        '/pms'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tasks'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = (string) $model;
?>
<div class="wrapper">
	<div class="container-fluid">
		<div class="block-header">
			<div class="row">
				<div class="col-lg-5 col-md-8 col-sm-12">
					<h2>
						<a href="<?=Url::toRoute(['/pms/project/view','id' => $model->project_id])?>"
							class="btn btn-xs btn-link btn-toggle-fullwidth"><i
							class="fa fa-arrow-left"></i></a><?=Yii::t('app', 'My Task')?>
					</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a
							href="<?=Url::toRoute(['/pms/project/view','id' => $model->project_id])?>"><i class="icon-home"></i></a></li>
						<li class="breadcrumb-item active"><?=Yii::t('app', 'Task Details')?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
         <?php

        echo \app\components\TDetailView::widget([
            'id' => 'task-detail-view',
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered'
            ],
            'attributes' => [
                'id',
                'title',
                [
                    'attribute' => 'amount',
                    'value' => $model->project->currency . $model->amount
                ],
                'start_date:date',
                'end_date:date',
                [
                    'attribute' => "<a> Duration in Days </a>",
                    'value' => $model->getDays(),
                    'label' => Yii::t('app', 'Duration of days')
                ],
                [
                    'attribute' => Yii::t('app', '% Complete'),
                    'value' => 'progress_id'
                ],
                [
                    'attribute' => 'state_id',
                    'format' => 'raw',
                    'value' => $model->getStateBadge()
                ],
                'created_on:datetime',

                [
                    'attribute' => 'created_by_id',
                    'format' => 'raw',
                    'value' => $model->getRelatedDataLink('created_by_id')
                ]
            ]
        ])?>
       	<table class="table table-striped table-bordered detail-view">
					<tbody>
						<tr>
							<th class="w-25"><?=Yii::t('app', 'Task Description')?> </th>
							<td colspan="1"><?php

    echo $model->description;
    ?></td>
						</tr>
					</tbody>
				</table>
							<table class="table table-striped table-bordered detail-view">
			<tbody>
				<tr>
					<th class="w-25"><?=Yii::t('app', 'Task Notes')?></th>
					<td colspan="1"><?php

    echo $model->notes;
    ?></td>
				</tr>
			</tbody>
		</table>
			</div>
		</div>
	</div>

</div>