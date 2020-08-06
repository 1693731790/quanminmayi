<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%region}}".
 *
 * @property integer $id
 * @property integer $region_id
 * @property string $region_name
 * @property integer $parent_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'region_name'], 'required'],
            [['region_id', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            [['region_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Region ID',
            'region_name' => 'Region Name',
            'parent_id' => 'Parent ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
