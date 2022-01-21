<?php
use app\models\User;
use app\modules\blog\Module;
use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use app\modules\blog\widgets\BlogWidget;
use app\modules\comment\widgets\CommentsWidget;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<!-- Page content area start -->
<section itemscope itemtype="http://schema.org/BlogPosting">
	<div class="hide_type">
		<div itemtype="https://schema.org/Organization" itemscope="itemscope"
			itemprop="publisher">
			<span itemprop="name"><?=$model->title?></span> <span itemprop="logo"
				itemscope itemtype="https://schema.org/ImageObject">
				<link itemprop="url" href="<?php echo $model->getUrl()?>">
				<meta itemprop="width" content="600">
				<meta itemprop="height" content="60">
			</span> auf <a href="https://www.facebook.com/UsaReiseTipps"
				target="_blank" itemprop="sameAs" rel="noopener">Facebook</a>
		</div>
		<div class="" itemprop="dateModified"><?=$model->created_on?></div>
		<div class="" itemprop="mainEntityOfPage"><?=$model->created_on?></div>
	</div>
	<!-- cx breadcrumb start -->
	<section class="content p-bg">
		<!-- cx portfolio section start -->
		<div class="portfolio-heading-section">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12 text-center">
						<div class="area-heading">
							<h1 class="area-title" itemprop="name headline"><?=$model->title?></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- cx breadcrumb end -->
	<!-- cx blog section start -->
	<div class="cx-section cx-blog-section">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-8 col-lg-7 col-md-12">
					<article class="blog-post post-single">
						<div class="row post-bar">
							<div class="col-md-8">
								<ul class="meta-info">
									<li><span itemprop="author"><i class="fa fa-user"></i><?=isset($model->createUser->full_name) ? $model->createUser->full_name : '';?></span></li>
									<li><span itemprop="datePublished"> <i class="fa fa-calendar"></i>
                              <?=Yii::$app->formatter->asDatetime($model->created_on, "php:d M Y");?> </span>
									</li>
								</ul>
								<ul class="meta-info">
									<li><span class="badge badge-primary">
                              <?php
                            $category = Category::findOne($model->type_id);
                            if (! empty($category)) {
                                ?> <a
											href="<?= $category->getUrl('type') ?>"><?= $model->type ?></a>
                              <?php } ?> </span></li>
									<li><span class="badge badge-success text-white"><i
											class="fa fa-eye"></i><?=$model->view_count?></span></li>
								</ul>
							</div>
							<div class="col-md-4 text-right blog-comment-section">
								<p class="text-right">Share this post on: &nbsp;</p>
                        <?php
                        echo Yii::$app->controller->getSocialTags();

                        ?>
                     </div>
						</div>
						<div class="post-thumbnail mt-3">
                     <?php
                    echo Html::img($model->imageUrl, [
                        'class' => 'img-responsive',
                        'alt' => $model->title,
                        'itemprop' => 'image'
                    ])?>
                  </div>
						<div class="post-content">
							<div class="post-content-inner">                                        
                        <?php
                        echo '<div itemprop="description">' . $model->content . '</div>';

                        if (User::isAdmin() || User::isManager()) {

                            echo Html::a('Update', $model->getUrl('update'), [
                                'class' => 'btn btn-primary'
                            ]);
                        }
                        ?>
                     </div>
						</div>
					</article>
					<div class="card">
						<div class="card-body">
							<div id="commentbox">
                        <?php
                        echo CommentsWidget::widget([
                            'model' => $model,
                            'type' => Module::self()->commentsType
                        ]);
                        ?>
                     </div>
						</div>
					</div>
				</div>
				<div class="col-lg-5 col-xl-4 col-md-12">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-6 mb-lg-0 mb-4">
							<div class="card blog-widget-view h-100">
								<div class="card-header">CATEGORIES</div>
								<div class="card-body">
									<div class="content-list content-image menu-action-right">
										<ul class="list-wrapper pl-3">
                                 <?php
                                $categories = Category::findActive()->all();

                                if (! empty($categories)) {
                                    foreach ($categories as $category) {
                                        $count = Post::find()->where([
                                            'type_id' => $category->id,
                                            'state_id' => Post::STATE_ACTIVE
                                        ])->count();
                                        ?>
                                 <li class="mb-2"><a
												href="<?= Url::toRoute(['/blog/category/type', 'id' => $category->id, 'title' => $category->title]) ?>"> <?= $category->title ?> <span>(<?= $count?>)</span>
											</a></li>
                                 <?php
                                    }
                                }

                                ?>
                                 <li class="mb-2"><a
												href="<?= Url::toRoute(['/blog']) ?>"> All <span>(<?=Post::find ()->where ( [ 'state_id' => Post::STATE_ACTIVE ] )->count ();?>)</span>
											</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-6 mb-lg-0 mb-4">
                     <?php echo  BlogWidget::widget(['model'=>$model,'type_id' => BlogWidget::TYPE_MOST_POPULAR]); ?>
                  </div>
						<div class="col-xl-12 col-lg-12 col-md-6 mb-lg-0 mb-4">
                     <?php echo  BlogWidget::widget(['model'=>$model,'type_id' => BlogWidget::TYPE_RECENT]); ?>
                  </div>
						<div class="col-xl-12 col-lg-12 col-md-6 mb-lg-0 mb-4">
                     <?php echo  BlogWidget::widget(['model'=>$model,'type_id' => BlogWidget::TYPE_SIMILAR]); ?>
                  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>