<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "{{%spike_time}}".
 *
 * @property integer $id
 * @property string $hour
 */
class SpikeTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%spike_time}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hour'], 'required'],
            [['hour'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hour' => '时间',
        ];
    }
    public static function getSpiketime(){
       $model=self::find()->all();
        $res=ArrayHelper::map($model, 'id', 'hour');
        return $res;
	}
  
  	public static function getSpikeOne($id){
        $model=self::findOne($id);
        return $model->hour;
	}
  
}
