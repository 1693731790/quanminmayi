<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_attr_val}}".
 *
 * @property integer $attr_id
 * @property integer $attr_key_id
 * @property integer $goods_id
 * @property string $attr_val_name
 */
class GoodsAttrVal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_attr_val}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attr_key_id', 'goods_id', 'attr_val_name'], 'required'],
            [['attr_key_id', 'goods_id'], 'integer'],
            [['attr_val_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attr_id' => 'Attr ID',
            'attr_key_id' => 'Attr Key ID',
            'goods_id' => '商品ID',
            'attr_val_name' => '规格值名称',
        ];
    }
}
