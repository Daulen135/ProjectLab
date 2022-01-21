<?php
namespace app\modules\social;

use app\components\TController;
use app\components\TModule;
use app\modules\social\models\Provider;
use app\modules\social\models\User;

/**
 * blog module definition class
 */
class Module extends TModule
{

    /**
     *
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\social\controllers';

    public $defaultRoute = 'provider';

    public static function subNav()
    {
        return TController::addMenu(\Yii::t('app', 'Social'), '#', 'key ', Module::isAdmin(), [ 
            TController::addMenu(\Yii::t('app', 'Provider'), '/social/provider/index', 'lock', Module::isAdmin())
        ]);
    }
    
    public static function dbFile()
    {
        return __DIR__ . '/db/install.sql';
    }

    public static function beforeDelete($user_id)
    {
        Provider::deleteRelatedAll([
            'created_by_id' => $user_id
        ]);
        User::deleteRelatedAll([
            'user_id' => $user_id
        ]);
    }
}

