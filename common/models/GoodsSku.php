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
class GoodsSku extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_sku}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'attr_path', 'price', 'stock', 'sku_name'], 'required'],
            [['goods_id', 'stock'], 'integer'],
            [['price'], 'number'],
            [['attr_path','sku_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sku_id' => 'ID',
            'goods_id' => '商品ID',
            'attr_path' => '路径',
            'price' => '价格',
            'stock' => '库存',
            'sku_name' => '名称',
        ];
    }
}
