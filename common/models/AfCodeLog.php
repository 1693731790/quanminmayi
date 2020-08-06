<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%af_code_log}}".
 *
 * @property integer $id
 * @property integer $code_id
 * @property integer $user_id
 * @property integer $type
 * @property string $nickname
 * @property string $user_phone
 * @property string $address
 * @property integer $create_time
 */
class AfCodeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%af_code_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code_id', 'type'], 'required'],
            [['code_id', 'user_id', 'type', 'create_time'], 'integer'],
            [['nickname', 'address'], 'string', 'max' => 200],
            [['user_phone'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_id' => '防伪码ID',
            'user_id' => '用户id',
            'type' => '类型',
            'nickname' => '微信昵称',
            'user_phone' => '微信手机号',
            'address' => '微信地址',
            'create_time' => '使用时间',
        ];
    }
}
