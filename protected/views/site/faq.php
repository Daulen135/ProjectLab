<?php
use yii\helpers\Url;
?>


<div class="breadcroumb-area bread-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcroumb-title text-center">
					<h1 class="text-white">FAQ</h1>
					<h6 class="text-white">
						<a href="<?php echo Url::toRoute(['/'])?>"><?= Yii::t('app', 'Home')?></a> / <?= Yii::t('app', 'FAQ')?>
					</h6>
				</div>
			</div>
		</div>
	</div>
</div>
<section id="main" class="clearfix category-page main-categories">
	<div class="container">
				<div class="row">
					<div class="col-12">
					<?php
					use yii\helpers\Html;

					foreach ($model->each() as $planModel) {
						?>
					<p style="text-align:left"><strong><span style="color:#333333"><span style="background-color:#ffffff"><?= !empty($planModel->question)?Html::encode($planModel->question):"";?></span></span></strong></p>
					<p style="text-align:left"><span style="color:#333333"><span style="background-color:#ffffff"><?= !empty($planModel->answer)?Html::encode($planModel->answer):"";?></span></span></p>
						<?php }?>

						</div>
					</div>
				</div>

		
	</section>
