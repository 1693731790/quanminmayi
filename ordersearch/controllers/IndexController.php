<?php
namespace ordersearch\controllers;

use Yii;
use yii\web\Controller;

use yii\filters\AccessControl;
use common\models\Order;
use common\models\OrderGoods;
use common\models\User;
use common\models\UserAuth;


/**
 * Site controller
 */
class IndexController extends CommonController
{
	public $layout="main";
	public function actionIndex()
	{
		
		return $this->render('index');
	}
    public function actionOrderSearch($order_sn="")
	{
		$model=Order::findOne(["order_sn"=>$order_sn]);
     
        if(!empty($model))
        {   
     	

           $goods=OrderGoods::find()->where(["order_id"=>$model->order_id])->all();
        }
        $user=User::findOne($model->user_id);
        $userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$model->user_id])->one();
        //$this->dump($goods);
        return $this->render('order-search', [
            'model' => $model,
            'order_sn' => $order_sn,
            'goods' => $goods,
          'user' => $user,
          'userAuth' => $userAuth,
           
            
        ]);
	}
  
    public function actionStatus($order_id="")
	{
		$model=Order::findOne($order_id);
    	$model->status="7";
        if($model->update(true,['status']))
        {
            $res["success"]=true;
                    $res["message"]="操作成功";
                    return json_encode($res);
               
        } else{
                    $res["success"]=false;
                    $res["message"]="操作失败";
                    return json_encode($res);
                }
	}
  
  	public function actionOrderList($status)
	{
		$model=Order::find()->where(["isgroup"=>1,"status"=>$status])->all();
      
        //$this->dump($model);
        return $this->render('order-list', [
            'model' => $model,
            
           
            
        ]);
	}
	

  
       
   
}
