<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_seckill}}".
 *
 * @property integer $order_id
 * @property integer $user_id
 * @property string $order_sn
 * @property integer $goods_id
 * @property string $goods_name
 * @property string $goods_thums
 * @property string $price
 * @property integer $num
 * @property string $total_fee
 * @property string $address_name
 * @property string $address_phone
 * @property string $address_region
 * @property string $address_region_id
 * @property string $address_address
 * @property integer $status
 * @property integer $pay_status
 * @property integer $pay_type
 * @property integer $pay_time
 * @property string $pay_num
 * @property string $remarks
 * @property string $refund_remarks
 * @property integer $refund_time
 * @property string $express_type
 * @property string $express_num
 * @property integer $create_time
 */
class OrderSeckill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_seckill}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'order_sn', 'goods_id', 'goods_name', 'goods_thums', 'price', 'num', 'total_fee', 'address_name', 'address_phone', 'address_region', 'address_region_id', 'address_address'], 'required'],
            [['user_id', 'goods_id', 'num', 'status', 'pay_status', 'pay_type', 'pay_time', 'refund_time', 'create_time'], 'integer'],
            [['price', 'total_fee'], 'number'],
            [['order_sn'], 'string', 'max' => 60],
            [['goods_name', 'goods_thums', 'refund_remarks',"refund_status_remark"], 'string', 'max' => 200],
            [['address_name'], 'string', 'max' => 30],
            [['address_phone', 'express_type'], 'string', 'max' => 20],
            [['address_region', 'express_num'], 'string', 'max' => 100],
            [['address_region_id', 'pay_num'], 'string', 'max' => 50],
            [['address_address'], 'string', 'max' => 255],
            [['remarks'], 'string', 'max' => 250],
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
            'order_sn' => '订单号',
            'goods_id' => '商品ID',
            'goods_name' => '商品名称',
            'goods_thums' => '商品缩略图',
            'price' => '价格',
            'num' => '购买数量',
            'total_fee' => '总金额',
            'address_name' => '收货人姓名',
            'address_phone' => '收货人电话',
            'address_region' => '收货人地区',
            'address_region_id' => '收货人地区id',
            'address_address' => '收货人详细地址',
            'status' => '状态',
            'pay_status' => '支付状态',
            'pay_type' => '支付方式',
            'pay_time' => '支付时间',
            'pay_num' => '流水号',
            'remarks' => '备注',
            'refund_remarks' => '退款备注',
            'refund_status_remark' => '退款审核备注',
          
            'refund_time' => '退款时间',
            'express_type' => '快递类型',
            'express_num' => '快递号',
            'create_time' => '创建时间',
        ];
    }
   public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($insert)
            {
                  $this->create_time=time();
                
            }
            return true;

        }else
        {
            return false;
        }
    }

     public function addOrder($goods_id,$aid,$num,$remarks)
     {
         $goods=GoodsSeckill::findOne($goods_id);
         $address=UserAddress::findOne($aid);
         $this->user_id=Yii::$app->user->identity->id;
         $this->order_sn=$this->order_sn=rand(100000,999999).Yii::$app->user->identity->id.time();
         $this->goods_id=$goods->goods_id;
         $this->goods_name=$goods->goods_name;
         $this->goods_thums=$goods->goods_thums;
         $this->price=$goods->price;
         $this->num=$num;
         $this->total_fee=round($goods->price*$num,2);
         $this->address_name=$address->name;
         $this->address_phone=$address->phone;
         $this->address_region=$address->region;
         $this->address_region_id=$address->region_id;
         $this->address_address=$address->address;
         $this->status=0;
         $this->remarks=$remarks;
        $transaction=Yii::$app->db->beginTransaction();
        try {
              if(!$this->save())
              {
                  throw new \yii\db\Exception("保存失败");
              }
             $goods->surplus=$goods->surplus-$num;
             if(!$goods->update(true,["surplus"]))
             {
                throw new \yii\db\Exception("保存失败");
             }
             $transaction->commit();
            return true;

        }catch (\Exception $e) {
            $transaction->rollBack();
            //throw $e;
            return false;
            
        }
     }  
}
