<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%agent_channel}}".
 *
 * @property integer $channel_id
 * @property integer $gt_fee
 * @property integer $reward
 * @property integer $proportion
 */
class AgentChannel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agent_channel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gt_fee', 'reward', 'proportion'], 'required'],
            [['gt_fee', 'reward', 'proportion'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'channel_id' => 'ID',
            'gt_fee' => '大于多少金额',
            'reward' => '奖金',
            'proportion' => '会员直推比例增加',
        ];
    }
}
