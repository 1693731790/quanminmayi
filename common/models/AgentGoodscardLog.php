<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%agent_goodscard_log}}".
 *
 * @property integer $id
 * @property integer $out_agent_id
 * @property integer $enter_agent_id
 * @property integer $num
 * @property integer $scFee
 * @property integer $create_time
 */
class AgentGoodscardLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agent_goodscard_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['out_agent_id', 'enter_agent_id', 'num', 'scFee', 'create_time'], 'required'],
            [['out_agent_id', 'enter_agent_id', 'num', 'scFee', 'create_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'out_agent_id' => '转出代理商ID',
            'enter_agent_id' => '转入代理商ID',
            'num' => '数量',
            'scFee' => '手续费',
            'create_time' => '添加时间',
        ];
    }
    public function add($out_agent_id,$enter_agent_id,$num,$scFee)
    {
        $this->out_agent_id=$out_agent_id;
        $this->enter_agent_id=$enter_agent_id;
        $this->num=$num;
        $this->scFee=$scFee;
        $this->create_time=time();
        if($this->save())
        {
            return true;
        }else{
            return false;
        }
    }
}
