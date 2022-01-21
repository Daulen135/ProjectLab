<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 *
 */
namespace app\modules\pms;
use app\components\TController;
use app\components\TModule;
use app\models\User;
/**
 * pms module definition class
 */
class Module extends TModule
{
    const NAME = 'pms';

    public $controllerNamespace = 'app\modules\pms\controllers';
	
	public $defaultRoute = 'pms';

    public static function subNav()
    {
        return TController::addMenu(\Yii::t('app', 'Pms'), '#', 'key ', Module::isAdmin(), [
           // TController::addMenu(\Yii::t('app', 'Home'), '//pms', 'lock', Module::isAdmin()),
        ]);
    }
    
    public static function dbFile()
    {
        return __DIR__ . '/db/install.sql';
    }
    
    public static function getRules()
    {
        return [
            
            'pms/<id:\d+>/<title>' => 'pms/post/view',
           // 'pms/post/<id:\d+>/<file>' => 'pms/post/image',
           //'pms/category/<id:\d+>/<title>' => 'pms/category/type'
        
        ];
    }
    
    
}

