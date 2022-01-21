<?php
use app\components\TDashBox;
use app\components\notice\Notices;
use app\models\EmailQueue;
use app\models\LoginHistory;
use app\modules\logger\models\Log;
use yii\helpers\Url;
use app\models\User;
use app\models\search\User as UserSearch;
use miloschuman\highcharts\Highcharts;

/**
 *
 * @copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 * @author : Shiv Charan Panjeta < shiv@toxsl.com >
 */
/* @var $this yii\web\View */
// $this->title = Yii::t ( 'app', 'Dashboard' );
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Dashboard')
];
?>
<div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-5 col-md-8 col-sm-12">
                            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>My Projects</h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                                <li class="breadcrumb-item active">Report</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="body">
                           <div class="tab-pane" id="Profile">
                            <div class="table-responsive">
                                <table id="project-detail-view" class="table table-striped table-bordered detail-view">
                                    <tbody>
                                        <tr>
                                            <th><?= Yii::t('app', 'Report Name')?></th>
                                            <td colspan="1"><?= Yii::t('app', 'Report: Regarding Activities')?></td>
                                        </tr>
                                        <tr>
                                            <th><?= Yii::t('app', 'Report Description')?></th>
                                            <td colspan="1"><?= Yii::t('app', 'Manage Daily Operations. One of the Manage Daily Operations. One of the Manage Daily Operations. One of the Manage Daily Operations. One of the')?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>