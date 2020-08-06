<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shops}}".
 *
 * @property integer $shop_id
 * @property integer $user_id
 * @property integer $shop_sn
 * @property string $name
 * @property string $desc
 * @property string $truename
 * @property string $id_front
 * @property string $id_back
 * @property string $img
 * @property string $tel
 * @property string $address
 * @property integer $level
 * @property string $notice
 * @property integer $browse
 * @property string $delivery_time
 * @property integer $status
 * @property integer $create_time
 */
class Shops extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shops}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'name','user_id', 'desc', 'id_front', 'id_back', 'img', 'tel','truename'], 'required'],
            [['user_id',  'level', 'browse', 'status', 'create_time'], 'integer'],
            [['name', 'address', 'notice','status_info'], 'string', 'max' => 200],
            [['desc'], 'string', 'max' => 250],
            [['truename'], 'string', 'max' => 30],
            [['id_front', 'id_back', 'img'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 25],
            [['delivery_time'], 'string', 'max' => 50],
            [['shop_sn'], 'safe'],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shop_id' => '店铺ID',
            'user_id' => '用户 ID',
            'shop_sn' => '店铺编号 Sn',
            'name' => '店铺名称',
            'desc' => '简介',
            'truename' => '店铺所有者姓名',
            'id_front' => '身份证前面照',
            'id_back' => '身份证后面照',
            'img' => '店铺图标',
            'tel' => '电话',
            'address' => '地址',
            'level' => '等级',
            'notice' => '店铺公告',
            'browse' => '浏览量',
            'delivery_time' => '承诺配送时间',
            'status' =>'状态',
            'status_info' =>'状态说明',
            'create_time' => '添加时间',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($insert)
            {
                
                $this->shop_sn="dh".time().rand(10000,99999);

                $this->status="0";
                $this->create_time=time();
                
            }
            return true;

        }
        else
        {
            return false;
        }
    }
    public function addShop($data)
    {

        $user_id=Yii::$app->user->identity->id;
        $this->user_id=$user_id;
        $this->shop_sn="dh".time().rand(10000,99999);
        $this->name=$data["name"];
        $this->desc=$data["desc"];
        $this->truename=$data["truename"];
        $this->id_front=$data["id_front"];
        $this->id_back=$data["id_back"];
        $this->img=$data["img"];
        $this->tel=$data["tel"];
        $this->address=$data["address"];
        $this->status="0";
        $this->create_time=time();
        if($this->save())
        {
            return true;
        }else{
            return false;
        } 
           
    }
    public function getGoods()
    {
        return $this->hasMany(Goods::className(), ["shop_id"=>"shop_id"]);
    }
  
  	public static function getShopsName($shops_id)
    {
      	$model=self::findOne($shops_id);
        return $model->name;
    }

}
