 <?php
use app\components\TActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\social\widgets\SocialShare;
use app\modules\social\components\TAuthChoice;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

// $this->title = 'Signup';
?>

<div id="wrapper">
	<div class="vertical-align-wrap">
		<div class="vertical-align-middle auth-main">
			<div class="auth-box">
				<div class="top">
					<h2 class="text-white">
						<a class="text-white" href="<?=Url::toRoute(['/']);?>">Project Lab</a>
					</h2>
				</div>
				<div class="card">
					<div class="header">
						<p class="lead"><?=Yii::t('app', 'SIGN UP')?></p>
					</div>
					<div class="body">
						
						     	<?php

            $form = TActiveForm::begin([
                'id' => 'form-signup',
                'options' => [
                    'class' => 'form-auth-small'
                ]
            ]);
            ?>
                      <span id="reauth-email" class="reauth-email"></span>
					<?=$form->field($model, 'first_name', ['template' => '{input}{error}'])->textInput(['maxlength' => true,'placeholder' => Yii::t('app', 'First Name')])->label(false)?>
						<?=$form->field($model, 'last_name', ['template' => '{input}{error}'])->textInput(['maxlength' => true,'placeholder' => Yii::t('app', 'Last Name')])->label(false)?>
<?=$form->field($model, 'email', ['template' => '{input}{error}'])->textInput(['maxlength' => true,'placeholder' => Yii::t('app', 'Email')])->label(false)?>
	<?=$form->field($model, 'password', ['template' => '{input}{error}'])->passwordInput(['maxlength' => true,'placeholder' => Yii::t('app', 'Password')])->label(false)?>
		<?=$form->field($model, 'confirm_password', ['template' => '{input}{error}'])->passwordInput(['maxlength' => true,'placeholder' => Yii::t('app', 'Confirm Password')])->label(false)?>
					
					
							<?=Html::submitButton(Yii::t('app', 'Sign Up'), ['class' => 'btn btn-primary btn-lg btn-block bg-theme','name' => 'signup-button'])?>
								<div class="bottom">
							<span class="helper-text"><?=Yii::t('app', 'Already have an account?')?><a
								href="<?=Url::toRoute(['/user/login'])?>"><?=Yii::t('app', 'Login')?></a></span>
						</div>
					<?php

    TActiveForm::end();
    ?>
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
