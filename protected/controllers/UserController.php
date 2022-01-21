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
namespace app\controllers;

use Imagine\Image\ManipulatorInterface;
use app\components\TActiveForm;
use app\components\TController;
use app\models\EmailQueue;
use app\models\LoginForm;
use app\models\User;
use app\models\search\User as UserSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\imagine\Image;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use app\modules\subscription\models\Plan;
use app\modules\subscription\models\Billing;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends TController
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
                            'view',
                            'logout',
                            'changepassword',
                            'profileImage',
                            'toggle',
                            'download',
                            'dashboard',
                            'recover',
                            'image-manager',
                            'image-upload',
                            'download-apk',
                            'theme-param',
                            'update',
                            'image',
                            'plan',
                            'image'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return User::isAdmin() || User::isManager() || User::isUser();
                        }
                    ],
                    [
                        'actions' => [
                            'index',
                            'add',
                            'shadow',
                            'view',
                            'update',
                            'delete',
                            'profileImage',
                            'clear',
                            'verify',
                            'image'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return User::isAdmin();
                        }
                    ],
                    [
                        'actions' => [
                            'index',
                            'add',
                            'view',
                            'update',
                            'changepassword',
                            'image'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return User::isManager();
                        }
                    ],
                    [
                        'actions' => [
                            'signup',
                            'image'
                        ],
                        'allow' => (! defined('ENABLE_ERP')) ? true : false,
                        'roles' => [
                            '?',
                            '*'
                        ]
                    ],
                    [
                        'actions' => [
                            'login',
                            'recover',
                            'resetpassword',
                            'profileImage',
                            'download',
                            'add-admin',
                            'image',
                            'confirm-email'
                        ],
                        'allow' => true,
                        'roles' => [
                            '?',
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
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction'
                // 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'image' => [
                'class' => 'app\components\actions\ImageAction',
                'modelClass' => User::class,
                'attribute' => 'profile_file',
                'default' => \Yii::$app->view->theme->basePath . '/img/default.jpg'
            ]
        ];
    }

    /**
     * Clear runtime and assets
     *
     * @return \yii\web\Response
     */
    public function actionClear()
    {
        $runtime = Yii::getAlias('@runtime');
        $this->cleanRuntimeDir($runtime);

        $this->cleanAssetsDir();
        return $this->goBack();
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->updateMenuItems();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single User model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $this->updateMenuItems($model);
        return $this->render('profile', [
            'model' => $model
        ]);
    }

    public function actionAddAdmin()
    {
        $this->layout = "login";
        $count = User::find()->count();
        if ($count != 0) {
            return $this->redirect([
                '/'
            ]);
        }
        $model = new User();
        $model->scenario = 'signup';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->role_id = User::ROLE_ADMIN;
            $model->state_id = User::STATE_ACTIVE;
            $model->full_name = $model->first_name . " " . $model->last_name;
            if ($model->validate()) {
                $model->setPassword($model->password);
                $model->generatePasswordResetToken();
                if ($model->save(false)) {
                    return $this->redirect([
                        'login'
                    ]);
                }
            }
        }
        return $this->render('signup', [
            'model' => $model
        ]);
    }

    public function actionVerify($id)
    {
        if (! empty($id)) {
            $model = $this->findModel($id);

            if ($model->is_verify == User::STATE_INACTIVE) {
                $model->is_verify = User::STATE_ACTIVE;
                Yii::$app->getSession()->setFlash('success', 'User Verified Successfully.');
            } else {
                $model->is_verify = User::STATE_INACTIVE;
                Yii::$app->getSession()->setFlash('success', 'User UnVerified Successfully.');
            }
            if ($model->updateAttributes([
                'is_verify'
            ])) {}
        }

        return $this->render('profile', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionAdd()
    {
        $this->layout = 'main';
        $model = new User();
        $model->role_id = User::ROLE_USER;
        $model->state_id = User::STATE_ACTIVE;
        $model->scenario = 'add';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->state_id = User::STATE_ACTIVE;
            $model->full_name = $model->first_name . " " . $model->last_name;
            $image = UploadedFile::getInstance($model, 'profile_file');
            if (! empty($image)) {
                $image->saveAs(UPLOAD_PATH . $image->baseName . '.' . $image->extension);
                $model->profile_file = $image->baseName . '.' . $image->extension;

                Yii::$app->getSession()->setFlash('success', 'User Added Successfully.');
            }
            if ($model->validate()) {
                $model->generatePasswordResetToken();
                $model->setPassword($model->password);
                $model->last_action_time = date('Y-m-d H:i:s');
                if ($model->save()) {
                    $bill = Plan::find()->where([
                        'title' => 'Basic'
                    ])->one();
                    $billing = new Billing();
                    $billing->state_id = Billing::STATE_ACTIVE;
                    $billing->subscription_id = $bill->id;
                    $billing->type_id = Billing::STATE_ACTIVE;
                    $billing->created_by_id = $model->id;
                    $billing->end_date = date('Y-m-d', strtotime('+7 days'));
                    if (! $billing->save()) {
                        \Yii::$app->getSession()->setFlash('info', "something went wrong");
                    }
                    $model->sendRegistrationMailtoAdmin();
                    $model->sendVerificationMailtoUser();
                    Yii::$app->getSession()->setFlash('success', ' User Added Successfully.');
                    return $this->redirect([
                        'view',
                        'id' => $model->id
                    ]);
                }
            }
        }
        $this->updateMenuItems($model);
        return $this->render('add', [
            'model' => $model
        ]);
    }

    public function actionRecover()
    {
        $this->layout = 'login';
        $model = new User();
        $model->scenario = 'token_request';
        if (isset($_POST['User'])) {
            $email = trim($_POST['User']['email']);
            if ($email != null) {

                $user = User::findOne([
                    'email' => $email
                ]);
                if ($user) {
                    $user->generatePasswordResetToken();
                    if (! $user->save()) {
                        throw new HttpException("Cant Generate Authentication Key");
                    }
                    $email = $user->email;
                    $sub = "Recover Your Account at: " . \Yii::$app->params['company'];
                    EmailQueue::add([
                        'from' => \Yii::$app->params['adminEmail'],
                        'to' => $email,
                        'subject' => $sub,
                        'html' => \yii::$app->view->renderFile('@app/mail/passwordResetToken.php', [
                            'user' => $user
                        ])
                    ]);

                    \Yii::$app->session->setFlash('success', 'Please check your email to reset your password.');
                } else {

                    \Yii::$app->session->setFlash('error', 'Email is not registered.');
                }
            } else {
                $model->addError('email', 'Email cannot be blank');
            }
        }
        $this->updateMenuItems($model);
        return $this->render('requestPasswordResetToken', [
            'model' => $model
        ]);
    }

    public function actionResetpassword($token)
    {
        $this->layout = 'login';
        $model = User::findByPasswordResetToken($token);
        if (! ($model)) {
            \Yii::$app->session->setFlash('error', \Yii::t('app', 'This URL is expired.'));
            return $this->redirect([
                'user/recover'
            ]);
        }
        $newModel = new User([
            'scenario' => 'resetpassword'
        ]);
        if ($newModel->load(Yii::$app->request->post()) && $newModel->validate()) {

            $model->setPassword($newModel->password);
            $model->removePasswordResetToken();
            $model->generateAuthKey();
            $model->last_password_change = date('Y-m-d H:i:s');

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'New password is saved successfully.'));
                return $this->redirect([
                    '/user/login'
                ]);
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error while saving new password.'));
            }
        }
        $this->updateMenuItems($model);
        return $this->render('resetpassword', [
            'model' => $newModel
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'main';
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $post = \yii::$app->request->post();
        $old_image = $model->profile_file;
        $password = $model->password;

        if (Yii::$app->request->isAjax && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }

        if ($model->load($post)) {
            if (! empty($post['User']['password']))
                $model->setPassword($post['User']['password']);
            else
                $model->password = $password;
            $model->profile_file = $old_image;
            $model->saveUploadedFile($model, 'profile_file');
            if ($model->save())
                return $this->redirect($model->getUrl());
        }

        $model->password = '';
        $this->updateMenuItems($model);
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->updateMenuItems($model);

        if (\Yii::$app->user->id == $model->id) {
            \Yii::$app->session->setFlash('user-action-error', 'You are not allowed to perform this operation.');
            return $this->goBack();
        }

        $model->delete();
        return $this->redirect([
            'index'
        ]);
    }

    public function actionMass($action = 'delete')
    {
        \Yii::$app->response->format = 'json';
        $response['status'] = 'NOK';
        $Ids = Yii::$app->request->post('ids');
        foreach ($Ids as $Id) {
            $model = $this->findModel($Id);

            if ($action == 'delete') {
                if (! $model->delete()) {
                    return $response['status'] = 'NOK';
                }
            }
        }

        $response['status'] = 'OK';

        return $response;
    }

    public function actionSignup()
    {
        $this->layout = "login";
        $model = new User([
            'scenario' => 'signup'
        ]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->scenario = 'signup';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->state_id = User::STATE_ACTIVE;
            $model->role_id = User::ROLE_USER;
            $model->full_name = $model->first_name . " " . $model->last_name;
            if ($model->validate()) {
                $model->scenario = 'add';
                $model->setPassword($model->password);
                $model->generatePasswordResetToken();
                $model->last_action_time = date('Y-m-d H:i:s');
                $model->state_id = User::STATE_ACTIVE;
                $model->role_id = User::ROLE_USER;
                if ($model->save()) {
                    $bill = Plan::find()->where([
                        'title' => 'Basic'
                    ])->one();
                    $billing = new Billing();
                    $billing->state_id = Billing::STATE_ACTIVE;
                    $billing->subscription_id = $bill->id;
                    $billing->type_id = Billing::STATE_ACTIVE;
                    $billing->created_by_id = $model->id;
                    $billing->end_date = date('Y-m-d', strtotime('+7 days'));
                    if (! $billing->save()) {
                        \Yii::$app->getSession()->setFlash('info', "something went wrong");
                    }
                    $model->sendRegistrationMailtoAdmin();
                    $model->sendVerificationMailtoUser();
                    \Yii::$app->getSession()->setFlash('success', "Please check your email to verify.");
                    return $this->redirect([
                        'user/login'
                    ]);
                }
            }
        }
        return $this->render('signup', [
            'model' => $model
        ]);
    }

    public function actionLogin()
    {
        $this->layout = "login";

        if (! \Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // TODO: change redirect to return url

            if (empty(\Yii::$app->user->identity->plan) && User::isUser())
                return $this->redirect([
                    'user/plan'
                ]);

            return $this->goBack([
                'pms/project'
            ]);
        }
        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionProfileImage()
    {
        return Yii::$app->user->identity->getProfileImage();
    }

    public function actionLogout()
    {
        $socialUser = \app\modules\social\models\User::find()->where([
            'user_id' => Yii::$app->user->id
        ])->one();

        if (! empty($socialUser)) {

            $socialUser->delete();
        }

        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionChangepassword($id)
    {
        $this->layout = 'main';
        $model = $this->findModel($id);
        if (! ($model->isAllowed()))
            throw new \yii\web\HttpException(403, Yii::t('app', 'You are not allowed to access this page.'));

        $newModel = new User([
            'scenario' => 'changepassword'
        ]);
        if (Yii::$app->request->isAjax && $newModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';
            return TActiveForm::validate($newModel);
        }
        if ($newModel->load(Yii::$app->request->post()) && $newModel->validate()) {
            $model->setPassword($newModel->newPassword);
            $model->last_password_change = date('Y-m-d H:i:s');
            $model->generateAuthKey();
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Password Changed');
                return $this->redirect([
                    'dashboard/index'
                ]);
            } else {
                \Yii::$app->getSession()->setFlash('error', "Error !!" . $model->getErrorsString());
            }
        }
        $this->updateMenuItems($model);
        return $this->render('changepassword', [
            'model' => $newModel
        ]);
    }

    public function actionImage($id, $file = null, $thumbnail = false)
    {
        $model = User::findOne($id);

        if (empty($model))
            throw new NotFoundHttpException('The requested page does not exist.');
        $file = UPLOAD_PATH . $model->profile_file;

        if (! is_file($file)) {

            $file = Yii::$app->view->theme->basePath . '/admin/img/default.jpg';
        }
        if ($thumbnail) {
            $h = is_numeric($thumbnail) ? $thumbnail : 100;

            $thumb_path = UPLOAD_PATH . $model->image_file;
            $img = Image::thumbnail($file, $h, null);
            $img->save($thumb_path);
            $file = $thumb_path;
        }
        return Yii::$app->response->sendFile($file);
    }

    public function actionPlan()
    {
        $user = Yii::$app->user->identity;
        $plans = Plan::findActive();
        return $this->render('plans', [
            'user' => $user,
            'plans' => $plans
        ]);
    }

    public function actionDownloadApk()
    {
        /*
         * $model = User::findOne ( [
         * 'profile_file' => $profile_file
         * ] );
         */
        $file = UPLOAD_PATH . '../../apk/ji_talent_app.apk';

        if (file_exists($file)) {
            Yii::$app->response->sendFile($file);
        }
    }

    public function actionThemeParam()
    {
        $is_collapsed = Yii::$app->session->get('is_collapsed', 'sidebar-collapsed');
        $is_collapsed = empty($is_collapsed) ? 'sidebar-collapsed' : '';
        Yii::$app->session->set('is_collapsed', $is_collapsed);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {

            if (! ($model->isAllowed()))
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
                    $this->menu['manage'] = array(
                        'label' => '<span class="glyphicon glyphicon-list"></span>',
                        'title' => Yii::t('app', 'Manage'),
                        'url' => [
                            'index'
                        ],
                        'visible' => User::isAdmin()
                    );
                }
                break;

            case 'index':
                {
                    $this->menu['add'] = [
                        'label' => '<span class="glyphicon glyphicon-plus"></span>',
                        'title' => Yii::t('app', 'Add'),
                        'url' => [
                            'add'
                        ]
                        // 'visible' => User::isAdmin ()
                    ];
                    $this->menu['clear'] = [
                        'label' => '<span class="glyphicon glyphicon-remove"></span>',
                        'title' => Yii::t('app', 'Clear'),
                        'url' => [
                            'clear'
                        ],
                        'htmlOptions' => [
                            'data-confirm' => "Are you sure to delete these items?"
                        ],
                        'visible' => User::isAdmin()
                    ];
                }
                break;
            default:
            case 'view':

                if ($model != null && $model->id != 1)
                    $this->menu['shadow'] = array(
                        'label' => '<span class="glyphicon glyphicon-refresh ">Shadow</span>',
                        'title' => Yii::t('app', 'Login as ' . $model),
                        'url' => [
                            '/shadow/session/login',
                            'id' => $model->id
                        ],
                    /* 'htmlOptions'=>[], */
                    'visible' => User::isManager()
                    );

                $this->menu['add'] = array(
                    'label' => '<span class="glyphicon glyphicon-plus"></span>',
                    'title' => Yii::t('app', 'Add'),
                    'url' => [
                        'add'
                    ],
                    'visible' => User::isManager()
                );

                if ($model != null)
                    $this->menu['changepassword'] = array(
                        'label' => '<span class="glyphicon glyphicon-paste"></span>',
                        'title' => Yii::t('app', 'changepassword'),
                        'url' => [
                            'changepassword',
                            'id' => $model->id
                        ],

                        'visible' => User::isManager()
                    );
                if ($model != null)
                    $this->menu['update'] = array(
                        'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                        'title' => Yii::t('app', 'Update'),
                        'url' => [
                            'update',
                            'id' => $model->id
                        ],

                        'visible' => User::isManager()
                    );

                $this->menu['manage'] = array(
                    'label' => '<span class="glyphicon glyphicon-list"></span>',
                    'title' => Yii::t('app', 'Manage'),
                    'url' => [
                        'index'
                    ],
                    'visible' => User::isManager()
                );
                if ($model != null)
                    $this->menu['delete'] = array(
                        'label' => '<span class="glyphicon glyphicon-trash"></span>',
                        'title' => Yii::t('app', 'Delete'),
                        'url' => [
                            'delete',
                            'id' => $model->id
                        ],

                        'visible' => User::isAdmin()
                    );
        }
    }

    public function actionGetLocation($id)
    {
        \Yii::$app->response->format = 'json';
        $response = [
            'status' => 'NOK'
        ];
        $query = User::findOne($id);
        $response['status'] = "OK";
        $response['detail'] = $query;
        return $response;
    }

    public function actionConfirmEmail($id)
    {
        $user = User::find()->where([
            'activation_key' => $id
        ])->one();
        if (! empty($user)) {

            $user->email_verified = User::EMAIL_VERIFIED;
            $user->state_id = User::STATE_ACTIVE;
            if ($user->save()) {
                \Yii::$app->cache->flush();
                $user->refresh();
                if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
                    \Yii::$app->getSession()->setFlash('success', 'Congratulations! your email is verified');
                    return $this->redirect([
                        '/pms/project'
                    ]);
                }
            }
        }
        \Yii::$app->getSession()->setFlash('expired', 'Token is Expired Please Resend Again');
        return $this->goBack([
            '/'
        ]);
    }
}
