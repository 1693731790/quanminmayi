<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "{{%shops_cate}}".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property string $img
 * @property string $banner
 * @property string $title
 */
class ShopsCate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shops_cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'img', 'title'], 'required'],
            [['shop_id'], 'integer'],
            [['img'], 'string', 'max' => 200],
            [['title'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => '店铺id',
            'img' => '品牌缩略图',
           
            'title' => '品牌名称',
        ];
    }
  

  	public static function getCate()
    {
    	$cate=self::find()->select(["id","title"])->all();
        $cates=ArrayHelper::map($cate, 'id', 'title');
      	$no=["0"=>"无"];
      	$cates = array_merge($no, $cates); 
        return $cates; 	 
    }
   public static function getCateName($id)
    {
    	$cate=self::findOne($id);
        return $cate->title; 	 
    }
}
