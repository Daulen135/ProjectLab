<?php
use app\components\useraction\UserAction;
use app\modules\comment\widgets\CommentsWidget;
use yii\helpers\Html;
use app\components\TActiveForm;
/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\CapexBudget */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Pms'),
    'url' => [
        '/pms'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Capex Budgets'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = (string) $model;
$title = Yii::t('app', 'Capex Budgets');
?>
<div class="wrapper">
	<div class="card">
		<div class="capex-budget-view card-body">
			<h4 class="text-danger"><?= Yii::t('app', 'Are you sure you want to delete this item? All related data is deleted'); ?></h4>
         <?php echo  \app\components\PageHeader::widget(['title'=>$title]); ?>
      </div>
	</div>
	<div class="card">
		<div class="card-body">
         <?php

        echo \app\components\TDetailView::widget([
            'id' => 'capex-budget-detail-view',
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered'
            ],
            'attributes' => [
                'id',
                [
                    'attribute' => 'project_id',
                    'format' => 'raw',
                    'value' => $model->getRelatedDataLink('project_id')
                ],
                [
                    'attribute' => 'milestone_id',
                    'format' => 'raw',
                    'value' => $model->getRelatedDataLink('milestone_id')
                ],
                'amount',
            /*'description:html',*/
            /*[
			'attribute' => 'state_id',
			'format'=>'raw',
			'value' => $model->getStateBadge(),],*/
            [
                    'attribute' => 'type_id',
                    'value' => $model->getType()
                ],
                'created_on:datetime',
                [
                    'attribute' => 'created_by_id',
                    'format' => 'raw',
                    'value' => $model->getRelatedDataLink('created_by_id')
                ]
            ]
        ])?>
         <?php  echo $model->description;?>
         <?php

        $form = TActiveForm::begin([
            'id' => 'capex-budget-form',
            'options' => [
                'class' => 'row'
            ]
        ]);
        ?>
         echo $form->errorSummary($model);	
         ?>         <div class="col-md-12 text-right">
            <?= Html::submitButton('Confirm', ['id'=> 'capex-budget-form-submit','class' =>'btn btn-success']) ?>
         </div>
         <?php TActiveForm::end(); ?>
      </div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="capex-budget-panel">
            <?php
            $this->context->startPanel();
            $this->context->addPanel('Feeds', 'feeds', 'Feed', $model /* ,null,true */);
            $this->context->endPanel();
            ?>
         </div>
		</div>
	</div>
      <?php echo CommentsWidget::widget(['model'=>$model]); ?>
</div>