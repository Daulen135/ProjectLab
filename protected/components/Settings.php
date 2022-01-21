<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\components;

use yii\base\Component;

class Settings extends Component
{

    public $modelClass = 'app\models\Setting';

    public function init()
    {
        parent::init();
    }

    public function __set($key, $value)
    {
        return $this->setValue($key, $value);
    }

    public function __get($key)
    {
        return $this->getValue($key);
    }

    protected function findByKey($key)
    {
        return $this->modelClass::find()->cache()
            ->where([
            'key' => $key
        ])
            ->one();
    }

    public function setValue($key, $value, $defaultKey = 'appConfig', $title = "Config")
    {
        $model = $this->findByKey($key);
        if (empty($model)) {
            $model = new $this->modelClass();
            $model->loadDefaultValues();
        }
        $model->key = $key;
        $model->title = $key;
        $model->value = $value;
        $model->save();
        \Yii::$app->cache->set($key, $value);
    }

    public function getValue($key, $default = null, $defaultKey = 'appConfig')
    {
        $value = \Yii::$app->cache->get($key);

        if ($value === false) {
            $model = $this->findByKey($key);

            if (! empty($model)) {
                $value = $model->value;
            } else {
                $value = $default;
            }
            \Yii::$app->cache->set($key, $value);

            return $value;
        }
        return $value;
    }

    public static function defaultCurrency()
    {
        return self::getCurrencySymbol('INR');
    }

    public static function getCurrencySymbol($currencyCode, $locale = 'en_US')
    {
        $formatter = new \NumberFormatter($locale . '@currency=' . $currencyCode, \NumberFormatter::CURRENCY);
        return $formatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
    }
}
