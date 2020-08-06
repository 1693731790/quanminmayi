<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shop_coupon}}".
 *
 * @property integer $shop_coupon_id
 * @property integer $shop_id
 * @property string $fee
 * @property integer $end_time
 */
class ShopCoupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_coupon}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'fee', 'end_time'], 'required'],
            [['shop_id', 'end_time'], 'integer'],
            [['fee'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shop_coupon_id' => 'ID',
            'shop_id' => '店铺ID',
            'fee' => '金额',
            'end_time' => '结束时间',
        ];
    }
}
