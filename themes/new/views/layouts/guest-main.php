<?php
use app\assets\AppAsset;
use app\components\FlashMessage;
use app\components\gdpr\Gdpr;
use lajax\languagepicker\widgets\LanguagePicker;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php

$this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
   <head>
      <meta name="viewport"
         content="width=device-width,initial-scale=1,maximum-scale=1">
      <meta charset="<?=Yii::$app->charset?>" />
      <?=Html::csrfMetaTags()?>
      <title> <?=Html::encode($this->title)?></title>
      <?php

    $this->head()?>
<link rel="shortcut icon"
	href="<?=$this->theme->getUrl('/admin/img/logo.png')?>" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">

<!-- Navigation CSS -->
<link rel="stylesheet" type="text/css" href="<?php

echo $this->theme->getUrl('frontend/css/menumaker.css')?>" />
<!-- Animated CSS -->
<link rel="stylesheet" type="text/css" href="<?php

echo $this->theme->getUrl('frontend/css/animate.css')?>" />
<!-- Owl Carousel css -->
<link rel="stylesheet" type="text/css" href="<?php

echo $this->theme->getUrl('frontend/css/owl.carousel.min.css')?>" />
<!-- Line Awesome CSS -->
<link rel="stylesheet" type="text/css" href="<?php

