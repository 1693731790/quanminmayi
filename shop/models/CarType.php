<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "car_type".
 *
 * @property string $id
 * @property string $name
 * @property integer $is_show
 * @property integer $sort
 */
class CarType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_show', 'sort'], 'integer'],
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
            'name' => '名称',
            'is_show' => '是否显示',
            'sort' => '排序',
        ];
    }
}
