<?php
   use app\modules\blog\models\Category;
   use app\modules\social\widgets\SocialShare;
   use yii\helpers\Html;
   use yii\helpers\StringHelper;
   use yii\helpers\Url;
   
   ?>
<div class="row">
   <article class="blog-post">
      <div class="row align-items-center">
         <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-lg-0 mb-3">
            <div class="post-thumbnail">
               <a href="<?= $model->url ?>">	
               <?=Html::img($model->getImageUrl(350), ['class' => 'img-responsive','alt' => 'Image'])?>
               </a>
            </div>
         </div>
         <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12">
            <div class="post-content">
               <div class="post-content-inner">
                  <h3>
                     <a href="<?= $model->url ?>"><?=$model->title;?></a>
                  </h3>
                  <ul class="meta-info">
                     <li><span><i class="fa fa-user"></i><?=isset($model->createUser->full_name) ? $model->createUser->full_name : '';?></span></li>
                     <li><span> <i class="fa fa-calendar"></i><?=Yii::$app->formatter->asDate($model->created_on, "php: d M Y");?>
                        </span>
                     </li>
                     <li>
                        <?php
                           $category = Category::findOne($model->type_id);
                           if (! empty($category)) {
                               ?>
                        <span><a href="<?= $category->getUrl('type') ?>"><?= $model->type ?></a></span>
                        <?php
                           }
                           ?>
                     </li>
                  </ul>
                  <p><?=strip_tags(StringHelper::truncate($model->content, 600, '...'))?></p>
                  <div class="read-more">
                     <a href="<?= $model->url ?>" class="btn btn-primary">Read More</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </article>
</div>