echo $this->theme->getUrl('frontend/css/line-awesome.min.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php

echo $this->theme->getUrl('frontend/css/font-awesome.min.css')?>" />
<!-- Flaticon CSS -->
<link rel="stylesheet" type="text/css" href="<?php

echo $this->theme->getUrl('frontend/css/flaticon.css')?>" />
<!-- Slicknav CSS -->
<link rel="stylesheet" type="text/css" href="<?php

echo $this->theme->getUrl('frontend/css/slicknav.min.css')?>" />
<!-- Main Style CSS -->
<link href="<?php

echo $this->theme->getUrl('frontend/css/style.css')?>" rel="stylesheet" type="text/css" />
<!-- Responsive CSS -->
<link href="<?php

echo $this->theme->getUrl('frontend/css/responsive.css')?>" rel="stylesheet">
<!-- Helper CSS -->
<link href="<?php

echo $this->theme->getUrl('frontend/css/helper.css')?>" rel="stylesheet">

   </head>
   <body class="home-page">
      <?php

    $this->beginBody()?>

            	<!-- top-nav bar start-->
        	<div id="nav-bar" class="nav-bar-main-block absolute">
        		<div class="sticky-area">
        			<div class="container">
        				<div class="row justify-content-center align-items-center">
        					<div class="col-lg-3 col-md-12">
        						<div class="logo">
        							<a href="<?php

            echo Url::toRoute([
                '/'
            ])?>" class="text-logo"><img src="<?=$this->theme->getUrl('/admin/img/logo.png')?>" alt="logo" /></a>
        						</div>
        						<!-- Responsive Menu Area -->
        						<div class="responsive-menu-wrap"></div>
        					</div>
        					<div class="col-lg-9">
        						<div class="navigation text-white theme-2">
        							<div id="cssmenu">
        								<ul>
        									<li class="active"><a href="<?=Url::toRoute(['/'])?>"><?=Yii::t('app', 'Home')?></a></li>
        									<li><a href="<?php

                echo Url::toRoute([
                    '/'
                ])?>#services"><?=Yii::t('app', 'Services')?></a></li>
        									<li><a href="<?php

                echo Url::toRoute([
                    '/pricing'
                ])?>"><?=Yii::t('app', 'Pricing')?></a></li>
        									<li><a href="<?php

                echo Url::toRoute([
                    '/contactus'
                ]);
                ?>"><?=Yii::t('app', 'Contact')?></a></li>
        									<li><a href="<?php

                echo Url::toRoute([
                    '/user/login'
                ]);
                ?>"><?=Yii::t('app', 'Login')?></a></li>
        									<li><a href="<?php

                echo Url::toRoute([
                    '/user/signup'
                ]);

                ?>"><?=Yii::t('app', 'Sign Up')?></a>
                </li>
        								<li
							class="dropdown language-dropdown main-tog pl-0 drop-toggle pl-md-2 d-flex pt-0"><a
							class="dropdown-toggle " href="javascript:;"
							id="dropdownMenuButton" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false"> <?=Yii::t('app', 'Language')?>
						</a>
							<ul class="dropdown-menu">
								<li class="dropdown-item"><a
									href="<?php

        echo Url::toRoute([
            '?language-picker-language=en'
        ]);
        ?>"><?=Yii::t('app', 'English')?></a></li>
								<li class="dropdown-item"><a
									href="<?php

        echo Url::toRoute([
            '?language-picker-language=ru'
        ]);
        ?>"><?=Yii::t('app', 'Russian')?></a></li>
							</ul>

							</li>

        								</ul>
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        	<!-- top-nav bar end-->



      <?=Gdpr::widget();?>
      <!-- body content start-->
      <div class="main_wrapper">
         <?=FlashMessage::widget(['type' => 'toster'])?>
         <?=$content?>
      </div>
      <!--body wrapper end-->

     		<!-- footer start-->
	<footer id="footer" class="footer-main-block">
    <div class="my-4 my-lg-5">
      <div class="container">
  			<div class="row text-white">
  				<div class="col-lg-3 col-sm-6">
  					<div class="about-widget footer-widget">
  						<div class="logo-footer">
  							<a class="text-logo" href="<?php

        Url::toRoute([
            '/'
        ])?>" title="logo">Project Lab</a>
  						</div>
  						<p><?php
        /*
         * $abouts = Page::find()->where(['type_id' => Page::TYPE_ABOUT_US])->limit(1)->one();
         * echo !empty($abouts->description)?$abouts->description:"";
         */
        ?></p>
  						<div class="row">
  							<div class="col-lg-2">
  								<div class="footer-icon">
  									<i class="fa fa-envelope"></i>
  								</div>
  							</div>
  							<div class="col-lg-10">
  								<div class="footer-address"><?=Yii::t('app', 'Email')?>:</div>
  								<div class="footer-address-dtl">daulen@pmcoaching.solutions</div>
  								
  								  							<ul>
  								<li><a href="<?php

        echo Url::toRoute([
            '/guidelines'
        ])?>" title="link"><i
  										class="las la-arrow-circle-right"></i><?=Yii::t('app', 'How to use PROJECTLAB website?')?></a></li></ul>
  							</div>
  						</div>
  					</div>
  				</div>
  				<div class="col-lg-3 col-sm-6 d-flex justify-content-center">
  					<div class="courier-type-widget footer-widget mrg-btm-30">
  						<h6 class="footer text-white"><?=Yii::t('app', 'Policies')?></h6>
  						<div class="footer-list">
  							<ul>
  								<li><a href="<?php

        echo Url::toRoute([
            '/terms'
        ])?>" title="link"><i
  										class="las la-arrow-circle-right"></i><?=Yii::t('app', 'Terms & Conditions')?></a></li>
  								<li><a href="<?php

        echo Url::toRoute([
            '/privacy'
        ]);
        ?>" title="link"><i
  										class="las la-arrow-circle-right"></i><?=Yii::t('app', 'Privacy')?></a></li>
  								<li><a href="<?php

        echo Url::toRoute([
            '/contactus'
        ]);
        ?>" title="link"><i
  										class="las la-arrow-circle-right"></i><?=Yii::t('app', 'Contact Us')?></a></li>
  							</ul>
  						</div>
  					</div>
  				</div>
  				<div class="col-lg-3 col-sm-6">
  					<div class="recent-news-widget footer-widget mrg-btm-30">
  						<h6 class="footer text-white"><?=Yii::t('app', 'Support')?></h6>
  						<div class="footer-list">
  							<ul>
  								<li><a href="<?php

        echo Url::toRoute([
            '/faq'
        ])?>" title="link"><i
  										class="las la-arrow-circle-right"></i><?=Yii::t('app', 'FAQ')?></a></li>
  								<li><a href="<?php

        echo Url::toRoute([
            '/'
        ])?>#pricing" title="link"><i
  										 class="las la-arrow-circle-right"></i><?=Yii::t('app', 'Pricing Plans')?></a></li>
  								<li><a href="<?php

        echo Url::toRoute([
            '/'
        ])?>#about" title="link"><i
  										id="#about" class="las la-arrow-circle-right"></i><?=Yii::t('app', 'About Us')?></a></li>

  							</ul>
  						</div>
  					</div>
  				</div>
  				<div class="col-lg-3 col-sm-6">
  					<div class="news-widget footer-widget mrg-btm-30">
  						<h6 class="footer text-white"><?=Yii::t('app', 'Newsletter')?></h6>
  						<p class="mb-0"><?=Yii::t('app', 'Sign up for News Letter')?></p>
  						<form id="subscribe-form" class="footer-form my-3">
  							<div class="form-group mb-0">
  								<input type="email" id="mc-email" class="form-control" placeholder=<?=Yii::t('app', "Email Address")?> required>
  							</div>
  							<button type="submit" class="btn btn-primary" title="subscribe"><?=Yii::t('app', 'Subscribe')?></button>
  							<label for="mc-email"></label>
  						</form>
  						<div class="footer-social">
  							<ul>
  								<li><?=Yii::t('app', 'Follow Us')?>:</li>
  								<li><a href="#" target="_blank"
  									title="facebook"><i class="lab la-facebook-f"></i></a></li>
  								<li><a href="#" target="_blank"
  									title="twitter"><i class="lab la-twitter"></i></a></li>
  								<li><a href="#" target="_blank"
  									title="linked-in"><i class="lab la-linkedin-in"></i></a></li>
  								<li><a href="#" target="_blank"
  									title="youtube"><i class="lab la-youtube"></i></a></li>

  							</ul>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
    </div>
		<div class="tiny-footer">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<div class="copyright-block">
							<p class="mb-0"><?=Yii::t('app', 'Copyright')?> © 2020 Project Lab | <?=Yii::t('app', 'All Rights Reserved')?> | <?=Yii::t('app', 'Developed By')?> ToXSL Technologies Pvt. Ltd
							</p>
						</div>
					</div>

				</div>
			</div>
		</div>
	</footer>
	<!-- footer end-->



	<script src="<?php

echo $this->theme->getUrl('frontend/js/owl.carousel.min.js')?>"></script>
	<script src="<?php

echo $this->theme->getUrl('frontend/js/menumaker.js')?>"></script>
	<script src="<?php

echo $this->theme->getUrl('frontend/js/theme.js')?>"></script>
	<script src="<?php

echo $this->theme->getUrl('frontend/js/scripts.js')?>"></script>
	<!-- end JS -->


      <!--[if !IE]>-->
      <!--<![endif]-->
      <?php

    $this->endBody()?>

   </body>
   <?php

$this->endPage()?>
</html>
