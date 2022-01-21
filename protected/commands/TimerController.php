<?php

/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\commands;

use app\models\EmailQueue;
use app\components\TConsoleController;
use app\modules\subscription\models\Billing;

class TimerController extends TConsoleController
{

    const MAX_ATTEMPTS = 5;

    public function actionSend()
    {
        $mails = EmailQueue::find()->where([
            'state_id' => EmailQueue::STATE_PENDING
        ])
            ->limit(50)
            ->
        orderBy('id asc')
            ->all();
        foreach ($mails as $mail) {
            $mail->sendNow();
        }
        return true;
    }

    public function actionCheckSubscription()
    {
        $query = Billing::find()->where([
            'state_id' => Billing::STATE_ACTIVE
        ])
            ->andWhere([
            '!=',
            'type_id',
            Billing::STATE_ACTIVE
        ])
            ->andWhere([
            '<',
            'date(end_date)',
            date("Y-m-d")
        ]);
        foreach ($query->batch() as $rides) {
            foreach ($rides as $ride) {
                $endTime = date("Y-m-d H:i:s", strtotime('+1 day', strtotime($ride->end_date)));
                if (strtotime($endTime) < strtotime(date('Y-m-d H:i:s'))) {
                    $ride->state_id = Billing::STATE_INACTIVE;
                    $ride->updateAttributes([
                        'state_id'
                    ]);
                }
            }
        }
    }
}


