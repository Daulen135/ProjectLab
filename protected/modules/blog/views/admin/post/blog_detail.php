<?php
   use app\modules\blog\Module;
use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use app\modules\blog\widgets\BlogWidget;
use yii\helpers\Html;
use yii\helpers\Url;
   
   ?>
<!-- Page content area start -->
<section class="content p-bg" itemscope  itemtype="http://schema.org/BlogPosting">
   <div class="portfolio-heading-section">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <div class="area-heading">
                  <h1 class="area-title" itemprop="name headline"><?=$model->title?></h1>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- cx breadcrumb end -->

<div class="cx-section cx-blog-section">
   <div class="container-fluid">
      <div class="row">
         <div class="col-xl-8 col-lg-7 col-md-12">
            <div class="row post-bar">
               <div class="col-md-8">
                  <ul class="meta-info">
                     <li><span itemprop="author"><i class="fa fa-user"></i><?=isset($model->createUser->full_name) ? $model->createUser->full_name : '';?></span></li>
                     <li><span itemprop="datePublished"> <i class="fa fa-calendar"></i>
                        <?=Yii::$app->formatter->asDatetime($model->created_on, "php:d M Y");?> </span>
                     </li>
                     <li><span><?php echo( Yii::$app->params['company']);?></span></li>
                     <li><span class="badge badge-primary">
                        <?php
                           $category = Category::findOne($model->type_id);
                           if (! empty($category)) {
                               ?> <a href="<?= $category->getUrl('type') ?>"><?= $model->type ?></a>
                        <?php } ?> </span>
                     </li>
                     <li><span class="badge badge-success"><i class="fa fa-eye"></i><?=$model->view_count?></span></li>
                  </ul>
               </div>
               <div class="col-md-4 text-right blog-comment-section">
                  <?php
                  
                  echo Yii::$app->controller->getSocialTags();
                     ?>
               </div>
            </div>
            <article class="blog-post post-single">
               <div class="post-thumbnail">
                  <?php
                     echo Html::img($model->imageUrl, [
                         'class' => 'img-responsive',
                         'alt' => 'Image',
                         'itemprop' => 'image'
                     ])?>
               </div>
               <div class="post-content">
                  <div class="post-content-inner">                                        
                     <?php
                        echo '<div itemprop="description">' . $model->content . '</div>';
                        
                        ?>
                  </div>
               </div>
            </article>
            <div class="card">
               <div class="card-body">
                  <div class="fb-comment-widget">
                     <?php
                        if ($this->context->module->commentsType == Module::COMMENT_FACEBOOK) {
                            ?>
                     <div id="fb-root"></div>
                     <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12';
                        fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                     </script>
                     <div class="fb-comments" data-href="<?php Url::canonical()?>"
                        data-numposts="5"></div>
                     <?php }?>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-5 col-xl-4 col-md-122">
           <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-6 mb-lg-0 mb-4">
                    <div class="card blog-widget-view">
                       <div class="card-header bg-success">CATEGORIES</div>
                       <div class="card-body card-body-list">
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
                                <li><a
                                   href="<?= Url::toRoute(['/blog/category/type', 'id' => $category->id, 'title' => $category->title]) ?>"> <?= $category->title ?> <span>(<?= $count?>)</span>
                                   </a>
                                </li>
                                <?php
                                   }
                                   }
                                   
                                   ?>
                                <li><a href="<?= Url::toRoute(['/blog']) ?>"> All <span>(<?=Post::find ()->where ( [ 'state_id' => Post::STATE_ACTIVE ] )->count ();?>)</span>
                                   </a>
                                </li>
                             </ul>
                          </div>
                       </div>
                    </div>
                  </div>
                  <div class="col-xl-12 col-lg-12 col-md-6 mb-lg-0 mb-4">
                    <?php echo  BlogWidget::widget(['model'=>$model,'type_id' => BlogWidget::TYPE_RECENT]); ?>
                  </div>
                  <div class="col-xl-12 col-lg-12 col-md-6 mb-lg-0 mb-4">
                    <?php echo  BlogWidget::widget(['model'=>$model,'type_id' => BlogWidget::TYPE_MOST_POPULAR]); ?>
                  </div>
                  <div class="col-xl-12 col-lg-12 col-md-6 mb-lg-0 mb-4">
                    <?php echo  BlogWidget::widget(['model'=>$model,'type_id' => BlogWidget::TYPE_SIMILAR]); ?>
                  </div>
            </div>
        </div>
      </div>
   </div>
</div>