<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

// $this->title = 'Request password reset';
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Request passwordReset'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = \yii\helpers\Inflector::camel2words(Yii::$app->controller->action->id);
?>
<div class="box-header with-border">
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="auth-box">
					<div class="top">

						<h2 class="text-white"><a class="text-white" href="<?=Url::toRoute(['/']);?>"><?=Yii::t('app', 'Project Lab')?></a></h2>


					</div>
					<div class="card">
						<div class="header">
							<p class="lead"><?=Yii::t('app', 'Forgot Password')?></p>
						</div>
						<div class="body">
						
							 <?php

        $form = ActiveForm::begin([
            'id' => 'request-password-reset-form'
        ]);
        ?>
							<?=$form->field($model, 'email')?>
								 <?=Html::submitButton(Yii::t('app', 'Send'), ['name' => 'send-button','class' => 'btn btn-primary btn-lg btn-block mb-3 bg-theme'])?>
							<?php

    ActiveForm::end();
    ?>
							<span class="helper-text"><?=Yii::t('app', 'Go to login page')?> <a
								href="<?=Url::toRoute(['/user/login'])?>"><?=Yii::t('app', 'Login')?></a></span>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>

	