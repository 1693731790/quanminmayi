<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mobile_card_order_detail}}".
 *
 * @property integer $mod_id
 * @property integer $mo_id
 * @property integer $mobile_card_id
 * @property string $name
 * @property string $price
 * @property integer $num
 */
class MobileCardOrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mobile_card_order_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mo_id', 'mobile_card_id', 'name', 'price', 'num'], 'required'],
            [['mo_id', 'mobile_card_id', 'num'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mod_id' => 'Mod ID',
            'mo_id' => 'Mo ID',
            'mobile_card_id' => 'Mobile Card ID',
            'name' => 'Name',
            'price' => 'Price',
            'num' => 'Num',
        ];
    }

    public function add($mo_id,$mobile_card_id,$name,$price,$num)
    {
        $this->mo_id=$mo_id;
        $this->mobile_card_id=$mobile_card_id;
        $this->name=$name;
        $this->price=$price;
        $this->num=$num;
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
