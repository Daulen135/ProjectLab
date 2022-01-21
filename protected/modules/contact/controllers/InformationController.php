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
namespace app\modules\contact\controllers;

use app\components\TActiveForm;
use app\components\TController;
use app\components\World;
use app\models\EmailQueue;
use app\models\User;
use app\modules\contact\models\Information;
use app\modules\contact\models\search\Information as InformationSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\VarDumper;

/**
 * InformationController implements the CRUD actions for Information model.
 */
class InformationController extends TController
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
                            'add',
                            'update',
                            'delete',
                            'mass',
                            'clear',
                            'push'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return user::isAdmin();
                        }
                    ],
                    [
                        'actions' => [
                            'index',
                            'view',
                            'ajax',
                            'push'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return user::isManager();
                        }
                    ],
                    [
                        'actions' => [
                            'add',
                            'view',
                            'thankyou',
                            'confirm',
                            'info',
                            'info-address',
                            'address'
                        ],
                        'allow' => true,
                        'roles' => [
                            '?',
                            '@',
                            '*'
                        ]
                    ]
                ]
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'delete' => [
                        'post'
                    ]
                ]
            ]
        ];
    }

    public function actions()
    {
        return [

            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction'
                // 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ]
        ];
    }

    /**
     * Lists all Information models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InformationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->updateMenuItems();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Information model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $this->updateMenuItems($model);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Information model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionAdd()
    {
        $model = Information::createNewRecord();

        $post = \yii::$app->request->post();

        if ($model->load($post)) {
            if ($model->checkSpamMail() > 0) {
                throw new HttpException(403, Yii::t('app', 'You are not allowed to access this page.'));
            }
            $model->state_id = Information::STATE_INACTIVE;
            if ($model->save()) {

                return $this->redirect([
                    '/contact/thankyou'
                ]);
            }
        }

        $this->updateMenuItems();
        return $this->render('add', [
            'model' => $model
        ]);
    }

    public function actionInfo($type = null)
    {
        $this->layout = "guest-main";

        $model = Information::createNewRecord();

        $post = \yii::$app->request->post();

        $model->scenario = 'add-contact-us';
        if ($type != null) {
            $model->type_id = Information::TYPE_QUOTE;
            $model->scenario = 'add-quote';
        }
        if ($post) {

            $model->type_id = ($type) ? $type : Information::TYPE_CONTACT;
            if (\yii::$app->request->isAjax && $model->load($post)) {
                \yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                Information::updateNewRecord($model);
                return TActiveForm::validate($model);
            }
        }

        if ($model->load($post) && $model->validate()) {
            $model->state_id = Information::STATE_SUBMITTED;
            if ($model->checkSpamMail() > 0) {
                // throw new HttpException(403, Yii::t('app', 'You are not allowed to SPAM'));
                $model->state_id = Information::STATE_SPAM;
            }

            if ($model->save()) {

                Yii::$app->session->setFlash('contactFormSubmitted');

                if ($model->state_id != Information::STATE_SPAM) {
                    // Sends email confirmation mail to user
                    $subject = 'Thank You for contacting us !!!';
                    $msg = \yii::$app->view->renderFile('@app/modules/contact/mail/thank-you.php', [
                        'model' => $model
                    ]);
                    EmailQueue::add([
                        // 'from' => \Yii::$app->params['adminEmail'],
                        'subject' => $subject,
                        'to' => $model->email,
                        'html' => $msg
                    ], false);
                }

                \Yii::$app->controller->redirect('thankyou');
            }
        }

        return $this->render('contact', [
            'model' => $model
        ]);
    }

    public function actionInfoAddress($type = null)
    {
        $this->layout = "guest-main";

        $model = Information::createNewRecord();

        $post = \yii::$app->request->post();

        $model->scenario = 'add-contact-us';
        if ($type != null) {
            $model->type_id = Information::TYPE_QUOTE;
            $model->scenario = 'add-quote';
        }
        if ($post) {

            $model->type_id = ($type) ? $type : Information::TYPE_CONTACT;
            if (\yii::$app->request->isAjax && $model->load($post)) {
                \yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                Information::updateNewRecord($model);
                return TActiveForm::validate($model);
            }
        }

        if ($model->load($post) && $model->validate()) {
            $model->state_id = Information::STATE_SUBMITTED;
            if ($model->checkSpamMail() > 0) {
                // throw new HttpException(403, Yii::t('app', 'You are not allowed to SPAM'));
                $model->state_id = Information::STATE_SPAM;
            }

            if ($model->save()) {

                Yii::$app->session->setFlash('contactFormSubmitted');

                if ($model->state_id != Information::STATE_SPAM) {
                    // Sends email confirmation mail to user
                    $subject = 'Thank You for contacting us !!!';
                    $msg = \yii::$app->view->renderFile('@app/modules/contact/mail/thank-you.php', [
                        'model' => $model
                    ]);
                    EmailQueue::add([
                        // 'from' => \Yii::$app->params['adminEmail'],
                        'subject' => $subject,
                        'to' => $model->email,
                        'html' => $msg
                    ], false);
                }

                \Yii::$app->controller->redirect('thankyou');
            }
        }
        return $this->render('contact-address', [
            'model' => $model
        ]);
    }

    public function actionAddress($type = null)
    {
        $this->layout = "guest-main";

        $model = Information::createNewRecord();

        $post = \yii::$app->request->post();

        $model->scenario = 'add-contact-us';
        if ($type != null) {
            $model->type_id = Information::TYPE_QUOTE;
            $model->scenario = 'add-quote';
        }
        if ($post) {

            $model->type_id = ($type) ? $type : Information::TYPE_CONTACT;
            if (\yii::$app->request->isAjax && $model->load($post)) {
                \yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                Information::updateNewRecord($model);
                return TActiveForm::validate($model);
            }
        }

        if ($model->load($post) && $model->validate()) {
            $model->state_id = Information::STATE_SUBMITTED;
            if ($model->checkSpamMail() > 0) {
                // throw new HttpException(403, Yii::t('app', 'You are not allowed to SPAM'));
                $model->state_id = Information::STATE_SPAM;
            }

            if ($model->save()) {

                Yii::$app->session->setFlash('contactFormSubmitted');

                if ($model->state_id != Information::STATE_SPAM) {
                    // Sends email confirmation mail to user
                    $subject = 'Thank You for contacting us !!!';
                    $msg = \yii::$app->view->renderFile('@app/modules/contact/mail/thank-you.php', [
                        'model' => $model
                    ]);
                    EmailQueue::add([
                        // 'from' => \Yii::$app->params['adminEmail'],
                        'subject' => $subject,
                        'to' => $model->email,
                        'html' => $msg
                    ], false);
                }

                \Yii::$app->controller->redirect('thankyou');
            }
        }
        return $this->render('contact-addr', [
            'model' => $model
        ]);
    }

    public function actionThankyou()
    {
        $this->layout = "guest-main";
        return $this->render('thankyou', [
            'verify' => false
        ]);
    }

    public function actionConfirm($id)
    {
        $model = $this->findModel($id);
        $model->state_id = Information::STATE_PROCESSED;
        $model->updateAttributes([
            'state_id'
        ]);
        return $this->render('thankyou', [
            'verify' => true,
            'model' => $model
        ]);
    }

    public function actionPush($id)
    {
        $model = $this->findModel($id);

        if ($model->sendToLeadManager()) {
            $model->state_id = Information::STATE_PROCESSED;
            $model->updateAttributes([
                'state_id'
            ]);
        }
        return $this->render('thankyou', [
            'verify' => true,
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Information model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $post = \yii::$app->request->post();
        if (\yii::$app->request->isAjax && $model->load($post)) {
            \yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }
        if ($model->load($post) && $model->save()) {
            return $this->redirect($model->getUrl());
        }
        $this->updateMenuItems($model);
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Information model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->delete();
        return $this->redirect([
            'index'
        ]);
    }

    public function actionClear($truncate = true)
    {
        $query = Information::find();
        foreach ($query->each() as $model) {
            $model->delete();
        }
        if ($truncate) {
            Information::truncate();
        }
        \Yii::$app->session->setFlash('success', 'Information Cleared !!!');
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the Information model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Information the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $accessCheck = true)
    {
        if (($model = Information::findOne($id)) !== null) {

            if ($accessCheck && ! ($model->isAllowed()))
                throw new HttpException(403, Yii::t('app', 'You are not allowed to access this page.'));

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function updateMenuItems($model = null)
    {
        switch (\Yii::$app->controller->action->id) {

            case 'add':
                {
                    $this->menu['manage'] = [
                        'label' => '<span class="glyphicon glyphicon-list"></span>',
                        'title' => Yii::t('app', 'Manage'),
                        'url' => [
                            'index'
                        ]
                        // 'visible' => User::isAdmin ()
                    ];
                }
                break;
            case 'index':
                {

                    $this->menu['clear'] = [
                        'label' => '<span class=" glyphicon glyphicon-remove"></span>',
                        'title' => Yii::t('app', 'Clear'),
                        'url' => [
                            'clear'
                        ],
                        'htmlOptions' => [
                            'data-confirm' => "Are you sure to delete all items?"
                        ],
                        'visible' => User::isAdmin()
                    ];
                }
                break;
            case 'update':
                {
                    $this->menu['add'] = [
                        'label' => '<span class="glyphicon glyphicon-plus"></span>',
                        'title' => Yii::t('app', 'add'),
                        'url' => [
                            'add'
                        ]
                        // 'visible' => User::isAdmin ()
                    ];
                    $this->menu['manage'] = [
                        'label' => '<span class="glyphicon glyphicon-list"></span>',
                        'title' => Yii::t('app', 'Manage'),
                        'url' => [
                            'index'
                        ]
                        // 'visible' => User::isAdmin ()
                    ];
                }
                break;
            default:
            case 'view':
                {
                    $this->menu['manage'] = [
                        'label' => '<span class="glyphicon glyphicon-list"></span>',
                        'title' => Yii::t('app', 'Manage'),
                        'url' => [
                            'index'
                        ]
                        // 'visible' => User::isAdmin ()
                    ];
                    if ($model != null) {

                        $this->menu['push'] = [
                            'label' => '<span class="glyphicon glyphicon-share"></span>',
                            'title' => Yii::t('app', 'SendToLeads'),
                            'url' => $model->getUrl('push'),
                            'visible' => User::isAdmin()
                        ];
                        $this->menu['delete'] = [
                            'label' => '<span class="glyphicon glyphicon-trash"></span>',
                            'title' => Yii::t('app', 'Delete'),
                            'url' => $model->getUrl('delete'),
                            'visible' => User::isAdmin()
                        ];
                    }
                }
        }
    }

    /**
     * actionMass delete in mass as items are checked
     *
     * @param string $action
     * @return string
     */
    public function actionMass($action = 'delete')
    {
        \Yii::$app->response->format = 'json';
        $response['status'] = 'NOK';
        $Ids = Yii::$app->request->post('ids', []);
        $status = Information::massDelete('delete');
        if ($status == true) {
            $response['status'] = 'OK';
        }
        return $response;
    }
}
