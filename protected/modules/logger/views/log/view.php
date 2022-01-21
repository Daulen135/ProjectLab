<?php
use app\components\useraction\UserAction;
use app\modules\comment\widgets\CommentsWidget;
/* @var $this yii\web\View */
/* @var $model app\modules\logger\models\Log */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Loggers'),
    'url' => [
        '/logger'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Logs'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = (string) $model;
?>
<div class="wrapper">
	<div class="card">
		<div class="log-view">
         <?php echo  \app\components\PageHeader::widget(['model'=>$model]); ?>
      </div>
	</div>
	<div class="card">
		<div class="card-body">
         <?php

        echo \app\components\TDetailView::widget([
            'id' => 'log-detail-view',
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered'
            ],
            'attributes' => [
                'id',
                'error',
            /*'description:html',*/
            /*[
			'attribute' => 'state_id',
			'format'=>'raw',
			'value' => $model->getStateBadge(),],*/
            'link',
                [
                    'attribute' => 'type_id',
                    'value' => $model->getType()
                ],
                'referer_link',
                'user_ip',
                [
                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'value' => function ($data) {
                    return $data->getRelatedDataLink('user_id');
                    }
                    ],
                'created_on:datetime'
            ]
        ])?>
         <?php  echo nl2br($model->description);?>
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