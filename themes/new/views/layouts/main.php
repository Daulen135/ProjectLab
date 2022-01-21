<?php
use app\assets\AppAsset;
use app\components\FlashMessage;
use app\components\TActiveForm;
use app\modules\shadow\components\ShadowWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use app\components\gdpr\Gdpr;
use yii\helpers\StringHelper;
use app\models\User;
use app\modules\subscription\models\Billing;
use lajax\languagepicker\widgets\LanguagePicker;

/* @var $this \yii\web\View */
/* @var $content string */
// $this->title = yii::$app->name;
$user = Yii::$app->user->identity;
AppAsset::register($this);
?>
<?php

$this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
<meta charset="<?=Yii::$app->charset?>" />
      <?=Html::csrfMetaTags()?>
      <title><?=Html::encode($this->title)?></title>
      <?php
    $this->head()?>
      <meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<link rel="shortcut icon"
	href="<?=$this->theme->getUrl('/admin/img/logo.png')?>" type="image/png">
	<link href="<?php

echo $this->theme->getUrl('admin/css/main.css')?>"
	rel="stylesheet">
<link href="<?php

echo $this->theme->getUrl('admin/css/color_skins.css')?>"
	rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php

echo $this->theme->getUrl('frontend/css/line-awesome.min.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php

echo $this->theme->getUrl('frontend/css/font-awesome.min.css')?>" />
<link href="<?php

echo $this->theme->getUrl('admin/css/glyphicon.css')?>"
	rel="stylesheet">
</head>
<body
	class="sticky-header <?php

echo Yii::$app->session->get('is_collapsed')?>">
      <?php
    $this->beginBody()?>
      <section class="position-relative">
		<nav class="navbar navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-offcanvas">
						<i class="lnr lnr-menu fa fa-bars"></i>
					</button>
				</div>
				<div class="navbar-brand">
					<a href="<?php

    echo Url::toRoute([

        '/pms/project'
    ]);
    ?>"><h4>Project Lab</h4></a>
				</div>
				<div class="navbar-right">
					<div id="navbar-menu">
						<ul class="nav navbar-nav">
							<li><a href="#" class="icon-menu d-none d-sm-block"><i
									class="icon-envelope"></i><span class="notification-dot"></span></a>
							</li>
							<li class="dropdown"><a href="javascript:void(0);"
								class="dropdown-toggle icon-menu" data-toggle="dropdown"> <i
									class="icon-bell"></i> <span class="notification-dot"></span>
							</a>
							</li>
							<li class="dropdown"><a href="javascript:void(0);"
								class="dropdown-toggle icon-menu" data-toggle="dropdown"><i
									class="icon-equalizer"></i></a>
								</li>
							<li><a data-confirm="Do you sure you want to logout?" href="<?=Url::toRoute(['/user/logout']);?>" class="icon-menu"><i class="icon-login"></i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
		<div id="left-sidebar" class="sidebar">
			<div class="sidebar-scroll">
				<div class="user-account">
			
		 <?php

if (Yii::$app->user->identity->profile_file) {
    ?>
                              <img id="profile_file"
									class="rounded-circle user-photo"
									src="<?=Yii::$app->user->identity->getImageUrl()?>" alt="">
									<?php
} else {
    ?>
                                 <img id="profile_file"
									class="rounded-circle user-photo" src="<?=$this->theme->getUrl('frontend/img/default.jpg')?>"> 
                                  
                             	<?php
}

// echo Html::img($user->getImageUrl(50), [
// 'class' => 'rounded-circle user-photo'
// ])

?>
					<div class="dropdown">
						<span><?=Yii::t('app', 'Welcome')?>,</span> <a href="javascript:void(0);"
							class="dropdown-toggle user-name" data-toggle="dropdown"><strong><?=StringHelper::mb_ucfirst($user->getFullName())?></strong></a>
						<ul class="dropdown-menu dropdown-menu-right account">
							<li><a href="<?=Url::toRoute(['/user/view','id' => $user->id])?>"><i class="icon-user"></i><?=Yii::t('app', 'My Profile')?></a></li>
						    <li><a href="<?=Url::toRoute(['/user/update','id' => $user->id])?>"><i class="icon-user"></i><?=Yii::t('app', 'Update Profile')?></a></li>
							<li><a href="<?=Url::toRoute(['/user/changepassword','id' => $user->id])?>"><i class="icon-envelope-open"></i><?=Yii::t('app', 'Change Password')?></a></li>
							<?php

    if (User::isAdmin()) {
        ?>
							<li><a href="<?=Url::toRoute(['/setting/index'])?>"><i class="icon-settings"></i><?=Yii::t('app', 'Settings')?></a></li>

							<?php
    }
    ?>
						 <li class="divider"></li>
							<li><a data-confirm="Do you sure you want to logout?" href="<?=Url::toRoute(['/user/logout']);?>"><i class="icon-power"></i><?=Yii::t('app', 'Logout')?></a></li>
						</ul>
						<li class="dropdown language-dropdown main-tog pl-0 pl-md-2 d-flex pt-0"><a
							class="dropdown-toggle pl-0 pt-2" href="javascript:;"
							id="dropdownMenuButton" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false"> <?php

    if (Yii::$app->language == 'ru') {
        echo "Russian";
    } elseif (Yii::$app->language == 'en') {
        echo "English";
    } else {
        echo "Language";
    }
    ?> 
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

					</div>
					<hr>
				</div>
				
				<!-- Sidebar navigation-->
                	<?php
                if (method_exists($this->context, 'renderNav')) {
                    ?>
                     <nav id="left-sidebar-nav" class="sidebar-nav">
                   
            			<?php

                    echo Menu::widget([
                        'encodeLabels' => false,
                        'activateParents' => true,
                        'items' => $this->context->renderNav(),
                        'options' => [
                            'class' => 'metismenu',
                            'id' => 'sidebarnav main-menu'
                        ],
                        'submenuTemplate' => "\n<ul class='child-list'>\n{items}\n</ul>\n"
                    ]);
                    ?>                   
                    </nav>
	<?php
                }
                ?>
                <!-- End Sidebar navigation -->
			</div>
		</div>

		<!-- body content start-->
		<div class="main_wrapper " id="main-content">
		<div class="pt-5">
		<h3>  <?php
$exist = \Yii::$app->user->identity->plan;

if (empty($exist) || $exist->subscription->title == 'Basic') {
    if (! User::isAdmin()) {
        $now = time(); // or your date as well
        $singup_date = strtotime(\Yii::$app->user->identity->last_action_time);
        $datediff = $now - $singup_date;

        $days = round($datediff / (60 * 60 * 24));
        if ($days < Billing::TRIAL_PERIOD) {
            echo Yii::t('app', 'You are on trial period');
        }
    }
}

?>
		 
		 </h3>
		</div>
 			<?=FlashMessage::widget(['type' => 'toster'])?>  
 			       <?=$content?>
 			     
      </div>
		<!--body wrapper end-->
	</section>
	 <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?=Yii::t('app', 'Logout')?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?=Yii::t('app', 'Do You want to Logout ?')?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" >No</button>
        <a type="button" href="login.php"  class="btn btn-secondary">Yes</a>
      </div>
    </div>
  </div>
</div>
<script src="<?php

echo $this->theme->getUrl('frontend/js/scripts.js')?>"></script>
<script>
 $(document).on( 'click', '.showModalButton', function() {
//         	if ($('#modal').data('bs.modal').isShown) {
//         		$('#modal').find('#modalContent').load($(this).attr('data-target'));
//         	} else {
        		$('#modal').modal('show').find('#modalContent').load(
        		$(this).attr('data-target'));
        		if($("#modalHeader").length > 0){
        		document.getElementById('modalHeader').innerHTML = '<button type="button" class="close" data-dismiss="modal"><span>�</span></button>';
        		}
            	//}
        });

</script>
	
	<!--common scripts for all pages-->
      <?php
    $this->endBody()?>
   </body>
   <?php
$this->endPage()?>
</html>

