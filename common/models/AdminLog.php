<?php

namespace common\models;

use Yii;

class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at','event'], 'integer'],
            [['ip'], 'string', 'max' => 15],
            [['info'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_log_id' => 'ID',
            'user_id' => '管理员id',
            'created_at' => '操作时间',
            'ip' => 'ip',
            'event' => '事件',
            'info' => '信息',
        ];
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            $time=time();
            if($this->isNewRecord){
                $this->created_at=$time;
                $this->ip=Yii::$app->request->userIP;
            }

            return true;
        }else{
            return false;
        }
    }

    public function getUser(){
        return $this->hasOne(User::className(),[
            'id'=>'user_id',
        ]);
    }
    // 创建日志 $event请参考配置文件
    public static function create($user_id,$event,$info=null){
        $model=new AdminLog();
        $model->user_id=$user_id;
        $model->event=$event;
        $model->info=$info;
        if($model->save()){
            return true;
        }
        return false;
    }


}
