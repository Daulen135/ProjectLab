<?php
// use app\components\useraction\UserAction;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\useraction\UserAction;

/* @var $this yii\web\View */
/* @var $model app\models\User */

/* $this->title = $model->label() .' : ' . $model->id; */
?>


<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">                        

                <h2><a href="<?php

                echo Url::toRoute([
                    '/'
                ]);
                ?>" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a><?=Yii::t('app', 'My Profile')?> </h2> 
           
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php

                    echo Url::toRoute([
                        '/'
                    ]);
                    ?>"><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active"><?=Yii::t('app', 'My Profile')?></li>
                    
                </ul>
            </div> 
               <div class="col-lg-5 col-md-8 col-sm-12">    
            <?=Html::a($model->is_verify == 1 ? Yii::t('app', 'Make UnFavourite') : Yii::t('app', 'Make Favourite'), Url::toRoute(['user/verify','id' => $model->id]), ['class' => 'btn btn-success'])?>
            </div>
        </div>
    </div>

    <div class="row clearfix">

        <div class="col-lg-4 col-md-12">
            <div class="card profile-header">
                <div class="body text-center">
                    <div class="profile-image">   
                        <?php
                        if (! empty($model->profile_file)) {
                            echo Html::img($model->getImageUrl(150), [
                                'class' => 'img-responsive'
                            ]);
                        } else {
                            ?>
                            <img id="profile_file"
									class="img-responsive" src="<?=$this->theme->getUrl('frontend/img/default.jpg')?>"> 
                            
                            <?php
                        }
                        ?>
                            <br /> <br />
                            
                       
                        
                    </div>
                    <div>
                        <h4 class="m-b-0"><strong><?php

                        echo $model->getFullname();
                        ?></strong></h4>
                        
                    </div>                         
                </div>
            </div>
        </div>
        <div class="col-lg-4">
           <div class="card">
            <div class="header">
                <h2>Info</h2>
            </div>
            <div class="body">
                <small class="text-muted">ID: </small>
                <p><?php

                echo $model->id;
                ?></p>                            
                <hr>
                <small class="text-muted"><?=Yii::t('app', 'First Name')?>: </small>
                <p><?php

                echo $model->first_name;
                ?></p>
                <hr>       
                <small class="text-muted"><?=Yii::t('app', 'Last Name')?>: </small>
                <p><?php

                echo $model->last_name;
                ?></p>                       
                <hr>                                
                <small class="text-muted"><?=Yii::t('app', 'Mobile')?>: </small>
                <p><?php

                echo $model->contact_no;
                ?></p>
                <hr>
                <small class="text-muted"><?=Yii::t('app', 'Email Address')?>: </small>
                <p><?php

                echo $model->email;
                ?></p>                            
            </div>
        </div>
    </div>
</div>
</div>