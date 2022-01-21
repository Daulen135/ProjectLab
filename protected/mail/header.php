<?php

use yii\helpers\Url;

?>
<!DOCTYPE html>
<html lang="en" >
   <head>
      <title>Welcome</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <style>
      	@font-face {
        
         font-family: 'Roboto-Regular';
          src: url(<?php echo Yii::$app->urlManager->createAbsoluteUrl('/');  ?>/themes/new/fonts/Roboto-Regular.ttf),
          url(<?php echo Yii::$app->urlManager->createAbsoluteUrl('/');  ?>/themes/new/fonts/roboto-regular-webfont.woff),
          url(<?php echo Yii::$app->urlManager->createAbsoluteUrl('/');  ?>/themes/new/fonts/roboto-regular-webfont.woff2);
                  }
          @font-face {
         font-family: 'Oswald-Regular';
          src: url(<?php echo Yii::$app->urlManager->createAbsoluteUrl('/');  ?>/themes/new/fonts/Oswald-Regular.ttf),
          url(<?php echo Yii::$app->urlManager->createAbsoluteUrl('/');  ?>/themes/new/fonts/oswald-regular-webfont.woff),
          url(<?php echo Yii::$app->urlManager->createAbsoluteUrl('/');  ?>/themes/new/fonts/oswald-regular-webfont.woff2);

                  }
         @media screen and (max-width: 600px) {
         html body table{
         table-layout:fixed;
         width:100%!important;
         }
         }
      </style>
   </head>
   <body style="margin: 0;font-family:'Roboto-Regular'">
   
      <table style="width: 600px; margin: auto; max-width: 100%"  cellspacing="0" cellpadding="0" border="0">
         <tbody>
            <!--header start-->
            <tr>
               <td class="logo" style="padding: 15px 20px 15px 20px;background: #fff;" align="left">
                  <img style="padding: ;width: 150px;" alt="<?php echo \yii::$app->name?>" src="<?php echo Yii::$app->urlManager->createAbsoluteUrl('/');  ?>/themes/new/frontend/images/logo.png">
               </td>
               <td class="logo" style="padding: 15px 20px 15px 20px;background: #fff;" align="right">
                  <a href="<?=Url::to(['/contactus']);?>"  style="border-radius: 3px; color: #f1962b;
                     display: inline-block;font-family: 'Oswald-Regular'; font-size:16px; font-weight: normal;
                     line-height: 36px; text-align: center; text-decoration: none; width: 120px; -webkit-text-size-adjust: none;
                     border: 1px solid #f1962b;
                     " target="_blank">Contact Us</a>
               </td>
            </tr>
            <tr>
               <td colspan="2" bgcolor="#6dbd63" align="center">
                  <table class="responsive-table" width="600" cellspacing="0" cellpadding="0" border="0">
                     <tbody>
                         <tr>
			            	<td style="padding: 0 20px 0 20px;" align="center">Project Lab
			            	</td>
           				 </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         
            <!--header end-->

