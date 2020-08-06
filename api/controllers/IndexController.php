<?php
namespace api\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\Banner;
use common\models\Special;
use common\models\Config;
use common\models\Goods;
use common\models\GoodsCate;
use common\models\RobBuy;
use common\models\Adv;
use common\models\User;
use common\models\Article;
use common\models\OrderName;
use common\models\Order;
use common\models\OrderGoods;
use common\models\UserAuth;


/**
 * Site controller
 */
class IndexController extends Controller
{
    
    public function actionBanner()
    {
       $banner=Banner::find()->asArray()->orderBy(["orderby"=>"asc"])->all();
       $res["success"]="200";
       $res["message"]="获取成功";
       $res["info"]=$banner;
       return json_encode($res);

    }
    public function actionArticle()
    {
       $article=Article::find()->asArray()->where(["ishot"=>"1"])->select(["article_id","title","title_img","key","create_time"])->limit(10)->all();
       $res["success"]="200";
       $res["message"]="获取成功";
       $res["info"]=$article;
       return json_encode($res);

    }

    public function actionGoodsCate()
    {
       $goodsCate=GoodsCate::find()->asArray()->where(["goods_cat_is_show"=>"1"])->andwhere(["<>","goods_cat_pid",'0'])->orderBy("goods_cat_sort desc")->limit(6)->all();
       $res["success"]="200";
       $res["message"]="获取成功";
       $res["info"]=$goodsCate;
       return json_encode($res);

    }

    public function actionGoods($page="")
    {
      if($page=="")
      {
          $goods=Goods::find()->asArray()->where(["status"=>"200","issale"=>"1","ishome"=>1])->select(["goods_id","shop_id","is_agent_buy","cate_id1","cate_id2","cate_id3","goods_name","goods_thums","salecount","goods_img","old_price","price","create_time","jdis_update_goods_thums"])->orderBy("price asc")->limit(10)->all();
           foreach($goods as $key=>$val)
           {
                 $goods[$key]["url"]="https://shop.qmmayi.com/goods/detail.html?goods_id=".$val["goods_id"];
           }
          $res["success"]="200";
          $res["message"]="获取成功";
          $res["info"]=$goods;
          return json_encode($res);

      }else{
          $page=($page-1)*10;
          $goods=Goods::find()->asArray()->where(["status"=>"200","issale"=>"1","ishome"=>1])->select(["goods_id","shop_id","is_agent_buy","cate_id1","cate_id2","cate_id3","goods_name","goods_thums","salecount","goods_img","old_price","price","create_time","jdis_update_goods_thums"])->orderBy("price asc")->offset($page)->limit(10)->all();
          
          if(empty($goods))
          {
              $res["success"]="0";
              $res["message"]="获取失败";
              $res["info"]="暂无更多数据";
              return json_encode($res);    
          }
        foreach($goods as $key=>$val)
           {
                 $goods[$key]["url"]="https://shop.qmmayi.com/goods/detail.html?goods_id=".$val["goods_id"];
           }
          $res["success"]="200";
          $res["message"]="获取成功";
          $res["info"]=$goods;
          return json_encode($res);
      }
       

       

    }
 	public function actionGoodsSeckill()
    {
        /*$datetime=date("Y-m-d H",time()).":00";
		$start_time=strtotime($datetime);
		$end_time=strtotime($datetime)+3559; 
      $goodsSeckill=Goods::find()->asArray()->where(["status"=>"200","is_seckill"=>"1"])->andFilterWhere(['between','seckill_start_time',$start_time,$end_time])->select(["goods_id","shop_id","is_seckill","old_price","seckill_price","goods_name","goods_thums","salecount","seckill_start_time","seckill_end_time","create_time"])->orderBy("create_time desc")->limit(3)->all();  */
      $goodsSeckill=Goods::find()->asArray()->where(["status"=>"200","is_seckill"=>"1"])->andFilterWhere(['>','seckill_end_time',time()])->andFilterWhere(['<','seckill_start_time',time()])->orderBy("seckill_price asc")->limit(3)->all();
		
      	foreach($goodsSeckill as $goodsSeckillKey=>$goodsSeckillVal)
        {
          	 	$surplusTime=$goodsSeckillVal["seckill_end_time"]-time();
        	   $goodsSeckill[$goodsSeckillKey]["surplusTime"]="$surplusTime";
               unset($goodsSeckill[$goodsSeckillKey]["content"]);
               unset($goodsSeckill[$goodsSeckillKey]["mobile_content"]);
        }
      
      	$res["success"]="200";
        $res["message"]="获取成功";
        $res["info"]=$goodsSeckill;
        return json_encode($res);
	} 
    public function actionGoodsUpgrade()
    {
       $goodsUpgrade=Goods::find()->asArray()->where(["status"=>"200","is_agent_buy"=>"1"])->select(["goods_id","shop_id","is_agent_buy","cate_id1","cate_id2","cate_id3","goods_name","goods_thums","salecount","goods_img","old_price","price","create_time"])->orderBy("create_time desc")->limit(3)->all();
       foreach($goodsUpgrade as $key=>$val)
       {
        	 $goodsUpgrade[$key]["url"]="https://shop.qmmayi.com/user-upgrade/detail.html?goods_id=".$val["goods_id"];
       }
       $res["success"]="200";
       $res["message"]="获取成功";
       $res["info"]=$goodsUpgrade;
       return json_encode($res);

    } 
  	
   
    
