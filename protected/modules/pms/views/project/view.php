    <?php
    use app\components\useraction\UserAction;
    use app\modules\comment\widgets\CommentsWidget;
    use yii\helpers\Url;
    use app\models\User;
    /* @var $this yii\web\View */
    /* @var $model app\modules\pms\models\Project */
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('app', 'Pms'),
        'url' => [
            '/pms'
        ]
    ];
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('app', 'Projects'),
        'url' => [
            'index'
        ]
    ];
    $this->params['breadcrumbs'][] = (string) $model;
    $trial = 0;
    if (User::isTrialUser()) {
        $trial = 1;
    }

    ?>
<div class="wrapper">
	<div class="container-fluid">
		<div class="block-header">
			<div class="row">
				<div class="col-lg-5 col-md-8 col-sm-12">
					<h2>
						<a href="<?=Url::toRoute(['/pms/project'])?>"
							class="btn btn-xs btn-link btn-toggle-fullwidth"><i


							class="fa fa-arrow-left"></i></a><?=Yii::t('app', 'My Projects')?>


					</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a

							href="<?=Url::toRoute(['/pms/project'])?>"><i class="icon-home"></i></a></li>
						<li class="breadcrumb-item active"><?=Yii::t('app', 'Project Details')?></li>

					</ul>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<h2><?php

echo \yii\helpers\Html::encode($this->title);
    ?></h2>
				<div class="body nav-tags">
					<div class="project-panel">
            <?php
            $this->context->startPanel();

            $this->context->addPanelPage(Yii::t('app', 'Activities'), $model, '_home');
            $this->context->addPanelPage(Yii::t('app', 'Project Passport'), $model, '_detail');
            $this->context->addPanelUrl(Yii::t('app', 'WBS'), Url::toRoute([
                'task/index',
                'id' => $model->id
            ]));
            $this->context->addPanelUrl(Yii::t('app', 'Risk Matrix'), Url::toRoute([
                'risk-matrix/index',
                'id' => $model->id
            ]));
            $this->context->addPanelUrl(Yii::t('app', 'Budget'), Url::toRoute([
                'project/capex',
                'id' => $model->id
            ]));
            $this->context->addPanelPage(Yii::t('app', 'Project Schedule'), $model, '_plan');

            $this->context->addPanelUrl(Yii::t('app', 'Calculations'), Url::toRoute([

                'finance/index',
                'id' => $model->id
            ]));

            $this->context->addPanelPage(Yii::t('app', 'Report'), $model, '_report');

            $this->context->endPanel();
            ?>
         </div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php

if ($trial && ! (User::isFriend())) {
    ?>

    <style>
#ui-id-10{
    pointer-events: none;
}
</style>
<?php

}
?>

<script>
<?php

if ($trial && ! (User::isFriend())) {
    ?> 
	$('li').click(function(e){
		let areaLabelled = $(this).attr('aria-labelledby');
		if(areaLabelled == 'ui-id-10'){
			alert('You are not allowed to access this feature.');
		}
	});
<?php

}
?>
    $(document).on('click', '.ui-tabs-anchor', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('id')); 
        if($(e.target).attr('id') =='ui-id-10'){
            var trial = <?=$trial?>;
            if(trial == 1){
             localStorage.setItem('activeTab', $(e.target).attr('id')); 
            }
        }
    });
    
    $(document).ready(function(){
    	var activeTab = localStorage.getItem('activeTab'); 
    //alert(activeTab);
    if(activeTab){ 
        setTimeout(function(){
        	$('#' + activeTab).click();
        }, 100); 
    }
    });  
    


 </script>

