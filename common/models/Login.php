<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\UserAuth;

/**
 * 会员登录，支持第三方登录
 */

class Login extends Model
{
    public $identity_type;
    public $identifier;
    public $credential;
    public $rememberMe=false;
    private $_user;
    public function rules()
    {
        return [

            [['identity_type', 'identifier'], 'required'],
            ['rememberMe', 'boolean'],
            ['credential', 'required','when'=>function(){
                return $this->identity_type=='phone'||$this->identity_type=='username';
            }],
            ['credential', 'validateCredential'],
        ];
    }

    public function attributeLabels(){
        return [
            'identity_type'=>'登录类型',
            'identifier'=>'账户',
            'credential'=>'密码凭证',
        ];
    }

    public function validateCredential($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $user_auth=UserAuth::find()->where(['identity_type'=>$this->identity_type,'identifier'=>$this->identifier])->one();
            if (!$user || !$user_auth->validateCredential($this->credential)) {
                $this->addError($attribute, '用户名或密码错误');
            }
        }
    }


    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }



    protected function getUser()
    {
        if ($this->_user === null) {
            $user_auth=UserAuth::find()->where(['identity_type'=>$this->identity_type,'identifier'=>$this->identifier])->one();

            if($user_auth){
                $this->_user = User::findByUserid($user_auth->user_id);
            }
        }

        return $this->_user;
    }

}
