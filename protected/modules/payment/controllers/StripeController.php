<?php
namespace app\modules\payment\controllers;

use Omnipay\Omnipay;
use app\components\TController;
use app\modules\payment\models\Gateway;
use app\modules\payment\models\GatewaySetting;
use app\modules\payment\models\Payment;
use app\modules\payment\models\Transaction;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use Complex\Exception;
use app\modules\subscription\models\Plan;

/**
 * Default controller for the `payment` module
 */
class StripeController extends TController
{

    public $enableCsrfValidation = false;

    public $gateway;

    public $config;

    /**
     * Renders the index view for the module
     *
     *
     * @return string
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'paynow',
                            'success',
                            'cancel'
                        ],
                        'allow' => true,
                        'roles' => [
                            '@',
                            '*',
                            '?'
                        ]
                    ]
                ]
            ]
        ];
    }

    public function beforeAction($action)
    {
        if ((\Yii::$app->controller->action->id == 'pay')) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function init()
    {
        $this->config = $this->getConfigParams();

        $this->gateway = Omnipay::create('Stripe');
    }

    /*
     * Create an action and copy the form from views/stripe/stripeform,
     * from the action send model_type, model_id, quantity,amount,etc and
     * then submit the form and payment will be done by stripe.
     */
    public function actionPay($id = null, $model_type = null)
    {
        $this->layout = "@app/views/layouts/main";
        $post = Yii::$app->request->post();
        if (! empty($id) && (! empty($model_type))) {
            $model = $model_type::find()->where([
                'id' => $id
            ])->one();

            if (! ($model instanceof PayableInterface)) {
                throw new Exception($model . 'must impelment payable inteface');
            }
            $quantity = isset($post['quantity']) ? $post['quantity'] : "1";
            $symbol = isset($post['currency']) ? $post['currency'] : "USD";

            if (empty($post['amount']) && empty($post['stripeToken'])) {
                throw new Exception('Amount or Stripe Token cannot be blank');
            }

            $params = array_merge($this->config, array(
                'currency' => $symbol
            ));

            $final_amount = sprintf("%.2f", $post['amount']);

            $this->gateway->setApiKey($params['secret_key']);

            $params['cancelUrl'] = \yii::$app->urlManager->createAbsoluteUrl([
                'payment/stripe/cancel'
            ]);

            $response = $this->gateway->purchase(array(
                'amount' => $final_amount,
                'currency' => $symbol,
                "source" => $post['stripeToken']
            ))->send();

            /*
             * For Transaction Reference
             * $response->getTransactionReference ()
             *
             */
            if ($response->isSuccessful()) {
                $result = $response->getData();

                /* save your Transaciton detials in the table */

                return $this->redirect($model->getAfterPayUrl());
            } else {
                return $this->redirect([
                    '/stripe/cancel'
                ]);
            }
        }
    }

