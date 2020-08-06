<?php
namespace mall\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;

use common\models\UserFeedback;


/**
 * Site controller
 */
class UserFeedbackController extends CommonController
{
      
     function actionIndex()// 添加反馈信息
     {
        $this->layout="nofooter";
        if($data=Yii::$app->request->get()){
           
            
            $model=new UserFeedback();
            $user_id=Yii::$app->user->identity->id;
            $model->user_id=$user_id;
            $model->phone=$data["phone"];
            $model->content=$data["content"];
            $model->create_time=time();
            
            
            if($model->save())
            {
                
                $res["success"]=true;
                
                return json_encode($res);
            }else{
                $res["success"]=false;
                
                return json_encode($res);
            }
           
        }else{
            return $this->render("index",[

            ]);  
        }

        
     }
    

}
