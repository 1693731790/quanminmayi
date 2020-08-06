<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%agent_grade}}".
 *
 * @property integer $grade_id
 * @property string $name
 * @property integer $need_fee
 * @property integer $goods_card
 * @property integer $reward
 */
class AgentGrade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agent_grade}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'gt_num', 'lt_num', 'price'], 'required'],
            [['gt_num', 'lt_num'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'grade_id' => 'ID',
            'name' => '名称',
            'gt_num' => '大于的数量',
            'lt_num' => '小于的数量',
            'price' => '价格',
        ];
    }
    public static function getGrade($grade_id)
    {
        $model=self::findOne($grade_id);
        return $model->name;
    }
}
