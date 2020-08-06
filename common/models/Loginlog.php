<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property string $address_id
 * @property string $user_id
 * @property string $name
 * @property string $phone
 * @property string $tel
 * @property integer $region1
 * @property integer $region2
 * @property integer $region3
 * @property string $content
 * @property string $zipcode
 */
class Loginlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%login_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => '自增id',
            'account' => '账号',
            'pwd' => '密码',
            'status' => '状态',
            'area' => '地区',
            'create_time' => '时间',
            'ip' => 'ip地址',
            
        ];
    }

}
