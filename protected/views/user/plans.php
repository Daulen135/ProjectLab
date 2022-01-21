<?php
use app\models\User;
use app\modules\subscription\models\Plan;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\subscription\models\Billing;
use app\modules\payment\models\Gateway;
use app\modules\payment\models\GatewaySetting;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use app\modules\translator\widget\TranslatorWidget;

/* @var $plans Plan */
?>

<div id="pricing" class="pricing-main-block">
	<div class="container">
		<div class="section text-center">
			<h1 class="section-heading"><?=Yii::t('app', 'Pricing & Plans')?></h1>
		</div>
		<?php
$key = Gateway::find()->where([
    'type_id' => GatewaySetting::GATEWAY_TYPE_STRIPE
])->one();

if (! empty($key)) {
    $value = Json::decode($key->value);
    $key = $value['publishable_key'];
} else {
    $key = '';
}
?>
		<div class="row">
		
			<?php

foreach ($plans->each() as $planModel) {

    ?>
				<div class="col-lg-4 col-md-6">
					<div class="single-price-item" style="height: 547px;">
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

    ?>				</div>
						<?php

    $myPlan = Billing::find()->where([
        'subscription_id' => $planModel->id,
        'state_id' => Billing::STATE_ACTIVE,
        'created_by_id' => Yii::$app->user->id
    ])
        ->andWhere([
        '!=',
        'type_id',
        Billing::STATE_ACTIVE
    ])
        ->one();

    ?>
						    <?php

    if (! empty($myPlan)) {
        ?>
					    <a href ="#" class="main-btn main-butnn"> <?=Yii::t('app', 'Current Plan')?></a>
		
<?php
    } else {
        ?>


						<?php

        if ($planModel->title == 'Advanced') {

            ?>
 <a  data-id="<?=$planModel->id?>" data-toggle="modal" data-target="#payment_method_<?=$planModel->id?>" class="main-btn main-butnn"> <?=Yii::t('app', 'Pay Now')?></a>
<?php
        } else if ($planModel->title == 'Enterprise') {
            ?>
					    <a href="<?=Url::toRoute(['/site/contact'])?>" class="main-btn main-butnn"><?=Yii::t('app', 'Contact Us')?></a>

					    <?php
        }
    }
    ?>

					
					</div>
				</div>
				<div class="modal" id="payment_method_<?=$planModel->id?>" tabindex="-1" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle"><?=Yii::t('app', 'Select Payment Method')?></h5>

				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

						<?php

    if ($planModel->title == 'Advanced') {

        ?>

               	<form class="d-inline-block"
								action="<?=Url::toRoute(['/payment/stripe/paynow','id' => ! empty($myPlan) ? $myPlan->id : null])?>"
								method="POST">
								<input type="hidden" name="<?=Yii::$app->request->csrfParam;?>"
									value="<?=Yii::$app->request->csrfToken;?>" /> <input
									type="hidden" name="Payment[amount]"
									value="<?=$planModel->price?>" /> <input type="hidden"
									name="Payment[model_id]" value="<?=$planModel->id?>" /> <input
									type="hidden" name="Payment[model_type]"
									value="<?=Billing::className()?>" /> <input type="hidden"
									name="Payment[email]"
									value="<?=Yii::$app->user->identity->email?>" /> <input
									type="hidden" name="Payment[name]"
									value="<?=Yii::$app->user->identity->full_name?>" /> <input
									type="hidden" name="Payment[description]"
									value="<?=$planModel->title?>" />
								<script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="<?=$key?>"

									data-amount="<?=! empty($planModel->price) ? Html::encode($planModel->price * 100) : "";?>"

                                    data-name="John"
									data-description="Payment"
									data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
									data-locale="auto">
                                  </script>
							</form>

							<?php
    }
    ?>

							 <a href ="<?=Url::toRoute('site/pay-now') . '?id=' . $planModel->id?>" class="paypal btn btn-secondary paypal-pay"> PayPal Pay</a>
			</div>
			<div class="modal-footer">
				<button type="button" id="close-menu" class="btn btn-secondary"
					data-dismiss="modal"><?=Yii::t('app', 'Close')?></button>
		
			</div>
		</div>
	</div>
</div>
				<?php
}

?>
		</div>
	</div>
</div>
