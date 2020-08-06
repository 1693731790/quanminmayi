<?php
namespace api\controllers;
use yii\helpers\Url;
use Yii;
use common\models\Express;
use common\models\OrderFreeTake;
use common\models\GoodsFreeTake;
use common\models\OrderUser;
use common\models\UserAuth;

use common\models\OrderFreeTakeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderFreeTakeController implements the CRUD actions for OrderFreeTake model.
 */
class OrderFreeTakeController extends Controller
{
  		public function actionIndex($user_id,$page="")
        {
        	if($page=="")
        	{
        		$model=OrderFreeTake::find()->asArray()->where(["user_id"=>$user_id])->orderBy("create_time desc")->limit(30)->all();	
        	}else{
        		$page=($page-1)*30;
	            $model=OrderFreeTake::find()->asArray()->where(["user_id"=>$user_id])->orderBy("create_time desc")->offset($page)->limit(30)->all();
        	}
            
            $res["success"]=true;
            $res["date"]=$model;
            return json_encode($res);
        }
  		
    	public function actionGetUser($order_id)
        {
          	//$this->dump($model);
          	$orderUser=OrderUser::find()->asArray()->where(["order_id"=>$order_id])->all();
            foreach($orderUser as $key=>$val)
            {
                $user=UserAuth::findOne(["user_id"=>$val["user_id"],"identity_type"=>"phone"]);
                $orderUser[$key]["username"]=$user->identifier;
            }
            $res["success"]=true;
            $res["date"]=$orderUser;
            return json_encode($res);
          
        }
  		public function actionDetail($order_id)
        {
          	
          	$model=OrderFreeTake::findOne($order_id);
          //$this->dump($model);
          	$goods=GoodsFreeTake::findOne($model->goods_id);
          	$orderUser=OrderUser::find()->asArray()->with(["user"])->where(["order_id"=>$model->order_id])->all();
            $orderUserCount=OrderUser::find()->where(["order_id"=>$model->order_id])->count();
          	$url="https://shop.qmmayi.com/site/free-take.html?order_sn=".$model->order_sn;
          	
          //$this->dump($url);
          	$arr["user_num"]=$goods->user_num;//邀请多少个用户可以拿
          	$arr["salecount"]=$goods->salecount;//多少人已免费拿到
          	$arr["orderUserCount"]=$orderUserCount;//我邀请的人数
          	//$arr["orderUser"]=$orderUser;//我邀请的人列表
          	$arr["shareUrl"]=$url;
            $arr["orderUser"]=$orderUser;

          	$res["success"]=true;
            $res["date"]=$arr;
            return json_encode($res);
           
        }
  		public function actionOrderCreate($goods_id,$aid,$user_id)
        {
          	$model=new OrderFreeTake();
          	$ress=$model->addOrder($goods_id,$aid,$user_id);
          	if($ress)
            {
              	$res["success"]=true;
                $res["massage"]="添加成功";
                $res["order_id"]=$model->order_id;
                return json_encode($res);
            }else{
             	$res["success"]=false;
                $res["massage"]="添加失败";
                
                return json_encode($res);
            }
        }
}
