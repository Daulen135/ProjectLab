<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\components\formatter;

use yii\i18n\Formatter;

class TFormatter extends Formatter
{

    public function init()
    {
        parent::init();
        $this->nullDisplay = '';
    }

    public function asHours($value, $format =  '%02d:%02d Hours')
    {
        if (empty($value) || ! is_numeric($value)) {
            return false;
        }
        
        $minutes = round($value / 60);
        $hours = floor($minutes / 60);
        $remainMinutes = ($minutes % 60);
        
        return sprintf($format, $hours, $remainMinutes);
    }
}