	public function actionOrder()
    {
       $orderName=OrderName::find()->asArray()->orderBy('RAND()')->limit(10)->select("name,goods_name")->all();
       $orderNameData=[];
       foreach($orderName as $orderNamekey=>$orderNameval)
       {
       		$orderNameData[$orderNamekey]["name"]=$orderNameval["name"]."**购买了".$orderNameval["goods_name"];
       }
      
       $order=Order::find()->orderBy("create_time desc")->limit(5)->all();
       $orderUser=[];
       foreach($order as $key=>$val)
       {
        	$userAuth=UserAuth::find()->where(["user_id"=>$val->user_id,"identity_type"=>"phone"])->one();
         	$orderGoods=OrderGoods::find()->where(["order_id"=>$val->order_id])->one();
         	$phone=substr($userAuth->identifier,0,strlen($userAuth->identifier)-4)."****";
       		$orderUser[$key]["name"]=$phone."购买了".$orderGoods->goods_name;
            //$orderUser[$key]["goods_name"]=$orderGoods->goods_name;
       }
      
     /*   foreach($order as $key=>$val)
       {
            $userAuth=UserAuth::find()->where(["user_id"=>$val->user_id,"identity_type"=>"phone"])->one();
            $orderGoods=OrderGoods::find()->where(["order_id"=>$val->order_id])->one();
            $orderUser[$key]["name"]=substr($userAuth->identifier,0,strlen($userAuth->identifier)-4)."****";
            $orderUser[$key]["goods_name"]=$orderGoods->goods_name;
       }
       foreach($orderName as $orderNameKey=>$orderNameVal)
       {
            $orderName[$orderNameKey]["name"]=$orderNameVal["name"]."**";
           
       }*/
      
      $newOrder=array_merge_recursive($orderUser,$orderNameData);
      $res["success"]="200";
       $res["message"]="获取成功";
       $res["info"]=$newOrder;
       return json_encode($res);
    }
          
    public function actionIndex()
    {
       /*$config=Config::findOne(1);
		
        $banner=Banner::find()->asArray()->orderBy(["orderby"=>"asc"])->all();
        
        $special=Special::find()->limit($config->home_show_special_num)->all();

        $goodsCate=GoodsCate::find()->asArray()->where(["goods_cat_is_show"=>"1"])->andwhere(["<>","goods_cat_pid",'0'])->orderBy("goods_cat_sort desc")->limit(6)->all();
        
        $goods=Goods::find()->asArray()->where(["status"=>"200","issale"=>"1","ishome"=>1])->select(["goods_id","shop_id","cate_id1","cate_id2","cate_id3","goods_name","goods_thums","goods_img","old_price","price","create_time"])->orderBy("create_time desc")->limit(10)->all();
    
        $goodsUpgrade=Goods::find()->asArray()->where(["status"=>"200","is_agent_buy"=>"1"])->select(["goods_id","shop_id","cate_id1","cate_id2","cate_id3","goods_name","goods_thums","goods_img","old_price","price","create_time"])->orderBy("create_time desc")->limit(3)->all();
    
        $robgoods=RobBuy::find()->with(["goods"])->where([">","start_time",time()])->orderBy("start_time asc")->limit(4)->all();
        $adv=Adv::find()->all();
        
        $article=Article::find()->asArray()->where(["ishot"=>"1"])->select(["article_id","title","title_img","key","create_time"])->limit(10)->all();
     
        $data=[];
        $data["banner"]=$banner;
        $data["article"]=$article;
        $data["goodsCate"]=$goodsCate;
        $data["goods"]=$goods;
        $data["goodsUpgrade"]=$goodsUpgrade;
        $res["success"]="200";
        $res["message"]="获取成功";
      
        $res["info"]=$data;
        return json_encode($res);*/
	}

}
