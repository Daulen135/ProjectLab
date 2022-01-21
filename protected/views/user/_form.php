<?php
use app\components\TActiveForm;
use app\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<header class="card-header">
    <?php

    echo Yii::t('app',strtoupper(Yii::$app->controller->action->id));
    ?>
                        </header>
<div class="card-body">

    <?php
    $form = TActiveForm::begin([
        'id' => 'user-form',
        'options' => [
            'class' => 'row'
        ]
    ]);
    ?>

<div class="col-lg-6">
			
		 <?php
// echo $form->field($model, 'full_name')->textInput(['maxlength' => 256]) ?>
		 
		 <?php

echo $form->field($model, 'first_name')
    ->textInput([
    'maxlength' => 256
])
    ->label(Yii::t('app', 'First Name'))?>
		 
		 <?php

echo $form->field($model, 'last_name')
    ->textInput([
    'maxlength' => 256
])
    ->label(Yii::t('app', 'Last Name'))?>

		 <?php

echo $form->field($model, 'email')
    ->textInput([
    'maxlength' => 255
])
    ->label(Yii::t('app', 'Email'))?>
 		<?php

echo $form->field($model, 'profile_file')
    ->fileInput()
    ->label(Yii::t('app', 'Profile File'))?>
		
		 <?php
// echo $form->field($model, 'password')->passwordInput(['maxlength' => 128]) ?>
		 
         <?php

        echo $form->field($model, 'contact_no')
            ->textInput([
            'maxlength' => 11
        ])
            ->label(Yii::t('app', 'Contact No'))?>

		 <?php
// echo $form->field($model, 'date_of_birth')->widget(yii\jui\DatePicker::class,
([
    // 'dateFormat' => 'php:Y-m-d',
    'options' => [
        'class' => 'form-control'
    ],
    'clientOptions' => [
        // 'minDate' => 0,
        'changeMonth' => true,
        'changeYear' => true
    ]
])?>

</div>
	<div class="col-lg-6">

		 
		 <?php

if ($model->role_id == User::isManager()) {
    ?>
	 		
	 		<?php

    echo $form->field($model, 'role_id')
        ->dropDownList($model->getRoleOptions(), [
        'prompt' => ''
    ])
        ->label(Yii::t('app', 'Role'))?>
	 		
		    <?php

    echo $form->field($model, 'state_id')
        ->dropDownList($model->getStateOptions(), [
        'prompt' => ''
    ])
        ->label(Yii::t('app', 'State'))?>
		    
		<?php
}
?>
	 	 <?php
    // echo $form->field($model, 'last_visit_time')->widget(yii\jui\DatePicker::class,
    [
        // 'dateFormat' => 'php:Y-m-d',
        'options' => [
            'class' => 'form-control'
        ],
        'clientOptions' => [
            // 'minDate' => 0,
            'changeMonth' => true,
            'changeYear' => true
        ]
    ]?>

	 		

		
		 <?php
// echo $form->field($model, 'last_action_time')->widget(yii\jui\DatePicker::class,
[
    // 'dateFormat' => 'php:Y-m-d',
    'options' => [
        'class' => 'form-control'
    ],
    'clientOptions' => [
        // 'minDate' => 0,
        'changeMonth' => true,
        'changeYear' => true
    ]
]?>

	 		

		
		 <?php
// echo $form->field($model, 'last_password_change')->widget(yii\jui\DatePicker::class,
[
    // 'dateFormat' => 'php:Y-m-d',
    'options' => [
        'class' => 'form-control'
    ],
    'clientOptions' => [
        // 'minDate' => 0,
        'changeMonth' => true,
        'changeYear' => true
    ]
]?>

	 		

		
		 <?php
// echo $form->field($model, 'login_error_count')->textInput() ?>

	 		

		
		 <?php
// echo $form->field($model, 'activation_key')->textInput(['maxlength' => 128]) ?>

	 		

		
		 <?php
// echo $form->field($model, 'timezone')->textInput(['maxlength' => 255]) ?>

	 			</div>




	<div class="form-group col-lg-12 text-right">
	
        <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'user-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success'])?>
    </div>
	

    <?php

    TActiveForm::end();
    ?>

</div>
