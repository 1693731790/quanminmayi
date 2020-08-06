<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%withdraw_cash}}".
 *
 * @property integer $wid
 * @property integer $type
 * @property integer $user_id
 * @property string $fee
 * @property string $real_fee
 * @property integer $bank_id
 * @property string $phone
 * @property integer $status
 * @property string $remark
 * @property integer $create_time
 * @property integer $handle_time
 */
class WithdrawCash extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%withdraw_cash}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'fee', 'bank_id', 'phone', 'create_time'], 'required'],
            [['type', 'user_id', 'bank_id', 'status', 'create_time', 'handle_time'], 'integer'],
            [['fee', 'real_fee'], 'number'],
            [['phone'], 'string', 'max' => 20],
            [['remark'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wid' => 'Wid',
            'type' => '类型',
            'user_id' => '用户id',
            'fee' => '提现金额',
            'real_fee' => '扣除手续分实际需打款',
            'bank_id' => '提现账户',
            'phone' => '联系电话',
            'status' => '状态',
            'remark' => '备注',
            'create_time' => '添加时间',
            'handle_time' => '处理时间',
        ];
    }
    public function cashExamine($data,$user_id)
    {
        $transaction=Yii::$app->db->beginTransaction();

        try {
            $this->status=$data['status'];
            $this->remark=$data['remark'];
            $this->handle_time=time();
            if(!$this->update(true,["status","remark"]))
            {
                throw new \yii\db\Exception("保存失败");
            }
            if($data['status']=="-1")
            {
                $user=User::findOne($user_id);
                $wallet=(float)$user->wallet;
                $user->wallet=$wallet+(float)$this->fee;
                if(!$user->update(true,['wallet']))
                {
                    throw new \yii\db\Exception("保存失败");
                }        
            }
            
            $transaction->commit();
            return true;

        }catch (\Exception $e) {
            $transaction->rollBack();
            //throw $e;
            return false;
            
        }

    }
    public function cashAdd($data,$user_id)
    {
          
        $transaction=Yii::$app->db->beginTransaction();

        try {
            $this->type="1";
            $this->user_id=$user_id;
            $this->fee=$data["fee"];
            $this->bank_id=$data["bank_id"];
            $this->phone=$data["phone"];
            $this->status=0;
            $this->create_time=time();
            
            if(!$this->save())
            {
                throw new \yii\db\Exception("保存失败");
            }   
            $user=User::findOne($user_id);
            $wallet=(float)$user->wallet;
            $user->wallet=$wallet-(float)$data["fee"];
            if(!$user->update(true,['wallet']))
            {
                throw new \yii\db\Exception("保存失败");
            }  
            $transaction->commit();
            return true;

        }catch (\Exception $e) {
            $transaction->rollBack();
            //throw $e;
            return false;
            
        }

  
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ["id"=>"user_id"]);
  
    }
   

}
