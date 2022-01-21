<?php
use app\modules\blog\models\Post;
use app\modules\feature\models\Feature;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use app\models\Page;
use app\models\Service;
use app\modules\translator\widget\TranslatorWidget;
/* @var $this yii\web\View */
// $this->title = Yii::$app->name;
?>
<!-- home slider start-->
<div id="home-slider" class="home-main-block owl-carousel">
	<div class="item home-slider-bg theme-3" style="background-image: url('<?=$this->theme->getUrl('frontend/images/banner1.jpg')?>')">
		<div class="overlay-bg"></div>
		<div class="container">
			<div class="row">
				<div class="col-lg-7">
					<div class="slider-dtl-2">
						<h1 class="slider-heading text-white font-48">
						<?=Yii::t('app', 'The Simplest Project Management Tool used by Project Managers')?>
						.</h1>
						<div class="slider-btn">
							<a class="btn btn-dark" href="<?=Url::toRoute(['user/signup']);?>"><?=Yii::t('app', 'Try for free')?>
							 <i class="las la-arrow-right"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="item home-slider-bg" style="background-image: url('<?=$this->theme->getUrl('frontend/images/banner2.jpg')?>')">
		<div class="overlay-bg"></div>
		<div class="container">
			<div class="row">
				<div class="col-lg-7">
					<div class="slider-dtl-2">
						<h1 class="slider-heading text-white font-48">
						<?=Yii::t('app', 'The Best Software Tool for Busy Professionals')?>
						.</h1>
						<div class="slider-btn">
							<a class="btn btn-dark" href="<?=Url::toRoute(['user/signup']);?>">
							<?=Yii::t('app', 'Try for free')?><i class="las la-arrow-right"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- home slider end-->

<!-- about start-->
<div id="about" class="about-main-block theme-2">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="about-left">
					<img src="<?=$this->theme->getUrl('frontend/images/about-us.jpg')?>" class="img-fluid image" alt="">
				</div>
			</div>
			<div class="col-lg-6 col-md-12 pl-4">
				<div class="about-content">
					<?php

    $abouts = Page::find()->where([
        'type_id' => Page::TYPE_ABOUT_US
    ])->one();
    ?>
			
					<h1>  <?=TranslatorWidget::widget(['type' => TranslatorWidget::TYPE_DISPLAY,'model' => $abouts,'attribute' => 'title']);?></h1>
					<p class="wow slideInDown text-justify"> <?=TranslatorWidget::widget(['type' => TranslatorWidget::TYPE_DISPLAY,'model' => $abouts,'attribute' => 'description']);?></p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- about end-->


<!-- services start -->
<div id="services" class="services-main-block-2" style="background-image:url('<?=$this->theme->getUrl('frontend/images/bg/best-bg.jpg')?>')">
	<div class="container">
		<div class="section text-center">
			<h1 class="section-heading"><?=Yii::t('app', 'Our Services')?></h1>
		</div>
		<div class="row">
			<?php

$terms = Service::find()->all();

if (! empty($terms)) {
    foreach ($terms as $term) {
        ?>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="single-service-item">
							<div class="download-icon">
									<?php

        echo Html::img($term->image_file = \Yii::$app->urlManager->createAbsoluteUrl([
            'service/image',
            'id' => $term->id
        ]), [
            'class' => 'w-60 user-photo',
            'alt' => $term,
            'width' => '75px',
            'height' => '75px'
        ])?>
							</div>
							<h4><?=TranslatorWidget::widget(['type' => TranslatorWidget::TYPE_DISPLAY,'model' => $term,'attribute' => 'title']);?></h4>
							<p><?=TranslatorWidget::widget(['type' => TranslatorWidget::TYPE_DISPLAY,'model' => $term,'attribute' => 'description']);?></p>
						</div>
					</div>
					<?php
    }
}
?>
		</div>
	</div>
</div>


<script type="text/javascript">



$(document).ready(function(){
(function( $ ) {
	// the sameHeight functions makes all the selected elements of the same height
	$.fn.sameHeight = function() {
			var selector = this;
			var heights = [];

			// Save the heights of every element into an array
			selector.each(function(){
					var height = $(this).height();
					heights.push(height);
			});

			// Get the biggest height
			var maxHeight = Math.max.apply(null, heights);
			// Show in the console to verify

			// Set the maxHeight to every selected element
			selector.each(function(){
					$(this).height(maxHeight);
			});
	};

}( jQuery ));

$('.single-service-item').sameHeight();

$('.single-price-item').sameHeight();

});


$(window).resize(function(){
    // Do it when the window resizes too
    $('.single-service-item').sameHeight();

		$('.single-price-item').sameHeight();
});


</script>


<!-- services end-->
<?=Yii::$app->controller->renderPartial('pricing', ['model' => $plans]);?>
