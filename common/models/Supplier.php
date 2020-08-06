<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%supplier}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $phone
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%supplier}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['address',"contacts"], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => '店铺ID',
            'name' => '名称',
            'phone' => '电话',
            'address' => '地址',
          'contacts' => '联系人',
          
        ];
    }
}
