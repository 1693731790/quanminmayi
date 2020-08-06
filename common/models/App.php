<?php
namespace common\models;

use Yii;

class App extends \yii\base\Model
{

	// 删除文件
	protected function deleteFile($file){
        $directory = Yii::getAlias('@webroot');
        if (is_file($directory . DIRECTORY_SEPARATOR . $name)) {
            return unlink($directory . DIRECTORY_SEPARATOR . $name);
        }
        return false;
    }
	
	// 发送手机短信 （容联云通信）
	static public function sendPhoneMsg($phone,$templateId,$datas){
            $time=date('YmdHis',time());
            $sig=strtoupper(md5(Yii::$app->params['duanxin']['account_sid'].Yii::$app->params['duanxin']['auth_token'].$time));
            $url=Yii::$app->params['duanxin']['rest_url']."/Accounts/".Yii::$app->params['duanxin']['account_sid']."/SMS/TemplateSMS?sig=".$sig;
            $data=[
                'to' =>$phone,
                "appId" =>Yii::$app->params['duanxin']['app_id'],
                "templateId"=>$templateId,
                "datas"=>$datas
            ];
            $post_data=json_encode($data);
            $headers = array();
            $headers[]="Accept:application/json";
            $headers[]="Content-Type:application/json;charset=utf-8";
            //$headers[]="Content-Length:256";
            $headers[]="Authorization:".base64_encode(Yii::$app->params['duanxin']['account_sid'].':'.$time);

            $ch =curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
            $output = curl_exec($ch);
            curl_close($ch);
            $res=json_decode($output);
            if(@$res->statusCode==="000000"){
				return true;
			}else{
				return $res->statusMsg;
			}
	}

    //手机号格式正则验证
    // 移动：134、135、136、137、138、139、150、151、152、157、158、159、182、183、184、187、188、178(4G)、147(上网卡)；
    // 联通：130、131、132、155、156、185、186、176(4G)、145(上网卡)；
    // 电信：133、153、180、181、189 、177(4G)；
    // 卫星通信：1349
    // 虚拟运营商：170
    static public function isPhone($mobile) {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,1,2,3,4,5,6,7,8,9]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    // 判断是否手机登录
    static public function isMobile() {
        static $is_mobile;
        if (isset($is_mobile)) return $is_mobile;
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $is_mobile = false;
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false
        ) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }
        return $is_mobile;
    }

    //查询ip信息
    static function getIpInfo($ip){
        $cache=Yii::$app->cache;
        return $cache->getOrSet($ip,function() use ($ip){
            $res=[];
            $ip_info = @file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);
            $ip_info = json_decode($ip_info,true);
            if($ip_info['code']!=0){
                $res['success']=false;
                $res['message']=$ip_info['data'];
                return $res;
            }
            $res['success']=true;
            $res['message']=$ip_info['data']['country'].$ip_info['data']['region'].$ip_info['data']['city'].$ip_info['data']['isp'];
            $res['data']=$ip_info['data'];
            return $res;
        });
    }

    // 必填参数检查
    static function checkParams($params,$request){
        $res['success']=true;
        $res=[];
        $res['errors']=[];
        if(is_array($params)&&!empty($params)){
            foreach($params as $k=>$v){
                if(!isset($request[$k])){
                    $res['success']=false;
                    array_push($res['errors'],'缺少必要参数：'.$k.'('.$v.')');
                }
            }
        }
        return $res;
    }

    static function formatTime($time){
        $day=intval($time/86400);
        $hour=intval(($time-$day*86400)/3600);
        $minute=intval(($time-$day*86400-$hour*3600)/60);
        if($day>0){
            return $day.'天'.$hour.'小时'.$minute.'分钟';
        }elseif($hour>0){
            return $hour.'小时'.$minute.'分钟';
        }else{
            return $minute.'分钟';
        }
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
