<?php

namespace elmnsk\yii2honeypot;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class HoneypotTimeWidget extends InputWidget
{
    public $attribute = 'honeypot_time';

    private $time;


    public function init()
    {
        $this->time = time();
        $this->time .= '|' . md5($this->time . $this->attribute);
        parent::init();
    }

    public function run()
    {
        if ($this->hasModel()) {
            return Html::activeHiddenInput(
                $this->model,
                $this->attribute,
                ArrayHelper::merge(
                    $this->options,
                    ['value' =>$this->time]
                )
            );
        }

        return Html::hiddenInput(
            $this->attribute,
            $this->time,
            $this->options
        );
    }
}