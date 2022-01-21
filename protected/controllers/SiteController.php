<?php

/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\controllers;

use app\components\TActiveForm;
use app\components\TController;
use app\models\EmailQueue;
use app\models\User;
use app\modules\subscription\models\Plan;
use Yii;
use yii\web\Response;
use app\components\filters\AccessControl;
use app\components\filters\AccessRule;
use app\modules\faq\models\Faq;
use app\models\ContactForm;
use app\modules\subscription\models\Billing;
use app\modules\payment\models\Payment;
use app\modules\payment\models\GatewaySetting;

class SiteController extends TController
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
                            'index',
                            'contact',
                            'about',
                            'error',
                            'demo',
                            'pricing',
                            'privacy',
                            'terms',
                            'captcha',
                            'faq',
                            'pay-now',
                            'success',
                            'guidelines'
                        ],
                        'allow' => true,
                        'roles' => [
                            '*',
                            '?',
                            '@'
                        ]
                    ]
                ]
            ]
        ];
    }

    public function actions()
    {
        return [

            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],

            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction'
            ]
        ];
    }

    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;
        return $this->render('error', [
            'message' => $exception->getMessage(),
            'name' => 'Error'
        ]);
    }

    public function actionIndex()
    {
        $this->updateMenuItems();
        $plans = Plan::find();
        if (! \Yii::$app->user->isGuest) {
            $this->layout = 'main';
            return $this->redirect('dashboard/index');
        } else {
            $this->layout = 'guest-main';
            return $this->render('index', [
                'plans' => $plans
            ]);
        }
    }

    public function actionContact()
    {
        $this->layout = 'guest-main';
        $model = new ContactForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $sub = $model->body;
            $from = yii::$app->params['adminEmail'];
            $message = \yii::$app->view->renderFile('@app/mail/contact.php', [
                'user' => $model
            ]);
            EmailQueue::sendEmailToAdmins([
                'from' => $from,
                'subject' => $sub,
                'html' => $message
            ], false);
            \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Warm Greetings!! Thank you for contacting us. We have received your request. Our representative will contact you soon.'));
            return $this->goHome();
        }
        return $this->render('contact', [
            'model' => $model
        ]);
    }

    public function actionAbout()
    {
        $this->layout = 'guest-main';
        return $this->render('about');
    }

    /**
     * list all questions and answers
     *
     * @return mixed
     */
    public function actionFaq()
    {
        $this->layout = 'guest-main';
        $faq = Faq::find();
        return $this->render('faq', [
            'model' => $faq
        ]);
    }

    public function actionFeatures()
    {
        $this->layout = 'guest-main';
        return $this->render('features');
    }

    public function actionPricing()
    {
        $this->layout = 'guest-main';
        $plans = Plan::find();
        return $this->render('pricing', [
            'model' => $plans
        ]);
    }

    public function actionPrivacy()
    {
        $this->layout = 'guest-main';
        return $this->render('privacy');
    }

    public function actionTerms()
    {
        $this->layout = 'guest-main';
        return $this->render('terms');
    }

    public function actionGuidelines()
    {
        $this->layout = 'guest-main';
        return $this->render('guidelines');
    }

    public function actionPayNow($id)
    {
        $user = Yii::$app->user->identity;

        $model = Plan::findOne($id);
        if (! empty($model)) {
            $payment = new Payment();
            $payment->name = $user->full_name;
            $payment->email = $user->email;
            $payment->amount = $model->price;
            $payment->gateway = GatewaySetting::GATEWAY_TYPE_PAYPAL;
            $payment->model_id = $model->id;
            $payment->model_type = get_class($model);
            $transactions = $payment->createTransaction();
            if (! empty($transactions->url)) {
                return $this->redirect($transactions->url);
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'something went wrong!!!'));

                return $this->goBack();
            }
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('app', 'something went wrong!!!'));
            return $this->goBack();
        }
    }

    public function actionSuccess($id)
    {
        $plan = Plan::findOne($id);
        if (! empty($plan)) {
            $exist = \Yii::$app->user->identity->plan;
            if (! empty($exist)) {
                $exist->delete();
            }
            $billing = new Billing();
            $billing->subscription_id = $id;
            $billing->start_date = date('Y-m-d');
            $billing->end_date = $plan->getEndDate($plan);

            $billing->created_by_id = \Yii::$app->user->id;
            $billing->state_id = Billing::STATE_ACTIVE;
            $billing->type_id = Billing::STATE_INACTIVE;
            if (! $billing->save()) {
                \Yii::$app->session->setFlash('error', $billing->getErrorsString());
                return $this->goBack();
            }
        }

        \Yii::$app->session->setFlash('success', \Yii::t('app', 'paid successfully'));
        return $this->redirect([
            'user/plan'
        ]);
    }

    protected function updateMenuItems($model = null)
    {
        // create static model if model is null
        switch ($this->action->id) {
            case 'add':
                {
                    $this->menu[] = array(
                        'label' => Yii::t('app', 'Manage'),
                        'url' => array(
                            'index'
                        ),
                        'visible' => User::isAdmin()
                    );
                }
                break;
            default:
            case 'view':
                {
                    $this->menu[] = array(
                        'label' => '<span class="glyphicon glyphicon-list"></span> Manage',
                        'title' => 'Manage',
                        'url' => array(
                            'index'
                        ),
                        'visible' => User::isAdmin()
                    );

                    if ($model != null)
                        $this->menu[] = array(
                            'label' => Yii::t('app', 'Update'),
                            'url' => array(
                                'update',
                                'id' => $model->id
                            ),
                            'visible' => ! User::isAdmin()
                        );
                }
                break;
        }
    }
}
