Honeypot time extension for Yii2
===========================
Protects the forms from spam using "honeypot" method

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Use composer

```
composer require --prefer-dist elmnsk/yii2-honeypot "*"
```

or add

```
"elmnsk/yii2-honeypot": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
//model property
public $honeypotTime;

//in model rules
 ['honeypotTime',\elmnsk\honeypot\HoneypotTimeValidator::class,'time'=>10];
```

```php
<?=$form->field($model,'honeypotTime')
            ->widget(\elmnsk\honeypot\HoneypotTimeWidget::class)->label(false);?>
```

'time' - this is the time in seconds, less than which the form submission will be detected as spam