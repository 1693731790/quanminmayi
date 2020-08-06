<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%banner}}".
 *
 * @property integer $banner_id
 * @property string $img
 * @property string $url
 * @property integer $orderby
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img', 'url', 'orderby'], 'required'],
            [['orderby'], 'integer'],
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
            'img' => '图片',
            'url' => '链接',
            'orderby' => '排序(升序排列)',
        ];
    }
}
