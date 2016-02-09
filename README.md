v1.0.2

Yii2 Save With Audit Trail Behavior
===================================
Adds a $model->saveWithAuditTrail() method to your Models allowing you to annotate changes to your data.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist exertis/yii2-save-with-audit-trail-behavior "*"
```

or add

```
"exertis/yii2-save-with-audit-trail-behavior": "*"
```

to the require section of your `composer.json` file.





Configuring
-----------

First you need to configure model as follows:

```php
use exertis\savewithaudittrail\SaveWithAuditTrailBehavior;

class Post extends ActiveRecord
{
    public function behaviors() {
        return [
            [
                'class' => SaveWithAuditTrailBehavior::className(),
            ],
        ];
    }
}
```