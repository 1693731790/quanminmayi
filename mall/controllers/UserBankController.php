<?php
namespace mall\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;

use common\models\UserBank;


/**
 * Site controller
 */
class UserBankController extends CommonController
{
      
     function actionBankCreate()// 添加收货地址
     {
        $this->layout="nofooter";
        if($data=Yii::$app->request->get()){
           
            
            $model=new UserBank();
            
            $model->user_id=Yii::$app->user->identity->id;
            $model->name=$data["name"];
            $model->phone=$data["phone"];
            $model->account=$data["account"];
            $model->bank_name=$data["bank_name"];
            
            if($model->save())
            {
                
                $res["success"]=true;
                
                return json_encode($res);
            }else{
                $res["success"]=false;
                
                return json_encode($res);
            }
           
        }else{
            return $this->render("bank-create",[

            ]);  
        }

        
     }
     function actionBankDelete($bank_id)//删除
    {
        $user_id=Yii::$app->user->identity->id;
        $model=UserBank::findOne($bank_id);
        $res=[];
        if($model->user_id!=$user_id)
        {
            $res["success"]=false;
            $res["message"]="无效的操作";
            return json_encode($res);
        }
        if(empty($model))
        {
            $res["success"]=false;
            $res["message"]="无效的操作";
            return json_encode($res);
        }
        if($model->delete())
        {
            $res["success"]=true;
            $res["message"]="删除成功";
            return json_encode($res);
        }else{
            $res["success"]=false;
            $res["message"]="删除失败";
            return json_encode($res);
        }
    }

     function actionBankList()// 银行卡地址列表
     {
          $this->layout="nofooter";
          $user_id=Yii::$app->user->identity->id;
          $model=UserBank::find()->where(["user_id"=>$user_id])->orderBy("bank_id desc")->all();
          return $this->render("bank-list",[
                "model"=>$model,
          ]); 
     }

}
