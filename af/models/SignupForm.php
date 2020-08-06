<?php
namespace backend\models;

use yii\base\Model;
use common\models\Admin;
use yii\helpers\VarDumper;

/**
 * Signup form
 */
class SignupForm extends Model
{
    
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                ['username', 'trim'],
                ['username', 'required'],
                ['username', 'string', 'min' => 2, 'max' => 255],
                
                ['password', 'required'],
                ['password', 'string', 'min' => 6],
                ['password_repeat',"compare",'compareAttribute'=>"password","message"=>"两次输入密码不一致"],
                
        ];
    }
    public function attributeLabels()
    {
        return [
                'id' => 'ID',
                'username' => '用户名称',
                'password' => '密码',
                'password_repeat' => '重复密码',
                'email' => '用户邮箱',
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        
        if (!$this->validate()) {
            return null;
        }
       $username= $this->username;
      
        $user = new Admin();
        $user->username =$username;
        //$user->email = $this->email;
        $user->created_at= time();
        $user->updated_at= time();
        
        $user->setPassword($this->password);
        
        $user->generateAuthKey();
        $user->password="******";
      /*	echo "<pre>";
      var_dump( $user->getErrors());
      die();*/
        return $user->save() ? $user : null;
    }
}
