<?php

namespace admin\modules\jdgoods;

/**
 * shop module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'admin\modules\jdgoods\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        define('SITE_ID',20);
    }
}
