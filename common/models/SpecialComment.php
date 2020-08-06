<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%special_comment}}".
 *
 * @property integer $special_comment_id
 * @property integer $special_id
 * @property integer $user_id
 * @property string $content
 * @property integer $create_time
 */
class SpecialComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%special_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['special_id', 'user_id', 'content', 'create_time'], 'required'],
            [['special_id', 'user_id', 'create_time'], 'integer'],
            [['content'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'special_comment_id' => 'Special Comment ID',
            'special_id' => 'Special ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'create_time' => 'Create Time',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ["id"=>"user_id"]);
  
    }
}
