<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_message}}".
 *
 * @property integer $message_id
 * @property integer $user_id
 * @property string $content
 * @property integer $create_time
 */
class UserMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'content', 'create_time'], 'required'],
            [['user_id', 'create_time'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_id' => 'Message ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'create_time' => 'Create Time',
        ];
    }
}
