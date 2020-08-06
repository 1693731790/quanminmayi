<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%af_code}}".
 *
 * @property integer $id
 * @property string $batch_num
 * @property string $number
 * @property integer $distributor_id
 * @property integer $goods_id
 * @property integer $status
 * @property integer $create_time
 */
class AfCode extends \yii\db\ActiveRecord
{
  	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%af_code}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['batch_num', 'number',  'goods_id'], 'required'],
            [['distributor_id', 'goods_id', 'status', 'create_time'], 'integer'],
            [['batch_num'], 'string', 'max' => 50],
            [['number'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch_num' => '批号',
            'number' => '防伪码',
            'distributor_id' => '经销商id',
            'goods_id' => '产品id',
            'status' => '状态',
            'create_time' => '添加时间',
        ];
    }
  
  

}
