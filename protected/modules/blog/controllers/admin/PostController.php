<?php

/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\modules\blog\controllers\admin;

use Imagine\Image\ManipulatorInterface;
use app\components\TActiveForm;
use app\modules\blog\controllers\PostController as BasePost;
use app\models\User;
use app\modules\blog\models\Post;
use app\modules\blog\models\search\Post as PostSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\imagine\Image;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class PostController extends BasePost
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
                            'add',
                            'view',
                            'update',
                            'delete',
                            'ajax',
                            'image',
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
                            'index',
                            'add',
                            'view',
                            'update',
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

    /**
     * Lists all Blog models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (User::isGuest()) {
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

    /**
     * Displays a single Blog model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionImage($id, $file = null, $thumbnail = false)
    {
        $model = $this->findModel($id, false);
        $file = UPLOAD_PATH . $model->image_file;
        
        if (! is_file($file)) {
            
            throw new NotFoundHttpException(Yii::t('app', "File not found"));
        }
        if ($thumbnail) {
            $h = is_numeric($thumbnail) ? $thumbnail : 100;
            
            $thumb_path = UPLOAD_PATH . 'thumbnail_' . $model->image_file;
            $img = Image::thumbnail($file, $h, null, ManipulatorInterface::THUMBNAIL_INSET);
            $img->save($thumb_path);
            $file = $thumb_path;
        }
        return Yii::$app->response->sendFile($file);
    }

    public function actionView($id, $title = null)
    {
        $model = $this->findModel($id, false);
       
        if ($title == null)
            return $this->redirect($model->getUrl());
        
        $model->updateCounters([
            'view_count' => 1
        ]);
        
        $this->updateMenuItems($model);
        if (User::isGuest()) {
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
    
    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Blog the loaded model
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
                        $this->menu['index'] = array(
                            'label' => '<span class="glyphicon glyphicon-list"></span>',
                            'title' => Yii::t('app', 'Manage'),
                            'url' => [
                                'index'
                            ]
                            // 'visible' => User::isAdmin()
                        );
                    }
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
}