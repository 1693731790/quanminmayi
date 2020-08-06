<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sysarticle}}".
 *
 * @property integer $article_id
 * @property string $title
 * @property string $title_img
 * @property string $key
 * @property string $desc
 * @property string $content
 * @property integer $create_time
 */
class Sysarticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sysarticle}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['create_time'], 'integer'],
            [['title'], 'string', 'max' => 200],
            [['title_img'], 'string', 'max' => 100],
            [['key'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => 'ID',
            'title' => '标题',
            'title_img' => '标题图',
            'key' => '关键字',
            'desc' => '描述',
            'content' => '内容',
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
                
            }else{
             
            }
            return true;

        }
        else
        {
            return false;
        }
    }
}
