<?php
   use app\assets\AppAsset;
   use app\components\gdpr\Gdpr;
   use app\models\User;
   use app\modules\blog\models\Post;
   use yii\helpers\Html;
   use yii\helpers\Url;
use app\components\FlashMessage;
   
   /* @var $this \yii\web\View */
   /* @var $content string */
   
   AppAsset::register($this);
   ?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
   <head>
      <meta name="viewport"
         content="width=device-width,initial-scale=1,maximum-scale=1">
      <meta charset="<?= Yii::$app->charset ?>" />
      <?= Html::csrfMetaTags()?>
      <title> <?= Html::encode($this->title) ?></title>
      <?php $this->head()?>
    <link href="<?php echo $this->theme->getUrl('admin/css/main.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->theme->getUrl('admin/css/color_skins.css')?>" rel="stylesheet"> 
	 <link rel="stylesheet" href="<?php echo $this->theme->getUrl('frontend/css/font-awesome.min.css')?>" />  
	 
   </head>
   <body class="home-page">
      <?php $this->beginBody()?>
      <?= Gdpr::widget();?>
      <!-- body content start-->
      <div class="main_wrapper">
         <?= FlashMessage::widget(['type' => 'toster'])?>
         <?= $content?>
      </div>
      <!--body wrapper end-->
    
 <!--<![endif]-->
      <?php $this->endBody()?>
    
   </body>
   <?php $this->endPage()?>
</html>