<?php
namespace front\controllers;

use Yii;
use yii\helpers\Url;

use yii\web\Controller;
use common\models\Goods;
use common\models\User;
use common\models\GoodsCate;
use common\models\Shops;
use common\models\GoodsFavorite;
use common\models\ShopsCate;
use common\models\ShopsClass;
use common\models\ShopsBanner;

/**
 * Site controller
 */
class ShopsController extends Controller  //CommonController
{
          
    public function actionIndex()
    {
        
          //$this->dump($goodsCateDate);
      
      return $this->render("index",[
        
      ]);
    
    }
  
  	public function actionShopInfo($shop_id)
    {
		$this->layout=false;
      	$cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
                'name' => 'shop_id',
                'value' => $shop_id,
                'expire'=>time()+1800,
        ]));
      	$user="";	
      	if(!yii::$app->user->isGuest)
        {
          	$user_id=Yii::$app->user->identity->id;
            $user=User::find()->where(["id"=>$user_id])->select(["id","recharge_fee"])->one();
        }
      	
      	/*
        $cookie = \Yii::$app->request->cookies;
      	$shop_id=$cookie->getValue("shop_id");
        */
      
        $shop=Shops::findOne($shop_id);
        $shop->browse=$shop->browse+1;
        $shop->update(true,["browse"]);
      	$shopCate=ShopsCate::find()->where(["shop_id"=>$shop_id,"ishome"=>1])->orderBy("id desc")->limit(9)->all();//店铺品牌分类
        $shopClass=ShopsClass::find()->where(["shop_id"=>$shop_id,"ishome"=>1])->andWhere(["<>","pid","0"])->orderBy("id desc")->limit(4)->all();//店铺品牌分类
        //$this->dump($shopCate);
      	$shopBanner=ShopsBanner::find()->where(["shop_id"=>$shop_id])->orderBy("orderby desc")->all();//店铺banner
      	
      	$model=Goods::find();
      	$shopsLimit=$model->where(["shop_id"=>$shop_id,"status"=>"200","shops_limit"=>1])->orderBy("create_time desc")->limit(3)->all();//限量商品
      
      
      
      	$goods1=$model->where(["shop_id"=>$shop_id,"status"=>"200"])->andWhere(["between","price","0","200"])->orderBy("create_time desc")->limit(4)->all();//0-100之间的商品
      	$goods2=$model->where(["shop_id"=>$shop_id,"status"=>"200"])->andWhere(["between","price","200","500"])->orderBy("create_time desc")->limit(4)->all();//100-200之间的商品
        $goods3=$model->where(["shop_id"=>$shop_id,"status"=>"200"])->andWhere(["between","price","500","1000"])->orderBy("create_time desc")->limit(4)->all();//200-300之间的商品
      	$goods3_=$model->where(["shop_id"=>$shop_id,"status"=>"200"])->andWhere(["between","price","1000","2000"])->orderBy("create_time desc")->limit(4)->all();//300+之间的商品
      	//$this->dump($goods4);
      	
        $goodsall=$model->where(["status"=>"200","shop_id"=>$shop_id])->orderBy("browse DESC")->limit(40)->select(["goods_id","goods_name","price","old_price","goods_thums"])->all();
		//
        return $this->render("shop-info",[
              "shop"=>$shop,
              "goods"=>$goods,
              "shopCate"=>$shopCate,
              "shopBanner"=>$shopBanner,
              "shopsLimit"=>$shopsLimit,
             
              "goodsall"=>$goodsall,
          	  "shop_id"=>$shop_id,
          	  "user"=>$user,
              "shopClass"=>$shopClass,
          	  "goods1"=>$goods1,
              "goods2"=>$goods2,
              "goods3"=>$goods3,
              "goods3_"=>$goods3_,
          		
              
             
        ]);
     }
  	public function actionShopCate()
    {
		$this->layout="nofooter";
      	
      //	$shopCate=ShopsCate::find()->where(["shop_id"=>$shop_id])->orderBy("id desc")->all();//店铺品牌分类
         $cookie = \Yii::$app->request->cookies;
         $shop_id=$cookie->getValue("shop_id");
              
        $shop=Shops::findOne($shop_id);
      	$shopsClass=ShopsClass::find()->asArray()->where(["shop_id"=>$shop_id,"pid"=>0])->orderBy("sort asc")->all();
      	foreach($shopsClass as $key=>$val)
        {
         	 $shopsClass[$key]["class"]=ShopsClass::find()->asArray()->where(["shop_id"=>$shop_id,"pid"=>$val["id"]])->orderBy("sort asc")->all();
        }
      
        $shopsCate=ShopsCate::find()->where(["shop_id"=>$shop_id])->orderBy("id desc")->all();
      	//$this->dump($shop);
        return $this->render("shopcate",[
              "shopsClass"=>$shopsClass,
              "shop"=>$shop,
              "shopsCate"=>$shopsCate,
          	  
              
          
        ]);
      
      
     }
  	  
   /*   function actionGoodsList($page,$shop_id)
      {
         
          $page=($page-1)*10;
          $model=Goods::find();
          $goodsall=$model->asArray()->where(["status"=>"200","shop_id"=>$shop_id])->orderBy("browse DESC")->offset($page)->limit(10)->select(["goods_id","goods_name","price","old_price","goods_thums"])->all();
      
          $str=""; 
          foreach($goodsall as $goodsval)
          {
              $str.='<li><a href="'.Url::to(["goods/detail","goods_id"=>$goodsval['goods_id']]).'"><div class="div-img"><img src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'" /></div><div><p class="p01">'.$goodsval['goods_name'].'</p><p><span class="sp01 text-overflow"><em>¥</em>'.$goodsval['old_price'].'</span><span class="sp02 text-overflow">¥'.$goodsval['price'].'</span></p></div></a></li>';
          } 
          //$this->dump($str);
          echo $str;
          //return json_encode($orders);
         
      }*/
    /* 旧版店铺首页
    public function actionShopInfo($shop_id,$istuijian="",$isnew="",$ishot="")
    {

        $shop=Shops::findOne($shop_id);
        $shop->browse=$shop->browse+1;
        $shop->update(true,["browse"]);
        $model=Goods::find();
        $newcount=$model->where(["status"=>"200","issale"=>"1","shop_id"=>$shop_id,"isnew"=>1])->count();
        $tuijiancount=$model->where(["status"=>"200","issale"=>"1","shop_id"=>$shop_id,"istuijian"=>1])->count();
        $hotcount=$model->where(["status"=>"200","issale"=>"1","shop_id"=>$shop_id,"ishot"=>1])->count();
        //$this->dump($orderby);
        $count=$model->where(["status"=>"200","issale"=>"1","shop_id"=>$shop_id])->andFilterWhere(["istuijian"=>$istuijian,"isnew"=>$isnew,"ishot"=>$ishot])->count();
        $goods=$model->asArray()->where(["status"=>"200","issale"=>"1","shop_id"=>$shop_id])->andFilterWhere(["istuijian"=>$istuijian,"isnew"=>$isnew,"ishot"=>$ishot])->orderBy("browse DESC")->limit(10)->select(["goods_id","goods_name","price","old_price","goods_thums"])->all();

        
        
        
        return $this->render("shop-info",[
              "shop"=>$shop,
              "goods"=>$goods,
              "count"=>$count,
              
              "shop_id"=>$shop_id,
              "istuijian"=>$istuijian,
              "isnew"=>$isnew,
              "ishot"=>$ishot,
              "newcount"=>$newcount,
              "tuijiancount"=>$tuijiancount,
              "hotcount"=>$hotcount,
        ]);
    
    }
    */
	
  
  /*  function actionGoodsList($page,$shop_id,$istuijian="",$isnew="",$ishot="")旧版异步加载商品列表
      {
         
          $page=($page-1)*10;
          $model=Goods::find();
          $goods=$model->asArray()->where(["status"=>"200","issale"=>"1","shop_id"=>$shop_id])->andFilterWhere(["istuijian"=>$istuijian,"isnew"=>$isnew,"ishot"=>$ishot])->orderBy("browse DESC")->offset($page)->limit(10)->select(["goods_id","goods_name","price","old_price","goods_thums"])->all();
          
          $str=""; 
         
          foreach($goods as $goodsval)
          {
              
              $str.='<li><a href="'.Url::to(["goods/detail","goods_id"=>$goodsval['goods_id']]).'"><div class="pic"> <img src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'" alt=""/> </div><h3 class="slh2">'.$goodsval['goods_name'].'</h3><p class="Price">￥'.$goodsval['price'].'<span class="OriginalPrice">￥'.$goodsval['old_price'].'</span></p></a></li>';
              
          } 
          //$this->dump($str);
          echo $str;
          //return json_encode($orders);
         
      }*/

    /*public function actionShopInfo($shop_id,$salecount="",$browse="",$new="")
    {
        $shop=Shops::findOne($shop_id);
        
        $model=Goods::find();
        $orderby='browse DESC';
        if($salecount!="")
        {
             $orderby='salecount '.$salecount;
        }
        if($browse!="")
        {
             $orderby='browse '.$browse;
        }
        if($new!="")
        {
             $orderby='create_time '.$new;
        }
        //$this->dump($orderby);
        $goods=$model->asArray()->where(["status"=>"200","issale"=>"1","shop_id"=>$shop_id])->orderBy($orderby)->limit(5)->all();

        foreach ($goods as $key => $goodsval)
        {
            $favorite=GoodsFavorite::find()->where(['goods_id'=>$goodsval['goods_id']])->count();
            $goods[$key]["favorite"]=$favorite;
        }
        //$this->dump($goods);
      
        return $this->render("shop-info",[
              "shop"=>$shop,
              "goods"=>$goods,
              "shop_id"=>$shop_id,
              "salecount"=>$salecount,
              "browse"=>$browse,
              "new"=>$new,
        ]);
    
    }
    function actionGoodsList($shop_id,$salecount="",$browse="",$new="")
      {
         
          $page=($page-1)*5;
          $model=Goods::find();
          $orderby='browse DESC';
          if($salecount!="")
          {
               $orderby='salecount '.$salecount;
          }
          if($browse!="")
          {
               $orderby='browse '.$browse;
          }
          if($new!="")
          {
               $orderby='create_time '.$new;
          }
          $goods=$model->asArray()->where(["status"=>"200","issale"=>"1","shop_id"=>$shop_id])->orderBy($orderby)->offset($page)->limit(5)->all();
          
          $str=""; 
         
          foreach($goods as $goodsval)
          {
              $favorite=GoodsFavorite::find()->where(['goods_id'=>$goodsval['goods_id']])->count();
              
              $str.='<li><a href="'.Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']]).'"><div class="Pic"><img src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'" alt=""/></div><div class="Con"><h2 class="slh2">'.$goodsval['goods_name'].'</h2><p class="Price"><span class="cr_f84e37">￥'.$goodsval['price'].'</span><span class="ml40" style="text-decoration:line-through;">￥'.$goodsval['old_price'].'</span></p><p class="Statistics"><span class="ml15">销量'.$goodsval['salecount'].'</span><span class="ml15">收藏'.$favorite.'</span></p></div></a></li>';
              
          } 
          //$this->dump($str);
          echo $str;
          //return json_encode($orders);
         
      }*/
   
}
