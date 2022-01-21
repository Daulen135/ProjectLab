<?php
use app\components\useraction\UserAction;
use app\modules\comment\widgets\CommentsWidget;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\RiskMatrix */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Pms'),
    'url' => [
        '/pms'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Risk Matrices'),
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
						<a href="<?=Url::toRoute(['/pms/project'])?>"
							class="btn btn-xs btn-link btn-toggle-fullwidth"><i
							class="fa fa-arrow-left"></i></a><?=Yii::t('app', 'Risk Matrix')?>
					</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a
							href="<?=Url::toRoute(['/pms/project'])?>"><i class="icon-home"></i></a></li>
						<li class="breadcrumb-item active"><?=Yii::t('app', 'Risk Matrix')?></li>
					</ul>
				</div>
			</div>
		</div>
   <div class="card">
      <div class="card-body">
         <?php

        echo \app\components\TDetailView::widget([
            'id' => 'risk-matrix-detail-view',
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered'
            ],
            'attributes' => [
                'id',
            /*'title',*/
          /*   [
            			'attribute' => 'project_id',
            			'format'=>'raw',
            			'value' => $model->getRelatedDataLink('project_id'),
            			], */
             [
                    'attribute' => 'severity',
                    'value' => $model->getSeverity()
                ],
                [
                    'attribute' => 'impact',
                    'value' => $model->getImpact()
                ],
                // 'factor',
                [
                    'attribute' => 'state_id',
                    'format' => 'raw',
                    'value' => $model->getStateBadge()
                ]
                /*
             * [
             * 'attribute' => 'type_id',
             * 'value' => $model->getType(),
             * ],
             * 'created_on:datetime',
             * [
             * 'attribute' => 'created_by_id',
             * 'format'=>'raw',
             * 'value' => $model->getRelatedDataLink('created_by_id'),
             * ],
             */
            ]
        ])?>
         </div>
         </div>
         </div>
</div>