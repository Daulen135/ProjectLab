<?php
use app\components\useraction\UserAction;
use app\modules\translator\widget\TranslatorWidget;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Page */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Pages'),
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
						<a href="<?=Url::toRoute(['/page/index'])?>"
							class="btn btn-xs btn-link btn-toggle-fullwidth"><i
							class="fa fa-arrow-left"></i></a><?=Yii::t('app', 'Page')?>
					</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a
							href="<?=Url::toRoute(['/page/index'])?>"><i class="icon-home"></i></a></li>
						<li class="breadcrumb-item active"><?=Yii::t('app', ($model->title));?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
         <?php

        echo \app\components\TDetailView::widget([
            'id' => 'page-detail-view',
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered'
            ],
            'attributes' => [
                'id',

            /*'description:html',*/
                [
                    'attribute' => 'title',
                    'format' => 'raw',
                    'value' => TranslatorWidget::widget([
                        'type' => TranslatorWidget::TYPE_DISPLAY,
                        'model' => $model,
                        'attribute' => 'title'
                    ])
                ],
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

        echo TranslatorWidget::widget([
            'type' => TranslatorWidget::TYPE_DISPLAY,
            'model' => $model,
            'attribute' => 'description'
        ]);
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
	</div>
</div>