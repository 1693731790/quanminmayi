<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_name}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $img
 */
class OrderName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_name}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name',"goods_name"], 'required'],
            [['name'], 'string', 'max' => 20],
            [['goods_name'], 'string', 'max' => 200],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'goods_name' => '商品名称',
          
        ];
    }
}
