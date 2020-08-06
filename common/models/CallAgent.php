<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */

class CallAgent extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    /**
     * This is the model class for table "{{%user}}".
     *
     * @property integer $id
     * @property string $username
     * @property string $auth_key
     * @property string $password_hash
     * @property string $password_reset_token
     * @property string $email
     * @property integer $status
     * @property integer $created_at
     * @property integer $updated_at
     */

	
    public $password;
    public $password_repeat;
        
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                    [["username"], 'required'],
                    ['password', 'string', 'min' => 6],
                    ['password_repeat',"compare",'compareAttribute'=>"password","message"=>"两次输入密码不一致"],
              		[["type","id_front","id_back","id_num","corp_code","phone","address","realname","corp_name","contract"], 'safe'],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                    'id' => 'ID',
                    'username' => '账号',
                    'auth_key' => 'Auth Key',
                    'password_hash' => 'Password Hash',
                    'password_reset_token' => 'Password Reset Token',
       				
              		
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
                    'status' => '状态',
              
                    'created_at' => '创建时间',
                    'updated_at' => '修改时间',
              
                    'password' => '密码',
                    'password_repeat' => '重复密码',
            ];
        }
    
    
 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%call_agent}}';
    }
   
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                TimestampBehavior::className(),
        ];
    }
    
    
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        
        return static::findOne([
                'password_reset_token' => $token,
                'status' => self::STATUS_ACTIVE,
        ]);
    }
    
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
