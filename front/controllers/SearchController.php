<?php
namespace front\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\Order;
use common\models\Goods;
use common\models\GoodsFavorite;
use common\models\Shops;




/**
 * Site controller
 */
class SearchController extends CommonController
{
      public $enableCsrfValidation = false;

      public function actionShops($searchKey="")
      {
          $this->layout="nofooter";
          $model=Shops::find();
          
          
          $shops=$model->asArray()->where(["status"=>"200"])->andFilterWhere(['like', 'name', $searchKey])->orderBy("browse desc")->limit(10)->all();

          foreach ($shops as $key => $shopsval)
          {   
              $shops[$key]["goods"]=Goods::find()->asArray()->where(['shop_id'=>$shopsval['shop_id'],"status"=>"200","issale"=>"1"])->select(['goods_id','goods_name','goods_thums','price'])->limit(5)->all();
              $shops[$key]["goodscount"]=Goods::find()->where(['shop_id'=>$shopsval['shop_id'],"status"=>"200","issale"=>"1"])->count();
              $shops[$key]["salecount"]=Order::find()->where(['shop_id'=>$shopsval['shop_id']])->count();
          }  
          //$this->dump($shops);
          return $this->render("shops",[
              "shops"=>$shops,
              "searchKey"=>$searchKey,
              
            
          ]);
      }

      function actionShopsList($page="",$searchKey="",$salecount="",$browse="",$new="")
      {
          $page=($page-1)*10;
          $model=Shops::find();
          $shops=$model->asArray()->where(["status"=>"200"])->andFilterWhere(['like', 'name', $searchKey])->orderBy("browse desc")->offset($page)->limit(10)->all();

          $str=""; 
          foreach ($shops as $key => $shopsval)
          {   
              $goods=Goods::find()->asArray()->where(['shop_id'=>$shopsval['shop_id'],"status"=>"200","issale"=>"1"])->select(['goods_id','goods_name','goods_thums','price'])->limit(5)->all();
              $goodscount=Goods::find()->where(['shop_id'=>$shopsval['shop_id'],"status"=>"200","issale"=>"1"])->count();
              $salecount=Order::find()->where(['shop_id'=>$shopsval['shop_id']])->count();
              $goodsstr="";
              foreach($goods as $goodskey=>$goodsval)
              {
                  $goodsstr.='<li><a href="'.Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']]).'"><img src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'" alt=""/> <span class="Price">￥'.$goodsval['price'].'</span> </a></li>';
              }

              $str.='<li class="blist"><div class="StoreInfo"><div class="photo"> <img src="'.Yii::$app->params['imgurl'].$shopsval['img'].'" alt=""/> </div><div class="con"><h2>'.$shopsval['name'].'</h2><i class="iconfont icon-flagshipstore"></i> <p>销量'.$salecount.'   共'.$goodscount.'件宝贝</p></div><div class="rightcon"><a href="'.Url::to(['shops/shop-info',"shop_id"=>$shopsval['shop_id']]).'">进入店铺</a></div></div><div class="ProLists"><div class="phone_gdt"><ul>'.$goodsstr.'</ul></div></div></li>';
          }  
          
          
         
          //$this->dump($str);
          echo $str;
          //return json_encode($orders);
         
      }


      public function actionGoods($searchKey="",$salecount="",$browse="",$new="",$istodaynew="",$isselected="",$shop_id="")
      {
          
          $this->layout="nofooter";
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
          $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andFilterWhere(["shop_id"=>$shop_id])->andFilterWhere(['istodaynew'=>$istodaynew])->andFilterWhere(['isselected'=>$isselected])->andFilterWhere(['like', 'goods_name', $searchKey])->orderBy($orderby)->limit(10)->all();

          foreach ($goods as $key => $goodsval)
          {
              $favorite=GoodsFavorite::find()->where(['goods_id'=>$goodsval['goods_id']])->count();
              $goods[$key]["favorite"]=$favorite;
          }  
          
          return $this->render("goods",[
              "goods"=>$goods,
              "searchKey"=>$searchKey,
            
              "salecount"=>$salecount,
              "browse"=>$browse,
              "new"=>$new,
              "istodaynew"=>$istodaynew,
              "isselected"=>$isselected,
              "shop_id"=>$shop_id,

          ]);
      }

      function actionGoodsList($page="",$searchKey="",$salecount="",$browse="",$new="",$istodaynew="",$isselected="",$shop_id="")
      {
         
          $page=($page-1)*10;
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
          $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andFilterWhere(["shop_id"=>$shop_id])->andFilterWhere(['istodaynew'=>$istodaynew])->andFilterWhere(['isselected'=>$isselected])->andFilterWhere(['like', 'goods_name', $searchKey])->orderBy($orderby)->offset($page)->limit(10)->all();
          
          $str=""; 
         
          foreach($goods as $goodsval)
          {
              $favorite=GoodsFavorite::find()->where(['goods_id'=>$goodsval['goods_id']])->count();
              
              $str.='<a href="'.Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']]).'"><div class="centers"><div class="centerone"><img class="centertwos" src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'"/></div><div class="centertwo"><div class="centertwoone">'.$goodsval['goods_name'].'</div><div class="centertwothree"><div class="centertwothrees">¥'.$goodsval['price'].'&nbsp&nbsp<span class="pi">¥'.$goodsval['old_price'].'</span></div></div><div class="centertwotwo">销量'.$goodsval['salecount'].'&nbsp&nbsp&nbsp 收藏'.$favorite.'</div></div></div></a>';
              
          } 
          //$this->dump($str);
          echo $str;
          //return json_encode($orders);
         
      }
      

      public function actionGoodsSearch($searchKey="",$salecount="",$browse="",$new="")//是否今日上新或者精选商品   未使用
      {
          
          $this->layout="nofooter";
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
          $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andFilterWhere(['like', 'goods_name', $searchKey])->orderBy($orderby)->limit(10)->all();

          foreach ($goods as $key => $goodsval)
          {
              $favorite=GoodsFavorite::find()->where(['goods_id'=>$goodsval['goods_id']])->count();
              $goods[$key]["favorite"]=$favorite;
          }  
          
          return $this->render("goods",[
              "goods"=>$goods,
              "searchKey"=>$searchKey,
            
              "salecount"=>$salecount,
              "browse"=>$browse,
              "new"=>$new,

          ]);
      }

      function actionGoodsSearchList($page="",$searchKey="",$salecount="",$browse="",$new="")//是否今日上新或者精选商品列表   未使用
      {
         
          $page=($page-1)*10;
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
          $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andFilterWhere(['like', 'goods_name', $searchKey])->orderBy($orderby)->offset($page)->limit(10)->all();
          
          $str=""; 
         
          foreach($goods as $goodsval)
          {
              $favorite=GoodsFavorite::find()->where(['goods_id'=>$goodsval['goods_id']])->count();
              
              $str.='<li><a href="'.Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']]).'"><div class="Pic"><img src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'" alt=""/></div><div class="Con"><h2 class="slh2">'.$goodsval['goods_name'].'</h2><p class="Price"><span class="cr_f84e37">￥'.$goodsval['price'].'</span><span class="ml40" style="text-decoration:line-through;">￥'.$goodsval['old_price'].'</span></p><p class="Statistics"><span class="ml15">销量'.$goodsval['salecount'].'</span><span class="ml15">收藏'.$favorite.'</span></p></div></a></li>';
              
          } 
          //$this->dump($str);
          echo $str;
          //return json_encode($orders);
         
      }

}
