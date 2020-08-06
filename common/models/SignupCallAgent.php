<?php
namespace common\models;

use yii\base\Model;
use common\models\CallAgent;
use yii\helpers\VarDumper;

/**
 * Signup form
 */
class SignupCallAgent extends Model
{
    
    public $username;
    public $password;
    public $password_repeat;
  	public $type;
    public $money;
    public $id_front;
    public $id_back;
  	public $id_num;
    public $corp_code;
    public $phone;
    public $address;
    public $realname;
	public $corp_name;
    public $contract;
 	
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                ['username', 'trim'],
                [['username',"money","phone","address","contract"], 'required'],
                ['username', 'unique', 'targetClass' => '\common\models\CallAgent', 'message' => '用户名称已经存在'],
                ['username',"safe"],
          		
                ['password', 'required'],
                ['password_repeat',"compare",'compareAttribute'=>"password","message"=>"两次输入密码不一致"],
                ['password', 'safe'],
          		
          		[["money"], 'number'],
                [["type","id_front","id_back","id_num","corp_code","phone","address","realname","corp_name","contract"], 'safe'],
                

              
          		
          
               
        ];
    }
   
    public function attributeLabels()
    {
        return [
                
                'username' => '账号',
                'password' => '密码',
                'password_repeat' => '重复密码',
          
                'type' => '类型',
          		'money' => '预付款',
                'id_front' => '身份证正面',
                'id_back' => '身份证反面',
          		'id_num' => '身份证号',
                'corp_code' => '营业执照',
                'phone' => '手机号',
                'address' => '地址',
                'realname' => '真实姓名',
          		'corp_name' => '公司名称',
          		'contract' => '合同',
               
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        /*$this->validate();
        echo "<pre>";
        var_dump($this->getErrors());
        die();*/
        if (!$this->validate()) {
          
          
            return false;
          
        }
        $user = new CallAgent();
        $user->username = $this->username;
        $user->created_at= time();
        $user->updated_at= time();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->password="******";
      	$user->type=$this->type;
        $user->money=$this->money;
        $user->id_front=$this->id_front;
        $user->id_back=$this->id_back;
      	$user->id_num=$this->id_num;
        $user->corp_code=$this->corp_code;
        $user->phone=$this->phone;
        $user->address=$this->address;
        $user->realname=$this->realname;
      	$user->corp_name=$this->corp_name;
        $user->contract=$this->contract;
      
      	
        //$user->save();
        /*// echo "<pre>";
        //var_dump($user);
        //var_dump($user->getErrors());
        die();*/
        return $user->save() ? $user : null;
    }
 
}
