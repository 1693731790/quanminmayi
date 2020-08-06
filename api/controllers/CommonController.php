<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;



/**
 * Site controller
 */
class CommonController extends Controller
{
	function beforeAction($action)
	{

		if(yii::$app->user->isGuest)
		{
			
			return $this->redirect(['site/login'])->send();
			
			
		}
		else{
			/*$action = Yii::$app->controller->id.Yii::$app->controller->action->id;//控制器名字加方法名字，判断是否有权限
			 if(!Yii::$app->user->can($action)){
			 throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
			 }	*/
			return true;
			
		}
		
	}
   
}
