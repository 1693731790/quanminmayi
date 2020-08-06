<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_sku}}".
 *
 * @property integer $sku_id
 * @property integer $goods_id
 * @property string $attr_path
 * @property string $price
 * @property integer $stock
 */
class Count 
{
    public static function getGoodsCount($shop_id="",$status="")//总商品数
    {
        if($status!="")
        {
           $num=Goods::find()->where(["status"=>$status])->andFilterWhere(["shop_id"=>$shop_id])->count();
        }else{
            $num=Goods::find()->where(["in","status",['0','200']])->andFilterWhere(["shop_id"=>$shop_id])->count();

        }
       
        return $num;
    }

    public static function getOrderCount($shop_id="",$type="")//订单数
    {
        //0=>'待付款', 1=>'已付款', 2=>'已发货',3=>'已完成', 4=>"退款中",5=>"已退款",

        $num=Order::find()->andFilterWhere(["shop_id"=>$shop_id])->andFilterWhere(["status"=>$type])->count();
        return $num;
    }

    public static function getOrderFeeCount($shop_id="",$type="")//订单金额
    {
        //0=>'待付款', 1=>'已付款', 2=>'已发货',3=>'已完成', 4=>"退款中",5=>"已退款",

        $num=Order::find()->andFilterWhere(["shop_id"=>$shop_id])->andFilterWhere(["status"=>$type])->sum("total_fee");
        return $num;
    }

    public static function getUserCount()//用户总数
    {

        $num=User::find()->count();
        return $num;
    }

    public static function getShopsCount($status="")//店铺总数
    {
        $num=Shops::find()->where(["<>","status","-1"])->andFilterWhere(['status'=>$status])->count();
        return $num;
    }

    
}
