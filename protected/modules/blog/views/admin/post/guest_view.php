<?php
use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $model app\models\Blog */
?>

<section class="content  p-bg">
	<!-- cx portfolio section start -->
			<div class="portfolio-heading-section">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="area-heading text-center">
								<h1 class="area-title">Our Blog</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
</section>
<div class="cx-section cx-blog-section">
	<div class="container-fluid">
				<div class="portfolio-filter-wrap">
					<ul class="portfolio-filter-1 text-center list-inline">
						
								<?php
        $categories = Category::findActive()->all();
        if (! empty($categories)) {
            foreach ($categories as $category) {
                $count = Post::find()->where([
                    'type_id' => $category->id,
                    'state_id' => Post::STATE_ACTIVE
                ])->count();
                ?>
						<li class=""><a href="<?= $category->getUrL('type') ?>"><?= $category->title ?> <span>(<?= $count?>)</span></a></li>
						
						<?php
            }
        }
        ?>
					</ul>
				</div>
	</div>
	<div class="container-fluid">
               <?=ListView::widget(['dataProvider' => $listDataProvider,'layout' => "{items}<div class='clearfix text-right'>{pager}</div>",'itemView' => function ($model, $key, $index, $widget) {return $this->render('_userview', ['model' => $model]);}]);?> 
	</div>
</div>


