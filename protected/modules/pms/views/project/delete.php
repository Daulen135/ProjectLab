<?php
use app\components\useraction\UserAction;
use app\modules\comment\widgets\CommentsWidget;
use yii\helpers\Html;
use app\components\TActiveForm;
/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Project */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Pms'),
    'url' => [
        '/pms'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Projects'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = (string) $model;
?>
<div class="wrapper">
	<div class="card">
		<div class="project-view card-body">
			<h4 class="text-danger"><?=Yii::t('app', 'Are you sure you want to delete this item? All related data is deleted')?></h4>
         <?php

        echo \app\components\PageHeader::widget([
            'model' => $model
        ]);
        ?>
      </div>
	</div>
	<div class="card">
		<div class="card-body">
         <?php

        echo \app\components\TDetailView::widget([
            'id' => 'project-detail-view',
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered'
            ],
            'attributes' => [
                'id',
            /*'title',*/
            /*'description:html',*/
          
                'client_name',
                'start_date:date',
                'end_date:date',
                [
                    'attribute' => 'type_id',
                    'value' => $model->getType()
                ],
            /*[
			'attribute' => 'state_id',
			'format'=>'raw',
			'value' => $model->getStateBadge(),],*/
            'created_on:datetime',
                [
                    'attribute' => 'created_by_id',
                    'format' => 'raw',
                    'value' => $model->getRelatedDataLink('created_by_id')
                ]
            ]
        ])?>
         <?php

        echo $model->description;
        ?>
         <?php

        $form = TActiveForm::begin([
            'id' => 'project-form',
            'options' => [
                'class' => 'row'
            ]
        ]);
        ?>

            <div class="col-md-12 text-right">
            <?=Html::submitButton('Confirm', ['id' => 'project-form-submit','class' => 'btn btn-success'])?>
         </div>
         <?php

        TActiveForm::end();
        ?>
      </div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="project-panel">
            <?php
            $this->context->startPanel();
            $this->context->addPanel('CapexBudgets', 'capexBudgets', 'CapexBudget', $model /* ,null,true */);
            $this->context->addPanel('Deliverables', 'deliverables', 'Deliverable', $model /* ,null,true */);
            $this->context->addPanel('Finances', 'finances', 'Finance', $model /* ,null,true */);
            $this->context->addPanel('Milestones', 'milestones', 'Milestone', $model /* ,null,true */);
            $this->context->addPanel('OpexBudgets', 'opexBudgets', 'OpexBudget', $model /* ,null,true */);
            $this->context->addPanel('RiskMatrices', 'riskMatrices', 'RiskMatrix', $model /* ,null,true */);
            $this->context->addPanel('Feeds', 'feeds', 'Feed', $model /* ,null,true */);
            $this->context->endPanel();
            ?>
         </div>
		</div>
	</div>
      <?php

    echo CommentsWidget::widget([
        'model' => $model
    ]);
    ?>
</div>