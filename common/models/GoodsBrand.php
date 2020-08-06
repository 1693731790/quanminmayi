<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_brand}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $img
 */
class GoodsBrand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_brand}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['img'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '品牌名称',
            'img' => '图片',
        ];
    }
}
