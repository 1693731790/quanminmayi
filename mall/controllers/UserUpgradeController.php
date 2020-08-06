<?php
namespace mall\controllers;

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
class UserUpgradeController extends CommonController
{
      public $enableCsrfValidation = false;
       public function actionDetail($goods_id)
      {
         
          $this->layout="nofooter";
         
          
          $model =Goods::findOne($goods_id);
          $goods_img=json_decode($model->goods_img);
          $model->browse=$model->browse+1;
          $model->update(true, ['browse']);
          
          $model->goods_img=$goods_img;          
          if($model->status!="200")
          { 
              exit("未知错误");
              return false;
          }
          return $this->render('detail', [
              'model' => $model,
              
          ]);
        
      }
      public function actionGoods($searchKey="",$salecount="",$browse="",$new="",$istodaynew="")
      {
          //$this->layout="nofooter";
          //$this->layout="newmain";
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
          $goods=$model->where(["status"=>"200","issale"=>"1","is_agent_buy"=>"1"])->andFilterWhere(['istodaynew'=>$istodaynew])->andFilterWhere(['like', 'goods_name', $searchKey])->orderBy($orderby)->limit(10)->all();

          
          
          return $this->render("goods",[
              "goods"=>$goods,
              "searchKey"=>$searchKey,
              "salecount"=>$salecount,
              "browse"=>$browse,
              "new"=>$new,
              "istodaynew"=>$istodaynew,
              
          ]);
      }

      function actionGoodsList($page="",$searchKey="",$salecount="",$browse="",$new="",$istodaynew="")
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
          $goods=$model->asArray()->where(["status"=>"200","issale"=>"1","is_agent_buy"=>"1"])->andFilterWhere(['istodaynew'=>$istodaynew])->andFilterWhere(['like', 'goods_name', $searchKey])->orderBy($orderby)->offset($page)->limit(10)->all();
          
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
