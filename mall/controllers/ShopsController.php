<?php
namespace mall\controllers;

use Yii;
use yii\helpers\Url;

use yii\web\Controller;
use common\models\Goods;
use common\models\GoodsCate;
use common\models\Shops;
use common\models\GoodsFavorite;

/**
 * Site controller
 */
class ShopsController extends CommonController
{
          
    public function actionIndex()
    {
        
          //$this->dump($goodsCateDate);
      
      return $this->render("index",[
        
      ]);
    
    }
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

    function actionGoodsList($page,$shop_id,$istuijian="",$isnew="",$ishot="")
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
         
      }

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
