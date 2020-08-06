<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $order_sn
 * @property integer $shop_id
 * @property integer $goods_id
 * @property string $total_fee
 * @property string $deliver_fee
 * @property integer $address_id
 * @property integer $status
 * @property integer $pay_status
 * @property integer $pay_type
 * @property integer $pay_time
 * @property string $pay_num
 * @property string $remarks
 * @property integer $is_comment
 * @property integer $is_refund
 * @property string $refund_remarks
 * @property integer $is_settlement
 * @property integer $use_score
 * @property integer $get_score
 * @property integer $delivery_time
 * @property integer $receive_time
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {        
        return [
            [['user_id', 'order_sn', 'shop_id',  'total_fee', 'deliver_fee', 'address_name','address_phone','address_region','address_region_id','address_address', 'create_time'], 'required'],
            [['user_id',  'shop_id', 'status',  'pay_type', 'pay_time', 'is_comment', 'is_settlement', 'delivery_time', 'receive_time', 'create_time','order_all_pay_id','refund_is_shop','isgroup'], 'integer'],
            [['total_fee','deliver_fee','coupon',"telfare_fee"], 'number'],
            [['pay_num',"address_region_id"], 'string', 'max' => 50],
            [['remarks',"address_address"], 'string', 'max' => 250],
            [['order_sn'], 'string', 'max' => 60],
            [['express_num',"address_region"], 'string', 'max' => 100],
            [['express_type',"address_phone"], 'string', 'max' => 20],
            [['address_name'], 'string', 'max' => 30],
            
            [['refund_remarks','refund_status_remark'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'ID',
            'user_id' => '用户ID',
            'order_sn' => '订单编号',
            'shop_id' => '店铺ID',
            
            'total_fee' => '总金额',
            'deliver_fee' => '运费金额',
            'address_name' => '收货人姓名',
            'address_phone' => '收货人电话',
            'address_region' => '收货人地区',
            'address_region_id' => '收货人地区id',
            'address_address' => '收货人详细地址',
             
            'status' => '状态',
            //'pay_status' => '支付状态',
            
            'pay_type' => '支付方式',
            'pay_time' => '支付时间',
            'pay_num' => '支付流水号',
            'remarks' => '备注',
            'is_comment' => '是否评论',
            'coupon' => '优惠券金额',
            
            'refund_remarks' => '退款说明',
            'refund_status_remark' => '退款状态说明',
          
            'is_settlement' => '是否结算',
            
            'delivery_time' => '发货时间',
            'receive_time' => '收货时间',
            'create_time' => '创建时间',
            "goods_card_fee"=>"使用商品卡抵扣的金额",
            'order_all_pay_id' => '是否批量付款',
                
        ];
    }

    public function getShops()
    {
        return $this->hasOne(Shops::className(), ["shop_id"=>"shop_id"])->select(["shop_id","name","img"]);
  
    }
    public function getOrderGoods()
    {
        return $this->hasMany(OrderGoods::className(), ["order_id"=>"order_id"]);
  
    }


    public function addOrder($data)//添加订单
    {
        $user_id=Yii::$app->user->identity->id;
        $sku=GoodsSku::findOne($data["skuid"]);
        $goods=Goods::findOne($data["goods_id"]);
        $config=Config::findOne(1);
        
        $userCoupon="";
        if(isset($data["coupon"]))
        {
            $userCoupon=UserCoupon::findOne($data["coupon"]);
        }

        if(isset($data["telFeeDeductions"]))
        {
            //计算可以使用话费抵扣的金额
              $telFeeDeductions=0;
              if($data['skuid']!=""){
                  $oneDeductions=round($goods->profitFee*($config->goods_telfare_pct/100),0);//单一抵扣金额
                  $telFeeDeductions=round($oneDeductions*$data['num'],0);
              }else{
                  $oneDeductions=round($goods->profitFee*($config->goods_telfare_pct/100),0);//单一抵扣金额
                  $telFeeDeductions=round($oneDeductions*$data['num'],0);
              }
              


            /*  $mobileApi=new MobileApi();
              $myTelFee=$mobileApi->getTelFare();//话费余额
             
              $myUserGetCallFee=$myUser->get_call_fee;
              
              $myUserTelFee=round($myTelFee+$myUserGetCallFee,2);*/
             //话费余额开始
          	
              $userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$user_id])->one();
              $mobile=$userAuth->identifier;               
              $suibianda=new Suibianda($mobile);
              $callRes=$suibianda->getMoney();
              $myTelFee="0";
              if($callRes)
              {
                  $myTelFee=$callRes;
              }
          	  $myUserTelFee=round($myTelFee,2);
          
			  $myUser=User::findOne($user_id);
          
              if($myUserTelFee<$telFeeDeductions&&$myUserTelFee>0)//话费少于可以抵扣金额并且大于0  
              {
                   $telFeeDeductions=$myUserTelFee;
              }
              if($myUserTelFee==0)//  
              {
                   $telFeeDeductions="0";
              }

              if($telFeeDeductions!="0") // 
              {
                  if($myUserGetCallFee>=$telFeeDeductions)
                  {
                    $myUser->get_call_fee=round($myUserGetCallFee-$telFeeDeductions,2);
                    $myUser->update(true,["get_call_fee"]);
                  }else{
                    if($myUserGetCallFee!=0)
                    {
                      $myUser->get_call_fee=0;
                      $myUser->update(true,["get_call_fee"]); 
                      $mobileApiCallFee=$telFeeDeductions-$myUserGetCallFee;
                    }else{
                      //$mobileApiCallFee=$myTelFee-$telFeeDeductions;
                       $mobileApiCallFee=$telFeeDeductions;
                    }

                    $reduceTelFare=$mobileApi->reduceTelFare("-".$mobileApiCallFee);
                      if(!$reduceTelFare)
                      {
                          echo "话费扣除失败";
                          die();
                      }
                  }
              }
              

             
        }
        $userAddress=UserAddress::find()->asArray()->where(["aid"=>$data["address_id"]])->one();
        
        $transaction=Yii::$app->db->beginTransaction();
        try {
            
            $this->user_id=$user_id;
            $this->order_sn=rand(100000,999999).Yii::$app->user->identity->id.time();
            $this->shop_id=$data["shop_id"];

           /* $yunzhonghe=new Yunzhonghe();
            if($data["shop_id"]=="1"&&$goods->is_agent_buy=="0")
            {
                
                $res=$yunzhonghe->getSubmit($goods->jdgoods_id."_".$data['num'],$this->order_sn,$userAddress);  
                
                if($res->result!=0)
                {
                    throw new \yii\db\Exception("保存失败"); 
                }else{
                    $this->order_yzh_sn=$res->ordersn;    
                }  
            }*/

            if($telFeeDeductions!=0)
            {
                $this->telfare_fee=$telFeeDeductions;
            }
            //如果是升级vip会员商品
            if($goods->is_agent_buy=="1")
            {
                $this->is_upagent_buy="1";    
            }
            if($goods->is_seckill=="1")
            {
                $this->is_seckill="1";    
            }
            $couponFee=0;
            if(!empty($userCoupon))
            {
                if($userCoupon->user_id!=$user_id)
                {
                    throw new \yii\db\Exception("保存失败");  
                }
                $couponFee=$userCoupon->fee;
                if(!$userCoupon->delete())
                {
                    throw new \yii\db\Exception("保存失败");  
                }
            }


            
            if($data['skuid']=="")
            {
                if($goods->is_seckill=="1")
                {
                    $this->total_fee=round($goods->seckill_price*$data['num']+$goods->freight,2);
                }else{
                    $this->total_fee=round(($goods->price*$data['num']+$goods->freight)-$couponFee,2);
                }
            }else{
                $this->total_fee=round(($sku->price*$data['num']+$goods->freight)-$couponFee,2);
                
            }

            

            
            $this->deliver_fee=$goods->freight;    
            $this->address_name=$userAddress['name'];
            $this->address_phone=$userAddress['phone'];
            $this->address_region=$userAddress['region'];
            $this->address_region_id=$userAddress['region_id'];
            $this->address_address=$userAddress['address'];
            $this->remarks=$data["remarks"];
            $this->coupon=$couponFee;
            $this->create_time=time();
           if($goods->is_group=="1")
           {
            	 $this->isgroup="1";
           }
            if(!$this->save())
            {
                throw new \yii\db\Exception("保存失败");
            } 

            $orderGoods=new OrderGoods();    
            $orderGoods->order_id=$this->order_id;
            $orderGoods->goods_id=$goods->goods_id;
            $orderGoods->goods_name=$goods->goods_name;
            $orderGoods->goods_thums=$goods->goods_thums;
            if($data['skuid']=="")
            {
                $orderGoods->attr_name="";
                if($goods->is_seckill=="1")
                {
                    $orderGoods->price=$goods->seckill_price;
                }else{
                    $orderGoods->price=$goods->price;
                }
            }else{
                $orderGoods->attr_name=$sku->sku_name;
                $orderGoods->price=$sku->price;
            }
            $orderGoods->num=$data['num'];
            if(!$orderGoods->save())
            {
                throw new \yii\db\Exception("保存失败");
            }

            if($data["skuid"]!="")
            {
                $sku->stock=$sku->stock-1;
                if(!$sku->save())
                {
                    throw new \yii\db\Exception("保存失败");
                }
            }
                        
            $transaction->commit();
            return true;

        }catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
            return false;
            
        }
    }



    public function addRobOrder($data)//抢单添加订单
    {
        $sku=GoodsSku::findOne($data["skuid"]);
        $goods=Goods::findOne($data["goods_id"]);
        $robBuy=RobBuy::findOne($data['rob_id']);
        $userCoupon=UserCoupon::findOne($data["coupon"]);
        $transaction=Yii::$app->db->beginTransaction();
        try {
            $this->user_id=Yii::$app->user->identity->id;
            $this->order_sn=rand(100000,999999).Yii::$app->user->identity->id.time();
            $cookie = \Yii::$app->request->cookies;
            $appType=$cookie->getValue('appType');
            if($appType=="hz")
            {
                $this->app_pay_type=2;
            }else if($appType=="sj"){
                $this->app_pay_type=1;
            }
            
            $this->shop_id=$data["shop_id"];
            $couponFee=0;
            if(!empty($userCoupon))
            {
                if($userCoupon->user_id!=$user_id)
                {
                    throw new \yii\db\Exception("保存失败");  
                }
                $couponFee=$userCoupon->fee;

            }

            $this->total_fee=round(($robBuy->price*$data['num']+$goods->freight)-$couponFee,2);
            
            
            $this->deliver_fee=$goods->freight;
            $this->address_id=$data["address_id"];
            $this->remarks=$data["remarks"];
            $this->coupon=$couponFee;
            $this->create_time=time();
          
            if(!$this->save())
            {
                throw new \yii\db\Exception("保存失败");
            }   
              
            $orderGoods=new OrderGoods();    
            $orderGoods->order_id=$this->order_id;
            $orderGoods->goods_id=$goods->goods_id;
            $orderGoods->goods_name=$goods->goods_name;
            $orderGoods->goods_thums=$goods->goods_thums;
            if($data['skuid']=="")
            {
                $orderGoods->attr_name="";
                $orderGoods->price=$goods->price;
            }else{
                $orderGoods->attr_name=$sku->sku_name;
                $orderGoods->price=$sku->price;
            }
            
            $orderGoods->num=$data['num'];
            if(!$orderGoods->save())
            {
                throw new \yii\db\Exception("保存失败");
            }
            if($data["skuid"]!="")
            {
                $sku->stock=$sku->stock-1;
                if(!$sku->save())
                {
                    throw new \yii\db\Exception("保存失败");
                }
            }
            
            
            $transaction->commit();
            return true;

        }catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
            return false;
            
        }
    }



}
