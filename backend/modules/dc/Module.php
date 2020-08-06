<?php

namespace backend\modules\dc;

/**
 * shop module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\dc\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        define('SITE_ID',10);
    }
}
