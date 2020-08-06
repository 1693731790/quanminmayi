<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%agent_mobile_card_num}}".
 *
 * @property integer $id
 * @property integer $agent_id
 * @property integer $user_id
 * @property string $card_num
 */
class AgentMobileCardNum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agent_mobile_card_num}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agent_id', 'user_id', 'card_num'], 'required'],
            [['agent_id', 'user_id'], 'integer'],
            [['card_num'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agent_id' => 'Agent ID',
            'user_id' => 'User ID',
            'card_num' => 'Card Num',
        ];
    }
}