    public function actionPaynow($id = null)
    {
        if (empty($this->config)) {

            $transaction = Transaction::findOne($id);
            if (! empty($transaction)) {
                $transaction->delete();
            }
            \Yii::$app->session->setFlash('error', \Yii::t('app', "Configartion not set."));
            return $this->redirect([
                '/'
            ]);
        }
        $bodyParams = \Yii::$app->request->bodyParams;

        if (isset($bodyParams['stripeToken']) && empty($bodyParams['stripeToken'])) {

            \Yii::$app->session->setFlash('error', \Yii::t('app', "Token not send."));
            return $this->redirect([
                '/'
            ]);
        }

        if (empty($id)) {
            $model = new Payment();
            $model->load(Yii::$app->request->post());
            $plan = Plan::findOne($model->model_id);
            $transaction = new Transaction();
            $transaction->amount = $model->getAmount();
            $transaction->currency = $model->getCurrency();
            $transaction->description = $model->getDescription();
            $transaction->email = $model->email;
            $transaction->name = $model->name;
            $transaction->model_id = $model->model_id;
            $transaction->model_type = get_class($plan);
            $transaction->value = Json::encode([
                'request' => $model->requestData()
            ]);
        } else {
            $transaction = Transaction::findOne($id);
        }

        $transaction->gateway_type = GatewaySetting::GATEWAY_TYPE_STRIPE;
        $transaction->payment_status = Transaction::PAYMENT_STATUS_PENDING;
        if ($transaction->save()) {

            $params = array_merge($this->config, array(
                'currency' => $transaction->currency,
                'amount' => $transaction->amount,
                "source" => $bodyParams['stripeToken']
            ));

            $this->gateway->setApiKey($params['apiKey']);

            $response = $this->gateway->purchase($params)->send();

            if ($response->isSuccessful()) {

                $result = $response->getData();
                /* save your Transaciton detials in the table */
                $paymentTransaction = Transaction::findOne($transaction->id);
                $paymentTransaction->transaction_id = $result['id'];
                $paymentTransaction->payment_status = Transaction::PAYMENT_STATUS_SUCCESS;
                $successUrl = \Yii::$app->urlManager->createUrl([
                    "/site/success",
                    'id' => $paymentTransaction->model_id
                ]);
                if ($paymentTransaction->save()) {

                    return Yii::$app->response->redirect($successUrl);
                } else {
                    return $this->redirect([
                        '/payment/stripe/cancel',
                        'id' => $transaction->id
                    ]);
                }

                // return $this->redirect($model->getAfterPayUrl());
            } else {
                parent::init();
                return $this->redirect([
                    '/payment/stripe/cancel',
                    'id' => $transaction->id
                ]);
            }
        }
    }

    public function actionSuccess($id)
    {
        $paymentTransaction = Transaction::findOne($id);
        if (! empty($paymentTransaction)) {

            $paymentTransaction->value = json_encode([
                'response' => $transactionDetail,
                'request' => $sendData['request']
            ]);
            $paymentTransaction->save();

            $successUrl = \Yii::$app->urlManager->createAbsoluteUrl([
                "/payment/default/success",
                'id' => $paymentTransaction->id
            ]);
            if (isset($sendData['send']['success'])) {
                $successUrl = $sendData['send']['success'];
                $query = parse_url($successUrl, PHP_URL_QUERY);
                // Returns a string if the URL has parameters or NULL if not
                if ($query) {
                    $successUrl .= "&id=$paymentTransaction->id ";
                } else {
                    $successUrl .= "?id=$paymentTransaction->id ";
                }
            }
            return $this->redirect($successUrl);
        }
        throw new Exception('Transaction not complete.');
    }

    public function actionCancel($id)
    {
        $paymentTransaction = Transaction::findOne($id);
        $calcelUrl = \Yii::$app->urlManager->createAbsoluteUrl([
            "/"
        ]);
        if (! empty($paymentTransaction)) {
            $paymentTransaction->payment_status = Transaction::PAYMENT_STATUS_CANCEL;
            $paymentTransaction->save();
            $sendData = json_decode($paymentTransaction->value, true);
            if (isset($sendData['send']['cancel'])) {
                $calcelUrl = $sendData['send']['cancel'];
            }
        }
        parent::init();
        return $this->redirect($calcelUrl);
    }

    protected function findModel($id)
    {
        if (($model = Gateway::findOne($id)) !== null) {
            if (! ($model->isAllowed()))
                throw new HttpException(403, Yii::t('app', 'You are not allowed to access this page.'));

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getConfigParams()
    {
        $gateway = Gateway::findActive()->where([
            'type_id' => GatewaySetting::GATEWAY_TYPE_STRIPE,
            'state_id' => Gateway::STATE_ACTIVE
        ])->one();
        $params = [];
        if ($gateway) {
            $gatewaySwtting = $gateway->gatewaySettings();
            $params['apiKey'] = $gatewaySwtting['secret_key'];
            $params['testMode'] = ($gateway->mode == GatewaySetting::MODE_TEST);
        }
        return $params;
    }

    protected function updateMenuItems($model = null)
    {}
}
