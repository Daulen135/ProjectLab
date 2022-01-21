<?php
use app\models\User;
use yii\helpers\Html;
use app\modules\pms\models\Rename;
use yii\helpers\VarDumper;
?>

<?php

$row_date = strtotime('2021-09-25');
$today = strtotime(date('Y-m-d'));
if ($row_date >= $today) {

    ?>


<div class="w-100 d-flex justify-content-center banner-imgs">
<?php

    echo Html::img(yii::$app->view->theme->getUrl('admin/img/passport.jpg'), []);
    ?>
</div>
<div class="tab-pane" id="Profile">
	<div class="table-profile">
							<?php

    if (! User::isGuest())
        echo \app\components\TToolButtons::widget();
    ?>
						<?php
    $proname = Rename::find()->Where([
        'type_id' => Rename::TYPE_PROJECT_NAME
    ])
        ->select('title')
        ->one();

    $clientname = Rename::find()->Where([
        'type_id' => Rename::TYPE_CLIENT
    ])
        ->select('title')
        ->one();

    $managername = Rename::find()->Where([
        'type_id' => Rename::TYPE_PROJECT_MANAGER
    ])
        ->select('title')
        ->one();

    $desig = Rename::find()->Where([
        'type_id' => Rename::TYPE_PROJECT_DESIGNATION
    ])
        ->select('title')
        ->one();

    $startdate = Rename::find()->Where([
        'type_id' => Rename::TYPE_PLANNED_START_DATE
    ])
        ->select('title')
        ->one();
    $enddate = Rename::find()->Where([
        'type_id' => Rename::TYPE_PLANNED_END_DATE
    ])
        ->select('title')
        ->one();
    $currency = Rename::find()->Where([
        'type_id' => Rename::TYPE_CURRENCY
    ])
        ->select('title')
        ->one();
    $createdby = Rename::find()->Where([
        'type_id' => Rename::TYPE_CREATED_BY
    ])
        ->select('title')
        ->one();
    $description = Rename::find()->Where([
        'type_id' => Rename::TYPE_PROJECT_DESCRIPTION
    ])
        ->select('title')
        ->one();

    $del = Rename::find()->Where([
        'type_id' => Rename::TYPE_PROJECT_DELIVERABLES
    ])
        ->select('title')
        ->one();
    $success = Rename::find()->Where([
        'type_id' => Rename::TYPE_SUCCESS_CRITERIA
    ])
        ->select('title')
        ->one();
    $mile = Rename::find()->Where([
        'type_id' => Rename::TYPE_MILESTONE
    ])
        ->select('title')
        ->one();
    $end = Rename::find()->Where([
        'type_id' => Rename::TYPE_END_DATE
    ])
        ->select('title')
        ->one();

    echo \app\components\TDetailView::widget([
        'id' => 'project-detail-view',
        'model' => $model,
        'options' => [
            'class' => 'table table-bordered'
        ],
        'attributes' => [
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => $model->title,

                'label' => empty($proname) ? Yii::t('app', 'Project Name') : $proname
            ],
            // [
            // 'attribute' => 'description',
            // 'format' => 'raw',
            // 'value' => $model->description,
            // 'label' => empty($description) ? 'Description' : $description
            // ],
            [
                'attribute' => 'client_name',
                'format' => 'raw',
                'value' => $model->client_name,

                'label' => empty($clientname) ? Yii::t('app', 'Client') : $clientname
            ],
            [
                'attribute' => 'manager_name',
                'format' => 'raw',
                'value' => $model->manager_name,

                'label' => empty($managername) ? Yii::t('app', 'Manager Name') : $managername
            ],

            [
                'attribute' => 'type_id',
                'value' => $model->getType()
            ],

            [
                'attribute' => 'start_date',

                'value' => $model->start_date,

                'label' => empty($startdate) ? Yii::t('app', 'Start Date') : $startdate
            ],

            [
                'attribute' => 'end_date',

                'value' => $model->end_date,

                'label' => empty($enddate) ? Yii::t('app', 'End Date') : $enddate
            ],
            [
                'attribute' => 'currency',
                'format' => 'raw',
                'value' => $model->currency,

                'label' => empty($currency) ? Yii::t('app', 'Currency') : $currency
            ],

            [
                'attribute' => 'created_by_id',
                'format' => 'raw',
                'value' => $model->getRelatedDataLink('created_by_id'),
                'label' => empty($createdby) ? Yii::t('app', 'Created By') : $createdby
            ]
        ]
    ])?>
    

					<table class="table table-striped table-bordered detail-view">
			<tbody>
				<tr>
					<th class="w-25"><p><?php

    if (! empty($description)) {
        echo $description;
    } else {
        $type = Rename::TYPE_PROJECT_DESCRIPTION;
        $list = Rename::getTypeOptions();
        echo isset($list[$type]) ? $list[$type] : 'Not Defined';
    }
    ?></th>
					<td colspan="1"><?php

    echo $model->description;
    ?></td>
				</tr>
			</tbody>
		</table>
		<div class="row">
			<div class="col-lg-6">


				<table class="table table-striped table-bordered detail-view">
					<tbody>
						<tr>
							<th class="w-25"><p><?php

    if (! empty($del)) {
        echo $del;
    } else {
        $type = Rename::TYPE_PROJECT_DELIVERABLES;
        $list = Rename::getTypeOptions();
        echo isset($list[$type]) ? $list[$type] : 'Not Defined';
    }
    ?></p></th>
								<?php
    $data = $model->deliverables;
    foreach ($data as $value) {
        ?>						
            <tr>
							<td colspan="1"><?=$value->title;?></td>
						</tr>
            									<?php
    }

    ?>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="col-lg-6">
				<table class="table table-striped table-bordered detail-view">
					<tbody>
						<tr>
							<th class="w-25"><p><?php

    if (! empty($success)) {
        echo $success;
    } else {
        $type = Rename::TYPE_SUCCESS_CRITERIA;
        $list = Rename::getTypeOptions();
        echo isset($list[$type]) ? $list[$type] : 'Not Defined';
    }
    ?></p></th>
								<?php

    $data = $model->successCriteria;
    foreach ($data as $value) {
        ?>
									
					        
						
		<tr>
							<td colspan="1"><?=$value->title;?></td>
						</tr>
								<?php
    }

    ?>
				</tr>
					</tbody>
				</table>
			</div>
		</div>
		<table class="table table-striped table-bordered detail-view">
			<tbody>
				<tr>
					<th class="w-25"><p><?php

    if (! empty($mile)) {
        echo $mile;
    } else {
        $type = Rename::TYPE_MILESTONE;
        $list = Rename::getTypeOptions();
        echo isset($list[$type]) ? $list[$type] : 'Not Defined';
    }
    ?></p></th>
					<th class="w-25"><p><?php

    if (! empty($end)) {
        echo $end;
    } else {
        $type = Rename::TYPE_END_DATE;
        $list = Rename::getTypeOptions();
        echo isset($list[$type]) ? $list[$type] : 'Not Defined';
    }
    ?></p></th>
								       <?php

    $data = $model->milestones;
    foreach ($data as $value) {
        ?>
									
								
								
		<tr>
					<td colspan="1"><?=$value->title;?></td>
					<td colspan="1"><?=$value->end_date;?></td>
				</tr>
									<?php
    }

    ?>
				</tr>
			</tbody>
		</table>





	</div>
</div>

<?php
}
?>