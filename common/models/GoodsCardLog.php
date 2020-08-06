<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_card_log}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $agent_id
 * @property integer $num
 * @property integer $create_time
 */
class GoodsCardLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_card_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'agent_id', 'num', 'create_time'], 'required'],
            [['user_id', 'agent_id', 'num', 'create_time'], 'integer'],
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
            'agent_id' => '开通的代理商ID',
            'num' => '商品卡个数',
            'create_time' => '创建时间',
        ];
    }
    public function add($user_id,$agent_id,$num)
    {
        $this->user_id=$user_id;
        $this->agent_id=$agent_id;
        $this->num=$num;
        $this->create_time=time();
        if($this->save())
        {
            return true;
        }else{
            return false;
        }
    }
}
