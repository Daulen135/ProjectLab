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
use app\modules\pms\models\Project;
use app\modules\pms\models\search\Project as ProjectSearch;
use app\components\TController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use app\models\User;
use yii\web\HttpException;
use app\components\TActiveForm;
use app\modules\pms\models\Milestone;
use app\modules\pms\models\Deliverable;
use yii\helpers\VarDumper;
use app\modules\pms\models\SuccessCriteria;
use app\modules\pms\models\search\Task;
use app\modules\pms\models\search\OpexBudget;
use app\components\TPdfWriter;
use app\modules\pms\models\RiskMatrix;
use app\models\Feed;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends TController
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
                            'my',
                            'delete',
                            'capex',
                            'plan',
                            'download-pdf'
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
     * Lists all Project models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->updateMenuItems();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCapex($id = null, $download = false, $print = false)
    {
        $searchModel = new Task();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (! User::isAdmin()) {
            $dataProvider->query->andWhere([
                'project_id' => $id,
                'created_by_id' => Yii::$app->user->id
            ]);
        } else {
            $dataProvider->query->andWhere([
                'project_id' => $id
            ]);
        }
        $searchOpexModel = new OpexBudget();
        $opexDataProvider = $searchOpexModel->search(Yii::$app->request->queryParams, $id);
        if (! User::isAdmin()) {
            $opexDataProvider->query->andWhere([
                'created_by_id' => Yii::$app->user->id
            ]);
        }
        $this->updateMenuItems();

        if ($print) {
            return $this->renderPartial('capex-report', [
                'dataProvider' => $dataProvider,
                'opexDataProvider' => $opexDataProvider
            ]);
        }

        if ($download) {
            $mpdf = new TPdfWriter();
            $mpdf->WriteHTML($this->renderPartial('capex-report', [
                'dataProvider' => $dataProvider,
                'opexDataProvider' => $opexDataProvider
            ]));
            $filename = 'Report' . date('Y-m-d') . '.pdf';
            $mpdf->Output($filename, 'D');
        }
        return $this->render('_capex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'opexDataProvider' => $opexDataProvider
        ]);
    }

    public function actionPlan($id, $download = false, $print = false)
    {
        $model = $this->findModel($id);
        if ($print) {
            return $this->renderPartial('schedule-report', [
                'model' => $model
            ]);
        }
        if ($download) {
            $mpdf = new TPdfWriter();
            $mpdf->WriteHTML($this->renderPartial('schedule-report', [
                'model' => $model
            ]));
            $filename = 'Report' . date('Y-m-d') . '.pdf';
            $mpdf->Output($filename, 'D');
        }
    }

    /**
     * Displays a single Project model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $download = false, $print = false)
    {
        $model = $this->findModel($id);
        $this->updateMenuItems($model);
        if ($print) {
            return $this->renderPartial('passport-report', [
                'model' => $model
            ]);
        }
        if ($download) {
            $mpdf = new TPdfWriter();
            $mpdf->WriteHTML($this->renderPartial('passport-report', [
                'model' => $model
            ]));
            $filename = 'Report' . date('Y-m-d') . '.pdf';
            $mpdf->Output($filename, 'D');
        }
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionAdd(/* $id*/)
    {
        $model = new Project();
        $model->loadDefaultValues();
        $model->state_id = Project::STATE_PLANNING;
        $milestone = new Milestone();
        $deliverable = new Deliverable();
        $success = new SuccessCriteria();
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
        if ($model->load($post) && $milestone->load($post) && $deliverable->load($post) && $success->load($post)) {
            if ($model->save()) {

                $deliver = $post['Deliverable']['title'];

                foreach ($deliver as $title) {

                    $deliverableModel = new Deliverable();
                    $deliverableModel->title = $title;
                    $deliverableModel->project_id = $model->id;
                    $deliverableModel->save();
                }

                $data = $post['Milestone']['title'];

                foreach ($data as $milestoneData) {
                    $milestoneModel = new Milestone();
                    $milestoneModel->title = $milestoneData['title'];
                    $milestoneModel->end_date = $milestoneData['end_date'];
                    $milestoneModel->project_id = $model->id;
                    $milestoneModel->save();
                }

                $criteria = $post['SuccessCriteria']['title'];

                foreach ($criteria as $title) {

                    $criteriaModel = new SuccessCriteria();
                    $criteriaModel->title = $title;
                    $criteriaModel->project_id = $model->id;
                    $criteriaModel->created_on = $model->created_on;
                    $criteriaModel->created_by_id = $model->created_by_id;
                    $criteriaModel->save();
                }

                return $this->redirect($model->getUrl());
            }
        }
        $this->updateMenuItems();
        return $this->render('add', [
            'model' => $model,
            'milestone' => $milestone,
            'deliverable' => $deliverable,
            'success' => $success
        ]);
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $milestone = new Milestone();
        $deliverable = new Deliverable();
        $success = new SuccessCriteria();
        $post = \yii::$app->request->post();
        if (\yii::$app->request->isAjax && $model->load($post)) {
            \yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }
        if ($model->load($post) && $milestone->load($post) && $deliverable->load($post) && $success->load($post)) {

            if ($model->save()) {
                $deliver = $post['Deliverable']['title'];
                if (! empty($deliver)) {
                    Deliverable::deleteAll([
                        'project_id' => $model->id
                    ]);

                    foreach ($deliver as $title) {

                        $deliverableModel = new Deliverable();
                        $deliverableModel->title = $title;
                        $deliverableModel->project_id = $model->id;
                        $deliverableModel->save();
                    }
                }
                $data = $post['Milestone']['title'];
                if (! empty($data)) {
                    Milestone::deleteAll([
                        'project_id' => $model->id
                    ]);

                    foreach ($data as $milestoneData) {
                        $milestoneModel = new Milestone();
                        $milestoneModel->title = $milestoneData['title'];
                        $milestoneModel->end_date = $milestoneData['end_date'];
                        $milestoneModel->project_id = $model->id;
                        $milestoneModel->save();
                    }
                }
                $criteria = $post['SuccessCriteria']['title'];
                if (! empty($criteria)) {
                    SuccessCriteria::deleteAll([
                        'project_id' => $model->id
                    ]);

                    foreach ($criteria as $title) {

                        $criteriaModel = new SuccessCriteria();
                        $criteriaModel->title = $title;
                        $criteriaModel->project_id = $model->id;
                        $criteriaModel->created_on = $model->created_on;
                        $criteriaModel->created_by_id = $model->created_by_id;
                        $criteriaModel->save();
                    }
                }
            }
            return $this->redirect($model->getUrl());
        }
        $this->updateMenuItems($model);
        return $this->render('update', [
            'model' => $model,
            'milestone' => $milestone,
            'deliverable' => $deliverable,
            'success' => $success
        ]);
    }

    /**
     * Clone an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionClone($id)
    {
        $old = $this->findModel($id);

        $model = new Project();
        $model->loadDefaultValues();
        $model->state_id = Project::STATE_PLAN;

        $model->title = $old->title;
        $model->description = $old->description;
        $model->manager_name = $old->manager_id;
        $model->client_name = $old->client_name;
        $model->start_date = $old->start_date;
        $model->end_date = $old->end_date;
        $model->type_id = $old->type_id;

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
     * Deletes an existing Project model.
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
     * Truncate an existing Project model.
     * If truncate is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionClear($truncate = true)
    {
        $query = Project::find();
        foreach ($query->each() as $model) {
            $model->delete();
        }
        if ($truncate) {
            Project::truncate();
        }
        \Yii::$app->session->setFlash('success', 'Project Cleared !!!');
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $accessCheck = true)
    {
        if (($model = Project::findOne($id)) !== null) {

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
                        'label' => '<span class="glyphicon glyphicon-list text-white"></span>',
                        'title' => Yii::t('app', 'Manage'),
                        'url' => [
                            'index'
                        ]
                        // 'visible' => User::isAdmin ()
                    ];
                }
                break;
            case 'capex':
                {
                    $opexBudgetModel = OpexBudget::find()->where([
                        'project_id' => Yii::$app->request->queryParams['id'],
                        'created_by_id' => Yii::$app->user->id
                    ])->one();
                    if (empty($opexBudgetModel)) {
                        $this->menu['capex'] = [
                            'label' => '<span class="glyphicon glyphicon-plus text-white"></span>',
                            'title' => Yii::t('app', 'Add'),
                            'url' => [
                                'opex-budget/add',
                                'id' => \Yii::$app->request->get('id')
                            ],
                        ];
                    }
                }
                break;
            case 'index':
                {
                    $this->menu['add'] = [
                        'label' => '<span class="glyphicon glyphicon-plus text-white"></span>',
                        'title' => Yii::t('app', 'Add'),
                        'url' => [
                            'add'
                        ]
                        // 'visible' => User::isAdmin ()
                    ];
                    $this->menu['clear'] = [
                        'label' => '<span class="glyphicon glyphicon-remove text-white"></span>',
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
                        'label' => '<span class="glyphicon glyphicon-plus text-white"></span>',
                        'title' => Yii::t('app', 'add'),
                        'url' => [
                            'add'
                        ]
                        // 'visible' => User::isAdmin ()
                    ];
                    $this->menu['manage'] = [
                        'label' => '<span class="glyphicon glyphicon-list text-white"></span>',
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
                    if ($model != null) {

                        $this->menu['update'] = [
                            'label' => '<span class="glyphicon glyphicon-pencil text-white"></span>',
                            'title' => Yii::t('app', 'Update'),
                            'url' => $model->getUrl('update')
                            // 'visible' => User::isAdmin ()
                        ];
                        $this->menu['delete'] = [
                            'label' => '<span class="glyphicon glyphicon-trash text-white"></span>',
                            'title' => Yii::t('app', 'Delete'),
                            'url' => $model->getUrl('delete')
                            // 'visible' => User::isAdmin ()
                        ];
                    }
                }
        }
    }
}
