<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_goods}}".
 *
 * @property integer $order_goods_id
 * @property integer $order_id
 * @property integer $goods_id
 * @property string $attr_name
 * @property string $goods_name
 * @property string $price
 * @property integer $num
 */
class OrderGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'goods_id', 'goods_name', 'price', 'num','goods_thums'], 'required'],
            [['order_id', 'goods_id', 'num'], 'integer'],
            [['price'], 'number'],
            [['attr_name', 'goods_name','goods_thums'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_goods_id' => 'Order Goods ID',
            'order_id' => 'Order ID',
            'goods_id' => 'Goods ID',
            'attr_name' => 'Attr Name',
            'goods_name' => 'Goods Name',
            'price' => 'Price',
            'goods_thums'=>"商品图",
            'num' => 'Num',
        ];
    }
    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ["goods_id"=>"goods_id"]);
    }
}
