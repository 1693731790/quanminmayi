<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jd_config}}".
 *
 * @property integer $id
 * @property string $label
 * @property string $value
 * @property integer $type
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 */
class JdConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%jd_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['label'], 'string', 'max' => 50],
            [[ 'description'], 'string', 'max' => 255],
            [['value'], 'safe'],
            [['label'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => '名称',
            'value' => '值',
            'type' => '类型',
            'description' => '描述',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
