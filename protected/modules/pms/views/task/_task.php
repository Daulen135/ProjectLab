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
use app\components\TActiveForm;
use yii\helpers\Html;

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

$form = TActiveForm::begin([

    'id' => 'basic-form'
]);
?>

      <div class="card">
        <div class="header">
          <h2><?=Yii::t('app', 'Update Task')?></h2>
        </div>
        <div class="body">
          <form id="basic-form" method="post" novalidate="">
            <div class="form-row">
                <div class="col-md-6">
                    	<div class="d-flex align-items-start">
						<label><?=Yii::t('app', 'Task Title')?></label> <span data-toggle="tooltip"

							title="A project activity that needs to be accomplished within a defined period.  A task (project piece of work) can be broken down into assignments that should also have a defined start and end date or a deadline for completion. Ex: Designing Electrical hardware, Calculate materials, Testing IT prototype, Contract signoff."
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
	               <?php

                echo $form->field($model, 'title')
                    ->textInput([
                    'maxlength' => 128
                ])
                    ->label(false)?>
               </div>
                <div class="col-md-6">
                   	<div class="d-flex align-items-start">
						<label><?=Yii::t('app', '% Complete')?></label> <span data-toggle="tooltip"

							title="The progress of a task execution (use %)."
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
           <?php

        echo $form->field($model, 'progress_id')
            ->textInput()
            ->label(false)?>
          </div>
            </div>          
          <div class="form-row">
                  <div class="col-md-6">
                       	<div class="d-flex align-items-start">

						<label><?=Yii::t('app', 'Start Date')?></label> <span data-toggle="tooltip"

							title="Particular Date of starting task (use Calendar)."
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
	              <?php

            echo $form->field($model, 'start_date')
                ->widget(yii\jui\DatePicker::class, [
                // 'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ],
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true
                ]
            ])
                ->label(false)?>
               </div>
            <div class="col-md-6">
            <div class="d-flex align-items-start">

						<label><?=Yii::t('app', 'End Date')?></label> <span data-toggle="tooltip"

							title="Particular Date when it is expected to complete the task (use Calendar)."
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
              <?php

            echo $form->field($model, 'end_date')
                ->widget(yii\jui\DatePicker::class, [
                // 'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ],
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true
                ]
            ])
                ->label(false)?>
              </div>
          
          </div>
          <div class="form-row">
                <div class="col-md-6">
                <div class="d-flex align-items-start">

						<label><?=Yii::t('app', 'Notes')?></label> <span data-toggle="tooltip"

							title="Some specific comment that related to this certain task. Ex: Responsible person (John Woo), Deliverable of this task (Signoff contract), Using specific Technology (Electrical welding)."
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
              <?php

            echo $form->field($model, 'notes')
                ->textarea([
                'rows' => 6
            ])
                ->label(false)?>
	              
                                                 </div>
                                                 </div>
          <br>
          <div class="d-flex justify-content-end align-items-center">
        	  <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'project-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
      	</div>
        </form>
        <?php

        TActiveForm::end();
        ?>
      </div>
    </div>
  
