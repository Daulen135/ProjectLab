<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */

// $Link = $user->getLoginUrl();
?>
<?=$this->render('@app/mail/header.php');?>

<tr>
	<td style="padding: 30px 40px 40px 40px">
		<table style="border: 2px solid #022a5e" width="100%">
			<tr>
				<td style="text-align: center; padding-top: 20px;">
					<p
						style="color: #022a5e; font-size: 24px; margin: 0px; font-family: 'Oswald-Regular';">A
						New Contact Request!</p>
				</td>
			</tr>
			<tr>
				<td style="padding: 20px;">
					<h2 style="margin: 0; font-weight: normal; font-size: 15px;">Dear
						Admin,</h2>
					<p>You have a new request. The user's details are mentioned below.
					</p>
					<table style="border-collapse: collapse;" cellpadding="6"
						width="100%">
						<tr>
							<td style="border-bottom: 1px solid #bdc8d7; color: #022a5e"
								width="50%">Username</td>
							<td style="border-bottom: 1px solid #bdc8d7;" width="50%"><?=Html::encode(isset($user->full_name)?$user->full_name:'');?></td>
						</tr>
						<tr>
							<td style="border-bottom: 1px solid #bdc8d7; color: #022a5e"
								width="50%">Email</td>
							<td style="border-bottom: 1px solid #bdc8d7" width="50%"><?=Html::encode($user->email);?></td>
						</tr>
						<tr>
							<td style="border-bottom: 1px solid #bdc8d7; color: #022a5e"
								width="50%">Contact No.</td>
							<td style="border-bottom: 1px solid #bdc8d7" width="50%"><?=Html::encode(isset($user->mobile)?$user->mobile:'');?></td>
						</tr>
						<tr>
							<td style="border-bottom: 1px solid #bdc8d7; color: #022a5e"
								width="50%">Country Code</td>
							<td style="border-bottom: 1px solid #bdc8d7" width="50%"><?=Html::encode(isset($user->country)?$user->country:'');?></td>
						</tr>
						<tr>
							<td style="border-bottom: 1px solid #bdc8d7; color: #022a5e"
								width="50%">Referrer</td>
							<td style="border-bottom: 1px solid #bdc8d7" width="50%"><?=Html::encode($user->referrer_url);?></td>
						</tr>
						<tr>
							<td style="border-bottom: 1px solid #bdc8d7; color: #022a5e"
								width="50%">IP Address</td>
							<td style="border-bottom: 1px solid #bdc8d7" width="50%"><?=Html::encode(isset($user->ip_address)?$user->ip_address:'');?></td>
						</tr>
						<tr>
							<td style="color: #022a5e" colspan="2">Message</td>

						</tr>
						<tr>
							<td colspan="2"><p style="margin: 0;"> <?=HtmlPurifier::process(isset($user->description)?$user->description:'');?> </p></td>
						</tr>
						<tr>
							<td colspan="2">
								<p style="margin: 0">Please confirm the enquiry :<?= $user->linkify(null,true) ?></p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>


<?=$this->render('@app/mail/footer.php');?>






