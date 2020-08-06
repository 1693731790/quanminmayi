<?php

namespace admin\modules\dc;

/**
 * shop module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'admin\modules\dc\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        define('SITE_ID',10);
    }
}
