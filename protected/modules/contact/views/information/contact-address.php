<?php
use app\components\World;
use app\modules\contact\models\Address;
use app\components\TActiveForm;
use yii\helpers\Url;
use app\modules\contact\models\Information;
use borales\extensions\phoneInput\PhoneInput;
use yii\helpers\Html;
?>
<?php
$this->registerCss(file_get_contents(__DIR__ . '/../../assets/css/contact.css'));
?>

<section class="contact-us-wrapper">
	<div class="page-title-wrapper">
		<div class="container-fluid main-container">
			<div class="row align-items-center">
				<div class="col-md-8 col-lg-6 col-xl-4 offset-lg-2 mx-auto">
					<div class="contact-right-wrapper form-cover">
						<h3 class="mb-md-25 mb-15">
							<b> I'm Looking For...</b>
						</h3>
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
 <?php echo $form->field($model, 'type_id',['options' => ['class' => 'form-custom-radio form-group']])->radioList($model->getTypeLabelOptions(),['class' => 'form-custom-radio'])->label(false) ?>
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
						
						<!-- <p class="lead">Just a few details from you and one of our representatives shall get in touch with you soon.</p> -->

					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="page-heading">
						<h1 class="title text-white mb-10">
							FEEL FREE TO <span class="text-green">CONTACT US</span>
						</h1>
						<p class="mb-0 text-white lead">We are here to help and answer
							your every query. Whether you need a free demo, know the
							features, or pricing, we look forward to hearing from you.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- start contact form  -->
	<div class="contact-us-outer mt-md-80 mt-50">
		<div class="container-fluid main-container fluid-2">
			<h1 class="title mb-md-50 mb-30 text-center">You Can Reach Us At
				Here..</h1>
			<div class="address-main-outer address-main-outer2">
				<?php
    $addressQuery = Address::findActive();
    foreach ($addressQuery->each() as $add) {
        ?>
					<div class="contact-location-wrapper">
					<div class="row">
						<div class="col-md-2">
							<div class="contact-location-area">
								<img
									src="<?=$this->theme->getUrl("img/contact/{$add->country}.png")?>">
								<h4><?= ($add->country) ? World::findCountryByCode($add->country) : ''?></h4>
							</div>
						</div>
						<div class="col-lg-5 col-md-6  offset-lg-1">
							<div class="address-location-outer">
								<div class="d-md-flex">
									<div class="img-wrapper">
										<img
											src="<?=$this->theme->getUrl("img/contact/{$add->country}.jpg")?>">
									</div>
									<div class="address-content">
										<div class="country-address">
											<h4><?php echo $add->title?></h4>
										</div>
										<div class="address-data">
											<?= $add->address?>
											<br>
												<?php if($add->latitude !== '0'){?>
												<a
												href="http://maps.google.com/?q=<?=$add->latitude?>,<?=$add->longitude?>"
												class="view-map m-0" target='_blank'>View On Map</a>
													<?php }?>
											</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-4 offset-lg-1 ">
							<div class="country-address phone-img">
								<h4>Phone/Mobile</h4>
							</div>
								<?php
        $sales = $add->contacts;

        ?>
        
								<div class="address-data">
								<?php

        foreach ($sales as $sale) {
            if ($sale->hasProperty('contact_no')) {
                ?>
									<span class="d-inline-block"
									style="font-size: 18px; color: #071c4d;"> <label>Sales: </label>
									<a href="tel:<?= $sale->contact_no?>"><?= $sale->contact_no?></a><span
									class="what-app-ic"> <a
										href="https://wa.me/<?= $sale->contact_no?>"> <img
											src="<?=$this->theme->getUrl('img/contact/whatsapp.png')?>"></a>
								</span></span> <?php }}?>
									
								</div>
						</div>
					</div>
				</div>
					<?php }?>
				</div>
		</div>
	</div>
	<!-- end contact form  -->
</section>
<!-- contact section end---->
<script>
	$('#information-type_id').change(function() {
		selected_value = $("input[name='Information[type_id]']:checked").val();
		if(selected_value == 0){
			$('#information-budget_type_id').hide();
		}else if(selected_value == 1){
			$('#information-budget_type_id').show();
		}
	});

</script>