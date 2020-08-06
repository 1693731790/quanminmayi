<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_bank}}".
 *
 * @property integer $bank_id
 * @property integer $user_id
 * @property string $bank_name
 * @property string $account
 * @property string $address
 */
class UserBank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_bank}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'bank_name', 'account','name','phone'], 'required'],
            [['user_id'], 'integer'],
            [['bank_name','name', 'account'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bank_id' => 'ID',
            'user_id' => '用户ID',
            'name' => '持卡人姓名',
            'bank_name' => '银行名称',
            'account' => '银行卡号',
            'phone' => '开户手机号',
        ];
    }
}
