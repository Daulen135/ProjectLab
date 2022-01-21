<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 *
 */
namespace app\components\helpers;


/**
 * Setup Commands for first time
 *
 * @author shiv
 *        
 */
trait TLogHelper
{

    public static function log($strings)
    {
        if (php_sapi_name() == "cli") {
            echo get_called_class() . ' : ' . $strings . PHP_EOL;
        } else {
            \Yii::debug(get_called_class() . ' : ' . $strings);
        }
    }
}