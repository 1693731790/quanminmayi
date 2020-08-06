<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_coupon}}".
 *
 * @property integer $user_coupon_id
 * @property integer $shop_id
 * @property integer $user_id
 * @property string $fee
 * @property integer $end_time
 */
class UserCoupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_coupon}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'user_id', 'fee', 'end_time'], 'required'],
            [['shop_id', 'user_id', 'end_time'], 'integer'],
            [['fee'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_coupon_id' => 'User Coupon ID',
            'shop_id' => 'Shop ID',
            'user_id' => 'User ID',
            'fee' => 'Fee',
            'end_time' => 'End Time',
        ];
    }
    public function getShops()
    {
        return $this->hasOne(Shops::className(), ["shop_id"=>"shop_id"]);
  
    }
}
