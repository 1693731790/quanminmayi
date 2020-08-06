<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_card_log}}".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $user_id
 * @property string $fee
 * @property string $card_num
 * @property string $order_sn
 * @property integer $create_time
 */
class UserCardLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_card_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'fee', 'create_time'], 'required'],
            [['type', 'user_id', 'create_time'], 'integer'],
            [['fee'], 'number'],
            [['card_num', 'order_sn'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'user_id' => 'User ID',
            'fee' => 'Fee',
            'card_num' => 'Card Num',
            'order_sn' => 'Order Sn',
            'create_time' => 'Create Time',
        ];
    }
}
