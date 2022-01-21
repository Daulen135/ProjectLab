<?php
use app\components\useraction\UserAction;
use app\modules\comment\widgets\CommentsWidget;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Feed */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Feeds'),
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
						<a href="<?=Url::toRoute(['/feed/index'])?>"
							class="btn btn-xs btn-link btn-toggle-fullwidth"><i
							class="fa fa-arrow-left"></i></a><?=Yii::t('app', 'Feeds')?>
					</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a
							href="<?=Url::toRoute(['/feed/index'])?>"><i class="icon-home"></i></a></li>
						<li class="breadcrumb-item active"><?=Yii::t('app', 'Feed Details')?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
         <?php

        echo \app\components\TDetailView::widget([
            'id' => 'feed-detail-view',
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered'
            ],
            'attributes' => [
                'id',
            /*'content:html',*/
            /*[
			'attribute' => 'state_id',
			'format'=>'raw',
			'value' => $model->getStateBadge(),],*/
            'model_type',
                'user_ip',
                'user_agent',
                'model_id',
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

        echo $model->content;
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