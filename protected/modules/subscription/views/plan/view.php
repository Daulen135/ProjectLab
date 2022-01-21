<?php
use app\components\useraction\UserAction;
use app\modules\comment\widgets\CommentsWidget;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\subscription\models\Plan */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Subscriptions'),
    'url' => [
        '/subscription'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Plans'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = (string) $model;
?>
<div class="wrapper">
	<div class="card">
		<div class="service-view">
         <?php

echo \app\components\PageHeader::widget([
            'model' => $model
        ]);
        ?>
      </div>
	</div>
	<div class="card">
		<div class="card-body">

			<div class="container-fluid">
				a
				<div class="block-header">
					<div class="row">
						<div class="col-lg-5 col-md-8 col-sm-12">
							<h2>
								<a href="<?=Url::toRoute(['/subscription/plan/index'])?>"
									class="btn btn-xs btn-link btn-toggle-fullwidth"><i
									class="fa fa-arrow-left"></i></a><?=Yii::t('app', 'Plan');?>
							</h2>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a
									href="<?=Url::toRoute(['/subscription/plan/index'])?>"><i
										class="icon-home"></i></a></li>
								<li class="breadcrumb-item active"><?=$model->title;?></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
         <?php

        echo \app\components\TDetailView::widget([
            'id' => 'plan-detail-view',
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered'
            ],
            'attributes' => [
                'id',
            /*'title',*/
            /*'description:html',*/
            'validity',
                'price',
                [
                    'attribute' => 'state_id',
                    'format' => 'raw',
                    'value' => $model->getStateBadge()
                ],
                [
                    'attribute' => 'type_id',
                    'value' => $model->getType()
                ],
                'created_on:datetime',
                [
                    'attribute' => 'created_by_id',
                    'format' => 'raw',
                    'value' => $model->getRelatedDataLink('created_by_id')
                ]
            ]
        ])?>
         <?php

echo $model->description;
        ?>
         <?php

        echo UserAction::widget([
            'model' => $model,
            'attribute' => 'state_id',
            'states' => $model->getStateOptions()
        ]);
        ?>
      </div>
				</div>
				<div class="card">
					<div class="card-body">
						<div class="plan-panel">
            <?php
            $this->context->startPanel();
            $this->context->addPanel(yii::t('app', 'Billings'), 'billings', 'Billing', $model /* ,null,true */);
            // $this->context->addPanel('Feeds', 'feeds', 'Feed',$model /*,null,true*/);
            $this->context->endPanel();
            ?>
         </div>
					</div>
				</div>
			</div>
		</div>