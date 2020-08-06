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
class AfCount 
{
    public static function getOrderCount($type="")//总商品数
    {
        
        $num=AfOrder::find()->andFilterWhere(["status"=>$type])->count();
        return $num;
    }
  

    public static function getOrderFeeCount()//订单金额
    {
        
        $num=AfOrder::find()->sum("total_fee");
        return $num;
    }
  
    public static function getTodayCount()//订单金额
    {
        $date=date("Y-m-d",time());
      	$startTime=strtotime($date." 00:00:00");
        $endTime=strtotime($date." 23:59:59");
      
        $num=AfOrder::find()->where(["between","create_time",$startTime,$endTime])->count();
        return $num;
    }

  

    
}
