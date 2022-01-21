<?php

/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\modules\contact\commands;

use app\components\TConsoleController;
use app\modules\contact\models\Information;
use app\modules\mailer\models\Unsubscribe;

class InformationController extends TConsoleController
{

    /**
     * Marks information as Spam if mail is unsubscribed
     */
    public function actionMarkSpam()
    {
        $query = Information::find()->where([
            'in',
            'state_id',
            [
                Information::STATE_SUBMITTED,
                Information::STATE_DRAFT
            ]
        ]);
        self::log('Contacts found: ' . $query->count());
        foreach ($query->each() as $info) {
            self::log('Processing : ' . $info->id);
            if (Unsubscribe::check($info->email) || strstr($info->user_agent, 'bot')) {
                $info->state_id = Information::STATE_SPAM;
                $info->updateAttributes([
                    'state_id'
                ]);
            } else {
                if ($info->state_id == Information::STATE_SUBMITTED) {
                    $info->sendToLeadManager();
                }
            }
        }
    }
}

