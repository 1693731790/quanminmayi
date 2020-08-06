<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%remind_send_goods}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $shop_id
 * @property integer $order_id
 * @property integer $create_time
 */
class RemindSendGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%remind_send_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'shop_id', 'order_id', 'create_time'], 'required'],
            [['user_id', 'shop_id', 'order_id', 'create_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'order_id' => '订单ID',
            'create_time' => '时间',
        ];
    }
}
