<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_free_take}}".
 *
 * @property integer $goods_id
 * @property string $goods_sn
 * @property integer $user_num
 * @property string $goods_name
 * @property string $goods_keys
 * @property string $goods_thums
 * @property string $goods_img
 * @property string $desc
 * @property string $old_price
 * @property integer $stock
 * @property integer $salecount
 * @property integer $browse
 * @property integer $issale
 * @property string $status
 * @property string $status_info
 * @property string $content
 * @property string $mobile_content
 * @property integer $create_time
 */
class GoodsFreeTake extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_free_take}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_sn', 'user_num', 'goods_name', 'goods_keys', 'goods_thums', 'desc', 'old_price', 'stock', 'content'], 'required'],
            [['user_num', 'stock', 'salecount', 'browse', 'issale', 'create_time'], 'integer'],
            [['desc', 'content', 'mobile_content'], 'string'],
            [['old_price'], 'number'],
            [['goods_sn'], 'string', 'max' => 50],
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
            'goods_sn' => '商品号',
            'user_num' => '邀请用户数量',
            'goods_name' => '商品名称',
            'goods_keys' => '商品关键字',
            'goods_thums' => '商品主图',
            'goods_img' => '商品轮播图',
            'desc' => '简介',
            'old_price' => '原始价格',
            'stock' => '库存',
            'salecount' => '销量（多少人已拿到）',
            'browse' => '浏览量',
            'issale' => '是否上架',
            'status' => '状态',
            'status_info' => '状态说明',
            'content' => '详细内容',
            'mobile_content' => '手机版详细内容',
            'create_time' => '创建时间',
        ];
    }
  
   public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($insert)
            {
                  $this->goods_img=json_encode($this->goods_img);
                  $this->status="0";
                  $this->create_time=time();
                
                
            }else{
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
