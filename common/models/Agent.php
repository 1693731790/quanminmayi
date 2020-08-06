<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%agent}}".
 *
 * @property integer $agent_id
 * @property integer $user_id
 * @property string $name
 * @property string $id_num
 * @property string $id_front
 * @property string $id_back
 * @property string $phone
 * @property string $address
 * @property integer $level
 * @property integer $goods_card
 * @property integer $reward_rate
 * @property integer $status
 * @property integer $create_time
 */
class Agent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agent}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','parent_id', 'level', 'create_time'], 'required'],
            [['user_id','parent_id', 'level', 'status',"ispay", 'create_time'], 'integer'],
            [['id_num',"name"], 'string', 'max' => 50],
            [['id_front', 'id_back'], 'string', 'max' => 200],
          
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'agent_id' => 'Agent ID',
            'user_id' => '用户ID',
            'parent_id' => '上级用户ID',
            "name"=>"姓名",
            'id_num' => '身份证号',
            'id_front' => '身份证正面照',
            'id_back' => '身份证反面照',
           
            'level' => '等级',
            'ispay' => '是否支付',
            'status' => '状态',
            'create_time' => '添加时间',
        ];
    }

    public function getPhoneAuth(){
        return $this->hasOne(UserAuth::className(),[
            'user_id'=>'user_id'
        ])->where(['{{%user_auth}}.identity_type'=>'phone']);
    }
    public function getUserName(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    public function getOrderAllPay(){
        return $this->hasOne(OrderAllPay::className(),['agent_id'=>'agent_id']);
    }
   public static function getAgentType(){
        $user_id=Yii::$app->user->identity->id;  
     	$agent=self::findOne(["user_id"=>$user_id]);
     	return $agent->type;
    }
}
