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
					<h1 class="text-white"><?=Yii::t('app', 'Guidelines')?></h1>
					<h6 class="text-white">
						<a href="#2"><?=Yii::t('app', 'Home')?></a> / <?=Yii::t('app', 'Guidelines')?>
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
        'type_id' => Page::TYPE_HOW_TO_USE
    ])->one();
    $pattern = '~[a-z]+://\S+~';
    if ($about) {
        $str = $about->description;
        if ($num_found = preg_match_all($pattern, $str, $out)) {

            $link = ($out[0][0]);

            ?>
            
<iframe width="782" height="440" src="<?=$link?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php
        } else {
            echo $str;
        }
    } else {
        echo Yii::t('app', 'Info will soon be available');
    }
    ?>
				</div>
		</div>
	</div>
</div>
