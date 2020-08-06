<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mobile_card}}".
 *
 * @property integer $mid
 * @property string $name
 * @property string $title_pic
 * @property string $desc
 * @property integer $create_time
 */
class MobileCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mobile_card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title_pic', 'desc'], 'required'],
            [['create_time'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['title_pic'], 'string', 'max' => 200],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mid' => 'ID',
            'name' => '名称',
            'title_pic' => '图片',
            'desc' => '描述',
            'create_time' => '添加时间',
        ];
    }
   public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($insert)
            {
                $this->create_time=time();
                
            }
            return true;

        }
        else
        {
            return false;
        }
    }
}
