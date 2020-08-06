<?php

namespace admin\modules\call;

/**
 * shop module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'admin\modules\call\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        define('SITE_ID',10);
    }
}
