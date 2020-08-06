<?php

namespace admin\models;

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
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
         return '{{%menu}}';
    }

    public static function getMenu($parent="")
    {
      	if($parent!="")
        {
        	$model=self::find()->where(["parent"=>$parent])->orderBy("order desc")->all();  
        }else{
            $model=self::find()->where(["parent"=>NULL])->orderBy("order desc")->all();  
        }
      	return $model;
      	/*echo "<pre>";
      	var_dump($model);
        die();*/
    }
}
