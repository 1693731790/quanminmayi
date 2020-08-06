<?php

namespace backend\modules\jdgoods;

/**
 * shop module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\jdgoods\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        define('SITE_ID',20);
    }
}
