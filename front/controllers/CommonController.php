<?php
namespace front\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;

/**
 * Site controller
 */
class CommonController extends Controller
{
  function beforeAction($action)
  {
        $data=Yii::$app->request->get();
        if(isset($data["token"])&&$data["token"]!="")
        {
            $token=$data["token"];
            
            $user=User::findIdentityByAccessToken($token,10);
            if($user){
                Yii::$app->user->login($user);   
            }
            if($token)
            {
                $cookies = Yii::$app->response->cookies;
                $cookies->add(new \yii\web\Cookie([
                            'name' => 'token',
                            'value' => $token,
                            'expire'=>time()+3600*24*7,
                ]));
            }
           /* var_dump(yii::$app->user->isGuest);
            die();*/
            return true;
        }else{
          	if(Yii::$app->controller->id!="index")
            {	
                if(yii::$app->user->isGuest)
                {
                  return $this->redirect(['site/login'])->send();
                }else{
                  /*$action = Yii::$app->controller->id.Yii::$app->controller->action->id;//控制器名字加方法名字，判断是否有权限
                   if(!Yii::$app->user->can($action)){
                   throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
                   }  */
                  return true;
                }
            }else{
             	return true; 
            }
        }
        
    
  }
   
}
