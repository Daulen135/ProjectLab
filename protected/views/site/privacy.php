<?php
use app\components\PageWidget;
use app\models\Page;

/* @var $this yii\web\View */
/*
 * $this->title = 'About';
 * $this->params ['breadcrumbs'] [] = $this->title;
 */
?>
<div class="breadcroumb-area bread-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcroumb-title text-center">
					<h1 class="text-white"><?= Yii::t('app', 'Privacy Policy')?></h1>
					<h6 class="text-white">
						<a href="#2"><?= Yii::t('app', 'Home')?></a> / <?= Yii::t('app', 'Privacy Policy')?>
					</h6>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="site-about py-5">
	<div class="container-fluid">
		<div class="row other-wrapper ">
			<div class="container">
				<?php
    $about = Page::find()->where([
        'type_id' => Page::TYPE_PRIVACY_POLICY
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
</div>
