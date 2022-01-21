<?php
use app\components\TActiveForm;
use app\models\User;
use app\modules\translator\widget\TranslatorWidget;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\modules\subscription\models\Plan */
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

    'id' => 'plan-form',
    'options' => [
        'class' => 'row'
    ]
]);
?>
<div class="col-md-6">

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
                                'inputType' => [
                                    'inputField' => TranslatorWidget::TYPE_EDITOR
                                ],
                                'attribute' => 'description',
                                'form' => $form
                            ])?>
              </div>
	<div class="col-md-6">
                              <?php

                            echo $form->field($model, 'validity')->textInput()?>
                              <?php

                            echo $form->field($model, 'price')->textInput([
                                'maxlength' => 255
                            ])?>
                              <?php

                            echo $form->field($model, 'big_text')
                                ->textInput()
                                ->label(Yii::t('app', 'Big_text'))?>
                            
                             <?php

                            echo TranslatorWidget::widget([
                                'type' => TranslatorWidget::TYPE_FORM,
                                'model' => $model,
                                'attribute' => 'big_text',
                                'form' => $form
                            ])?>
                    <?php

                    if (User::isAdmin()) {
                        ?>      <?php

                        echo $form->field($model, 'state_id')->dropDownList($model->getStateOptions(), [
                            'prompt' => ''
                        ])?>
      <?php
                    }
                    ?>                        <?php

                    echo $form->field($model, 'type_id')->dropDownList($model->getTypeOptions(), [
                        'prompt' => ''
                    ])?>
           </div>
	<div class="col-md-12 text-right">
      <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'plan-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
   </div>
   <?php

TActiveForm::end();
?>
</div>