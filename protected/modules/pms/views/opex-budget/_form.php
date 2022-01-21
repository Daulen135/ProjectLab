<?php
use yii\helpers\Html;
use app\components\TActiveForm;
use app\models\User;
use app\modules\pms\models\Project;
/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\OpexBudget */
/* @var $form yii\widgets\ActiveForm */
?>


   <?php

$form = TActiveForm::begin([

    'id' => 'opex-budget-form',
    'options' => [
        'class' => 'row'
    ]
]);
?>
<div class="card">
	<div class="header">
         <?php
        if (yii::$app->controller->action->id == 'add') {
            ?>
              
           
           <?php
        } else {
            ?>
                     <h2><?php

            echo $model->project;
            ?></h2>
           
           <?php
        }
        ?>
        </div>
	<div class="body">
		<div class="row">
			<div class="col-md-12"></div>
                  <?php
                // echo $form->field($model, 'project_id')->dropDownList($model->getProjectOptions(), ['prompt' => '']) ?>
                              <?php
                            // echo $form->field($model, 'amount')->textInput() ?>
                              <div class="col-md-6">
				<div class="d-flex align-items-start">
					<label><?=Yii::t('app', 'General Expenses')?></label> <span data-toggle="tooltip"
						title="General expenses that are spent on the entire project rather than a specific project activity/task."
						class="ques-mark ml-2"><i
						class="fa fa-info-circle vt-top text-primary"></i></span>
				</div>
                              <?php

                            echo $form->field($model, 'expense')
                                ->textInput([
                                'maxlength' => 255
                            ])
                                ->label(false)?>
                              </div>
			<div class="col-md-6">
				<div class="d-flex align-items-start">
					<label><?=Yii::t('app', 'Payroll')?></label> <span data-toggle="tooltip"
						title="Salary of project participants for the entire project implementation period."
						class="ques-mark ml-2"><i
						class="fa fa-info-circle vt-top text-primary"></i></span>
				</div>
                              <?php

                            echo $form->field($model, 'payroll')
                                ->textInput([
                                'maxlength' => 255
                            ])
                                ->label(false)?>
                              </div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="d-flex align-items-start">
					<label><?=Yii::t('app', 'Others')?></label> <span data-toggle="tooltip"
						title="Possible other expenses that could not be related to GE and Payroll."
						class="ques-mark ml-2"><i
						class="fa fa-info-circle vt-top text-primary"></i></span>
				</div>
                              <?php

                            echo $form->field($model, 'item_name')
                                ->textInput([
                                'maxlength' => 255
                            ])
                                ->label(false)?>
                              </div>
			<div class="col-md-6">
                        <?php

                        if (User::isAdmin()) {
                            ?>      <?php

                            echo $form->field($model, 'state_id')
                                ->dropDownList($model->getStateOptions(), [
                                'prompt' => ''
                            ])
                                ->label(Yii::t('app', 'State'))?>
      <?php
                        }
                        ?>             
      </div>
		</div>
                <?php
                /* echo $form->field($model, 'type_id')->dropDownList($model->getTypeOptions(), ['prompt' => '']) */
                ?>
                  <div class="col-md-12 text-right">
      <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'opex-budget-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
   </div>
	</div>
</div>
<?php

TActiveForm::end();
?>
