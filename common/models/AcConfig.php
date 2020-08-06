<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property string $id
 * @property string $web_name
 * @property string $web_link
 * @property string $web_key
 * @property string $web_describe
 * @property string $web_call
 * @property string $web_copyright
 */
class AcConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ac_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [["lt_num_class","price_50","price_100"], 'safe'],
            
        ];
    }
      
    
 
   
   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
          	'lt_num_class' => '购买低于数量不可选择样式',  
            'price_50' => '50面值价格',
            'price_100' => '100面值价格',
            
          
           
            
            
            
        ];
    }
}
