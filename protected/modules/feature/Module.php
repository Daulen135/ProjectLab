<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\modules\feature;

use app\components\TController;
use app\components\TModule;
use app\models\User;
use app\modules\feature\assets\RemoteFeatureAssets;
use app\modules\feature\models\Feature;
use app\modules\feature\models\Type;
use app\modules\feature\models\Update;
use app\modules\feature\models\Vote;

/**
 * feature module definition class
 */
class Module extends TModule
{

    const NAME = 'feature';

    public $remote = false;

    public $controllerNamespace = 'app\modules\feature\controllers';

    public $defaultRoute = 'feature';

    public function init()
    {
        parent::init();
        
        RemoteFeatureAssets::register(\Yii::$app->getView());
        // custom initialization code goes here
    }
    public static function subNav()
    {
        return TController::addMenu(\Yii::t('app', 'Features'), '#', 'key ', User::isManager(), [
            TController::addMenu(\Yii::t('app', 'List'), '//feature/feature/index', 'lock', User::isManager()),
            TController::addMenu(\Yii::t('app', 'Types'), '//feature/type/index', 'lock', User::isManager()),
            TController::addMenu(\Yii::t('app', 'Votes'), '//feature/vote/index', 'lock', User::isManager())
        ]);
    }

    public static function dbFile()
    {
        return __DIR__ . '/db/install.sql';
    }
    public static function getRules()
    {
        return [
            'feature/<id:\d+>/<title>' => 'feature/feature/view',
            'feature/<id:\d+>' => 'feature/feature/view',
            'features' => 'feature/feature/index',
           
        ];
    }
    public static function beforeDelete($user_id)
    {
        Feature::deleteRelatedAll([
            'created_by_id' => $user_id
        ]);
        Type::deleteRelatedAll([
            'created_by_id' => $user_id
        ]);
        Update::deleteRelatedAll([
            'created_by_id' => $user_id
        ]);
    }
}
