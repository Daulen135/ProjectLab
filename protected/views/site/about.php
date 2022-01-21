<?php
use app\components\PageWidget;
use app\models\Page;

/* @var $this yii\web\View */
/*
 * $this->title = 'About';
 * $this->params ['breadcrumbs'] [] = $this->title;
 */
?>


 <section class="pagetitle-section">
    <div class="container-fluid">
       <div class="row">
            <div class="col-md-12 text-center">
            <h1 class="mb-0 mt-0"><?= Yii::t('app', 'About Us')?></h1>
            </div>
                    </div>
       </div>
 </section>
            
<div class="site-about">
	<div class="container-fluid">
		<div class="row other-wrapper ">
	<?php
$about = Page::find()->where([
    'type_id' => Page::TYPE_ABOUT_US
])->one();
if ($about) {
    echo $about->description;
} else {
    echo Yii::t('app', 'Info will soon be available');
}
?>
</div>
	</div>
</div>