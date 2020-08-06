<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $auth_key;

    public static function tableName()
    {
        return '{{%user}}';
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
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['realname','validateRealname'],
           
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'parent_id',
            'realname' => '真实姓名',
            'user_type' => '账户类型',
            'sex' => '性别1男0女',
            'age' => '年龄',
            'nickname' => '昵称',
            'headimgurl' => '头像地址',
            'headimg' => '头像',
            'wallet' => '钱包余额',
            'integral' => '积分',
            'status' => 'Status',
            'created_at' => '注册时间',
            'access_token' => '用于api登录',
            
        ];
    }
    public function fields()
    {
        $fields = parent::fields();

        // 删除一些包含敏感信息的字段
            unset($fields['access_token']);
            $fields['check_status_name']=function($model){
                return Yii::$app->params['check_status'][$model->card_check_status];
            };
            $fields['phone']=function($model){
                return $model->phone;
            };
           

        return $fields;
    }


    public function validateRealname($attribute, $params)
    {
       /* if (!self::isRealname($this->$attribute)){
            $this->addError($attribute, '真实姓名不正确');
        }*/
    }

    public function validateCardId($attribute, $params)
    {
        if (!self::isCardId($this->$attribute)){
            $this->addError($attribute, '身份证号不正确');
        }
    }

   

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // 如果token无效的话，
        if(!static::accessTokenIsValid($token)) {
            if($type==10){
                return false;
            }else{
                throw new \yii\web\UnauthorizedHttpException("请登录");
            }
            
        }

        return static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
        // throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */


    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPhone($phone)
    {
        $auth=UserAuth::findOne(['identity_type'=>'phone','identifier'=>$phone]);
        if($auth){
            return static::findOne($auth->user_id);
        }
        return false;
        
    }

    //通过邀请码查找用户
    public static function findByInvitationcode($invitation_code)
    {
        return static::findOne(['invitation_code' => $invitation_code, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByUserid($userid)
    {
        return static::findOne(['id' => $userid, 'status' => self::STATUS_ACTIVE]);
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

    public function getOpenid()
    {
        $model=UserAuth::find()->where(['user_id'=>$this->id,'identity_type'=>'weixin'])->one();
        if($model){
            return $model->identifier;
        }
        return false;
    }

    public function getPhoneAuth(){
        return $this->hasOne(UserAuth::className(),[
            'user_id'=>'id'
        ])->where(['{{%user_auth}}.identity_type'=>'phone']);
    }
  public function getAuthPhone(){
        return $this->hasOne(UserAuth::className(),[
            'user_id'=>'id'
        ])->where(['{{%user_auth}}.identity_type'=>'phone'])->select(["user_id","identifier"]);
    }
  public function getWxAuth(){
        return $this->hasOne(UserAuth::className(),[
            'user_id'=>'id'
        ])->where(['{{%user_auth}}.identity_type'=>'username']);
    }
    public function getPhone()
    {
        $model=UserAuth::find()->where(['user_id'=>$this->id,'identity_type'=>'phone'])->one();
        if($model){
            return $model->identifier;
        }
        return false;
    }
    
    public function getUsername()
    {
        $model=UserAuth::find()->where(['user_id'=>$this->id,'identity_type'=>'username'])->one();
        if($model){
            return $model->identifier;
        }
        return false;
    }

    public function getHeadimg(){
        return $this->headimgurl==null?'https://www.chelunzhan.top/upload/image/car.png':$this->headimgurl;
    }
    
    public static function getNicknameById($id)
    {
        $model=User::findOne($id);
        if($model){
            return $model->nickname;
        }
        return false;
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

    // 验证交易密码
    public function validateTradePassword($trade_password)
    {
        if($this->trade_password==null){
            return true;
        }
        return Yii::$app->security->validatePassword($trade_password,$this->trade_password)?true:false;
    }

    // 设置交易密码
    public function setTradePassword($trade_password)
    {
        $this->trade_password = Yii::$app->security->generatePasswordHash($trade_password);
    }

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

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * 校验access_token是否有效
     */
    public static function accessTokenIsValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.accessTokenExpire'];
        return $timestamp + $expire >= time();
    }
    public function getAuth(){
        return $this->hasMany(UserAuth::className(),[
            'user_id'=>'id'
        ]);
    }

    //设置邀请码
    public function setInvitationCode(){
        if($this->invitation_code){
            return $this->invitation_code;
        }
        $str = null;
        // $len=strlen($this->id);
        // if($len<5){
        //     for($i=0;$i<5-$len;$i++){
        //         $str.='0';
        //     }
        // }
         $str.=$this->id;

         $array=str_split($str);
         $code=null;
         foreach($array as $v){
            $code.=chr(rand(65, 90)).$v;
         }
        $this->invitation_code=$code;
        return $code;
    }

    // 是否交易密码（6位数字）
    static public function isTradePassword($trade_password){
      $res=preg_match('/^\d{6}$/', $trade_password);
      return $res?true:false;
    }


    // 是否中文真实姓名
    static public function isRealname($name){
      $res=preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/', $name);
      return $res?true:false;
    }
    
    // 是否身份证号
    static public function isCardId($id_card){
        if(strlen($id_card)==18){
            return self::idcard_checksum18($id_card);
        }elseif((strlen($id_card)==15)){
            $id_card=self::idcard_15to18($id_card);
            return self::idcard_checksum18($id_card);
        }else{
            return false;
        }
    }

    // 计算身份证校验码，根据国家标准GB 11643-1999
    static public function idcard_verify_number($idcard_base){
        if(strlen($idcard_base)!=17){
            return false;
        }
        //加权因子
        $factor=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
        //校验码对应值
        $verify_number_list=array('1','0','X','9','8','7','6','5','4','3','2');
        $checksum=0;
        for($i=0;$i<strlen($idcard_base);$i++){
            $checksum += substr($idcard_base,$i,1) * $factor[$i];
        }
        $mod=$checksum % 11;
        $verify_number=$verify_number_list[$mod];
        return $verify_number;
    }
    // 将15位身份证升级到18位
    static public function idcard_15to18($idcard){
        if(strlen($idcard)!=15){
            return false;
        }else{
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
            if(array_search(substr($idcard,12,3),array('996','997','998','999')) !== false){
                $idcard=substr($idcard,0,6).'18'.substr($idcard,6,9);
            }else{
                $idcard=substr($idcard,0,6).'19'.substr($idcard,6,9);
            }
        }
        $idcard=$idcard.self::idcard_verify_number($idcard);
        return $idcard;
    }
    // 18位身份证校验码有效性检查
    static public function idcard_checksum18($idcard){
        if(strlen($idcard)!=18){
            return false;
        }
        $idcard_base=substr($idcard,0,17);
        if(self::idcard_verify_number($idcard_base)!=strtoupper(substr($idcard,17,1))){
            return false;
        }else{
            return true;
        }
    }

    
 
   

   






}
