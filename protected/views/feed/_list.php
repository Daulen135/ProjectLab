<?php
use yii\helpers\Html;
?>
<?php $user = Yii::$app->user->identity; ?>
<li class="list-group-item">
	<ul class="list-unstyled d-flex">
		<li>
			<div class="comment-image">
				<?php echo Html::img($user->profile_file = \Yii::$app->urlManager->createAbsoluteUrl([
                'user/image',
				'id' => $user->id
            ]),
				    [
				        'class' => 'w-60 user-photo',
				        'alt' => $user,
				       // 'width' => '150',
				       // 'height' => '150'
				    ])?>
			</div>
		</li>
		<li class="ml-2">
			
		<?php 
		$object = $model->getModel();
		
		?>
			<div id="<?= $model->id;?>" class="mic-info activity"><?= $model->content;?> <?= $object? $object->linkify():'';?> </div>
			<div class="mic-info">By  <?= $model->createdBy? $model->createdBy :'' ?> 
			<?= Yii::$app->formatter->asRelativeTime($model->created_on, 'now');?></div>
	
		</li>
	</ul>
	
</li>