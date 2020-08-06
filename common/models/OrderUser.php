<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_user}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $create_time
 */
class OrderUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id'], 'required'],
            [['order_id', 'user_id', 'create_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单',
            'user_id' => '用户ID',
            'create_time' => '创建时间',
        ];
    }
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($insert)
            {
                  $this->create_time=time();  
                
            }
            return true;

        }else
        {
            return false;
        }
    }
  	public function getUser()
    {
        return $this->hasOne(User::className(), ["id"=>"user_id"]);
  
    }
}
