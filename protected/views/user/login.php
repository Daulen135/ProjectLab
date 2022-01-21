<?php
use app\components\TActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\social\components\TAuthChoice;

/* @var $this yii\web\View */

// $this->title = 'Sign In';
?>

	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="auth-box">
					<div class="top">
						<h2 class="text-white"><a class="text-white" href="<?=Url::toRoute(['/']);?>">Project Lab</a></h2>
					</div>
					<div class="card">
						<div class="header">
							<p class="lead"><?=Yii::t('app', 'LOGIN')?></p>
						</div>
					<div class="body">
						
							   <?php
        $form = TActiveForm::begin([
            'id' => 'login-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,

            'options' => [
                'class' => 'form-auth-small'
            ]
        ]);
        ?>
                                     <span id="reauth-email"
							class="reauth-email"></span>
								<?=$form->field($model, 'username')->label(false)->textInput(['placeholder' => Yii::t('app', $model->getAttributeLabel('email'))])?>
           						 <?=$form->field($model, 'password')->label(false)->passwordInput(['placeholder' => Yii::t('app', $model->getAttributeLabel('password'))])?>
								<div id="remember" class="checkbox">
                 					 <?php

                    echo $form->field($model, 'rememberMe')
                        ->checkbox()
                        ->label(Yii::t('app', 'Remember Me'));
                    ?>
           						 </div>
								<?=Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary btn-lg btn-block bg-theme','id' => 'login','name' => 'login-button'])?>
								<div class="bottom">
							<span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a
								href="<?php

        echo Url::toRoute([
            'user/recover'
        ])?>"><?=Yii::t('app', "Forgot password?")?>
									</a></span> <span><?=Yii::t('app', "Don't have an account?")?><a
								href="<?=Url::toRoute(['/user/signup'])?>"><?=Yii::t('app', "Sign Up")?></a></span>



						</div>
								 <?php

        TActiveForm::end()?>
							<div class="separator-linethrough">
							<span>OR</span>
						</div>
					 <?=TAuthChoice::widget()?>
						</div>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>


