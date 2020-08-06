<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shops_cate_class}}".
 *
 * @property integer $id
 * @property integer $class_id
 * @property integer $cate_id
 */
class ShopsCateClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shops_cate_class}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_id', 'cate_id'], 'required'],
            [['class_id', 'cate_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_id' => 'Class ID',
            'cate_id' => 'Cate ID',
        ];
    }
}
