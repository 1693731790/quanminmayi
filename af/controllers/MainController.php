<?php
namespace af\controllers;

use Yii;
use yii\web\Controller;
use admin\models\Menu;


class MainController extends Controller
{
    /**
     * 系统首页
     *
     * @return string
     */
    public function actionIndex()
    {
      	$menu=new Menu();
      	//$menu->getMenu(5);
        return $this->renderPartial($this->action->id, [
        ]);
    }

    /**
     * 子框架默认主页
     *
     * @return string
     */
    public function actionSystem()
    {
        return $this->render($this->action->id, [
        ]);
    }

   
}