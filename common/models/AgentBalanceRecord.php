<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%agent_balance_record}}".
 *
 * @property integer $id
 * @property integer $agent_id
 * @property integer $user_id
 * @property integer $type
 * @property string $fee
 * @property string $remarks
 * @property integer $create_time
 */
class AgentBalanceRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agent_balance_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agent_id', 'user_id', 'type', 'fee'], 'required'],
            [['agent_id', 'user_id', 'type', 'create_time'], 'integer'],
            [['fee'], 'number'],
            [['remarks'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agent_id' => '合伙人ID',
            'user_id' => '用户ID',
            'type' => '类型',
            'fee' => '金额',
            'remarks' => '备注',
            'create_time' => '创建时间',
        ];
    }
    public function add($agent_id,$user_id,$type,$fee,$remarks="")
    {
        
        $this->agent_id=$agent_id;
        $this->user_id=$user_id;
        $this->type=$type;
        $this->fee=$fee;
        $this->remarks=$remarks;
        $this->create_time=time();
        /*$this->save();
      	echo "<pre>";
      	var_dump($this->getErrors());
      	die();*/
        if($this->save())
        {
            return true;
        }else{
            return false;
        }
    }
}
