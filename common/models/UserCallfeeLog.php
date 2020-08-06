<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_callfee_log}}".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $user_id
 * @property string $fee
 * @property string $card_num
 * @property string $order_sn
 * @property integer $create_time
 */
class UserCallfeeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_callfee_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'fee', 'create_time'], 'required'],
            [['type', 'user_id', 'create_time'], 'integer'],
            [['fee',"balance"], 'number'],
            [['card_num', 'order_sn',"phone"], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型',
            'user_id' => '用户id',
            'fee' => '金额',
            'balance' => '余额',
            'card_num' => '充值卡号',
            'phone' => '充值手机号',
            'order_sn' => '订单号',
            'create_time' => '创建时间',
        ];
    }
  
  	function create($user_id,$fee,$card_num,$balance,$type="",$order_sn="")
    {
      	$userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$user_id])->one();
      if($type=="")
      {
        	$this->type="1";
      }else{
       	   $this->type=$type; 
      }
     	
        $this->user_id=$user_id;
        $this->fee=$fee;
        $this->balance=$balance;
        $this->card_num=$card_num;
        $this->phone=$userAuth->identifier;
        $this->order_sn=$order_sn;
        $this->create_time=time();
      	$this->save();
    }
}
