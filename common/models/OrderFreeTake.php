<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_free_take}}".
 *
 * @property integer $order_id
 * @property integer $user_id
 * @property string $order_sn
 * @property integer $user_num
 * @property integer $get_user_num
 * @property integer $goods_id
 * @property string $goods_name
 * @property string $goods_thums
 * @property string $address_name
 * @property string $address_phone
 * @property string $address_region
 * @property string $address_region_id
 * @property string $address_address
 * @property integer $status
 * @property string $remarks
 * @property integer $is_comment
 * @property string $express_type
 * @property string $express_num
 * @property integer $create_time
 */
class OrderFreeTake extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_free_take}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'order_sn', 'user_num', 'get_user_num', 'goods_id', 'goods_name', 'goods_thums', 'address_name', 'address_phone', 'address_region', 'address_region_id', 'address_address'], 'required'],
            [['user_id', 'user_num', 'get_user_num', 'goods_id', 'status', 'is_comment', 'create_time'], 'integer'],
            [['order_sn'], 'string', 'max' => 60],
            [['goods_name', 'goods_thums'], 'string', 'max' => 200],
            [['address_name'], 'string', 'max' => 30],
            [['address_phone', 'express_type'], 'string', 'max' => 20],
            [['address_region', 'express_num'], 'string', 'max' => 100],
            [['address_region_id'], 'string', 'max' => 50],
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
            'user_num' => '需邀请用户个数',
            'get_user_num' => '已邀请用户个数',
            'goods_id' => '商品id',
            'goods_name' => '商品名称',
            'goods_thums' => '商品缩略图',
            'address_name' => '收货人姓名',
            'address_phone' => '收货人电话',
            'address_region' => '收货人地区',
            'address_region_id' => '收货人地区id',
            'address_address' => '收货人详细地址',
            'status' => '状态',
            'remarks' => '备注',
            'is_comment' => '是否评论',
            'express_type' => '快递公司',
            'express_num' => '快递号',
            'create_time' => '下单时间',
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

    public function addOrder($goods_id,$aid,$user_id="")
    {
        $goods=GoodsFreeTake::findOne($goods_id);
        $address=UserAddress::findOne($aid);
       
        if(empty($goods)||empty($address))
        {
            return false;
        }
      	if($user_id=="")
        {
        	$user_id=Yii::$app->user->identity->id;
        }

        $this->user_id=$user_id;
        $this->order_sn=$this->order_sn=rand(100000,999999).$user_id.time();
        $this->user_num=$goods->user_num;
        $this->get_user_num=0;
        $this->goods_id=$goods->goods_id;
       
        $this->goods_name=$goods->goods_name;
        $this->goods_thums=$goods->goods_thums;
        $this->address_name=$address->name;
        $this->address_phone=$address->phone;
        $this->address_region=$address->region;
        $this->address_region_id=$address->region_id;
        $this->address_address=$address->address;
        $this->status=0;
        /*$this->save();
        echo "<pre>";
        var_dump($this->getErrors());
        die();*/

        if($this->save())
        {
            return true;
        }else{
            return false;
        }
        

    }
}
