<?php
namespace mall\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;

use common\models\UserMessage;


/**
 * Site controller
 */
class MessageController extends CommonController
{
      
     function actionIndex()// 添加反馈信息
     {
        $user_id=Yii::$app->user->identity->id;
            
        $model=UserMessage::find()->where(["user_id"=>$user_id])->limit(20)->all();

  
        return $this->render("index",[
                "model"=>$model,
        ]);  
      
        
     }
    

}
