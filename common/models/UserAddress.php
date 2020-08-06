<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_address}}".
 *
 * @property integer $aid
 * @property string $name
 * @property string $phone
 * @property string $region
 * @property string $address
 * @property integer $isdefault
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone','user_id', 'region', 'address'], 'required'],
            [['isdefault','user_id'], 'integer'],
            [['name', 'phone'], 'string', 'max' => 20],
            [['region'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aid' => 'ID',
            "user_id"=>"用户id",
            'name' => '收货人姓名',
            'phone' => '收货人电话',
            'region' => '收货人地区',
            'address' => '收货人地址',
            'isdefault' => '是否默认地址',
        ];
    }
}
