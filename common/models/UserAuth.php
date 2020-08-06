<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_auth".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $identity_type
 * @property string $identifier
 * @property string $credential
 */
class UserAuth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'identity_type', 'identifier'], 'required'],
            [['user_id'], 'integer'],
            [['identity_type'], 'string', 'max' => 50],
            [['identifier', 'credential'], 'string', 'max' => 255],
            [['identity_type', 'identifier'], 'unique', 'targetAttribute' => ['identity_type', 'identifier'], 'message' => '账号已存在'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'identity_type' => '登录类型（手机号 邮箱 用户名）或第三方应用名称（微信 微博等）',
            'identifier' => '标识（手机号 邮箱 用户名或第三方应用的唯一标识）',
            'credential' => '密码凭证（站内的保存密码，站外的不保存或保存token）',
        ];
    }

    // 验证密码凭证，使用Yii自带加密方式，第三方登录不需要验证凭证
    public function validateCredential($credential)
    {
        if($this->identity_type==='phone'||$this->identity_type==='email'||$this->identity_type==='username'){
            return Yii::$app->security->validatePassword($credential, $this->credential);
        }elseif($this->identity_type==='weixin'||$this->identity_type==='qq'){
            return true;
        }else{
            return false;// 非法登录类型
        }
    }

    // 设置密码凭证，使用yii方式加密
    public function setCredential($credential)
    {
        if($this->identity_type==='phone'||$this->identity_type==='email'||$this->identity_type==='username'){
            $this->credential = Yii::$app->security->generatePasswordHash($credential);
        }
    }

    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    static public function findUserByOpenid($openid){
        return self::find()->where(['identity_type'=>'weixin','identifier'=>$openid])->joinWith('user')->one();
    }

    static public function findUserByPhone($phone){
        return self::find()->where(['identity_type'=>'phone','identifier'=>$phone])->joinWith('user')->one();
    }
    /*static public function findUserByOpenid($openid){
        return self::find()->where(['identity_type'=>'weixin','identifier'=>$openid])->joinWith('user')->one();
    }*/
    static public function findUserByUsername($username){
        return self::find()->where(['identity_type'=>'username','identifier'=>$username])->joinWith('user')->one();
    }

    //密码:6—20位,由字母、数字组成
    static function isPassword($value,$minLen=8,$maxLen=16){
        $match='/^[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"\d\w]{'.$minLen.','.$maxLen.'}$/'; 
        $v = trim($value);
        if($v==null)
        return false; 
        return preg_match($match,$v); 
    }
    
    static public function isPhone($mobile) {
        if (!is_numeric($mobile)) {
            return false;
        }
        //return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,1,2,3,4,5,6,7,8,9]{1}\d{8}$|^18[\d]{9}$#|^199{8}', $mobile) ? true : false;
      	return preg_match("/^1[3456789]\d{9}$/", $mobile) ? true : false;
      
    }
}
