<?php
use app\components\TActiveForm;
use app\models\User;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\jui\DatePicker;
use app\modules\pms\models\Rename;
use yii\helpers\VarDumper;

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
// $createdby = Rename::find()->Where([
// 'type_id' => Rename::TYPE_CREATED_BY
// ])
// ->select('title')
// ->one();
$description = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_DESCRIPTION
])
    ->select('title')
    ->one();
$desg = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_DESIGNATION
])
    ->select('title')
    ->one();
$del = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_DELIVERABLES
])
    ->select('title')
    ->one();
$successi = Rename::find()->Where([
    'type_id' => Rename::TYPE_SUCCESS_CRITERIA
])
    ->select('title')
    ->one();
$mile = Rename::find()->Where([
    'type_id' => Rename::TYPE_MILESTONE
])
    ->select('title')
    ->one();
// $end = Rename::find()->Where([
// 'type_id' => Rename::TYPE_END_DATE
// ])
// ->select('title')
// ->one();
?>


<div class="row clearfix">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h2><?=Yii::t('app', 'Create Projects')?></h2>
			</div>
			<div class="body">
				<form id="basic-form" method="post" novalidate="">
					<div class="form-row">
						<div class="form-group col-md">
							<div class="d-flex align-items-start">

								<label> <?=empty($proname) ? Yii::t('app', 'Project Name') : $proname?> </label> <span data-toggle="tooltip"

									title="the unique unambiguous name of user project. Ex: Projectlab Business apps."
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
						<div class="form-group col-md">
							<div class="d-flex align-items-start">
								<label><?=empty($clientname) ? Yii::t('app', 'Client Name') : $clientname?></label> <span data-toggle="tooltip"

									title="the company or person for whom the project is being made and the main consumer of the project results. Ex: ABC Company, Ahmed Mansur."
									class="ques-mark ml-2"><i
									class="fa fa-info-circle vt-top text-primary"></i></span>
							</div>
                <?php

                echo $form->field($model, 'client_name')
                    ->textInput([
                    'maxlength' => 128
                ])
                    ->label(false)?>
              </div>
					</div>
					<div class="form-row">
						<div class="form-group col-md">
							<div class="d-flex align-items-start">
							<label><?=empty($managername) ? Yii::t('app', 'Manager Name') : $managername?></label> <span data-toggle="tooltip"

									title="responsible person for all project activities in any undertaking that has a defined scope, defined start and a defined completion. Project managers are first point of contact for any issues or discrepancies and has authorities as a project representative. Ex: John Smith."
									class="ques-mark ml-2"><i
									class="fa fa-info-circle vt-top text-primary"></i></span>
							</div>
                <?php

                echo $form->field($model, 'manager_name')
                    ->textInput([
                    'maxlength' => 128
                ])
                    ->label(false)?>
              </div>
						<div class="form-group col-md">
							<div class="d-flex align-items-start">
								<label><?=empty($desg) ? Yii::t('app', 'Project Designation') : $desg?></label> <span data-toggle="tooltip"

									title="the purpose of the project. Apps functionality allows using list of values: Education, Investment, Project execution."
									class="ques-mark ml-2"><i
									class="fa fa-info-circle vt-top text-primary"></i></span>
							</div>
                <?php

                echo $form->field($model, 'type_id')
                    ->dropDownList($model->getTypeOptions(), [
                    'prompt' => ''
                ])
                    ->label(false)?>
              </div>
					</div>
					<div class="form-row">
						<div class="form-group col-md">
							<div class="form-row px-2">
								<div class="d-flex align-items-start w-100">
									<label
										class="col-md-3 bg-transparent d-flex align-items-start "><span

										class="bg-bluish"><?=empty($del) ? Yii::t('app', 'Project Deliverables') : $del?> </span> <span

										data-toggle="tooltip"
										title="the description the quantifiable products that must be provided upon the completion of project task, stage or whole project. Deliverable can be tangible or intangible in nature. Ex: Document, Acquisition, Decision, Goods or Semi goods, Service, Completed action."
										class="ques-mark ml-2"><i
											class="fa fa-info-circle vt-top text-primary"></i></span></label>

								</div>
								<div class="form-group col-md-12">
                     <?php
                    $deliverable->title = $model->deliverables;
                    ?>
                  <?php

                echo $form->field($deliverable, 'title')
                    ->widget(MultipleInput::className(), [
                    // 'max' => 100,
                    'min' => 1,
                    'allowEmptyList' => false
                ])
                    ->label(false);
                ?>                                      
                </div>
							</div>
							<div class="form-row px-2">

								<div class="input col-md-6">
									<div class="d-flex align-items-start">

										<label><?=empty($mile) ? Yii::t('app', 'Milestone') : $mile?></label> <span data-toggle="tooltip"

											title="tools used to mark specific points along a project timeline. These points may signal anchors such as a project start and end date, or a need for external review or input and checks. In many instances, milestones do not affect project duration. Instead, they focus on major progress points that should be reached to achieve success. Ex: Project finance calculation completed, Project preparation is done, First Project sprint finished."
											class="ques-mark ml-2"><i
											class="fa fa-info-circle vt-top text-primary"></i></span>
									</div>
								</div>
                <?php
                $milestone->title = $model->milestones;
                ?>
                <?=$form->field($milestone, 'title')->widget(MultipleInput::className(), ['min' => 1,'columns' => [['name' => 'title','type' => 'textInput','title' => Yii::t('app', 'Title')],['name' => 'end_date','type' => DatePicker::className(),'title' => Yii::t('app', 'End Date')]]])->label(false);?>

               
              </div>
							
							<div class="form-row">
								<div class="form-group col-lg-6">
									<div class="d-flex align-items-start">
										<label><?=empty($startdate) ? Yii::t('app', 'Start Date') : $startdate?></label> <span data-toggle="tooltip"

											title="a specific day when the project starts. Ex: chose from calendar."
											class="ques-mark ml-2"><i
											class="fa fa-info-circle vt-top text-primary"></i></span>
									</div>
              <?php

            echo $form->field($model, 'start_date')
                ->widget(yii\jui\DatePicker::class, [
                // 'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ],
                'clientOptions' => [
                    // 'minDate' => date('Y-m-d', strtotime('-1 year')),
                    // 'maxDate' => date('Y-m-d', strtotime('+1 year')),
                    'changeMonth' => true,
                    'changeYear' => true
                ]
            ])
                ->label(false)?>
            </div>
								<div class="form-group col-lg-6">
									<div class="d-flex align-items-start">

										<label><?=empty($enddate) ? Yii::t('app', 'End Date') : $enddate?></label> <span

											data-toggle="tooltip"
											title="a specific day when the project ends. Ex: chose from calendar."
											class="ques-mark ml-2"><i
											class="fa fa-info-circle vt-top text-primary"></i></span>
									</div>
              <?php

            echo $form->field($model, 'end_date')
                ->widget(yii\jui\DatePicker::class, [
                // 'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ],
                'clientOptions' => [
                    // 'minDate' => date('Y-m-d', strtotime('-1 year')),
                    // 'maxDate' => date('Y-m-d', strtotime('+1 year')),
                    'changeMonth' => true,
                    'changeYear' => true
                ]
            ])
                ->label(false)?>
            </div>

								<div class="form-group">
  

             <?php

            if (User::isAdmin()) {
                ?>      <?php

                echo $form->field($model, 'state_id')
                    ->dropDownList($model->getStateOptions(), [
                    'prompt' => ''
                ])
                    ->label(Yii::t('app', 'State'))?>
      <?php
            }
            ?>    

            </div>
							</div>

						</div>

						<div class="form-group col-md">

							<div class="form-row px-2">
								<div class="d-flex align-items-start w-100">

									<label class="col-md-3"><?=empty($successi) ? Yii::t('app', 'Success Criteria') : $successi?></label> <span

										data-toggle="tooltip"
										title="the standards by which the project is going to be judged at the end to decide whether it has been successful in the eyes of the stakeholders. Ex: Apps deployed, Apps tested, Apps productivity instance works accordingly a Project scope."
										class="ques-mark ml-2"><i
										class="fa fa-info-circle vt-top text-primary"></i></span>
								</div>
								<div class="form-group col-md-12">
                  <?php
                $success->title = $model->successCriteria;
                ?>
                  <?php

                echo $form->field($success, 'title')
                    ->widget(MultipleInput::className(), [
                    // 'max' => 100,
                    'min' => 1, // should be at least 2 rows
                    'allowEmptyList' => false
                    // 'enableGuessTitle' => true,
                    // 'addButtonPosition' => MultipleInput::POS_HEADER, // show add button in the header
                ])
                    ->label(false);
                ?>                                      
                </div>
							</div>
													<div class="form-row">


								<div class="col-md">
									<div class="form-group ">
										<div class="d-flex align-items-start">

											<label><?=empty($description) ? Yii::t('app', 'Description') : $description?></label> <span

												data-toggle="tooltip"
												title="a brief explanation of the project's goals and boundaries. Sometimes it also includes a technical statement of how the project goals will be achieved."
												class="ques-mark ml-2"><i
												class="fa fa-info-circle vt-top text-primary"></i></span>
										</div>
              <?php

            echo $form->field($model, 'description')
                ->textarea([
                'rows' => 5
            ])
                ->label(false)?>
            </div>
								</div>
							</div>
							<div class="col-md">
								<div class="d-flex align-items-start">

									<label><?=empty($currency) ? Yii::t('app', 'Currency') : $currency?></label> <span data-toggle="tooltip"

										title="a currency of the project. Ex: USD($), Euro, RUB, Tenge etc."
										class="ques-mark ml-2"><i
										class="fa fa-info-circle vt-top text-primary"></i></span>
								</div>
              <?php

            echo $form->field($model, 'currency')
                ->textInput([
                'maxlength' => 255
            ])
                ->label(false)?>
              </div>
						</div>

					</div>

					<div class="d-flex justify-content-end">
          	<?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create Project') : Yii::t('app', 'Update'), ['id' => 'project-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
          </div>
				</form>
        <?php

        TActiveForm::end();
        ?>
      </div>
		</div>
	</div>
</div>


<!-- The Modal -->
<div class="modal" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header bg-transparent border-0 p-0">
				<button type="button" class="close mr-2 mt-1" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body text-center">
				<h2>Yet to implement...</h2>
			</div>



		</div>
	</div>
</div>
