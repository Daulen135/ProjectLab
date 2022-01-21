<?php
use app\components\TActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\components\grid\TGridView;
use app\modules\pms\models\search\Task;
use app\models\User;
use yii\bootstrap\Progress;
use yii\helpers\StringHelper;
use app\modules\pms\models\Rename;

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
<?php
$proname = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_NAME
])
    ->select('title')
    ->one();

$start = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_START_DATE
])
    ->select('title')
    ->one();

$managername = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_MANAGER
])
    ->select('title')
    ->one();
$com = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_COMPLETION_DATE
])
    ->select('title')
    ->one();
$overall = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_OVERALL
])
    ->select('title')
    ->one();

$startdate = Rename::find()->Where([
    'type_id' => Rename::TYPE_START_DATE
])
    ->select('title')
    ->one();

$enddate = Rename::find()->Where([
    'type_id' => Rename::TYPE_END_DATE
])
    ->select('title')
    ->one();

$title = Rename::find()->Where([
    'type_id' => Rename::TYPE_TASK_TITLE
])
    ->select('title')
    ->one();
$complete = Rename::find()->Where([
    'type_id' => Rename::TYPE_COMPLETE
])
    ->select('title')
    ->one();
$status = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_STATUS
])
    ->select('title')
    ->one();
$title = Rename::find()->Where([
    'type_id' => Rename::TYPE_TASK_TITLE
])
    ->select('title')
    ->one();

$notice = Rename::find()->Where([
    'type_id' => Rename::TYPE_NOTES
])
    ->select('title')
    ->one();

?>
<div class="w-100 d-flex justify-content-center banner-imgs">
<?php

echo Html::img(yii::$app->view->theme->getUrl('admin/img/schedule.jpg'), []);
?>
</div>
<?php

$form = TActiveForm::begin([

    'id' => 'basic-form'
]);
?>
<div class="row clearfix">
	<div class="col-md-12">
		<div class="card">
			<div class="body">
					<div class="form-row">
						<div class="form-group col-md">

							<label><?=empty($proname) ? Yii::t('app', 'Project Name') : $proname?></label>
                <?php

                echo $form->field($model, 'title')
                    ->textInput([
                    'maxlength' => 128,
                    'disabled' => true
                ])
                    ->label(false)?>
              </div>
						<div class="form-group col-md">
							<label><?=empty($managername) ? Yii::t('app', 'Manager Name') : $managername?> </label>
                <?php

                echo $form->field($model, 'manager_name')
                    ->textInput([
                    'maxlength' => 128,
                    'disabled' => true
                ])
                    ->label(false)?>

              </div>
					</div>
					<div class="form-row">
						<div class="form-group col-md">

							<div class="form-row">
								<div class="form-group col-lg-6">

									<label><?=empty($start) ? Yii::t('app', 'Project Start Date') : $start?></label>

              <?php

            echo $form->field($model, 'start_date')
                ->widget(yii\jui\DatePicker::class, [
                'options' => [
                    'class' => 'form-control',
                    'disabled' => true
                ],
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true
                ]
            ])
                ->label(false)?>
            </div>
								<div class="form-group col-lg-6">

									<label><?=empty($com) ? Yii::t('app', 'Project Completion Date') : $com?></label>

              <?php

            echo $form->field($model, 'end_date')
                ->widget(yii\jui\DatePicker::class, [
                'options' => [
                    'class' => 'form-control',
                    'disabled' => true
                ],
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true
                ]
            ])
                ->label(false)?>
            </div>
							</div>

							<label class="mt-20"><?=empty($overall) ? Yii::t('app', 'Project Overall Status') : $overall?> (<?php

    echo $model->getAverage() . '%';
    ?>)</label>

					
                	 <?php
                echo Progress::widget([
                    'percent' => $model->getAverage(),
                    'barOptions' => [
                        'class' => $model->getProgressContext()
                    ]
                ]);
                ?>
                
              </div>
					</div>

       
      </div>
		</div>
	</div>
</div>
 <?php

TActiveForm::end();
?>
<?php

Pjax::begin([
    'id' => 'task-pjax-grid-new',
    'enablePushState' => true,
    'enableReplaceState' => false
]);
?>
<?php

$searchModel = new Task();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
if (! User::isAdmin()) {
    $dataProvider->query->andWhere([
        'project_id' => $model->id,
        'created_by_id' => \Yii::$app->user->id
    ]);
} else {
    $dataProvider->query->andWhere([
        'project_id' => $model->id
    ]);
}
?>
 
 <?php
echo TGridView::widget([
    'summary' => false,
    'id' => 'task-grid-view-new',
    'dataProvider' => $dataProvider,
    'enableRowClick' => false,
    'tableOptions' => [
        'class' => 'table custom-table mt-3'
    ],
    'columns' => [
        [
            'attribute' => 'task title',
            'value' => 'title',

            'label' => empty($title) ? Yii::t('app', 'Task Title') : $title
        ],
        [
            'attribute' => 'start_date',
            'label' => empty($startdate) ? Yii::t('app', 'Start Date') : $startdate
        ],
        [
            'attribute' => 'end_date',
            'label' => empty($enddate) ? Yii::t('app', 'End Date') : $enddate
        ],

        [

            'value' => function ($data) {
                return $data->getDays();
            },

            'label' => empty($duration) ? Yii::t('app', 'Duration in Days') : $duration
        ],
        [

            'value' => 'progress_id',

            'label' => empty($complete) ? Yii::t('app', '% Complete') : $complete
        ],
        [
            'attribute' => 'state_id',
            'format' => 'raw',
            'value' => function ($data) {
                return $data->getStateBadge();
            }
        ],
        [
            'attribute' => 'notes',
            'format' => 'html',
            'value' => function ($data) {
                return Html::a(strip_tags(StringHelper::truncate($data->notes, 5, '...')), [
                    'task/view',
                    'id' => $data->id
                ]);
            },

            'label' => empty($notice) ? Yii::t('app', 'Notes') : $notice
        ],
        [
            'class' => 'app\components\TActionColumn',
            'header' => Yii::t('app', 'Actions'),
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {

                    return Html::a("<span class='glyphicon glyphicon-pencil' title='Update'></span> ", [
                        'task/update-task',
                        'id' => $model->id,
                        'data-pjax' => false
                    ], [
                        'class' => 'btn btn-info'
                    ]);
                }
            ]
        ]
    ]
]);
?>

            <?php

            Pjax::end();
            ?>

