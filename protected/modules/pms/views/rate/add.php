<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\modules\pms\models\Rate */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pms'), 'url' => ['/pms']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
?>
<div class="wrapper">
	<div class="card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?>
	</div>
</div>


