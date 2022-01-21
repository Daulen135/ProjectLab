<?php
namespace app\modules\blog;

use app\components\TController;
use app\components\TModule;
use app\modules\blog\assets\BlogAsset;
use app\modules\blog\models\Category;
use app\modules\blog\models\Post;

/**
 * blog module definition class
 */
class Module extends TModule
{

    /**
     *
     * @inheritdoc
     */
    const NAME = 'blog';

    public $controllerNamespace = 'app\modules\blog\controllers';

    public $defaultRoute = 'post';

    public $layout = null;

    const COMMENT_NONE = 0;

    const COMMENT_BUILTIN = 1;

    const COMMENT_FACEBOOK = 2;

    public $commentsType = self::COMMENT_FACEBOOK;

    /**
     *
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (\Yii::$app instanceof \yii\web\Application) {
            BlogAsset::register(\Yii::$app->getView());
        }
        // custom initialization code goes here
    }

    public static function getRules()
    {
        return [
            'blog/<id:\d+>/<title>' => 'blog/post/view',
            'blog/<id:\d+>' => 'blog/post/view',
            'blog/image/<id:\d+>/<file>' => 'blog/post/image',
            'blog/category/<id:\d+>/<title>' => 'blog/category/type',
            'blog' => 'blog/post/index'
        ];
    }

    public static function subNav()
    {
        if (method_exists("\app\components\WebUser", 'getIsAdminMode'))
            if (\Yii::$app->user->isAdminMode) {
                return self::adminSubNav();
            }
        return TController::addMenu(\Yii::t('app', 'Blog'), '#', 'key ', (Module::isManager()), [
            TController::addMenu(\Yii::t('app', 'Posts'), '//blog/post', 'lock', (Module::isManager())),
            TController::addMenu(\Yii::t('app', 'Categories'), '//blog/category', 'lock', (Module::isManager()))
        ]);
    }

    public static function adminSubNav()
    {
        return TController::addMenu(\Yii::t('app', 'Blog'), '#', 'key ', (Module::isAdmin()), [
            TController::addMenu(\Yii::t('app', 'Posts'), '//blog/admin/post', 'lock', (Module::isAdmin())),
            TController::addMenu(\Yii::t('app', 'Categories'), '//blog/admin/category', 'lock', (Module::isAdmin()))
        ]);
    }

    public static function dbFile()
    {
        return __DIR__ . '/db/install.sql';
    }

    public static function beforeDelete($user_id)
    {
        Post::deleteRelatedAll([
            'created_by_id' => $user_id
        ]);
        Category::deleteRelatedAll([
            'created_by_id' => $user_id
        ]);
    }
}

