<?php

/**
 *
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author     : Shiv Charan Panjeta < shiv@toxsl.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 */
namespace app\base;

use app\models\User;
use Yii;
use yii\web\Controller;
use app\modules\subscription\models\Billing;
use app\modules\subscription\models\Plan;

abstract class TBaseController extends Controller
{

    public $allowedIPs = [
        '127.0.0.1',
        '::1',
        '192.168.*.*'
    ];

    public $layout = '//guest-main';

    public $menu = [];

    public $top_menu = [];

    public $side_menu = [];

    public $user_menu = [];

    public $tabs_data = null;

    public $tabs_name = null;

    public $dryRun = false;

    public $assetsDir = '@webroot/assets';

    public $ignoreDirs = [];

    public $nav_left = [];

    protected $_author = '@toxsltech';

    // nav-left-medium';
    protected $_pageCaption;

    protected $_pageDescription;

    protected $_pageKeywords;

    public function beforeAction($action)
    {
        if (! parent::beforeAction($action)) {
            return false;
        }

        if (! \Yii::$app->user->isGuest) {
            $this->layout = 'main';

            if (! User::isFriend()) {

                $now = time(); // or your date as well
                $singup_date = strtotime(\Yii::$app->user->identity->last_action_time);
                $datediff = $now - $singup_date;

                $days = round($datediff / (60 * 60 * 24));

                if (! (User::isAdmin())) {
                    $plan = Billing::find()->where([
                        'created_by_id' => Yii::$app->user->id,
                        'state_id' => Plan::STATE_ACTIVE
                    ])
                        ->andWhere([
                        '!=',
                        'type_id',
                        Billing::STATE_ACTIVE
                    ])
                        ->one();
                    if ($days > Billing::TRIAL_PERIOD) {
                        if (empty($plan) && ! in_array(\Yii::$app->controller->action->id, $this->allowedActions())) {
                            return $this->redirect([
                                '/user/plan'
                            ]);
                        }
                    }
                }
            }
        }

        return true;
    }

    public function allowedActions()
    {
        return array(
            'pay-now',
            'logout',
            'paynow',
            'plan'
        );
    }

    public static function addmenu($label, $link, $icon, $visible = null, $list = null)
    {
        if (! $visible)
            return null;
        $item = [
            'label' => '<i
							class="fa fa-' . $icon . '"></i> <span>' . $label . '</span>',
            'url' => [
                $link
            ]
        ];
        if ($list != null) {
            $item['options'] = [
                'class' => 'menu-list nav-item'
            ];

            $item['items'] = $list;
        }

        return $item;
    }

    public function renderNav()
    {
        $nav_left = [
            self::addMenu(Yii::t('app', 'All Projects'), '//pms/project', 'th-list', User::isAdmin()),
            self::addMenu(Yii::t('app', 'My Projects'), '//pms/project', 'clipboard', User::isUser()),
            self::addMenu(Yii::t('app', 'Create Projects'), '//pms/project/add', 'edit', User::isUser()),
            self::addMenu(Yii::t('app', 'Plans'), '//user/plan', 'money', User::isUser()),

            'Manage' => self::addMenu(Yii::t('app', 'Manage'), '#', 'tasks', User::isManager(), [
                self::addMenu(Yii::t('app', 'Users'), '//user', 'user', (User::isManager())),
                self::addMenu(Yii::t('app', 'Feeds'), '//feed/index/', 'tasks', User::isAdmin()),
                self::addMenu(Yii::t('app', 'Pages'), '//page/index/', 'tasks', User::isManager()),
                self::addMenu(Yii::t('app', 'Services'), '//service/index/', 'tasks', User::isManager()),
                self::addMenu(Yii::t('app', 'Backup'), '//backup/', 'download', User::isAdmin()),
                self::addMenu(Yii::t('app', 'Logger'), '//logger/log', 'tasks', User::isAdmin()),
                self::addMenu(Yii::t('app', 'Emails In Queue'), '//email-queue/', 'retweet', (! User::isGuest())),
                self::addMenu(Yii::t('app', 'Modify Template'), '//pms/rename/', 'tasks', (User::isAdmin()))
            ]),
            self::addMenu(Yii::t('app', 'Logout'), '//user/logout', 'user', User::isUser())
        ];
        if (yii::$app->hasModule('subscription'))
            $nav_left['subscription'] = \app\modules\subscription\Module::subNav();
        if (yii::$app->hasModule('translator'))
            $nav_left['translator'] = \app\modules\translator\Module::subNav();
        if (yii::$app->hasModule('seo'))
            $nav_left['seo'] = \app\modules\seo\Module::subNav();
        if (yii::$app->hasModule('social'))
            $nav_left['social'] = \app\modules\social\Module::subNav();
        if (yii::$app->hasModule('faq'))
            $nav_left['faq'] = \app\modules\faq\Module::subNav();
        if (yii::$app->hasModule('payment'))
            $nav_left['payment'] = \app\modules\payment\Module::subNav();
        $this->nav_left = $nav_left;
        return $this->nav_left;
    }
}

