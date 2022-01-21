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
class TRegExHelper
{

    const PATTERN_EMAIL = '/[a-z0-9_.\-\+]+@[a-z0-9\-]+\.([a-z]+)(?:\.[a-z]+)?/i';

    public static function findMatching($subject, $pattern)
    {
        if (preg_match_all($pattern, $subject, $matches)) {
            return $matches;
        }
        return null;
    }
}