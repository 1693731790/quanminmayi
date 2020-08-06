<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_seckill}}".
 *
 * @property integer $goods_id
 * @property string $goods_sn
 * @property string $goods_name
 * @property string $goods_keys
 * @property string $goods_thums
 * @property string $goods_img
 * @property string $desc
 * @property string $old_price
 * @property string $price
 * @property integer $stock
 * @property string $status
 * @property integer $start_time
 * @property integer $hour
 * @property string $status_info
 * @property string $content
 * @property string $mobile_content
 * @property integer $create_time
 */
class GoodsSeckill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_seckill}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_sn', 'goods_name', 'goods_keys', 'goods_thums', 'desc', 'old_price', 'price', 'stock',"surplus", 'start_time','end_time', 'hour', 'content'], 'required'],
            [[ 'desc', 'content', 'mobile_content'], 'string'],
            [['old_price', 'price'], 'number'],
            [['stock',"surplus", 'hour', 'create_time'], 'integer'],
            [['goods_sn',"start_time","end_time"], 'string', 'max' => 50],
            [['goods_name', 'goods_keys', 'goods_thums', 'status_info'], 'string', 'max' => 200],
            [['status'], 'string', 'max' => 10],
			[['goods_img'], 'safe'],          
          	
          	
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => 'ID',
            'goods_sn' => '商品编号',
            'goods_name' => '商品名称',
            'goods_keys' => '商品关键字',
            'goods_thums' => '商品缩略图',
            'goods_img' => '商品图片',
            'desc' => '描述',
            'old_price' => '原价',
            'price' => '现价',
            'stock' => '商品总数',
            'status' => '状态',
            'surplus' => '剩余个数',
          
            'start_time' => '秒杀开始日期',
            'hour' => '秒杀开始时间',
          	'end_time' => '秒杀结束时间',
            'status_info' => '状态说明',
            'content' => '详细内容',
            'mobile_content' => '手机版详细内容',
            'create_time' => '添加时间',
        ];
    }
   public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($insert)
            {	
              	$this->start_time=strtotime($this->start_time);
				$this->end_time=strtotime($this->end_time);              
              	$this->goods_img=json_encode($this->goods_img);
                $this->create_time=time();
                $this->status=200;
              
                
            }else{
                $this->start_time=strtotime($this->start_time);
                $this->end_time=strtotime($this->end_time);              
              	$this->goods_img=json_encode($this->goods_img);
            }
            return true;

        }
        else
        {
            return false;
        }
    }
}
