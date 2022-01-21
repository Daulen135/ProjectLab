<?php
use app\components\useraction\UserAction;
use app\modules\comment\widgets\CommentsWidget;
/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Rename */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Pms'),
    'url' => [
        '/pms'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Renames'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = (string) $model;
?>
<div class="wrapper">
   <div class="card">
      <div class="rename-view">
         <?php

        echo \app\components\PageHeader::widget([
            'model' => $model
        ]);
        ?>
      </div>
   </div>
   <div class="card">
      <div class="card-body">
         <?php

        echo \app\components\TDetailView::widget([
            'id' => 'rename-detail-view',
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered'
            ],
            'attributes' => [
                'id',
            /*'title',*/
            [
                    'attribute' => 'type_id',
                    'value' => $model->getType()
                ],
            /*[
			'attribute' => 'state_id',
			'format'=>'raw',
			'value' => $model->getStateBadge(),],*/
            'created_by_id',
                'created_on:datetime'
            ]
        ])?>
         <?php

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