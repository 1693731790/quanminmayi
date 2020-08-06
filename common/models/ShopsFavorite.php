<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shops_favorite}}".
 *
 * @property integer $shops_favorite_id
 * @property integer $shop_id
 * @property integer $user_id
 */
class ShopsFavorite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shops_favorite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'user_id'], 'required'],
            [['shop_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shops_favorite_id' => 'Shops Favorite ID',
            'shop_id' => 'Shop ID',
            'user_id' => 'User ID',
        ];
    }
    public function getShops()
    {
        return $this->hasOne(Shops::className(), ["shop_id"=>"shop_id"]);
  
    }
}
