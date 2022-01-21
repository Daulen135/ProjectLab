  <?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<div class="bg-white p-5 box-shadow thanks-div">
				<h3 class="thanks-text">
			 <?php echo \Yii::t('app', "Thank You !!"); ?> 
    		</h3>
				<p> <?php if(! $verify){?>
					<?=\Yii::t('app', 'Thank you for reaching out to us! We have received your request and are happy to have you.
							Till then, kindly check your email and confirm your email address.It ensures we have the right mailing address in case we need to contact you.');} else {?> 
					<?= \Yii::t('app', 'Thank you for contacting us.We have received your request, our team will get back to you soon.'); }?>
					</p>
				<a href="<?= Url::home() ?>" class="btn-theme">Go home</a>
			</div>
		</div>

	</div>
</div>


