<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%article_cate}}".
 *
 * @property integer $cate_id
 * @property string $name
 * @property integer $sort
 */
class AcArticleCate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ac_article_cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cate_id' => 'Id',
            'name' => '名称',
            //'sort' => 'Sort',
        ];
    }
     public static function getCate()
    {
       	$arr = AcArticleCate::find()->asArray()->all();
        $result = ArrayHelper::map($arr, 'cate_id', 'name');
       	return $result;
       
    }
     public static function getCateOne($id)
    {
       	$arr = AcArticleCate::findOne($id);
        if(!empty($arr))
        {
           return $arr->name;
        }else{
        	return "";  
        }
       	
       
    }
  	
}
