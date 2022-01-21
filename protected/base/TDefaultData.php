<?php

/**
 *
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author     : Shiv Charan Panjeta < shiv@toxsl.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 */
namespace app\base;

use app\models\Page;
use app\models\User;
use app\modules\blog\models\Category as BlogCategory;
use app\modules\blog\models\Post as Blog;
use app\modules\feature\models\Feature;
use app\modules\feature\models\Type as FeatureType;

class TDefaultData
{

    public static function data()
    {
        User::log(__FUNCTION__ . ' =>Default data start');
        User::addData([
            [
                'full_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@toxsl.in',
                'role_id' => User::ROLE_ADMIN,
                'password' => 'admin@123',
                'contact_no' => '89668653565'
            ]
        ]);
        BlogCategory::addData([
            [
                'title' => 'Updates',
                'type_id' => 1
            ],

            [
                'title' => 'Success Stories',
                'type_id' => 2
            ]
        ]);
        Blog::addData([
            [
                'title' => 'Applicant Tracking System',
                'type_id' => 1
            ],
            [
                'title' => 'Top Recuritment Challenges',
                'type_id' => 1
            ]
        ]);

        Page::addData([
            [
                'title' => 'About Us',
                'header' => 'about-us',
                'type_id' => 2
            ],
            [
                'title' => 'Privacy Policy',
                'header' => 'about-us',
                'type_id' => 0
            ],
            [
                'title' => 'Terms and Conditions',
                'header' => 'about-us',
                'type_id' => 1
            ],
        ]);
        FeatureType::addData([
            [
                'title' => 'Core',
                'type_id' => 1
            ]
        ]);
        Feature::addData([
            [
                'title' => 'Advanced Applicant Tracking',
                'order_id' => 1,
                'type_id' => 1
            ],
            [
                'title' => 'AI Based Resume Parsing',
                'order_id' => 2,
                'type_id' => 1
            ]
        ]);

        User::log(__FUNCTION__ . " ==> End");
    }
}

