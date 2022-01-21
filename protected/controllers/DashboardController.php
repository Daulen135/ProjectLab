<?php
/**
 *
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 */
namespace app\controllers;

use app\components\TController;
use app\components\filters\AccessControl;
use app\components\filters\AccessRule;
use app\models\User;

class DashboardController extends TController
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRule::class
                ],
                'rules' => [
                    [
                        'actions' => [
                            'index'
                        ],
                        'allow' => true,
                        'roles' => [
                            '@'
                        ]
                    ]
                    
                ]
            ]
        ];
    }
    
    public function actionIndex()
    {
        $this->updateMenuItems();
        if (empty(\Yii::$app->user->identity->plan) && User::isUser())
            return $this->redirect([
                'user/plan'
            ]);
        
        return $this->redirect(['pms/project']);
    }
    
}