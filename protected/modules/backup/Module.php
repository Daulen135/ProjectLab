<?php
namespace app\modules\backup;

use app\components\TController;
use app\components\TModule;

class Module extends TModule
{

    const NAME = 'backup';

    public $controllerNamespace = 'app\modules\backup\controllers';

    public $path;

    public $allowDownload = false;

    /**
     *
     * @var int Max Files in DB folder
     */
    public $max_files = 10;

    public static function subNav()
    {
        if (method_exists("\app\components\WebUser", 'getIsAdminMode'))
            if (\Yii::$app->user->isAdminMode) {
                return self::adminSubNav();
            }
        return TController::addMenu(\Yii::t('app', 'Backup'), '//backup', 'database', (Module::isAdmin()));
    }

    public static function adminSubNav()
    {
        return TController::addMenu(\Yii::t('app', 'Backup'), '//backup/admin/default', 'database', (Module::isAdmin()));
    }
}
