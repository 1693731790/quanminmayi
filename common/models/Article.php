<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $article_id
 * @property string $title
 * @property string $title_img
 * @property string $key
 * @property string $desc
 * @property string $content
 * @property integer $ishot
 * @property string $author
 * @property integer $create_time
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'title_img', 'key', 'desc', 'content',  'author'], 'required'],
            [['content'], 'string'],
            [['ishot', 'create_time'], 'integer'],
            [['title'], 'string', 'max' => 200],
            [['title_img'], 'string', 'max' => 100],
            [['key'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 250],
            [['author'], 'string', 'max' => 30],
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
            'title_img' => '标题图片',
            'key' => '关键字',
            'desc' => '描述',
            'content' => '详细内容',
            'ishot' => '热门',
            'author' => '作者',
            'create_time' => '添加时间',
        ];
    }
}
