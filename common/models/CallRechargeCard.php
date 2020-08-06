<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%recharge_card}}".
 *
 * @property integer $id
 * @property string $card_num
 * @property string $password
 * @property integer $is_use
 * @property integer $fee
 * @property integer $create_time
 */
class CallRechargeCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%call_recharge_card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['batch_num','card_num', 'password', 'fee', 'create_time',"end_time"], 'required'],
            [['is_use', 'fee', 'create_time',"end_time","user_id","call_agent_id"], 'integer'],
            [['card_num',"batch_num"], 'string', 'max' => 50],
            [['password',"phone"], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
          	"call_agent_id"=>"代理商id",
            'batch_num'=>"批号",
            'card_num' => '卡号',
            'password' => '密码',
            'is_use' => '是否已经使用',
            'fee' => '金额',
            'user_id' => '使用者id',
            'phone' => '充值的手机号',
            'end_time' => '有效期',
            'create_time' => '添加时间',
        ];
    }
}
