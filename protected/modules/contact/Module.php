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
namespace app\modules\contact;

use app\components\TController;
use app\components\TModule;
use app\models\User;

/**
 * contact module definition class
 */
class Module extends TModule
{

    const NAME = 'contact';

    public $controllerNamespace = 'app\modules\contact\controllers';

    // public $defaultRoute = 'information';
    public $enableAck = false;

    public static function subNav()
    {
        return TController::addMenu(\Yii::t('app', 'Contacts'), '//contact', 'phone', (Module::isManager()), [
            TController::addMenu(\Yii::t('app', 'Home'), '//contact', 'lock', Module::isManager()),
            TController::addMenu(\Yii::t('app', 'Addresses'), '//contact/address', 'lock', (Module::isManager())),
            TController::addMenu(\Yii::t('app', 'Phones'), '//contact/phone', 'lock', (Module::isManager())),
            TController::addMenu(\Yii::t('app', 'Information'), '//contact/information', 'lock', (Module::isManager()))
        ]);
    }

    public static function dbFile()
    {
        return __DIR__ . '/db/install.sql';
    }

    public static function getRules()
    {
        return [

            'contact/request/demo' => 'contact/information/info',
            'contact/request/quote' => 'contact/information/info',
            'contact/request/thankyou' => 'contact/information/thankyou'
        ];
    }
}
