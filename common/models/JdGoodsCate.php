<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jd_goods_cate}}".
 *
 * @property integer $goods_cat_id
 * @property string $goods_cat_name
 * @property string $goods_cat_name_mob
 * @property integer $goods_cat_is_show
 * @property integer $goods_cat_is_tuijian
 * @property integer $goods_cat_group
 * @property integer $goods_cat_sort
 * @property integer $goods_cat_pid
 * @property integer $cat_class
 * @property string $ads
 * @property string $ads_url
 * @property string $thumb
 * @property integer $level
 */
class JdGoodsCate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%jd_goods_cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_cat_name', 'level'], 'required'],
            [['goods_cat_is_show', 'goods_cat_is_tuijian', 'goods_cat_group', 'goods_cat_sort', 'goods_cat_pid', 'cat_class', 'level'], 'integer'],
            [['ads'], 'string'],
            [['goods_cat_name', 'goods_cat_name_mob'], 'string', 'max' => 20],
            [['ads_url'], 'string', 'max' => 200],
            [['thumb'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_cat_id' => 'Goods Cat ID',
            'goods_cat_name' => 'Goods Cat Name',
            'goods_cat_name_mob' => 'Goods Cat Name Mob',
            'goods_cat_is_show' => 'Goods Cat Is Show',
            'goods_cat_is_tuijian' => 'Goods Cat Is Tuijian',
            'goods_cat_group' => 'Goods Cat Group',
            'goods_cat_sort' => 'Goods Cat Sort',
            'goods_cat_pid' => 'Goods Cat Pid',
            'cat_class' => 'Cat Class',
            'ads' => 'Ads',
            'ads_url' => 'Ads Url',
            'thumb' => 'Thumb',
            'level' => 'Level',
        ];
    }
}
