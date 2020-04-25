<?php

namespace elmnsk\yii2honeypot;

use Yii;
use yii\i18n\PhpMessageSource;
use yii\validators\Validator;

class HoneypotTimeValidator extends Validator
{
    /**
     * @var int time in second
     */
    public $time = 5;

    public function init()
    {
        parent::init();

        if (!isset(Yii::$app->get('i18n')->translations['message*'])) {
            Yii::$app->get('i18n')->translations['message*'] = [
                'class' => PhpMessageSource::className(),
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en-US'
            ];
        }

        if($this->message ===null){
            $this->message =Yii::t('messages','Spam detected');
        }
    }

    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;

        list($time, $hash) = explode('|', $value);

        if (!$this->validateTime($time,$hash,$attribute)) {
            $this->addError($model, $attribute, $this->message);
        }

        if (($time + $this->time) > time()) {
            $this->addError($model, $attribute, $this->message);
        }
    }

    private function validateTime($time, $hash, $attribute)
    {
        return md5($time . $attribute) === $hash;
    }
}