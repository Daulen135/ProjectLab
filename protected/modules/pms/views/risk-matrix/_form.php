<?php
use yii\helpers\Html;
use app\components\TActiveForm;
use app\models\User;
use app\modules\pms\models\Project;
use app\modules\pms\models\RiskMatrix;
/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\RiskMatrix */
/* @var $form yii\widgets\ActiveForm */
?>


   <?php

$form = TActiveForm::begin([

    'id' => 'risk-matrix-form',
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
                     <h2><?php

            echo Project::getTitle()?></h2>
           
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
		<div class="col-md-12">
   <?php
echo $form->errorSummary($model);
?>  </div>
		<div class="row">
			<div class="col-md-6">
				<div class="d-flex align-items-start">

					<label><?=Yii::t('app', 'Risk Description')?></label> <span data-toggle="tooltip"
						title="There is a definition of the potential risk that may occur on the project and to affect to a project constraint. Ex: Non-delivery of equipment, Lack of necessary resources, Not entering into an agreement."
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

					<label><?=Yii::t('app', 'Likelihood')?></label> <span data-toggle="tooltip"

						title="      There is a probability of the hazard occurring and it is often ranked on a five point scale:
    • Rare - Event may only occur in exceptional circumstances.
    • Unlikely - Event could occur at some point in time.
    • Moderate - Event is as likely to occur as not occur.
    • Likely - Event will probably occur in most circumstances.
    • Almost certain - Event is expected to occur in most circumstances."
						class="ques-mark ml-2"><i
						class="fa fa-info-circle vt-top text-primary"></i></span>
				</div>
      <?php

    echo $form->field($model, 'severity')
        ->dropDownList($model->getSeverityOptions(), [
        'prompt' => ''
    ])
        ->label(false)?>
      </div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="d-flex align-items-start">

					<label><?=Yii::t('app', 'Consequence')?></label> <span data-toggle="tooltip"

						title="     There is the amount of damage or harm a hazard could create and it is often ranked on a four point scale as follows:
    • Catastrophic - Operating conditions are such that human error, environment, design deficiencies, element, subsystem or component failure, or procedural deficiencies may commonly cause death or major system loss, thereby requiring immediate cessation of the unsafe activity or operation.
    • Major - Operating conditions are such that human error, environment, design deficiencies, element, subsystem or component failure or procedural deficiencies may commonly cause severe injury or illness or major system damage thereby requiring immediate corrective action.
    • Moderate - Operating conditions may commonly cause minor injury or illness or minor systems damage such that human error, environment, design deficiencies, subsystem or component failure or procedural deficiencies can be counteracted or controlled without severe injury, illness or major system damage.
    • Insignificant - Operating conditions are such that personnel error, environment, design deficiencies, subsystem or component failure or procedural deficiencies will result in no, or less than minor, illness, injury or system damage. "
						class="ques-mark ml-2"><i
						class="fa fa-info-circle vt-top text-primary"></i></span>
				</div>
     <?php

    echo $form->field($model, 'impact')
        ->dropDownList($model->getImpactOptions(), [
        'prompt' => ''
    ])
        ->label(false)?>
      </div>
			<div class="col-md-6">
			 <?php

    if (User::isAdmin()) {
        ?>  
				<div class="d-flex align-items-start">

					<label><?=Yii::t('app', 'Risk Status')?></label> <span data-toggle="tooltip"

						title="There is a monetary assumption of the estimated cost to perform this activity/task. "
						class="ques-mark ml-2"><i
						class="fa fa-info-circle vt-top text-primary"></i></span>
				</div>
           <?php

        echo $form->field($model, 'state_id')
            ->dropDownList($model->getStateOptions(), [
            'prompt' => ''
        ])
            ->label(false)?>
      <?php
    }
    ?>  </div>
		</div>
              
                              <?php
                            // echo $form->field($model, 'project_id')->dropDownList($model->getProjectOptions(), ['prompt' => '']) ?>
                             
                              
                              <?php
                            // echo $form->field($model, 'factor')->textInput(['maxlength' => 128]) ?>
                                           <?php
                                        /* echo $form->field($model, 'type_id')->dropDownList($model->getTypeOptions(), ['prompt' => '']) */
                                        ?>
        <div class="col-md-12 text-right">
      <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'risk-matrix-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
   </div>
	</div>
</div>
<?php

TActiveForm::end();
?>
