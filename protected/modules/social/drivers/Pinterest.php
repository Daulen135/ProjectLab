<?php
/**
 * @link https://github.com/yiimaker/yii2-social-share
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace app\modules\social\drivers;


use app\modules\social\socialshare\base\AbstractDriver;

/**
 * Driver for Pinterest.
 *
 * @link https://pinterest.com
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class Pinterest extends AbstractDriver
{
    /**
     * @inheritdoc
     */
    protected function processShareData()
    {
        $this->url = static::encodeData($this->url);
        $this->imageUrl = static::encodeData($this->imageUrl);
        $this->description = static::encodeData($this->description);
    }

    /**
     * @inheritdoc
     */
    protected function buildLink()
    {
        return 'https://www.pinterest.com/pin/create/link/?'
            . 'url={url}'
            . '&media={imageUrl}'
            . '&description={description}';
    }
}
