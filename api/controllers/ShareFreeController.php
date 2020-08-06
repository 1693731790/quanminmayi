<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\GoodsFreeTake;
use common\models\UserAddress;
use common\models\GoodsFreeTakeKey;
use common\models\GoodsFreeTakeVal;


/**
 * Site controller
 */
class ShareFreeController extends Controller
{
  	  public function actionIndex($page="")
      {  
	     $model=GoodsFreeTake::find()->asArray();
	     if($page=="")
	     {
	     	$goods=$model->where(["status"=>"200","issale"=>"1"])->orderBy("create_time desc")->limit(30)->select(["goods_id","user_num","goods_name","goods_thums","old_price","salecount"])->all();
	     }else{
	     	$page=($page-1)*30;
	      	$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->orderBy("create_time desc")->offset($page)->limit(30)->select(["goods_id","user_num","goods_name","goods_thums","old_price","salecount"])->all();
	     }
          
        $res["success"]=true;
        $res["date"]=$goods;
        return json_encode($res);
          
      }
  	
  	  public function actionDetail()
      {  
      	  $data=Yii::$app->request->get();
          if(!$data["goods_id"])
          { 
              $res["success"]=false;
              $res["message"]="缺少参数goods_id";
              return json_encode($res);
          }
          $model=GoodsFreeTake::find()->asArray()->where(["goods_id"=>$data["goods_id"]])->one();
          
          $goods_img=json_decode($model['goods_img']);
          $model['goods_img']=$goods_img;
        	
          if($model['status']!="200"||empty($model))
          { 
              $res["success"]=false;
              $res["message"]="商品已下架或不存在";
              return json_encode($res);
          }
          
       	//$this->dump($goodsKey);
          $goods["goods_id"]=$model["goods_id"];
          $goods["user_num"]=$model["user_num"];
          $goods["goods_name"]=$model["goods_name"];
          $goods["goods_keys"]=$model["goods_keys"];
          $goods["desc"]=$model["desc"];
          $goods["old_price"]=$model["old_price"];
          $goods["stock"]=$model["stock"];
          $goods["salecount"]=$model["salecount"];
          $goods["browse"]=$model["browse"];
          $goods["goods_thums"]=$model["goods_thums"];
          $goods["goods_img"]=empty($model["goods_img"])?$model["goods_thums"]:$model["goods_img"];
          
          $res["success"]=true;
          $res["message"]="获取成功";
          $res["data"]=$goods;
          
          return json_encode($res);	
      }
       public function actionAddOrder()//添加订单
      {
         	 $data=Yii::$app->request->get();
            if(!$data["goods_id"]||!$data["user_id"])
            { 
                $res["success"]=false;
                $res["message"]="缺少参数";
                return json_encode($res);
            }
          
             //$this->dump($data);
             
              $model=GoodsFreeTake::findOne($data['goods_id']);
              
              $address=UserAddress::find()->where(["user_id"=>$data['user_id']])->orderBy("isdefault desc")->one();
         	  if(empty($address))
              {
                	$addressRes["success"]=false;
              }else{
                $addressRes["success"]=true;
                $addressRes["address_id"]=$address->aid;  
                $addressRes["name"]=$address->name;  
                
			  	$addressRes["phone"]=$address->phone; 
                $addressRes["region"]=$address->region;  
			  	$addressRes["address"]=$address->address; 
              }
         	
         	  $goods["goods_id"]=$model["goods_id"];
          	  $goods["goods_name"]=$model["goods_name"];
              $goods["goods_keys"]=$model["goods_keys"];
              $goods["desc"]=$model["desc"];
              $goods["old_price"]=$model["old_price"];
	          $goods["goods_thums"]=$model["goods_thums"];
          		
              $res["success"]=true;
              $res["message"]="获取成功";
              $res["goods"]=$goods;
              $res["address"]=$addressRes;
         	  
              return json_encode($res);	
              //$this->dump($goods);
              
          
      }
  	  
}
