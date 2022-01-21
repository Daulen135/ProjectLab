<?php
use yii\helpers\Url;
use yii\helpers\VarDumper;

/**
 *
 * @copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 * @author : Shiv Charan Panjeta < shiv@toxsl.com >
 *        
 *         All Rights Reserved.
 *         Proprietary and confidential : All information contained herein is, and remains
 *         the property of ToXSL Technologies Pvt. Ltd. and its partners.
 *         Unauthorized copying of this file, via any medium is strictly prohibited.
 *        
 */
/* @var $this yii\web\View */
// $Link = $user->getLoginUrl();
?>
<style>
.theme-btn {
	border: 2px solid #fff;
	padding: 10px 30px;
	display: inline-block;
}
</style>
<?=$this->render('@app/mail/header.php');?>

<!--body start-->

<tr>
	<td style="background-color: #f5f5f5;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td align="center" class="rounded-icon"
						style="background-color: #0083eb; padding: 60px 0">
						<h1 style="color: #fff; margin-bottom: 0;">Thank You For
							Contacting Us</h1>
						<p
							style="color: #fff; font-weight: 500; margin-bottom: 30px; line-height: 1.5;">
							Team will get back you within 24 hours</p> <a
						href="<?= Url::home()?>" class="theme-btn"
						style="color: #fff; font-weight: 500; text-decoration: none;">Done</a>
					</td>

				</tr>
			</tbody>
		</table>
	</td>
</tr>
<!--body end-->

<?=$this->render('@app/mail/footer.php');?>


        