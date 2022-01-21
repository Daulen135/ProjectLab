<?php
use yii\helpers\Html;
use app\components\TActiveForm;
use app\models\User;
use app\modules\translator\widget\TranslatorWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>
<header class="card-header">
   <?php

echo yii::t('app', strtoupper(Yii::$app->controller->action->id));
?>
</header>
<div class="card-body">
   <?php

$form = TActiveForm::begin([

    'id' => 'service-form',
    'options' => [
        'class' => 'row'
    ]
]);
?>
<div class="col-md-9">
                  <?php

                echo $form->field($model, 'title')->textInput([
                    'maxlength' => 255
                ])?>
                  <?php

                echo TranslatorWidget::widget([
                    'type' => TranslatorWidget::TYPE_FORM,
                    'model' => $model,
                    'attribute' => 'title',
                    'form' => $form
                ])?>
                              <?php

                            echo $form->field($model, 'description')->widget(app\components\TRichTextEditor::className(), [
                                'options' => [
                                    'rows' => 6
                                ],
                                'preset' => 'basic'
                            ]); // $form->field($model, 'description')->textarea(['rows' => 6]); ?>
                            <?php

                            echo TranslatorWidget::widget([
                                'type' => TranslatorWidget::TYPE_FORM,
                                'model' => $model,
                                'attribute' => 'description',
                                'inputType' => [
                                    'inputField' => TranslatorWidget::TYPE_EDITOR
                                ],
                                'form' => $form
                            ])?>
                            
                            
                         
                             </div>
	<div class="col-md-3">
                              <?php

                            echo $form->field($model, 'image_file')->fileInput()?>
                        <?php

                        if (User::isAdmin()) {
                            ?>      <?php

                            echo $form->field($model, 'state_id')->dropDownList($model->getStateOptions(), [
                                'prompt' => ''
                            ])?>
      <?php
                        }
                        ?>                        <?php

                        // echo $form->field($model, 'type_id')->dropDownList($model->getTypeOptions(), [
                        // 'prompt' => ''
                        // ])
                        ?>
                 </div>
	<div class="col-md-12 text-right">
      <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'service-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
   </div>
   <?php

TActiveForm::end();
?>
</div>