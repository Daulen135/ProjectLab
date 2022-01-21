<?php
use app\modules\subscription\models\Plan;
use app\modules\translator\widget\TranslatorWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $plans Plan */
?>
<div class="breadcroumb-area bread-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcroumb-title text-center">
                        <h1 class="text-white"><?=Yii::t('app', 'Pricing & Plans')?></h1>
                        <h6 class="text-white"><a  href="<?php

                        echo Url::toRoute([
                            '/'
                        ])?>"><?=Yii::t('app', 'Home')?></a> / <?=Yii::t('app', 'Pricing & Plans')?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div id="pricing" class="pricing-main-block">
	<div class="container">
		<div class="section text-center">
			<h1 class="section-heading"><?=Yii::t('app', 'Pricing & Plans')?></h1>
		</div>
		<div class="row">
			<?php

foreach ($model->each() as $planModel) {
    ?>
				<div class="col-lg-4 col-md-6">
					<div class="single-price-item">
						<div class="prices-hd">
							<h4><?=TranslatorWidget::widget(['type' => TranslatorWidget::TYPE_DISPLAY,'model' => $planModel,'attribute' => 'title']);?></h4>
						</div>
						<div class="content-prices">
							<div class="mb-20 price-days">
								<p class="mb-0"><b><?=! empty($planModel->price) ? Html::encode(yii::t('app', $planModel->price)) : "";?></b></p>
								<?php

    if ($planModel->title == 'Advanced') {
        ?>
								<small><?=Html::encode($planModel->getType());?></small>
								<?php
    }
    ?>
							</div>
							<?php
    if (! empty($planModel->big_text)) {

        ?>
							<p class="cppd-extra-details">
							<?=TranslatorWidget::widget(['type' => TranslatorWidget::TYPE_DISPLAY,'model' => $planModel,'attribute' => 'big_text']);?>
							</p><?php
    }

    echo TranslatorWidget::widget([
        'type' => TranslatorWidget::TYPE_DISPLAY,
        'model' => $planModel,
        'attribute' => 'description'
    ]);

    ?>
						</div>
						<?php

    if ($planModel->title == 'Basic' && ! empty(Yii::$app->request->queryParams)) {

        ?>
					    <a href="<?=Url::toRoute('site/pay-now') . '?id=' . $planModel->id?>"
						class="main-btn main-butnn"> <?=Yii::t('app', 'Pay Now')?></a>



					    <?php
    } elseif ($planModel->title == 'Basic') {
        ?>


					    <a href="<?=Url::toRoute(['/user/signup'])?>"
						class="main-btn main-butnn"><?=Yii::t('app', 'Sign Up')?></a>
					<?php
    } elseif ($planModel->title == 'Enterprise') {
        ?>
					    <a href="<?=Url::toRoute(['/site/contact'])?>"
						class="main-btn main-butnn"><?=Yii::t('app', 'Contact Us')?></a>

					    <?php
    } else {
        ?>
					    <a href="<?=Url::toRoute(['/user/login'])?>"
						class="main-btn main-butnn"><?=Yii::t('app', 'Buy Plan')?></a>

					    <?php
    }
    ?>
					</div>
			</div>
				<?php
}

?>
		</div>
	</div>
</div>
