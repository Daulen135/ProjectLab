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
namespace app\components\commands;

use app\components\TConsoleController;
use Yii;
use yii\console\ExitCode;

class ModuleController extends TConsoleController
{

    public $dryrun = false;

    public $module = null;

    public function options($actionID)
    {
        return [
            'dryrun',
            'module'
        ];
    }

    public function optionAliases()
    {
        return [
            'd' => 'dryrun',
            'm' => 'module'
        ];
    }

    public static function moduleList()
    {
        $config = include (DB_CONFIG_PATH . 'web.php');
        $modules = array_keys($config['modules']);
        $configConsole = include (DB_CONFIG_PATH . 'console.php');
        $modules = array_merge($modules, array_keys($configConsole['modules']));
        $modules = array_unique($modules);

        return $modules;
    }

    public function actionMigrate()
    {
        self::log('Run migration on app');
        Yii::$app->runAction("migrate", [
            'interactive' => 0
        ]);

        self::log('Run migration on all modules');
        $modules = self::moduleList();
        if (empty($modules)) {
            self::log('No modules found');
            return ExitCode::NOUSER;
        }
        foreach ($modules as $module) {

            $path = Yii::$app->basePath . '/modules/' . $module . '/migrations';

            self::log(' Checking path:' . $path);
            if (is_dir($path)) {
                try {
                    self::log('Run on withPaths:' . $path);
                    Yii::$app->runAction("migrate", [
                        'migrationPath' => $path,
                        'interactive' => 0
                    ]);
                } catch (\Exception $ex) {
                    self::log($ex->getMessage());
                    self::log($ex->getTraceAsString());
                }
            }
        }

        return ExitCode::OK;
    }
}
