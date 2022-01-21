<?php

/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author    : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\modules\payment\controllers;

use app\components\TController;
use app\models\User;
use app\modules\payment\models\Transaction;
use app\modules\payment\models\TransactionSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * PaymentTransactionController implements the CRUD actions for PaymentTransaction model.
 */
class TransactionController extends TController
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
                            'index',
                            'view',
                            'delete',
                            'ajax',
                            'mass',
                            'clear'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return User::isAdmin();
                        }
                    ]
                ]
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => [
                        'post'
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all PaymentTransaction models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->updateMenuItems();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single PaymentTransaction model.
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
     * Deletes an existing PaymentTransaction model.
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

    /**
     * Finds the PaymentTransaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return PaymentTransaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $accessCheck = true)
    {
        if (($model = Transaction::findOne($id)) !== null) {

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
            case 'index':
                {
                    $this->menu['clear'] = [
                        'label' => '<span class=" glyphicon glyphicon-remove"></span>',
                        'title' => Yii::t('app', 'Clear'),
                        'htmlOptions' => [
                            'data-confirm' => "Are you Sure?"
                        ],
                        'url' => [
                            'clear'
                        ],
                        'htmlOptions' => [
                            'data-confirm' => 'Are you absolutely sure ?'
                        ],
                        'visible' => User::isAdmin()
                    ];
                }
                break;
            case 'view':
                {
                    $this->menu['manage'] = array(
                        'label' => '<span class="glyphicon glyphicon-list"></span>',
                        'title' => Yii::t('app', 'Manage'),
                        'url' => [
                            'index'
                        ]
                        // 'visible' => User::isAdmin ()
                    );
                    if ($model != null) {
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
                    break;
                }
        }
    }

    function actionClear($truncate = true)
    {
        $query = Transaction::find();
        foreach ($query->each() as $model) {
            $model->delete();
        }
        if ($truncate) {
            Transaction::truncate();
        }
        \Yii::$app->session->setFlash('success', 'Done !!!');
        return $this->redirect([
            'index'
        ]);
    }

    public function actionMass($action = 'delete')
    {
        \Yii::$app->response->format = 'json';
        $response['status'] = 'NOK';
        $Ids = Yii::$app->request->post('ids', []);
        $status = Transaction::massDelete('delete');
        if ($status == true) {
            $response['status'] = 'OK';
        }
        return $response;
    }
}