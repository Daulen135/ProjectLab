<?php
namespace app\modules\payment;

use app\components\TModule;
use app\components\TController;

/**
 * payment module definition class
 */
class Module extends TModule
{

    /**
     *
     * @inheritdoc
     */
    public static $payConfig;

    public $controllerNamespace = 'app\modules\payment\controllers';

    public function init()
    {
        parent::init();
        // if (empty(\Yii::$app->db->getSchema()
        // ->getTableSchema('tbl_payment_transaction')
        // ->getColumn('description'))) {
        // \Yii::$app->db->createCommand("ALTER TABLE `tbl_payment_transaction` ADD `description` TEXT NULL DEFAULT NULL AFTER `email`;")->execute();
        // }
    }

    public static function subNav()
    {
        if (method_exists("\app\components\WebUser", 'getIsAdminMode'))
            if (\Yii::$app->user->isAdminMode) {
                return self::adminSubNav();
            }
           return TController::addMenu(\Yii::t('app', 'Payment'), '#', 'key ', (Module::isManager()), [
            TController::addMenu(\Yii::t('app', 'Payment Gateway'), '//payment/gateway/', 'lock', (Module::isManager())),
            TController::addMenu(\Yii::t('app', 'Transaction'), '//payment/transaction/', 'lock', (Module::isManager()))
        ]);
    }

    public static function adminSubNav()
    {
        return TController::addMenu(\Yii::t('app', 'Payment'), '#', 'key ', (Module::isAdmin()), [
            TController::addMenu(\Yii::t('app', 'Payment Gateway'), '//payment/gateway/', 'lock', (Module::isAdmin())),
            TController::addMenu(\Yii::t('app', 'Transaction'), '//payment/transaction/', 'lock', (Module::isAdmin()))
        ]);
    }

    public static function dbFile()
    {
        return __DIR__ . '/db/install.sql';
    }
}
