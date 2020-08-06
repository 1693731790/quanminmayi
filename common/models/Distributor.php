<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%distributor}}".
 *
 * @property integer $d_id
 * @property string $balance
 * @property integer $user_id
 * @property string $name
 * @property string $id_num
 * @property string $phone
 * @property string $company_name
 * @property string $address
 * @property integer $status
 * @property integer $create_time
 */
class Distributor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%distributor}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['balance'], 'number'],
            [['user_id', 'phone', 'address'], 'required'],
            [['user_id', 'status', 'create_time'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['id_num'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 22],
            [['company_name'], 'string', 'max' => 200],
            [['address'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'd_id' => 'D ID',
            'balance' => '预充值余额',
            'user_id' => '用户id',
            'name' => '姓名',
            'id_num' => '身份证号',
            'phone' => '手机号',
            'company_name' => '公司名称',
            'address' => '详细地址',
            'status' => '状态',
            'create_time' => '添加时间',
        ];
    }
  
   public function beforeSave($insert)
    {
        
        if(parent::beforeSave($insert))
        {  
            if($insert)
            {
             
                    $this->status="200";
                    $this->create_time=time();
              
            }
            return true;

        }
        else
        {
          
            return false;
        }
    }
}
