<?php
use yii\helpers\Html;

?>

<li>
	<div class="items">
		<div class="menu-icon">
			<div class="media sideimage">
				<div class="mr-3">
					<a href="<?php echo $model->getUrl()?>" class="d-block">
							<?php echo Html::img($model->getImageUrl(80), [
	 						 'class' => 'img-fluid rounded-lg',
						    'alt' => $model->title
							])?>
	    			</a>
    			</div>
			  <div class="media-body">
			    <?php echo  $model->linkify()?>

			  </div>
			</div>
		</div>
	</div>
</li>






