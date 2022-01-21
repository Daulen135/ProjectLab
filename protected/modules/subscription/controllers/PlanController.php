<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author    : Shiv Charan Panjeta < shiv@toxsl.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 *
 */
namespace app\modules\subscription\controllers;

use app\components\TActiveForm;
use app\components\TController;
use app\models\User;
use app\modules\subscription\models\Plan;
use app\modules\subscription\models\search\Plan as PlanSearch;
use app\modules\translator\widget\TranslatorWidget;
use Yii;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * PlanController implements the CRUD actions for Plan model.
 */
class PlanController extends TController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className()
                ],
                'rules' => [
                    [
                        'actions' => [
                            'clear',
                            'delete'
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
                            'clone',
                            'ajax',
                            'mass'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return User::isManager();
                        }
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Plan models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->updateMenuItems();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Plan model.
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
     * Creates a new Plan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionAdd(/* $id*/)
    {
        $model = new Plan();
        $model->loadDefaultValues();
        $model->state_id = Plan::STATE_ACTIVE;

        /*
         * if (is_numeric($id)) {
         * $post = Post::findOne($id);
         * if ($post == null)
         * {
         * throw new NotFoundHttpException('The requested post does not exist.');
         * }
         * $model->id = $id;
         *
         * }
         */

        $model->checkRelatedData([
            'created_by_id' => User::class
        ]);
        $post = \yii::$app->request->post();
        if (\yii::$app->request->isAjax && $model->load($post)) {
            \yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }
        if ($model->load($post) && $model->save()) {
            TranslatorWidget::widget([
                'type' => TranslatorWidget::TYPE_SAVE,
                'model' => $model,
                'dataAttribute' => [
                    'title',
                    'description',
                    'big_text'
                ]
            ]);
            return $this->redirect($model->getUrl());
        }
        $this->updateMenuItems();
        return $this->render('add', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Plan model.
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
            TranslatorWidget::widget([
                'type' => TranslatorWidget::TYPE_SAVE,
                'model' => $model,
                'dataAttribute' => [
                    'title',
                    'description',
                    'big_text'
                ]
            ]);
            return $this->redirect($model->getUrl());
        }
        $this->updateMenuItems($model);
        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionMass($action = 'delete')
    {
        \Yii::$app->response->format = 'json';
        $response['status'] = 'NOK';
        $status = Plan::massDelete('delete');
        if ($status == true) {
            $response['status'] = 'OK';
        }
        return $response;
    }

    /**
     * Clone an existing Plan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionClone($id)
    {
        $old = $this->findModel($id);

        $model = new Plan();
        $model->loadDefaultValues();
        $model->state_id = Plan::STATE_ACTIVE;

        // $model->id = $old->id;
        $model->title = $old->title;
        $model->description = $old->description;
        $model->validity = $old->validity;
        $model->price = $old->price;
        // $model->state_id = $old->state_id;
        $model->type_id = $old->type_id;
        // $model->created_on = $old->created_on;
        // $model->created_by_id = $old->created_by_id;

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
     * Deletes an existing Plan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (\yii::$app->request->post()) {
            $model->delete();
            return $this->redirect([
                'index'
            ]);
        }
        return $this->render('delete', [
            'model' => $model
        ]);
    }

    /**
     * Truncate an existing Plan model.
     * If truncate is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionClear($truncate = true)
    {
        $query = Plan::find();
        foreach ($query->each() as $model) {
            $model->delete();
        }
        if ($truncate) {
            Plan::truncate();
        }
        \Yii::$app->session->setFlash('success', 'Plan Cleared !!!');
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the Plan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Plan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $accessCheck = true)
    {
        if (($model = Plan::findOne($id)) !== null) {

            if ($accessCheck && ! ($model->isAllowed()))
                throw new HttpException(403, Yii::t('app', 'You are not allowed to access this page.'));

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function updateMenuItems($model = null)
    {
        $advance_plan = Plan::find()->where([
            'state_id' => Plan::STATE_ACTIVE
        ])->one();
        switch (\Yii::$app->controller->action->id) {

            case 'add':
                {
                    $this->menu['manage'] = [
                        'label' => '<span class="glyphicon glyphicon-list"></span>',
                        'title' => Yii::t('app', 'Manage'),
                        'url' => [
                            'index'
                        ],
                        'visible' => User::isAdmin()
                    ];
                }
                break;
            case 'index':
                {
                    $this->menu['add'] = [
                        'label' => '<span class="glyphicon glyphicon-plus"></span>',
                        'title' => Yii::t('app', 'Add'),
                        'url' => [
                            'add'
                        ],
                        'visible' => (empty($advance_plan)) ? true : false
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
            case 'update':
                {
                    $this->menu['add'] = [
                        'label' => '<span class="glyphicon glyphicon-plus"></span>',
                        'title' => Yii::t('app', 'add'),
                        'url' => [
                            'add'
                        ],
                        'visible' => (empty($advance_plan)) ? true : false
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
                        $this->menu['clone'] = array(
                            'label' => '<span class="glyphicon glyphicon-copy">' . Yii::t('app', 'Clone') . '</span>',
                            'title' => Yii::t('app', 'Clone'),
                            'url' => $model->getUrl('clone')
                            // 'visible' => User::isAdmin ()
                        );
                        $this->menu['update'] = [
                            'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                            'title' => Yii::t('app', 'Update'),
                            'url' => $model->getUrl('update')
                            // 'visible' => User::isAdmin ()
                        ];
                        $this->menu['delete'] = [
                            'label' => '<span class="glyphicon glyphicon-trash"></span>',
                            'title' => Yii::t('app', 'Delete'),
                            'url' => $model->getUrl('delete')
                            // 'visible' => User::isAdmin ()
                        ];
                    }
                }
        }
    }
}
