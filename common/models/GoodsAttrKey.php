<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_attr_key}}".
 *
 * @property integer $attr_key_id
 * @property integer $goods_id
 * @property string $attr_key_name
 */
class GoodsAttrKey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_attr_key}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'attr_key_name'], 'required'],
            [['goods_id'], 'integer'],
            [['attr_key_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attr_key_id' => 'Attr Key ID',
            'goods_id' => '商品ID',
            'attr_key_name' => '键名',
        ];
    }
}
