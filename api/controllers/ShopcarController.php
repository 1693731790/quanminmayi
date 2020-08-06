<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\UserAddress;
use common\models\GoodsShopcar;
use common\models\Goods;
use common\models\Shops;
use common\models\GoodsSku;
use common\models\Order;
use common\models\OrderAllPay;
use common\models\OrderGoods;
use common\models\Liguanjia;
use common\models\MobileApi;
use common\models\Config;
use common\models\User;
use common\models\Yunzhonghe;



/**
 * 购物车
 */
class ShopcarController extends Controller
{
      public $enableCsrfValidation = false;

    
      public function actionAddShopcar()//加入购物车
      {
          $res=[];
          if($data=Yii::$app->request->get())
          {
              $goods=Goods::findOne($data["goods_id"]);
              if($goods["is_agent_buy"]=="1")
              {
                    $res["success"]=false;
                    $res['message']="未知错误";
              }
              $model=new GoodsShopcar();
              if($model->addShopcar($data,"api"))
              {
                  $res["success"]=true;
                  $res['message']="加入购物车成功";
              }else{
                  $res["success"]=false;
                  $res['message']="加入购物车失败";
              }
              return json_encode($res);

              
          }
          $res["success"]=false;
          $res['message']="数据不正确";
          return json_encode($res);
      }

    

}
