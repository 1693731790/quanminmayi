<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;

use common\models\UserMessage;


/**
 * Site controller
 */
class MessageController extends Controller
{
      
     function actionIndex($user_id)// 添加反馈信息
     {
            
        $model=UserMessage::find()->asArray()->where(["user_id"=>$user_id])->limit(20)->all();

  
        
      		$res["success"]=false;
            $res["data"]=$model;
            return json_encode($res);
        
     }
    

}
