<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%agent_fee_record}}".
 *
 * @property integer $record_id
 * @property integer $user_id
 * @property integer $fee
 * @property integer $create_time
 */
class AgentFeeRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agent_fee_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'fee',"agent_id", 'create_time'], 'required'],
            [['user_id', 'fee',"agent_id", 'create_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'record_id' => 'ID',
            'user_id' => '用户ID',
            'agent_id' => '代理商ID',
            'fee' => '金额',
            'create_time' => '创建时间',
        ];
    }

    public function add($user_id,$agent_id,$fee)
    {
        $this->user_id=$user_id;
        $this->agent_id=$agent_id;
        $this->fee=$fee;
        $this->create_time=time();
        if($this->save())
        {
            return true;
        }else{
            return false;
        }
    }
}
