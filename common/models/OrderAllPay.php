<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_all_pay}}".
 *
 * @property integer $id
 * @property string $all_pay_sn
 */
class OrderAllPay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_all_pay}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['all_pay_sn'], 'required'],
            [['all_pay_sn'], 'string', 'max' => 100],
            [['agent_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'all_pay_sn' => 'All Pay Sn',
            'agent_id' => 'agent_id',
        ];
    }
}
