<?php
use yii\helpers\Html;
use app\components\TActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\BlogCategory */
/* @var $form yii\widgets\ActiveForm */
?>
<header class="card-header">
                            <?php echo strtoupper(Yii::$app->controller->action->id); ?>
                        </header>
<div class="card-body">
    <?php
    
    $form = TActiveForm::begin([
        'id' => 'blog-category-form',
        'options'=>[
            'class'=>'row'
        ]
    ]);
    ?>	
    <div class="col-md-6 offset-md-3">
    	 <?php echo $form->field($model, 'title')->textInput(['maxlength' => 256]) ?>
	 	 <?php echo $form->field($model, 'state_id')->dropDownList($model->getStateOptions(), ['prompt' => '']) ?>
	 	 <div class="form-group text-center">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id'=> 'blog-category-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	</div>
    <?php TActiveForm::end(); ?>
</div>
