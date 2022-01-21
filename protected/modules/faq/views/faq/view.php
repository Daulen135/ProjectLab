<?php
use app\components\useraction\UserAction;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\faq\models\Faq */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'FAQs'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'FAQs'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = (string) $model;
?>
<div class="wrapper">
	<div class="container-fluid">
		<div class="block-header">
			<div class="row">
				<div class="col-lg-5 col-md-8 col-sm-12">
					<h2>
						<a href="<?= Url::toRoute(['/faq/faq/index'])?>"
							class="btn btn-xs btn-link btn-toggle-fullwidth"><i
							class="fa fa-arrow-left"></i></a><?= Yii::t('app', 'Faq') ?>
					</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a
							href="<?= Url::toRoute(['/faq/faq/index'])?>"><i
								class="icon-home"></i></a></li>
						<li class="breadcrumb-item active"><?= $model->question; ?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
         <?php

        echo \app\components\TDetailView::widget([
            'id' => 'faq-detail-view',
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered'
            ],
            'attributes' => [
                'id',
                'question',
                'answer',
                [
                    'attribute' => 'state_id',
                    'format' => 'raw',
                    'value' => $model->getStateBadge()
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

        echo UserAction::widget([
            'model' => $model,
            'attribute' => 'state_id',
            'states' => $model->getStateOptions()
        ]);
        ?>
      </div>
		</div>
	</div>
</div>