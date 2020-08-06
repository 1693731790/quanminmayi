<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mobile_card_order}}".
 *
 * @property integer $mo_id
 * @property string $morder_sn
 * @property integer $partner_id
 * @property integer $agent_id
 * @property string $total_fee
 * @property integer $mi_id
 * @property string $phone
 * @property string $pay_img
 * @property integer $status
 * @property integer $create_time
 */
class MobileCardOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mobile_card_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['morder_sn', 'partner_id', 'agent_id', 'total_fee', 'status',"type"], 'required'],
            [['partner_id', 'agent_id', 'mi_id', 'status', 'create_time', 'is_agent_id'], 'integer'],
            [['total_fee'], 'number'],
            [['morder_sn', 'pay_img',"remarks"], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mo_id' => 'ID',
            'is_agent_id' => '是否开通代理商订单',
            'type' => '分类',
            'morder_sn' => '订单号',
            'partner_id' => '合伙人ID',
            'agent_id' => '代理商ID',
            'total_fee' => '总金额',
            'mi_id' => '封面图ID',
            'phone' => '备注电话',
            'pay_img' => '汇款凭证图',
            'status' => '状态',
            'remarks' => '备注',
            'create_time' => '创建时间',
        ];
    }
    public function add($partner_id,$agent_id,$total_fee,$mi_id,$phone="",$pay_img="",$type,$is_agent_id)
    {
        $this->morder_sn=rand(100000,999999).Yii::$app->user->identity->id.time();
      	$this->is_agent_id=$is_agent_id;
        $this->type=$type;
        $this->partner_id=$partner_id;
        $this->agent_id=$agent_id;
        $this->total_fee=$total_fee;
        $this->mi_id=$mi_id;
        $this->phone=$phone;
        $this->pay_img=$pay_img;
        $this->status=0;
        $this->create_time=time();
        /*$this->save();
      	echo "<pre>";
      	var_dump($this->getErrors());
      	die();*/
        if($this->save())
        {
            return true;
        }else{
            return false;
        }
    }
}
