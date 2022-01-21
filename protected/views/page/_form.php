<?php
use yii\helpers\Html;
use app\components\TActiveForm;
use app\models\User;
use app\modules\translator\widget\TranslatorWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>
<header class="card-header">
   <?php

echo Yii::t('app', strtoupper(Yii::$app->controller->action->id));
?>
</header>
<div class="card-body">
   <?php

$form = TActiveForm::begin([

    'id' => 'page-form',
    'options' => [
        'class' => 'row'
    ]
]);
?>
   <div class="col-md-12">
</div>
<div class="col-md-9">
   <?=$form->field($model, 'title')->textInput(['maxlength' => 256])?>
<?php

echo TranslatorWidget::widget([
    'type' => TranslatorWidget::TYPE_FORM,
    'model' => $model,
    'attribute' => 'title',
    'form' => $form
])?>
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
   <?php

echo $form->field($model, 'description')->widget(app\components\TRichTextEditor::className(), [
    'options' => [
        'rows' => 6
    ],
    'preset' => 'basic'
]);
?>

</div>
<div class="col-md-3">
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
  <div  class="col-md-12 text-right">
      <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'page-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
   </div>
   <?php

TActiveForm::end();
?>
</div>