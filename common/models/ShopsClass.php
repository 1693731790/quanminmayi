<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shops_class}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $img
 * @property string $name
 * @property integer $sort
 */
class ShopsClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shops_class}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'img', 'name', 'sort',"shop_id"], 'required'],
            [['pid', 'sort',"ishome","shop_id"], 'integer'],
            [['img'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '上级分类',
            'img' => '缩略图',
            'name' => '名称',
            'sort' => '排序',
            'ishome' => '是否首页显示',
        ];
    }
    public static function getCateName($id)
    {
    	$cate=self::findOne($id);
        return $cate->name; 	 
    }
}
