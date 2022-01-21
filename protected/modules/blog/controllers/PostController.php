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
namespace app\modules\blog\controllers;

use app\components\TActiveForm;
use app\components\TController;
use app\models\User;
use app\modules\blog\models\Post;
use app\modules\blog\models\search\Post as PostSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class PostController extends TController
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
                            'clear'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return User::isAdmin();
                        }
                    ],
                    [
                        'actions' => [
                            'add',
                            'update'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return User::isManager();
                        }
                    ],
                    [
                        'actions' => [
                            'index',
                            'view',
                            'ajax',
                            'image'
                        ],
                        'allow' => true,
                        'roles' => [

                            '@'
                        ]
                    ],
                    [
                        'actions' => [

                            'view',
                            'index',
                            'image'
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

            'image' => [
                'class' => 'app\components\actions\ImageAction',
                'modelClass' => Post::class
            ]
        ];
    }

    /**
     * Lists all Blog models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (User::isGuest()|| !User::isManager()) {
            $this->layout = 'guest-main';
            $searchModel = new PostSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->pagination->pageSize = 8;
            $recent = Post::find()->where([
                'state_id' => User::STATE_ACTIVE
            ])
                ->orderBy('id desc')
                ->limit(5)
                ->all();
            return $this->render('guest_view', [
                'listDataProvider' => $dataProvider,
                'recent' => $recent,
                'searchModel' => $searchModel
            ]);
        } else {
            $searchModel = new PostSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $this->updateMenuItems();
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]);
        }
    }

    public function actionView($id, $title = null)
    {
        $model = $this->findModel($id, false);

        if ($title == null) {
            return $this->redirect($model->getUrl());
        }

        if (! $model->isActive() && ! User::isManager()) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->updateCounters([
            'view_count' => 1
        ]);

        $this->updateMenuItems($model);
        if (User::isGuest() || !User::isManager()) {
            $this->layout = 'guest-main';
            return $this->render('blog_detail', [
                'model' => $model
            ]);
        } else {
          
                $this->layout = 'main';
                return $this->render('view', [
                    'model' => $model
                ]);          
            }       
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionAdd()
    {
        $model = new Post();
        $model->loadDefaultValues();
        $model->checkRelatedData([
            'type_id' => 'app\modules\blog\models\Category'
        ]);
        $model->state_id = Post::STATE_ACTIVE;
        $post = \yii::$app->request->post();
        if (\yii::$app->request->isAjax && $model->load($post)) {
            \yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }
        if ($model->load($post) && $model->validate()) {
            $model->saveUploadedFile($model, 'image_file');
            if ($model->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Blog Created Successfully');
                return $this->redirect($model->getUrl());
            }
        }
        $this->updateMenuItems($model);
        return $this->render('add', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Blog model.
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
        $old_image = $model->image_file;
        if ($model->load($post) && $model->validate()) {
            $model->saveUploadedFile($model, 'image_file', $old_image);

            if ($model->save()) {

                return $this->redirect([
                    'view',
                    'id' => $model->id
                ]);
            }
        }
        $this->updateMenuItems($model);
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Blog model.
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
        $query = Post::find();
        foreach ($query->each() as $model) {
            $model->delete();
        }
        if ($truncate) {
            Post::truncate();
        }
        \Yii::$app->session->setFlash('success', 'Post Cleared !!!');
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $isAllowed = true)
    {
        if (($model = Post::findOne($id)) !== null) {

            if ($isAllowed == true && ! ($model->isAllowed()))
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
                    $this->menu['index'] = array(
                        'label' => '<span class="glyphicon glyphicon-list"></span>',
                        'title' => Yii::t('app', 'Manage'),
                        'url' => [
                            'index'
                        ]
                        // 'visible' => User::isAdmin()
                    );
                }
                break;
            case 'index':
                {
                    $this->menu['add'] = array(
                        'label' => '<span class="glyphicon glyphicon-plus"></span>',
                        'title' => Yii::t('app', 'Add'),
                        'url' => [
                            'add'
                        ]
                        // 'visible' => User::isAdmin()
                    );

                    {
                        $this->menu['clear'] = array(
                            'label' => '<span class=" glyphicon glyphicon-remove"></span>',
                            'title' => Yii::t('app', 'Clear'),
                            'url' => [
                                'clear'
                            ],
                            'htmlOptions' => [
                                'data-confirm' => "Are you sure to delete all items?"
                            ],
                            'visible' => User::isAdmin()
                        );
                    }
                }
                break;
            case 'update':
                {
                    $this->menu['add'] = array(
                        'label' => '<span class="glyphicon glyphicon-plus"></span>',
                        'title' => Yii::t('app', 'Add'),
                        'url' => [
                            'add'
                        ]
                        // 'visible' => User::isAdmin()
                    );
                    $this->menu['index'] = array(
                        'label' => '<span class="glyphicon glyphicon-list"></span>',
                        'title' => Yii::t('app', 'Manage'),
                        'url' => [
                            'index'
                        ]
                        // 'visible' => User::isAdmin()
                    );
                    if ($model != null)
                        $this->menu['delete'] = array(
                            'label' => '<span class="glyphicon glyphicon-trash"></span>',
                            'title' => Yii::t('app', 'Delete'),
                            'url' => [
                                'delete',
                                'id' => $model->id
                            ],
                            'htmlOptions' => [
                                'data-method' => 'post'
                            ]
                            // 'visible' => User::isAdmin()
                        );
                }
                break;
            case 'view':
                {
                    $this->menu['add'] = array(
                        'label' => '<span class="glyphicon glyphicon-plus"></span>',
                        'title' => Yii::t('app', 'Add'),
                        'url' => [
                            'add'
                        ],
                        'visible' => User::isAdmin()
                    );
                    if ($model != null)
                        $this->menu['update'] = array(
                            'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                            'title' => Yii::t('app', 'Update'),
                            'url' => [
                                'update',
                                'id' => $model->id
                            ],

                            'visible' => User::isAdmin()
                        );
                    $this->menu['index'] = array(
                        'label' => '<span class="glyphicon glyphicon-list"></span>',
                        'title' => Yii::t('app', 'Manage'),
                        'url' => [
                            'index'
                        ],
                        'visible' => User::isAdmin()
                    );
                    if ($model != null)
                        $this->menu['delete'] = array(
                            'label' => '<span class="glyphicon glyphicon-trash"></span>',
                            'title' => Yii::t('app', 'Delete'),
                            'url' => [
                                'delete',
                                'id' => $model->id
                            ],
                            'htmlOptions' => [
                                'data-method' => 'post'
                            ],
                            'visible' => User::isAdmin()
                        );
                }

                break;
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
        $status = Post::massDelete('delete');
        if ($status == true) {
            $response['status'] = 'OK';
        }
        return $response;
    }
}