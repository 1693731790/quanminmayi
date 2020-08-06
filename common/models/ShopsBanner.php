<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shops_banner}}".
 *
 * @property integer $banner_id
 * @property integer $shop_id
 * @property string $img
 * @property string $url
 * @property integer $orderby
 */
class ShopsBanner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shops_banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'img', 'url', 'orderby'], 'required'],
            [['shop_id', 'orderby'], 'integer'],
            [['img'], 'string', 'max' => 200],
            [['url'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'banner_id' => 'ID',
            'shop_id' => 'Shop ID',
            'img' => '图片',
            'url' => '链接',
            'orderby' => '排序',
        ];
    }
}
