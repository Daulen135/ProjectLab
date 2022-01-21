<?php
/* @var $this yii\web\View */
use app\components\TActiveForm;
use app\modules\contact\widgets\ContactWidget;
use yii\helpers\Url;

// $this->title = "Contact Us ";

?>
<div class="breadcroumb-area bread-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcroumb-title text-center">
                        <h1 class="text-white"><?= Yii::t('app', 'Contact Us')?></h1>
                        <h6 class="text-white"><a  href="<?php echo Url::toRoute(['/'])?>"><?= Yii::t('app', 'Home')?></a> / <?= Yii::t('app', 'Contact Us')?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
<section class="py-5 clr-green">
	<div id="contact-main">
		<div class="container-fluid text-center">

			<h2 class="title"><?= Yii::t('app', 'Get in touch')?></h2>
			<p class="intro"><?= Yii::t('app', 'We have a great customer support team who would love to hear from you.')?></p>
		</div>
	</div>

	<div class="container contact-form-section clearfix">
		<div class="col-md-12">
			<div class="contact-main section padding-0">     
      <?php $this->endBody()?>
   </div>
			<div class="contact-form-bg mt-4 bg-white">
				<div class="contact-form">
     <?php
    $form = TActiveForm::begin([
        'id' => 'contact-form',

        'fieldConfig' => [
            'template' => "{input}{error}"
        ]
    ]);
    ?>
            	<div class="row">
					<div class="col-md-6">
                     <?php echo $form->field ( $model, 'first_name')->textInput ( [ 'placeholder' => 'First Name' ] )->label ( false )?>
                     </div>
                     	<div class="col-md-6">
                     <?php echo $form->field ( $model, 'last_name')->textInput ( [ 'placeholder' => 'Last Name' ] )->label ( false )?>
                     </div>

					</div>


                     <?php echo  $form->field($model, 'email')->textInput(['placeholder'=>'Email'])->label(false)?>

                     <?php echo $form->field ( $model, 'body' )->textArea ( [ 'rows' => 6,'placeholder' => 'Message' ] )->label ( false )?>
					<div class="text-center">
					<?php

    echo \yii\helpers\Html::submitButton('Submit', [
        'class' => 'btn btn btn-primary btn-lg btn-block bg-theme',
        'name' => 'submit-button'
    ])?>
    </div>

                    <?php TActiveForm::end(); ?>
          </div>
			</div>
		</div>
	</div>
</section>
