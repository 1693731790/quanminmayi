<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_feedback}}".
 *
 * @property integer $feedback_id
 * @property integer $user_id
 * @property string $phone
 * @property string $content
 * @property integer $create_time
 */
class UserFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_feedback}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'phone', 'content', 'create_time'], 'required'],
            [['user_id', 'create_time'], 'integer'],
            [['content'], 'string'],
            [['phone'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'feedback_id' => 'ID',
            'user_id' => '用户ID',
            'phone' => '联系方式',
            'content' => '反馈内容',
            'create_time' => '反馈时间',
        ];
    }
}
