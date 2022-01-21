<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$Link = $user->getLoginUrl();
?>
<?= $this->render ( 'header.php' );?>
 <!--- body start-->
            <tr>
               <td style="padding: 30px 20px 20px 20px;background: #fff;" colspan="2" align="left">
                  <p style="margin: 10px 0; font-size: 18px; line-height: 1.6; color: #333;">
                     Dear <?php echo  Html::encode($user->full_name) ?>,                        
                  </p>
                  <p style="margin:10px 20px 0px 0px; font-size: 16px; line-height: 1.6;">
                  	Thank you for registering with <?php echo Yii::$app->name ?>
                  </p>
                  <p style="margin: 20px 0 30px;">
                     <a href="<?= Html::encode($Link)?>" style="background-color: #f1962b; border-radius: 3px; color: #fff; display: inline-block;font-size:16px;  line-height: 30px; text-align: center; text-decoration: none; width: 80px; -webkit-text-size-adjust: none;
                        border: 1px solid #f1962b; "target="_blank">Log In</a>
                  </p>
               </td>
            </tr>
            <!--body end-->

<?= $this->render ( 'footer.php' );?>


