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
namespace app\modules\pms\controllers;

use Yii;
use app\modules\pms\models\RiskMatrix;
use app\modules\pms\models\search\RiskMatrix as RiskMatrixSearch;
use app\components\TController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\helpers\Url;
use app\models\User;
use yii\web\HttpException;
use app\components\TActiveForm;
use app\modules\pms\models\Project;
use app\components\TPdfWriter;
use yii\data\ActiveDataProvider;

/**
 * RiskMatrixController implements the CRUD actions for RiskMatrix model.
 */
class RiskMatrixController extends TController
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
                            'clone',
                            'ajax',
                            'mass',
                            'delete'
                        ],
                        'allow' => true,
                        'roles' => [
                            '@'
                        ]
                    ],
                    [
                        'actions' => [

                            'view'
                        ],
                        'allow' => true,
                        'roles' => [
                            '?',
                            '*'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all RiskMatrix models.
     *
     * @return mixed
     */
    public function actionIndex($id = null, $download = false, $print = false)
    {
        $searchModel = new RiskMatrixSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->updateMenuItems($searchModel);
        if (\yii::$app->request->isAjax && $id != null) {
            return $this->renderAjax('_ajax-grid', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'menu' => $this->menu['add']
            ]);
        }
        if ($print) {
            if (! User::isAdmin()) {
                $dataProvider->query->andWhere([
                    'project_id' => Yii::$app->request->queryParams['id'],
                    'created_by_id' => \Yii::$app->user->id
                ]);
            } else {
                $dataProvider->query->andWhere([
                    'project_id' => Yii::$app->request->queryParams['id']
                ]);
            }
            return $this->renderPartial('risk-report', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]);
        }
        if ($download) {
            $mpdf = new TPdfWriter();
            if (! User::isAdmin()) {
                $dataProvider->query->andWhere([
                    'project_id' => Yii::$app->request->queryParams['id'],
                    'created_by_id' => \Yii::$app->user->id
                ]);
            } else {
                $dataProvider->query->andWhere([
                    'project_id' => Yii::$app->request->queryParams['id']
                ]);
            }
            $mpdf->WriteHTML($this->renderPartial('risk-report', [
                'dataProvider' => $dataProvider
            ]));
            $filename = 'Report' . date('Y-m-d') . '.pdf';
            $mpdf->Output($filename, 'D');
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single RiskMatrix model.
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
     * Creates a new RiskMatrix model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionAdd($id)
    {
        $model = new RiskMatrix();
        $model->loadDefaultValues();

        if (is_numeric($id)) {
            $project = Project::findOne($id);
            if ($project == null) {
                throw new NotFoundHttpException('The requested project does not exist.');
            }
            $model->project_id = $project->id;
        }

        $model->checkRelatedData([
            'created_by_id' => User::class,
            'project_id' => Project::class
        ]);
        $post = \yii::$app->request->post();
        if (\yii::$app->request->isAjax && $model->load($post)) {
            \yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }
        if ($model->load($post)) {
            $model->project_id = $id;
            $model->state_id = $model->getRiskStatus();
            if ($model->save()) {
                return $this->redirect([
                    'project/view',
                    'id' => $id
                ]);
            }
        }
        $this->updateMenuItems();
        return $this->render('add', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing RiskMatrix model.
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
        if ($model->load($post)) {
            $model->state_id = $model->getRiskStatus();
            if ($model->save()) {
                return $this->redirect([
                    'project/view',
                    'id' => $model->project_id
                ]);
            }
        }
        $this->updateMenuItems($model);
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Clone an existing RiskMatrix model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionClone($id)
    {
        $old = $this->findModel($id);

        $model = new RiskMatrix();
        $model->loadDefaultValues();
        $model->state_id = RiskMatrix::STATE_ACTIVE;

        // $model->id = $old->id;
        $model->title = $old->title;
        $model->project_id = $old->project_id;
        $model->severity = $old->severity;
        $model->impact = $old->impact;
        $model->factor = $old->factor;
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
     * Deletes an existing RiskMatrix model.
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
                'project/view',
                'id' => $model->project_id
            ]);
        }
        return $this->render('delete', [
            'model' => $model
        ]);
    }

    public function actionAjax($type, $id, $function, $grid = '_ajax-grid', $addMenu = true, $action = null)
    {
        $model = $type::findOne([
            'id' => $id
        ]);
        if (! empty($model)) {
            
            if (! ($model->isAllowed()))
                // throw new \yii\web\HttpException(403, Yii::t('app', 'You are not allowed to access this page.'));
                exit();
                $function = 'get' . ucfirst($function);
                $query = $model->$function();
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                        'defaultOrder' => [
                            'id' => SORT_ASC
                        ]
                    ],
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ]);
                $menu = [];
                if ($model && $addMenu) {
                    
                    if ($action != null) {
                        if (strstr($action, '/')) {
                            $menu['url'] = Url::toRoute($action, [
                                'id' => $model->id
                            ]);
                        } else {
                            $menu['url'] = $model->getUrl($action);
                        }
                    } else {
                        $linkModel = new $query->modelClass();
                        $action = 'add';
                        $menu['url'] = $linkModel->getUrl($action, $model->id);
                    }
                    $menu['label'] = '<i class="fa fa-plus"></i> <span></span>';
                    $menu['htmlOptions'] = [
                        'class' => 'btn btn-success pull-right',
                        'title' => $action
                    ];
                }
                return $this->renderAjax($grid, [
                    'dataProvider' => $dataProvider,
                    'searchModel' => null,
                    'id' => $id,
                    'menu' => $menu
                ]);
        }
    }
    
    /**
     * Truncate an existing RiskMatrix model.
     * If truncate is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionClear($truncate = true)
    {
        $query = RiskMatrix::find();
        foreach ($query->each() as $model) {
            $model->delete();
        }
        if ($truncate) {
            RiskMatrix::truncate();
        }
        \Yii::$app->session->setFlash('success', 'RiskMatrix Cleared !!!');
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the RiskMatrix model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return RiskMatrix the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $accessCheck = true)
    {
        if (($model = RiskMatrix::findOne($id)) !== null) {

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
                    if (! empty(Yii::$app->request->queryParams['id'])) {
                        $this->menu['add'] = [
                            'label' => '<span class="glyphicon glyphicon-plus"></span>',
                            'title' => Yii::t('app', 'Add'),
                            'url' => [
                                'add',
                                'id' => Yii::$app->request->queryParams['id']
                            ]
                        ];
                    }
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
                        $this->menu['clone'] = array(
                            'label' => '<span class="glyphicon glyphicon-copy">Clone</span>',
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
