<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_comment}}".
 *
 * @property integer $cid
 * @property integer $goods_id
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $type
 * @property integer $goods_score
 * @property integer $service_score
 * @property integer $time_score
 * @property string $content
 * @property string $images
 * @property integer $ishide
 * @property integer $create_time
 */
class GoodsComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'goods_id', 'order_id', 'user_id', 'type', 'goods_score', 'service_score', 'time_score', 'content'], 'required'],
            [[ 'goods_id', 'order_id', 'user_id', 'type', 'goods_score', 'service_score', 'time_score', 'ishide', 'create_time'], 'integer'],
            [['content'], 'string'],
            [['images'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'ID',
            'goods_id' => '商品ID',
            'order_id' => '订单ID',
            'user_id' => '用户ID',
            'type' => '评论类型',
            'goods_score' => '商品评分',
            'service_score' => '服务评分',
            'time_score' => '物流评分',
            'content' => '评论内容',
            'images' => '评论图片',
            'ishide' => '是否隐藏',
            'create_time' => '评论时间',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ["id"=>"user_id"]);
  
    }
    public function getUserAuth()
    {
        return $this->hasOne(UserAuth::className(), ["user_id"=>"user_id"])->where(["identity_type"=>'username']);
  
    }

    public function createComment($data,$goods_id)
    {
          $user_id=Yii::$app->user->identity->id;
          $this->goods_id=$goods_id;
          $this->order_id=$data["order_id"];
          $this->user_id=$user_id;
          $this->type=$data["type"];
          $this->goods_score=$data["goods_score"];
          $this->service_score=$data["service_score"];
          $this->time_score=$data["time_score"];
          $this->content=$data["content"];
          $this->create_time=time();
          // $this->save();
          // echo "<pre>";
          // var_dump($this->getErrors());
          // die();
          if($this->save())
          {
                return true;
          }else{
                return false;
          }
          
  
    }    
          

}
