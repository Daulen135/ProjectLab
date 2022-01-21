<?php

/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\modules\blog\widgets;

use app\components\TBaseWidget;
use app\modules\blog\models\Post;

/**
 * This is just an example.
 */
class FrontPage extends TBaseWidget
{

    protected function getOurBlog()
    {
        $query = Post::findActive()->orderBy('id desc')->limit(3)->all();
        return $query;
    }

    public function run()
    {
        $posts = $this->getOurBlog();
        if ($posts == null) {
            return;
        }
        return $this->render('front-page', [
            'posts' => $posts,
            'type' => 'OUR BLOG'
        ]);
    }
}
