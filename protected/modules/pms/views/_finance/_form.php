<?php
use yii\helpers\Html;
use app\components\TActiveForm;
use app\models\User;
use app\modules\pms\models\Project;
use app\modules\pms\models\Rename;
use app\modules\pms\models\Variable;
/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Finance */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$variable = Variable::variable();
?>
   <?php

$form = TActiveForm::begin([

    'id' => 'finance-form'
]);
?>

<div class="card">
	<div class="header">
		<?php 
        if (yii::$app->controller->action->id == 'add') {
           ?>
                     <h2><?php echo Project::getTitle()?></h2>
           
           <?php 
        }else{
            ?>
                     <h2><?php echo $model->project;?></h2>
           
           <?php 
        }
        ?>
	</div>
	<div class="body">
			<div class="form-row">
			<div class="col-md-6">
			    <div class="d-flex align-items-start">
						<label><?=empty($variable['income']->title) ?'Income' : $variable['income']->title?></label> <span data-toggle="tooltip"
							title="Income received for a certain period from the project result/product."
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
                  <?php echo $form->field($model, 'income')->textInput()->label(false) ?>
                  </div>
			<div class="col-md-6">
			    <div class="d-flex align-items-start">
						<label><?=empty($variable['opex']->title) ?'Opex' : $variable['opex']->title ?></label> <span data-toggle="tooltip"
							title="Costs for a certain period received from the use of the project result/product."
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
                            <?php echo $form->field($model, 'opex')->textInput()->label(false)?>
                              </div>
		</div>      
				<div class="form-row">
			<div class="col-md">
			    <div class="d-flex align-items-start">
						<label><?=empty($variable['period']->title) ?'T Period' : $variable['period']->title?></label> <span data-toggle="tooltip"
							title="Particular calculated period of time Ex: Week 1, Week 2 and so on (Month, Year, any another period of time)."
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
                            <?php echo $form->field($model, 'time')->textInput()->label(false) ?>
                              </div>
		</div>
                        <?php if(User::isAdmin()){?>      <?php echo $form->field($model, 'state_id')->dropDownList($model->getStateOptions(), ['prompt' => '']) ?>
      <?php }?>                       
     
                  <div class="col-md-12 text-right">
      <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id'=> 'finance-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
   </div>
   <?php TActiveForm::end(); ?>
   </div>
</div>