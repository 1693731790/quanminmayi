<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%special}}".
 *
 * @property integer $special_id
 * @property integer $goods_id
 * @property string $name
 * @property string $img
 * @property string $content
 * @property integer $create_time
 */
class Special extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%special}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'name', 'img', 'content','browse'], 'required'],
            [['goods_id', 'create_time','ishome','browse','orderby'], 'integer'],
            [['content'], 'string'],
            [['name', 'img'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'special_id' => 'ID',
            'goods_id' => '商品ID',
            'name' => '专题名称',
            'img' => '专题图片',
            'content' => '详细内容',
            'ishome' => '首页显示',
            "browse"=>"浏览量",
            "orderby"=>"排序",
            'create_time' => '添加时间',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($insert)
            {
                $this->create_time=time();
            }
            return true;

        }
        else
        {
            return false;
        }
    }
}
