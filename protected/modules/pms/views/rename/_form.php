<?php
use yii\helpers\Html;
use app\components\TActiveForm;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Rename */
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

    'id' => 'rename-form'
]);

?>                              <?php

echo $form->field($model, 'type_id')->dropDownList($model->getTypeOptions(), [
    'prompt' => ''
])?>

                  <?php

                echo $form->field($model, 'title')->textInput([
                    'maxlength' => 255
                ])?>
                        <?php

                        if (User::isAdmin()) {
                            ?>      <?php
                            /* echo $form->field($model, 'state_id')->dropDownList($model->getStateOptions(), ['prompt' => '']) */
                            ?>
      <?php
                        }
                        ?>            <div class="col-md-12 text-right">
      <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'rename-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
   </div>
   <?php

TActiveForm::end();
?>
</div>