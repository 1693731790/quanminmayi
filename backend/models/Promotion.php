<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%promotion}}".
 *
 * @property string $promotion_id
 * @property string $start_time
 * @property string $end_time
 * @property integer $status
 * @property string $remark
 * @property integer $admin_id
 * @property string $data
 */
class Promotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%promotion}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time', 'status', 'admin_id'], 'integer'],
            [['status'], 'required'],
            [['data'], 'string'],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'promotion_id' => 'Promotion ID',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'status' => '状态',
            'remark' => '备注',
            'admin_id' => '创建人',
            'data' => 'Data',
        ];
    }
}
