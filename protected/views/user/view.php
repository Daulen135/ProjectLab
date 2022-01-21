<?php
// use app\components\useraction\UserAction;
use app\models\User;
use yii\helpers\Html;
use app\components\useraction\UserAction;

/* @var $this yii\web\View */
/* @var $model app\models\User */

/* $this->title = $model->label() .' : ' . $model->id; */
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Users'),
    'url' => [
        'index'
    ]
];
$title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = (string) $model;
?>
<div class="wrapper">
	<div class="card mb-4">
     <?php
    echo \app\components\PageHeader::widget([
        'title' => $title
    ]);
    ?>
</div>
	<div class="content-section clearfix">
		<div class="widget light-widget">
			<div class="user-view">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-2">
                    <?php

                    if (! empty($model->profile_file)) {
                        ?>
                        <?php
                        echo Html::img($model->getImageUrl(150), [
                            'class' => 'img-responsive'
                        ])?><br /> <br />
                            <p>
                             <?=Html::a('Download image ', $model->imageUrl, ['class' => 'btn btn-success'])?>
                         </p>
                     <?php

} else {
                        ?>
                     
                     <img id="profile_file"
									class="rounded-circle user-photo" src="<?=$this->theme->getUrl('frontend/img/default.jpg')?>"> 
                     
                     <?php

}
                    ?>
                 </div>
							<div class="col-md-10">     
                    <?php
                    echo \app\components\TDetailView::widget([
                        'model' => $model,

                        'options' => [
                            'class' => 'table table-bordered'
                        ],
                        'attributes' => [
                            'id',
                            'email:email',
                            [
                                'attribute' => 'role_id',
                                'format' => 'raw',
                                'value' => $model->getRole()
                            ],
                            'last_visit_time:datetime',
                            'last_action_time:datetime',
                            'last_password_change:datetime',
                            'created_on:datetime',
                            [
                                'attribute' => 'created_by_id',
                                'format' => 'raw',
                                'value' => $model->getRelatedDataLink('created_by_id')
                            ]
                        ]
                    ])?>
                        
                    </div>
						</div>
					</div>
				</div>
        
        
        <?php
        echo UserAction::widget([
            'model' => $model,
            'attribute' => 'state_id',
            'states' => $model->getStateOptions(),
            'visible' => User::isAdmin()
        ]);
        ?>
        
        <div class="card">
					<div class="card-body">
            <?php
            $this->context->startPanel();

            $this->context->addPanel('LoginHistories', 'loginHistories', 'LoginHistory', $model);
            $this->context->addPanel('Feeds', 'feeds', 'Feed', $model);
            $this->context->addPanel('Files', 'files', 'File', $model);
            $this->context->addPanel('Comments', 'comments', 'Comment', $model);
            $this->context->endPanel();
            ?>
        </div>
				</div>
    
    <?php

echo \app\modules\comment\widgets\CommentsWidget::widget([
        'model' => $model
    ]);
    ?>
    
</div>
		</div>
	</div>
</div>
