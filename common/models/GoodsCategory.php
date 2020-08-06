<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_category}}".
 *
 * @property integer $cate_id
 * @property integer $pid
 * @property string $name
 * @property integer $level
 * @property integer $sort
 * @property string $cate_img
 * @property string $adv_img
 * @property string $adv_url
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'name', 'level'], 'required'],
            [['pid', 'level', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['cate_img', 'adv_img', 'adv_url'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cate_id' => 'ID',
            'pid' => '上级',
            'name' => '名称',
            'level' => '级别',
            'sort' => '排序',
            'cate_img' => '分类图片',
            'adv_img' => '广告图',
            'adv_url' => '广告url',
        ];
    }

    
}
