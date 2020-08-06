<?php
namespace front\controllers;
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
use common\models\Yunzhonghe;
use common\models\OrderName;
use common\models\Order;
use common\models\OrderGoods;
use common\models\UserAuth;
use common\models\Sysarticle;



/**
 * Site controller
 */
class IndexController extends CommonController
{
   	function actionTest()
    {
   
      	
    }
    function actionSetGoods()
    {
     	 $goods=Goods::find()->orderBy("goods_id asc")->offset(2000)->limit(500)->all();
      	 $yunzhonghe=new Yunzhonghe();
      	//$this->dump($userAll);
      	foreach($goods as $key=>$val)
        {
          		
          	  if($val->source!="qmmy"&&$val->shop_id=="1")
              {
                //$this->dump($val);
				  $getPriceRes=$yunzhonghe->getGoodsPrice($val->jdgoods_id);
      			  if($getPriceRes->RESPONSE_STATUS=="true")//profitPCT
                  {
                      if($getPriceRes->RESULT_DATA->retail_price!="" && $getPriceRes->RESULT_DATA->market_price!="")
                      {
                        	$goodsOne=Goods::findOne($val->goods_id);
                            $goodsOne->jd_price=$getPriceRes->RESULT_DATA->market_price;
                            $goodsOne->xy_price=$getPriceRes->RESULT_DATA->retail_price;
                            $goodsOne->profitPCT="30";  
							$goodsOne->price=round($getPriceRes->RESULT_DATA->retail_price+($getPriceRes->RESULT_DATA->retail_price*(30/100)),2);
                            $goodsOne->old_price=round($goodsOne->price+($goodsOne->price*0.3),2);
                            $goodsOne->profitFee=round($getPriceRes->RESULT_DATA->retail_price*(30/100),2);
                            
                            $goodsOne->update(true,["jd_price","xy_price","profitPCT","price","old_price","profitFee"]);
                      }


                     /* echo "jd_price:".$this->jd_price."---xy_price:".$this->xy_price."---profitPCT:".$this->profitPCT."---price:".$this->price."---old_price:".$this->old_price."----profitPCT:".$this->profitPCT."----profitFee:".$this->profitFee;
                      die();*/
                  }
                     
              }
        	 
        }
    }
    function actionQifu()
    {
      	$this->layout="nofooter";
        	return $this->render("qifu",[
        ]);
    }
    
   function actionTiaokuan()
    {
      	$this->layout="nofooter";
     	 $model=Sysarticle::findOne(3);
          //$this->dump($model);
        
        return $this->render("tiaokuan",[
          	 "model"=>$model,
        ]);
    }
    
