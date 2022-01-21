<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 *
 */
use app\components\TActiveForm;
use yii\helpers\Html;
use borales\extensions\phoneInput\PhoneInput;
use yii\helpers\Url;
use app\modules\contact\models\Information;

/* @var $this yii\web\View */
/* @var $model app\modules\contact\models\Information */
/* @var $form yii\widgets\ActiveForm */
?>
   <?php
$form = TActiveForm::begin([
    'options' => [
        'id' => 'quote_form_id'
    ],
    'action' => Url::toRoute([
        '/contact/information/info',
        'type' => Information::TYPE_QUOTE
    ])
]);
?>

      <?php echo $form->field($model, 'full_name')->textInput(['maxlength' => 255,'placeholder' => 'Name*'])->label(false) ?>
      <?php echo $form->field($model, 'email')->textInput(['maxlength' => 255,'placeholder' => 'Email*'])->label(false) ?>
 <?php

echo $form->field($model, 'mobile')
    ->input('tel', [
    'id' => "phone_number",
    'maxlength' => 10
])
    ->widget(PhoneInput::className(), [
    'options' => [
        'id' => 'quote_phone_number',
        'placeholder' => 'Mobile*'
    ],
    'jsOptions' => [
        'separateDialCode' => true,
        'autoPlaceholder' => 'off',
        'initialCountry' => $model->country_code
    ]
])
    ->label(false);
?>
	  <?php echo $form->field($model, 'budget_type_id')->dropDownList($model->getBudgetTypeOptions(),['prompt' => 'Select Budget'])->label(false);  ?>
      <?php // echo $form->field($model, 'subject')->textInput(['maxlength' => 255,'placeholder' => 'Subject*'])->label(false) ?>
      <?php echo $form->field($model, 'description')->textarea(['rows' => 4,'placeholder' => 'Description'])->label(false);  ?>
<div class="form-group">
	<div class="text-center">
         <?php
        echo Html::submitButton('Send Message', [
            'class' => 'contact-form-btn w-100',
            'id' => 'quote-form-submit',
            'name' => 'submit-button'
        ])?> 
      </div>
</div>
<?php TActiveForm::end(); ?>
