<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
use app\components\TActiveForm;
use app\modules\blog\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card-body">

    <?php
    $form = TActiveForm::begin([
        'id' => 'blog-form',
        'options'=>[
            'class'=>'row'
        ]
    ]);

    ?>
    
    <div class="col-md-9">
    
    	<?= $form->field($model, 'title')->textInput(['maxlength' => 256])?>
    	
    	 <?= $form->field($model, 'content')->widget ( app\components\TRichTextEditor::className (), [ 'options' => [ 'rows' => 6 ],'preset' => 'full' ] ); ?>
	 		
   </div>

	<div class="col-md-3">
	
    <?= $form->field($model, 'image_file')->fileInput() ?>
 
	
	<?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(Category::find()->orderBy('id asc')->all(), 'id', 'title'), ['prompt' => ''])?>
	
	<?= $form->field($model, 'state_id')->dropDownList($model->getStateOptions(), ['prompt' => ''])?>
			
	</div>

	<div class="form-group col-md-12 text-right">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'blog-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>
	<?php TActiveForm::end(); ?>

</div>
