<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\TActiveForm;
use yii\helpers\Url;

// $this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
?><br>
<br>
<br>
<br>


	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="auth-box">
					<div class="top">
						<h2 class="text-white"><a class="text-white" href="<?= Url::toRoute(['/'])?>">Project Lab</a></h2>
					</div>
					<div class="card">
						<div class="header">
							<p class="lead"><?= Yii::t('app', 'Change Password')?></p>
							<br>
							<p><?= Yii::t('app', 'Please fill out the following fields to change password')?>:</p>
						</div>
						<div class="body">
						
							   <?php

                                    $form = TActiveForm::begin([
                                        'id' => 'changepassword-form',
                                        'enableAjaxValidation' => false,
                                        'enableClientValidation' => false,
                        
                                        'options' => [
                                            'class' => 'form-auth-small'
                                        ]
                                    ]);
                                    ?>
                                     <span id="reauth-email" class="reauth-email"></span>
								  <?=$form->field ( $model, 'password', [ 'inputOptions' => [ 'placeholder' => '' ] ] )->passwordInput ()?>
                                  <?=$form->field ( $model, 'confirm_password', [ 'inputOptions' => [ 'placeholder' => '' ] ] )->passwordInput ()?>
							
								<?=Html::submitButton ( 'Change password', [ 'class' => 'btn btn-primary btn-lg btn-block bg-theme','id' => 'login','name' => 'login-button' ] )?>
							
								 <?php TActiveForm::end()?>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>