<?php
namespace mall\controllers;
use yii\helpers\Url;
use Yii;
use common\models\Express;
use common\models\OrderSeckill;
use common\models\GoodsSeckill;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderFreeTakeController implements the CRUD actions for OrderFreeTake model.
 */
class OrderSeckillController extends CommonController
{
        public function actionOrder($status="")
        {
            $this->layout="nofooter";
            $user_id=Yii::$app->user->identity->id;
            $order=OrderSeckill::find()->where(["user_id"=>$user_id])->andFilterWhere(["status"=>$status])->orderBy("create_time desc")->limit(30)->all();
          
            return $this->render("order",[
                  "order"=>$order,
            ]);
        }
       
      public function actionDetail($order_id)
        {
            $this->layout="nofooter";
            $model=OrderSeckill::findOne($order_id);
          
            return $this->render("detail",[
                  "model"=>$model, 
                  "goods"=>$goods, 
                  
            ]);
        }
  
    function actionOrderRefund($order_id="")//用户退货订单
    {
     
        if($data=Yii::$app->request->post()){
            $user_id=Yii::$app->user->identity->id;
            $order=OrderSeckill::findOne($data['order_id']);   
          
      
            if($order->user_id!=$user_id||$order->status=="0"||$order->status=="3"||$order->status=="4"||$order->status=="5")
            {
                $res["success"]=false;
                $res["message"]="无法操作";
                return json_encode($res);
            }
            $order->status=4;
            $order->refund_remarks=$data["refund_remarks"];
            $order->refund_time=time();
            if($order->update(true,["status","refund_remarks","refund_time"]))
            {
                $res["success"]=true;
                $res["message"]="提交成功等待审核";
                return json_encode($res);
            }else{
                $res["success"]=false;
                $res["message"]="提交失败";
                return json_encode($res);
            }

        }
        return $this->render("order-refund",[
            "order_id"=>$order_id,
        ]);
    }
  
    function actionConfirmReceived()  //确认收货
    {
          $user_id=Yii::$app->user->identity->id;
          $res=[];
          if($data=Yii::$app->request->get()){
                $order=OrderSeckill::find()->where(["order_id"=>$data["order_id"]])->one();
                if($order->status!="2")
                {
                    $res['success']=false;
                    $res['message']="未知错误";
                    return json_encode($res);
                }
                if(empty($order))
                {
                    $res['success']=false;
                    $res['message']="未知错误";
                    return json_encode($res);
                }
                if($order->status!=2)
                {
                    $res['success']=false;
                    $res['message']="未知错误";
                    return json_encode($res);

                }
                if($order->user_id!=$user_id)
                {
                    $res['success']=false;
                    $res['message']="您没有权限操作";
                    return json_encode($res);

                }
                $order->status=3;
                if($order->update(true,["status"]))
                {
                    $res['success']=true;
                    $res['message']="操作成功";
                    return json_encode($res);
                }else{
                    $res['success']=false;
                    $res['message']="操作失败";
                    return json_encode($res);
                }
           
          }
    }
     
}
