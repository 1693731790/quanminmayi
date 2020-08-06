<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%express}}".
 *
 * @property integer $express_id
 * @property string $name
 * @property string $code
 */
class Express extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%express}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'express_id' => 'ID',
            'name' => '快递名称',
            'code' => '编号',
        ];
    }
}
