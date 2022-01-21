<?php
use app\components\TDashBox;
use app\components\notice\Notices;
use app\models\EmailQueue;
use app\models\LoginHistory;
use app\modules\logger\models\Log;
use yii\helpers\Url;
use app\models\User;
use app\models\search\User as UserSearch;
use miloschuman\highcharts\Highcharts;
use app\components\TActiveForm;
use yii\helpers\Html;
use app\modules\pms\models\Task;
use app\modules\pms\models\Project;

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

$form = TActiveForm::begin([

    'id' => 'basic-form'
]);
?>

<div class="card">
	<div class="header">
        <?php
        if (yii::$app->controller->action->id == 'add') {
            ?>
                     <h2><?php

            echo Project::getTitle()?></h2>
           
           <?php
        } else {
            ?>
                     <h2><?php

            echo $model->project;
            ?></h2>
           
           <?php
        }
        ?>

        </div>
	<div class="body">
		<form id="basic-form" method="post" novalidate="">
			<div class="form-row">
				<div class="col-md-6">
					<div class="d-flex align-items-start">
						<label><?=Yii::t('app', 'Task')?></label> <span data-toggle="tooltip"

							title="A project activity that needs to be accomplished within a defined period.  A task (project piece of work) can be broken down into assignments that should also have a defined start and end date or a deadline for completion. Ex: Designing Electrical hardware, Calculate materials, Testing IT prototype, Contract signoff."
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
                <?php

                echo $form->field($model, 'title')
                    ->textInput([
                    'maxlength' => 128
                ])
                    ->label(false)?>
              </div>
				<div class="col-md-6">
					<div class="d-flex align-items-start">

						<label><?=Yii::t('app', 'Budget')?></label> <span data-toggle="tooltip"

							title="There is a monetary assumption of the estimated cost to perform this activity/task. "
							class="ques-mark ml-2"><i
							class="fa fa-info-circle vt-top text-primary"></i></span>
					</div>
					
              <?php

            echo $form->field($model, 'amount')
                ->textInput([
                'maxlength' => 255
            ])
                ->label(false)?>
               </div>
			</div>
			<div class="form-row">
				<div class="col-md">
					<div class="form-group text-group">
						<div class="d-flex align-items-start">

							<label><?=Yii::t('app', 'Description')?></label> <span data-toggle="tooltip"

								title="There is a brief explanation of the task. It could also include the delivery that related to this task and as well, some comment regarding execution of this task. Ex: Contract signoff: The result needs to be valid signed agreement. Comment: Please translate to Chinese language. "
								class="ques-mark ml-2"><i
								class="fa fa-info-circle vt-top text-primary"></i></span>
						</div>
              <?php

            echo $form->field($model, 'description')
                ->textarea([
                'rows' => 6
            ])
                ->label(false)?>
            </div>
				</div>
			</div>
			<br>
			<div class="d-flex justify-content-end align-items-center">
        	  <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'project-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
      	</div>
		</form>
        <?php

        TActiveForm::end();
        ?>
      </div>
</div>

