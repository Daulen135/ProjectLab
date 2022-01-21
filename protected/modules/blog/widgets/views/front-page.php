<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 text-center TOPHEADING">
			<h2><?php echo $type ?></h2>
		</div>
	</div>
	<div class="row justify-content-center">
		<!-- Single Video Post -->
      <?php
    if (! empty($posts)) {
        foreach ($posts as $post) {
            ?>
      <?php
            $route = $post->getUrl('view', [
                'id' => $post->id
            ]);
            ?>
      <div class="hidden-sm col-lg-4 col-md-6" data-wow-delay="0.6s">
			<div class="single-blog">
				<div class="blog-img">
					<a href="<?php echo $route;?>">
               <?php
            echo Html::img($post->getImageUrl(80), [
                'class' => 'img-fluid',
                'alt' => $post
            ]);
            ?>
               </a>
				</div>
				<h4>
					<a href="<?php echo $route;?>"><?php echo $post->title;?></a>
				</h4>
				<p><?=strip_tags(StringHelper::truncate($post->content, 300, '...'))?></p>
				<br> <a class="read-more" href="<?php echo $route;?>">Read more</a>
			</div>
		</div>
      <?php }}?>
   </div>
</div>