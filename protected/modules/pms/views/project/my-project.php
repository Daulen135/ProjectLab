<?php
use app\components\TDashBox;
use app\components\notice\Notices;
use app\models\EmailQueue;
use app\models\LoginHistory;
use app\modules\logger\models\Log;
use yii\helpers\Url;
use app\modules\pms\models\Project;
use app\components\grid\TGridView;
use app\models\User;

/**
 *
 * @copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 * @author : Shiv Charan Panjeta < shiv@toxsl.com >
 */
/* @var $this yii\web\View */
// $this->title = Yii::t ( 'app', 'Dashboard' );
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Dashboard')
];
?>
<div class="wrapper">
	<div class="block-header">
		<div class="row">
			<div class="col-lg-5 col-md-8 col-sm-12">
				<h2>
					<a href="javascript:void(0);"
						class="btn btn-xs btn-link btn-toggle-fullwidth"><i
						class="fa fa-arrow-left"></i></a><?= Yii::t('app', 'My Projects')?>
				</h2>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php Url::toRoute(['/']);?>"><i
							class="icon-home"></i></a></li>
					<li class="breadcrumb-item active"><?= Yii::t('app', 'Projects')?></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-lg-3 col-md-6">
			<div class="card top_counter">
				<a
					href="<?= Url::toRoute(['index','state_id' => Project::STATE_COMPLETED]);?>"
					class="completed_proj">
					<div class="body">
						<div class="icon text-info">
							<i class="fa fa-user"></i>
						</div>
						<div class="content">
							<div class="text"><?= Yii::t('app', 'Total Completed Projects')?></div>
							<h5 class="number"><?= Project::getCompletedProjects()->count();?></h5>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="card top_counter">
				<a
					href="<?= Url::toRoute(['index','state_id' => Project::STATE_PLAN])?>"
					class="completed_proj">
					<div class="body">
						<div class="icon text-warning">
							<i class="fa fa-tags"></i>
						</div>
						<div class="content">
							<div class="text"><?= Yii::t('app', 'Total Pending Projects')?></div>
							<h5 class="number"><?= Project::getPendingProjects()->count();?></h5>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12">
				<div class="header my-2">
					<h2><?= Yii::t('app', 'My Projects')?></h2>
				</div>
				<div class="body">
					<div class="table-responsive">
                                      <?php

                                    echo TGridView::widget([
                                        'id' => 'project-grid-view',
                                        'dataProvider' => $dataProvider,
                                        // 'filterModel' => $searchModel,
                                        'tableOptions' => [
                                            'class' => 'table table-bordered'
                                        ],
                                        'columns' => [
                                            // ['class' => 'yii\grid\SerialColumn','header'=>'<a>S.No.<a/>'],
                                            [
                                                'name' => 'check',
                                                'class' => 'yii\grid\CheckboxColumn',
                                                'visible' => User::isAdmin()
                                            ],

                                            'id',
                                            'title',
            /* 'description:html',*/
            [
                                                'attribute' => 'manager_id',
                                                'format' => 'raw',
                                                'value' => function ($data) {
                                                    return $data->getRelatedDataLink('manager_id');
                                                }
                                            ],
                                            'client_name',
                                            'start_date:date',
                                            'end_date:date',
            /* ['attribute' => 'type_id','filter'=>isset($searchModel)?$searchModel->getTypeOptions():null,
			'value' => function ($data) { return $data->getType();  },],*/
            [
                                                'attribute' => 'state_id',
                                                'format' => 'raw',
                                                'filter' => isset($searchModel) ? $searchModel->getStateOptions() : null,
                                                'value' => function ($data) {
                                                    return $data->getStateBadge();
                                                }
                                            ],
                                            'created_on:datetime',
            /* [
				'attribute' => 'created_by_id',
				'format'=>'raw',
				'value' => function ($data) { return $data->getRelatedDataLink('created_by_id');  },
				],*/

            [
                                                'class' => 'app\components\TActionColumn',
                                                'header' => '<a>Actions</a>'
                                            ]
                                        ]
                                    ]);
                                    ?>
                                   </div>
				</div>
			</div>
		</div>
	</div>

</div>
