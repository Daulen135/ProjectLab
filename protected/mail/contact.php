<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$Link = $user->getLoginUrl();
?>
<?= $this->render ( 'header.php' );?>
<!--- body start-->
            <tr>
               <td style="padding: 30px 20px 20px 20px; colspan="2" align="left">
                  <p  style="margin: 10px 0; font-size: 16px; font-weight: bold; line-height: 1.6; color: #333;">
                     Hi <?php echo  Html::encode($user->first_name) ?>,                        
                  </p>
                   <p style="margin: 20px 0; font-size: 16px; line-height: 1.6; color: #333;">
                  	<?php echo $user->body?> 
                  </p>
                  <p style="margin: 20px 0; font-size: 16px; line-height: 1.6; color: #333;">
                 Thankyou for contact us.We will contact you soon as possible                        
                  </p>
                
                  
               </td>
            </tr>
 <!--body end-->
<?= $this->render ( 'footer.php' );?>
  
  