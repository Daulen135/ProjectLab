<?php

/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\modules\blog\widgets;

use app\components\TBaseWidget;
use app\modules\blog\models\Post;
use yii\data\ArrayDataProvider;

/**
 * This is just an example.
 */
class BlogWidget extends TBaseWidget
{

    public $model;

    public $type_id = self::TYPE_SIMILAR;

    const TYPE_RECENT = 0;

    const TYPE_SIMILAR = 1;

    const TYPE_MOST_POPULAR = 2;

    public $disabled = false;

    public static function getTypeOptions()
    {
        return [
            self::TYPE_RECENT => "Recent Posts",
            self::TYPE_SIMILAR => "Similar Posts",
            self::TYPE_MOST_POPULAR => "Most Popular"
        ];
    }

    public function getType()
    {
        $list = self::getTypeOptions();
        return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';
    }

    protected function getRecent()
    {
        $provider = new ArrayDataProvider([
            'allModels' => Post::findActive()->limit(5)
                ->orderBy('created_on DESC')
                ->all()
        ]);
        return $provider;
    }

    protected function getSimilar()
    {
        if ($this->model == null)
            return null;
        $allModels = Post::findActive()->limit(5)
            ->andWhere([
            'type_id' => $this->model->type_id
        ])
            ->andWhere([
            'not in',
            'id',
            [
                $this->model->id
            ]
        ])
            ->all();

        $provider = new ArrayDataProvider([
            'allModels' => $allModels
        ]);
        return $provider;
    }

    protected function getMostPopular()
    {
        $allModels = Post::findActive()->limit(5)
            ->orderBy('view_count DESC')
            ->all();
        $provider = new ArrayDataProvider([
            'allModels' => $allModels
        ]);
        return $provider;
    }

    protected function getPosts()
    {
        switch ($this->type_id) {
            case self::TYPE_RECENT:
                return $this->getRecent();
                break;
            case self::TYPE_SIMILAR:
                return $this->getSimilar();
                break;
            case self::TYPE_MOST_POPULAR:
                return $this->getMostPopular();
                break;
        }
    }

    public function run()
    {
        if ($this->disabled)
            return; // Do nothing
        $posts = $this->getPosts();
        if ($posts == null)
            return;
        return $this->render('posts', [
            'posts' => $posts,
            'type' => $this->getType()
        ]);
    }
}
