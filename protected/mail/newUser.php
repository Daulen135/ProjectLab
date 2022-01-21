<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user common\models\User */

$Link = $user->getLoginUrl();
?>
<?= $this->render ( 'header.php' );?>

<!--- body start-->
            <tr>
               <td style="padding: 30px 20px 20px 20px;background: #fff;" colspan="2" align="left">
                  <p  style="margin: 10px 0; font-size: 16px; font-weight: bold; line-height: 1.6; color: #333;">
                     Hi <?php echo  Html::encode($user->full_name) ?>,                        
                  </p>
                  <p style="margin: 20px 0; font-size: 16px; line-height: 1.6; color: #333;">
                   Your account has been successfully created. You can login to your account using the link given below :                       
                  </p>
                
                  <p style="margin: 20px 0 30px;">
                     <a href="<?= Html::encode($Link)?>" style="background-color: #f1962b; border-radius: 3px; color: #fff;
                        display: inline-block;font-size:16px; font-weight: normal;
                        line-height: 45px; text-align: center; text-decoration: none; width: 100px; -webkit-text-size-adjust: none;
                        border: 1px solid #f1962b;
                        " target="_blank">LOG IN</a>
                  </p>
               </td>
            </tr>
            <!--body end-->

  <?= $this->render ( 'footer.php' );?>
  
  