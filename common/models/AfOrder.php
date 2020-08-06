<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%af_order}}".
 *
 * @property integer $order_id
 * @property integer $d_id
 * @property integer $user_id
 * @property string $order_sn
 * @property string $total_fee
 * @property string $address_name
 * @property string $address_phone
 * @property string $address_region
 * @property string $address_region_id
 * @property string $address_address
 * @property integer $status
 * @property string $pay_img
 * @property string $remarks
 * @property string $express_type
 * @property string $express_num
 * @property integer $create_time
 */
class AfOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%af_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['d_id', 'user_id', 'order_sn', 'total_fee', 'address_name', 'address_phone', 'address_region', 'address_region_id', 'address_address',"goods_id","goods_name","num"], 'required'],
            [['d_id', 'user_id', 'status', 'create_time',"goods_id","num"], 'integer'],
            [['total_fee'], 'number'],
            [['order_sn'], 'string', 'max' => 60],
            [['address_name'], 'string', 'max' => 30],
            [['address_phone', 'express_type'], 'string', 'max' => 20],
            [['address_region', 'express_num'], 'string', 'max' => 100],
            [['address_region_id'], 'string', 'max' => 50],
            [['address_address'], 'string', 'max' => 255],
            [['pay_img',"goods_name"], 'string', 'max' => 200],
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
            'd_id' => '经销商id',
            'user_id' => '用户id',
            'order_sn' => '订单号',
            'total_fee' => '总金额',
            'goods_id' => '商品id',
            'goods_name' => '商品名称',
            'num' => '数量',
            'address_name' => '收货人姓名',
            'address_phone' => '收货人电话',
            'address_region' => '收货人地区',
            'address_region_id' => '地区id',
            'address_address' => '收货人详细地址',
            'status' => '状态',
            'pay_img' => '汇款凭证',
            'remarks' => '备注',
            'express_type' => '快递名称',
            'express_num' => '快递单号',
            'create_time' => '创建时间',
        ];
    }
   public function create($data,$user_id,$d_id)
   {
    	 $goods=AfGoods::findOne($data["goods_id"]);
     	 $this->user_id=$user_id;
         $this->d_id=$d_id;
         $this->order_sn=rand(100000,999999).Yii::$app->user->identity->id.time();
         $this->total_fee=round($goods->price*$data["num"],2);
         $this->goods_id=$goods->goods_id;
         $this->goods_name=$goods->goods_name;
         $this->num=$data["num"];
     	 $this->address_name=$data["address_name"];
         $this->address_phone=$data["address_phone"];
     	 $this->address_region=$data["region"];
         $this->address_region_id=$data["region_id"];
     	 $this->address_address=$data["address_address"];
         $this->status=0;
     	 $this->remarks=$data["remarks"];
      	 $this->create_time=time();
   
         if($this->save())
         {
          	return $this->order_id; 
         }else{
          	return false; 
         }
     
   }
}
