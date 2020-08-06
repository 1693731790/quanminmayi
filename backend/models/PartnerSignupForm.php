<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\UserAuth;

/**
 * 创建合伙人账号表单模型
 */

class PartnerSignupForm extends Model
{
    public $username;
    public $password;
    public $realname;
    public $phone;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 4, 'max' => 20],
            ['username', 'validateUsername'],

            ['realname', 'trim'],
            ['realname', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 10],
            ['realname','validateRealname'],

            ['password', 'required'],
            ['password', 'validatePwd'],
            
            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'string', 'max' => 11],
            ['phone', 'validatePhone'],
        ];
    }

    public function validateRealname($attribute, $params)
    {
        if (!User::isRealname($this->$attribute)){
            $this->addError($attribute, '真实姓名不正确');
        }
    }

    public function validateUsername($attribute, $params){
        if (!$this->hasErrors()) {
            if(UserAuth::findUserByUsername($this->username)!=null){
                $this->addError($attribute,'用户名已占用');
            }
        }
    }

    public function validatePhone($attribute, $params){
        if (!$this->hasErrors()) {
            if(!UserAuth::isPhone($this->phone)){
                $this->addError($attribute,'手机号格式不正确');
            }
        }
        if (!$this->hasErrors()) {
            if(UserAuth::findUserByPhone($this->phone)!=null){
                $this->addError($attribute,'手机号已注册');
            }
        }
    }
    public function validatePwd($attribute, $params){
        if (!$this->hasErrors()) {
            if(!UserAuth::isPassword($this->password)){
                $this->addError($attribute,'密码8—20位,由字母、数字组成');
            }
        }
    }

    public function attributeLabels(){
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'realname'=>'真实姓名',
            'phone'=>'手机号'
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        //开启事务保存数据
        $transaction=Yii::$app->db->beginTransaction();
        try{
            // 注册新用户
            $user_model=new User();
            $user_model->user_type=2;
            $user_model->card_check_status=10;
            $user_model->apply_info='管理员'.Yii::$app->user->identity->username.'开通账号';
            $user_model->realname=$this->realname;
            if(!$user_model->save()){
                foreach($user_model->errors as $v){
                    $msg=$v[0];
                    break;
                }
                 throw new \yii\db\Exception($msg);
                }
            

            $user_model->setInvitationCode();
            if(!$user_model->save()){
                 throw new \yii\db\Exception('邀请码生成失败');
            }

            $user_auth_model_1=new UserAuth();

            $user_auth_model_1->user_id=$user_model->id;
            $user_auth_model_1->identity_type='phone';
            $user_auth_model_1->identifier=$this->phone;
            $user_auth_model_1->setCredential($this->password);
            $user_auth_model_1->save();
            if(!$user_auth_model_1->save()){
                 throw new \yii\db\Exception('手机号登录创建失败');
            }
            $user_auth_model=new UserAuth();
            $user_auth_model->user_id=$user_model->id;
            $user_auth_model->identity_type='username';
            $user_auth_model->identifier=$this->username;;
            $user_auth_model->setCredential($this->password);
            if(!$user_auth_model->save()){
                 throw new \yii\db\Exception('用户名登录创建失败');
            }
            $transaction->commit();
            return $user_model;
        }catch(\Exception $e){
            $transaction->rollBack();
            throw $e;
            return false;
        }
    }
}
