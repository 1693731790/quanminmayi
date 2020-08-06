<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mobile_card_img}}".
 *
 * @property integer $mi_id
 * @property string $title
 * @property string $img
 */
class MobileCardImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mobile_card_img}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'img'], 'required'],
            [['title'], 'string', 'max' => 100],
            [['img'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mi_id' => 'ID',
            'title' => '名称',
            'img' => '图片',
        ];
    }
}
