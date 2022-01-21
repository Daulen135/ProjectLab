<?php
   use app\components\TActiveForm;
   use yii\helpers\Html;
use app\components\World;
   
   /* @var $this yii\web\View */
   /* @var $model app\models\Contact */
   /* @var $form yii\widgets\ActiveForm */
   ?>
<header class="card-header">
   <?php echo strtoupper(Yii::$app->controller->action->id); ?>
</header>
<div class="card-body">
   <?php
      $form = TActiveForm::begin([
          'id' => 'contact-form',
          'options'=>[
            'class'=>'row'
          ]
      ]);
      ?>
      <div class="col-md-6">
         <?php echo $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
   <?php echo $form->field($model, 'contact_no')->textInput(['maxlength' => 255]) ?>
   <?php echo $form->field($model, 'type_chat')->textInput(['maxlength' => 255]) ?>
   <?php echo $form->field($model, 'skype_chat')->textInput(['maxlength' => 255]) ?>
      </div>
      <div class="col-md-6">
         <?php echo $form->field($model, 'gtalk_chat')->textInput(['maxlength' => 255]) ?>
   <?php echo $form->field($model, 'type_id')->dropDownList($model->getTypeOptions(), ['prompt' => '']) ?>
   <?php echo $form->field($model, 'country')->dropDownList(World::countries()) ?>
   <?php echo $form->field($model, 'state_id')->dropDownList($model->getStateOptions(), ['prompt' => '']) ?>
      </div>

   <div class="col-md-12 text-right">
         <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id'=> 'contact-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>
 
   <?php TActiveForm::end(); ?>
</div>
