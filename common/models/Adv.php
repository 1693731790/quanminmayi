<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%adv}}".
 *
 * @property integer $adv_id
 * @property string $url
 * @property string $img
 * @property string $name
 */
class Adv extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%adv}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'img', 'name'], 'required'],
            [['url'], 'string'],
            [['img'], 'string', 'max' => 200],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adv_id' => 'ID',
            'url' => '广告链接',
            'img' => '广告图片',
            'name' => '备注',
        ];
    }
}
