<?php

namespace common\models;

use Yii;


class AfGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%af_goods}}';
    }

   
    public function rules()
    {
        return [
            [[ 'shop_goods_id', 'cate_id1', 'cate_id2', 'cate_id3', 'create_time'], 'integer'],
            [[ 'cate_id1', 'cate_id2', 'cate_id3', 'goods_sn', 'goods_name', 'goods_keys', 'goods_thums', 'desc', 'old_price', 'price'], 'required'],
            [[ 'content', 'desc'], 'string'],
            [['old_price', 'price'], 'number'],
            [[ 'goods_sn'], 'string', 'max' => 50],
            [['goods_name', 'goods_keys', 'goods_thums'], 'string', 'max' => 200],
            [['status'], 'string', 'max' => 10],
            [['goods_img',"attr"],'safe'],
          
        ];
    }
 
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => '商品ID',
            'shop_goods_id' => '主网站商品id',
            'cate_id1' => '顶级分类',
            'cate_id2' => '二级分类',
            'cate_id3' => '三级分类',
            'goods_sn' => '商品编号',
            'goods_name' => '商品名称',
            'goods_keys' => '关键字',
            'goods_thums' => '商品缩略图',
            'goods_img' => '商品相册',
            'desc' => '商品描述',
            'old_price' => '原价',
            'price' => '批发价',
            'status' => '状态',
            'content' => '详情',
            'attr' => 'attr',
            'create_time' => '添加时间',
            
        ];
    }

    
    public static function getGoods($jdgoods_id)
    {
      $goods=self::find()->where(["jdgoods_id"=>$jdgoods_id])->count();
        if($goods>0)
        {
            return true;
        }else{
          return false; 
        }
      
    }


    public function beforeSave($insert)
    {
        
        if(parent::beforeSave($insert))
        {  
          
          
            if($insert)
            {
                    if(!empty($this->goods_img))
                    {
                      $this->goods_img=json_encode($this->goods_img);
                    }
                    $this->status="200";
                    $this->create_time=time();
                
                
            }else{
              
              if(!empty($this->goods_img))
              {
                $this->goods_img=json_encode($this->goods_img);
              }
              
             
            }
            return true;

        }
        else
        {
          
            return false;
        }
    }


   
}
