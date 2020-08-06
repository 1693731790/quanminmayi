<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%wallet}}".
 *
 * @property integer $wid
 * @property integer $user_id
 * @property integer $type
 * @property string $fee
 * @property string $before_fee
 * @property string $after_fee
 * @property integer $order_id
 * @property string $order_sn
 * @property integer $d_id
 * @property string $d_sn
 * @property integer $create_time
 */
class WaitWallet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wait_wallet}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'fee', 'before_fee', 'after_fee', 'create_time'], 'required'],
            [['user_id', 'type', 'order_id', 'create_time'], 'integer'],
            [['fee', 'before_fee', 'after_fee'], 'number'],
            [['order_sn', 'scale'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wid' => 'Wid',
            'user_id' => '用户id',
            'type' => '类型',
            'fee' => '金额',
            'before_fee' => '之前金额',
            'after_fee' => '之后金额',
            'order_id' => '订单id',
            'order_sn' => '订单号',
             'create_time' => '创建时间',
            'scale'=>'分销金额比例'
        ];
    }
    public function addWallet($user_id,$type,$fee,$user_wallet,$order_id="",$order_sn="",$scale="")
    {
        $this->user_id=$user_id;
        $this->type=$type;
        $this->fee=$fee;
        $this->before_fee=$user_wallet;
        $this->after_fee=round($user_wallet+$fee,2);
        if($order_id!="")
        {
             $this->order_id=$order_id;
        }
        if($order_sn!="")
        {
             $this->order_sn=$order_sn;
        }
        if($scale!="")
        {
             $this->scale=$scale;
        }
        $this->create_time=time();
        /*$this->save();
      	echo "<pre>";
      	var_dump($this->getErrors());
      	die();  */
        if($this->save())
        {
            return true;
        }else{
            return false;
        }
    }
}
