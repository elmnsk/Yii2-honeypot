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

    public $skipOnEmpty = false;

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

        if(strpos($value,'|') === false){
            $model->addError($attribute, $this->message);
            return;
        }

        list($time, $hash) = explode('|', $value);

        if (!$this->validateTime($time,$hash,$attribute) || ($time + $this->time) > time()) {
            $model->addError($attribute, $this->message);
        }
    }

    private function validateTime($time, $hash, $attribute)
    {
        return md5($time . $attribute) === $hash;
    }
}