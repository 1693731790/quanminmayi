<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_favorite}}".
 *
 * @property integer $goods_favorite_id
 * @property integer $goods_id
 * @property integer $user_id
 * @property integer $create_time
 */
class GoodsFavorite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_favorite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'user_id', 'create_time'], 'required'],
            [['goods_id', 'user_id', 'create_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_favorite_id' => 'Goods Favorite ID',
            'goods_id' => 'Goods ID',
            'user_id' => 'User ID',
            'create_time' => 'Create Time',
        ];
    }
    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ["goods_id"=>"goods_id"]);
  
    }
}
