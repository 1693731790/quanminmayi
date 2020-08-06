<?php
namespace ordersearch\controllers;
use yii;
use yii\web\Controller;


class CommonController extends Controller 
{ 

	function beforeAction($action)
	{
		if(yii::$app->user->isGuest)
		{
			return $this->redirect(['login/login']);
			//return $this->goHome();
			
		}else{
			/*//控制器名字加方法名字，判断是否有权限
			 * $action = Yii::$app->controller->id.Yii::$app->controller->action->id;
			if(!Yii::$app->user->can($action)){
				throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
			}	*/		
			return true;	
		
		}
		
	}
}
