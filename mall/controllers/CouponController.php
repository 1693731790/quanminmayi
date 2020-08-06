<?php
namespace mall\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\UserCoupon;
use common\models\ShopCoupon;
use common\models\Shops;



/**
 * Site controller
 */
class CouponController extends CommonController
{
      public function actionIndex($type="")
      { 
          $this->layout="nofooter";
          $user_id=Yii::$app->user->identity->id;
          $model=UserCoupon::find();
          $time="";
          if($type!="")
          {
            $time=time();
          }
          $coupon=$model->with(["shops"])->where(["user_id"=>$user_id])->andFilterWhere(["<","end_time",$time])->orderBy("user_coupon_id desc")->limit(10)->all();
          //$this->dump($coupon);
          return $this->render("index",[
              "coupon"=>$coupon,
              "type"=>$type,
          ]);
      }

    function actionCouponList($page,$type="")
    {
        $user_id=Yii::$app->user->identity->id;
        $page=($page-1)*10;
        $time="";
        if($type!="")
        {
          $time=time();
        }
        $model=UserCoupon::find();
        $coupon=$model->with(["shops"])->where(["user_id"=>$user_id])->andFilterWhere(["<","end_time",$time])->orderBy("user_coupon_id desc")->offset($page)->limit(10)->all();
        $str=""; 
        foreach($coupon as $couponVal)
        {
            $ison="";
            $astr='<a href="'.Url::to(["shops/shop-info",'shop_id'=>$couponVal->shops->shop_id]).'">去使用</a>';
            if($couponVal->end_time<time())
            {
                $ison="class='on'";
                $astr='已过期';
            }
            $str.=' <li '.$ison.' ><div class="item radius-15"><div class="bt clearfix"><p class="num fl"><i>￥</i>'.$couponVal->fee.'</p><div class="txt fl"><p>优惠券</p></div><div class="round"></div><div class="btn">'.$astr.'</div></div><div class="desc"><p>有效期：'.date("Y-m-d H:i:s",$couponVal->end_time).'</p><p>店铺：'.$couponVal->shops->name.'</p></div></div></li>';

            
           
            
        } 
        //$this->dump($str);
        echo $str;
        //return json_encode($orders);
       
    }

    public function actionAddCoupon($shop_coupon_id)
      { 
          $res=[];
          $user_id=Yii::$app->user->identity->id;
          $shopCoupon=ShopCoupon::findOne($shop_coupon_id);
      	  //$shop=Shops::findOne(["shop_id"=>$shopCoupon->shop_id]);
          
          if(empty($shopCoupon))
          {
              $res["success"]=false;
              $res["message"]="领取失败";
              return json_encode($res);
          }
          $userCoupon=UserCoupon::find()->where(["user_id"=>$user_id,"shop_id"=>$shopCoupon->shop_id])->one();
          if(!empty($userCoupon))
          {
              $res["success"]=false;
              $res["message"]="您已经领取过了";
              return json_encode($res);
          }
      
          $time=time()+($shopCoupon->end_time*86400);
          $model=new UserCoupon();
          $model->shop_id=$shopCoupon->shop_id;
          $model->user_id=$user_id;
          $model->fee=$shopCoupon->fee;
          $model->end_time=$time;
          
          if($model->save())
          {
              $res["success"]=true;
              $res["message"]="领取成功";
              return json_encode($res);
          }else{
              $res["success"]=false;
              $res["message"]="领取失败";
              return json_encode($res);
          }
          
      }
   

      
     

}
