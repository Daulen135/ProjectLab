<?php
use app\components\useraction\UserAction;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\EmailQueue */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Email Queues'),
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
						<a href="<?=Url::toRoute(['/email-queue/index'])?>"
							class="btn btn-xs btn-link btn-toggle-fullwidth"><i
							class="fa fa-arrow-left"></i></a><?=Yii::t('app', 'Email-Queue')?>
					</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a
							href="<?=Url::toRoute(['/email-queue/index'])?>"><i
								class="icon-home"></i></a></li>
						<li class="breadcrumb-item active"><?=yii::t('app', $model->subject);?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
         <?php

        echo \app\components\TDetailView::widget([
            'id' => 'email-queue-detail-view',
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered'
            ],
            'attributes' => [
                'id',
                'from_email:email',
                'to_email:email',
                'date_sent:datetime',
                'date_published:datetime',
                'last_attempt:datetime',
                'attempts',
                [
                    'attribute' => 'model_id',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->model_id;
                    },
                    'label' => yii::t('app', 'Model Id')
                ],
                [
                    'attribute' => 'model_type',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->model_type;
                    },
                    'label' => yii::t('app', 'Model Type')
                ],
                [
                    'attribute' => 'message_id',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->message_id;
                    },
                    'label' => yii::t('app', 'Message Id')
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
		<div class="card">
			<div class="card-body">

				<iframe src="<?php

    echo $model->getUrl('show')?>" width="80%"
					height="500px"></iframe>
			</div>

		</div>

	</div>
</div>