    public function actionIndex($token="",$app_type="")
    {
      
      	
        $cookie = \Yii::$app->request->cookies;
      	$shop_id=$cookie->getValue("shop_id");
        if(!empty($shop_id))
        {
         	return $this->redirect(['shops/shop-info',"shop_id"=>$shop_id]); 
        }
      
        // $this->dump($goodsSeckill);
        // $this->layout="webmain";
        //$this->layout=false;
        $config=Config::findOne(1);
        $banner=Banner::find()->orderBy(["orderby"=>"asc"])->all();
        $special=Special::find()->limit($config->home_show_special_num)->all();

        $goodsCate=GoodsCate::find()->asArray()->where(["goods_cat_is_show"=>"1"])->andwhere(["<>","goods_cat_pid",'0'])->orderBy("goods_cat_sort desc")->limit(6)->all();

        $goodsHot=Goods::find()->where(["status"=>"200","ishot"=>"1","ishome"=>1])->orderBy("create_time desc")->limit(3)->all();
        
        //$goods=Goods::find()->where(["status"=>"200","issale"=>"1","ishome"=>1])->orderBy("create_time desc")->limit(10)->all();
        $goods=Goods::find()->where(["status"=>"200","issale"=>"1","ishome"=>1])->orderBy("price asc")->limit(10)->all();

        //$goodsBuy=Goods::find()->where(["status"=>"200","is_agent_buy"=>"1"])->orderBy("create_time desc")->limit(3)->all();

       
		$goodsSeckill=Goods::find()->where(["status"=>"200","is_seckill"=>"1"])->andFilterWhere(['>','seckill_end_time',time()])->andFilterWhere(['<','seckill_start_time',time()])->orderBy("seckill_price asc")->limit(3)->all();

        //$this->dump($goodsSeckill);

        $adv=Adv::find()->all();
        $article=Article::find()->where(["ishot"=>"1"])->limit(10)->all();
          
        $orderName=OrderName::find()->asArray()->orderBy('RAND()')->limit(10)->select("name,goods_name")->all();
      
       $order=Order::find()->orderBy("create_time desc")->limit(5)->all();
       $orderUser=[];
       foreach($order as $key=>$val)
       {
            $userAuth=UserAuth::find()->where(["user_id"=>$val->user_id,"identity_type"=>"phone"])->one();
            $orderGoods=OrderGoods::find()->where(["order_id"=>$val->order_id])->one();
            $orderUser[$key]["name"]=substr($userAuth->identifier,0,strlen($userAuth->identifier)-4)."****";
            $orderUser[$key]["goods_name"]=$orderGoods->goods_name;
       }
       foreach($orderName as $orderNameKey=>$orderNameVal)
       {
            $orderName[$orderNameKey]["name"]=$orderNameVal["name"]."**";
           
       }
      
      
      $newOrder=array_merge_recursive($orderUser,$orderName);
      //$this->dump($newOrder);
      return $this->render("index",[
          "banner"=>$banner,
          "special"=>$special,
          "goodsCate"=>$goodsCate,
          "goods"=>$goods,
          //"robgoods"=>$robgoods,
          "adv"=>$adv,
          "article"=>$article,
          "goodsHot"=>$goodsHot,
          //"goodsBuy"=>$goodsBuy,
          "goodsSeckill"=>$goodsSeckill,
          "newOrder"=>$newOrder,      

      ]);
    
    }
     function actionGoodsList($page="")
      {
         
          $page=($page-1)*10;
          //$goods=Goods::find()->asArray()->where(["status"=>"200","issale"=>"1","ishome"=>1])->orderBy("create_time desc")->offset($page)->limit(10)->all();
          $goods=Goods::find()->asArray()->where(["status"=>"200","issale"=>"1","ishome"=>1])->orderBy("price asc")->offset($page)->limit(10)->all();
          $str=""; 
          foreach($goods as $goodsVal)
          {
              $str.='<li><a style="display: block;" href="'.Url::to(["goods/detail","goods_id"=>$goodsVal['goods_id']]).'"><div class="spa"><img class="picee" src="'.Yii::$app->params['imgurl'].$goodsVal['goods_thums'].'"><div class="titlewee">'.$goodsVal['goods_name'].'<div class="pricee">¥'.$goodsVal['price'].'&nbsp<span class="hahae">¥'.$goodsVal['old_price'].'</span></div><div class="shopedsi">'.$goodsVal['salecount'].'人已买</div><div class="shoppingsan"><img class="pqc" src="/webstatic/images/picc_03.jpg"></div></div></div></a></li>';
              //$str.='<li style="margin-top:15px;"><a style="display: block;" href="'.Url::to(["goods/detail","goods_id"=>$goodsVal['goods_id']]).'"><div class="spa" style="margin-top: 20px;"><img class="picee" src="'.Yii::$app->params['imgurl'].$goodsVal['goods_thums'].'"><div class="titlewee"><span >'.$goodsVal['goods_name'].'</span><div class="pricee">¥'.$goodsVal['price'].'&nbsp<span class="hahae">¥'.$goodsVal['old_price'].'</span></div></div></div></a></li>';
              
          } 
          //$this->dump($str);
          echo $str;
          //return json_encode($orders);
         
      }
  
   public function actionIndexx($token="",$app_type="")
    {
        $this->layout="webmain";
        $config=Config::findOne(1);
        $banner=Banner::find()->orderBy(["orderby"=>"asc"])->all();
        $special=Special::find()->limit($config->home_show_special_num)->all();

        $goodsCate=GoodsCate::find()->asArray()->where(["goods_cat_is_show"=>"1"])->andwhere(["<>","goods_cat_pid",'0'])->orderBy("goods_cat_sort desc")->all();
        $goods=Goods::find()->where(["status"=>"200","issale"=>"1","ishome"=>1])->orderBy("create_time desc")->limit(60)->all();
        $robgoods=RobBuy::find()->with(["goods"])->where([">","start_time",time()])->orderBy("start_time asc")->limit(4)->all();
        $adv=Adv::find()->all();
        $article=Article::find()->where(["ishot"=>"1"])->limit(10)->all();
          //$this->dump($token);
        if(Yii::$app->user->isGuest)
        {
              if(isset($language))
              {
                  $user=User::findIdentityByAccessToken($language->value,10);
              }else{
                  $user=User::findIdentityByAccessToken($token,10);
              }
   
              if($user){
                  Yii::$app->user->login($user);   
              }
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
        if($app_type)
        {
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                        'name' => "appType",
                        'value' => $app_type,
                        'expire'=>time()+3600*24*7,
            ]));
        }

      return $this->render("index-old",[
          "banner"=>$banner,
          "special"=>$special,
          "goodsCate"=>$goodsCate,
          "goods"=>$goods,
          "robgoods"=>$robgoods,
          "adv"=>$adv,
          "article"=>$article,

      ]);
    
    }
   
}
