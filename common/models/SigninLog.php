<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%signin_log}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $create_time
 */
class SigninLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%signin_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'create_time',"fee"], 'integer'],
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
            'create_time' => '签到时间',
            'fee' => '签到获得金额',
        ];
    }
}
