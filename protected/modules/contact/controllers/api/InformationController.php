
<?php
 
namespace app\modules\contact\controllers\api;

use app\components\filters\AccessControl;
use app\components\filters\AccessRule;
#use app\modules\contact\models\Information;
use yii\data\ActiveDataProvider;
use app\modules\api\components\ApiBaseController;
use app\modules\contact\models\Information;
use Yii;
use yii\web\HttpException;
use app\models\User;

/**
 * InformationController implements the API actions for Information model.
 */
class InformationController extends ApiBaseController
{
    public $modelClass = "app\modules\contact\models\Information";
  
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
                            'create',
                            'view',
                            'update',
                            'delete'
                        ],
                        'allow' => true,
                        'roles' => [
                            '@'
                        ]
                    ]
                ]
            ]
        ];
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        unset($actions['view']);
        unset($actions['index']);
        return $actions;
    } 
    public function actionCreate(){
        $data = [];
        $model = new Information();
        $model->loadDefaultValues();
        $post = \yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->checkSpamMail() > 0) {
                throw new HttpException(403, Yii::t('app', 'You are not allowed to access this page.'));
            }
            $model->state_id = Information::STATE_INACTIVE;
            if ($model->save()) {
                $data['detail'] = $model->asJson();
            }else {
                $data['message'] = $model->getErrorsString();
            }
        }else{
            $data['message'] = "Data not Posted";
        }
        return $data;
    }
}
