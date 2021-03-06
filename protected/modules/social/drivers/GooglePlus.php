<?php
/**
 * @link https://github.com/yiimaker/yii2-social-share
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace app\modules\social\drivers;


use app\modules\social\socialshare\base\AbstractDriver;

/**
 * Driver for Google Plus.
 *
 * @link https://plus.google.com
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class GooglePlus extends AbstractDriver
{
    /**
     * @inheritdoc
     */
    protected function processShareData()
    {
        $this->url = static::encodeData($this->url);
    }

    /**
     * @inheritdoc
     */
    protected function buildLink()
    {
        return 'https://plusone.google.com/_/+1/confirm?hl=en&url={url}';
    }
}
