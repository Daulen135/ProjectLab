<?php
use app\components\TActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Notice */
/* @var $form yii\widgets\ActiveForm */
?>
<header class="card-header">
                            <?php echo strtoupper(Yii::$app->controller->action->id); ?>
                        </header>
<div class="card-body">

    <?php
    $form = TActiveForm::begin([
             'id' => 'notice-form',
        'options' => [
            'class' => 'row'
        ]
    ]);
    ?>
<div class="col-lg-9">
	 		<?php echo $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
<?php echo  $form->field($model, 'content')->widget ( app\components\TRichTextEditor::className (), [ 'options' => [ 'rows' => 6 ],'preset' => 'basic' ] ); //$form->field($model, 'content')->textarea(['rows' => 6]); */ ?>
		 
	 	</div>
	<div class="col-lg-3">
		 <?php echo $form->field($model, 'state_id')->dropDownList($model->getStateOptions(), ['prompt' => '']) ?>
		 <?php echo $form->field($model, 'type_id')->dropDownList($model->getTypeOptions(), ['prompt' => '']) ?>
			
</div>
	<div class="form-group col-lg-12 text-right">
		
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id'=> 'notice-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	
    <?php TActiveForm::end(); ?>

</div>
