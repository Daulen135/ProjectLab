<?php
use yii\helpers\Html;
use app\components\TActiveForm;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Rate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-body">
   <?php    $form = TActiveForm::begin([
    
   'id' => 'rate-form'
   ]);
   echo $form->errorSummary($model);    
   ?>
   
     <div class="form-row">
                    <div class="col-md">
                    <div class="d-flex align-items-start">
						<label>Rate</label> <span data-toggle="tooltip"
							title="Discount Rate or Return is a percentage that could be earned in alternative investment. For instance it is ussualy use a local Bank rate to compare diffence beetween a project result income and making a Bank deposit."
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
                              <?php echo $form->field($model, 'rate')->textInput(['maxlength' => 255])->label(false) ?>
                              <div class="d-flex align-items-start">
						<label>Period</label> <span data-toggle="tooltip"
							title="Particular calculated period of time Ex: Week 1, Week 2 and so on (Month, Year, any another period of time)."
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
                              <?php echo $form->field($model, 'type_id')->dropDownList($model->getTypeOptions(), ['prompt' => ''])->label(false) ?>
                        <?php if(User::isAdmin()){?>      <?php echo $form->field($model, 'state_id')->dropDownList($model->getStateOptions(), ['prompt' => '']) ?>
      <?php }?>     
      </div></div>                 
                  <div
      class="col-md-12 text-right">
      <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id'=> 'rate-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
   </div>
   <?php TActiveForm::end(); ?>
</div>