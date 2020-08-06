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
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['web_name'], 'string', 'max' => 255],
            [['web_link', 'web_key', 'web_describe'], 'string', 'max' => 250],
            [['web_call'], 'string', 'max' => 30],
            [['web_copyright'], 'string', 'max' => 100],
            [['web_name'], 'unique'],
            [['confirm_order_time',"home_show_special_num","partner_price","partner_direct_fee","partner_indirect_fee","agent_fee","user_direct_fee","user_partner_fee","user_agent_fee","partner_profit_pct","goods_telfare_pct","signin_fee","version","appapk_url","call_price_m"], 'safe'],
            
        ];
    }
      
    
 
   
   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'web_name' => '网站名称',
            'web_link' => '网站链接',
            'web_key' => '网站关键字',
            'web_describe' => '网站描述',
            'web_call' => '电话',
            'web_copyright' => '版权',
            'confirm_order_time' => '超时自动确认收货时间',
            
            'home_show_special_num' => '首页显示专题个数',
            'partner_price' => '合伙人购买电话卡价格',
            'partner_direct_fee' => '合伙人直接推荐分成金额(购买大礼包)',
            'partner_indirect_fee' => '合伙人间接推荐分成金额(购买大礼包)',	
            'agent_fee' => '代理商分成金额(购买大礼包)', 
            'user_direct_fee' => '用户直接推荐分成金额(购买大礼包)',
          
            'user_partner_fee' => '通过用户推荐购买大礼包合伙人分成金额',
            'user_agent_fee' => '通过用户推荐购买大礼包代理商分成金额',
            
            'partner_profit_pct' => '用户购买商品利润金额分成合伙人的百分比',
           
            'goods_telfare_pct' => '话费可抵扣商品利润百分比',
           'signin_fee' => '签到获得话费的金额',
            "version"=>"版本号",
          "appapk_url"=>"app",
          "call_price_m"=>"每分钟电话价格(元)",
          
          
           
            
            
            
        ];
    }
}
