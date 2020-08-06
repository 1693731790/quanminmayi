<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_shopcar}}".
 *
 * @property integer $goods_shopcar_id
 * @property integer $shop_id
 * @property integer $goods_id
 * @property integer $user_id
 * @property string $skuPath
 * @property integer $goodsnum
 * @property integer $create_time
 */
class GoodsShopcar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_shopcar}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'goods_id', 'user_id', 'goodsnum'], 'required'],
            [['shop_id', 'goods_id', 'user_id', 'goodsnum', 'create_time'], 'integer'],
            [['skuPath'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_shopcar_id' => 'Goods Shopcar ID',
            'shop_id' => 'Shop ID',
            'goods_id' => 'Goods ID',
            'user_id' => 'User ID',
            'skuPath' => 'Sku Path',
            'goodsnum' => 'Goodsnum',
            'create_time' => 'Create Time',
        ];
    }

    public function addShopcar($data,$type="")
    {
      	if($type=="api")
        {
            $user_id=$data["user_id"];
        }else{
          	$user_id=Yii::$app->user->identity->id;
        }
        
        $iscar=self::find()->where(["goods_id"=>$data["goods_id"],"shop_id"=>$data["shop_id"],"user_id"=>$user_id,"skuPath"=>$data["skuPath"]])->one();//如果已加入    购物车数量增加1
        if(!empty($iscar))
        {
            $iscar->goodsnum=$iscar->goodsnum+1;
            if($iscar->update(true,['goodsnum']))
            {
                return true;
            }else{
                return false;
            }
            
        }
        $this->goods_id=$data["goods_id"];
        $this->shop_id=$data["shop_id"];
        $this->user_id=$user_id;
        $attr_path=$data['skuPath'];
        if($data['skuPath']!="")
        {
            $attr_path=substr($data["skuPath"],0,strlen($data["skuPath"])-1);
        }
        $this->skuPath=$attr_path;
        $this->goodsnum=$data["goodsnum"];
        $this->create_time=time();
        if($this->save())
        {
            return true;
        }else{
            return false;
        }
    }

    public function getShops()
    {
        return $this->hasOne(Shops::className(), ["shop_id"=>"shop_id"])->select(["shop_id","name"]);
  
    }

    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ["goods_id"=>"goods_id"]);
  
    }

    public function getSku()
    {
        return $this->hasOne(GoodsSku::className(), ["attr_path"=>"skuPath"]);
  
    }
}
