<?php
namespace front\controllers;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\AfGoods;
use common\models\Goods;
use common\models\AfCode;
use common\models\AfCodeLog;


/**
 * 购物车
 */
class AfCodeController extends Controller
{
      public $enableCsrfValidation = false;

      public function actionAfCodeShow($number,$type="",$class="",$nickname="",$province="")
      {
          $this->layout=false;
          $afCode=AfCode::findOne(["number"=>$number]);
          if(empty($afCode))
          {
          		return $this->render('index-false', [
                    
                ]);
          }
          $afGoods=AfGoods::findOne($afCode->goods_id);
          $afCodeLog=new AfCodeLog();
          if($type!="")
          {
          	  $afCodeLog->type=$type;  
          }else{
           	  $afCodeLog->type="1"; 
          }
          
          $afCodeLog->code_id=$afCode->id;
          $afCodeLog->nickname=$nickname;
          //$afCodeLog->user_phone="123123";
          $afCodeLog->address=$province;
        
          $afCodeLog->create_time=time();
          $afCodeLog->save();
          $afCode->status="1";
          $afCode->update(true,["status"]);
          $goods="";
          $shareImg="";
          if($afGoods->goods_id!="")
          {
            	$goods=Goods::findOne($afGoods->shop_goods_id);
            	if(yii::$app->user->isGuest)
                {
                      $searchLink=yii::$app->params['webLink']."/goods/detail.html?goods_id=".$goods->goods_id;  
                }else{
                      $searchLink=yii::$app->params['webLink']."/goods/detail.html?goods_sn=".$goods->goods_sn."&code=".Yii::$app->user->identity->invitation_code;
                }
               
            	if($goods->jdis_update_goods_thums=="1"||$goods->shop_id!="1")
                {	
                       $shareImg=Yii::$app->params['webLink'].$goods->goods_thums;
                }else{
                       $shareImg=$goods->goods_thums;
                }

          }
   
          
          return $this->render('code-show', [
                  "goods"=>$afGoods,
                  "goodsDetail"=>$goods,
                  "attr"=> $afGoods->attr!=""?unserialize($afGoods->attr):"" ,
                  "searchLink"=>$searchLink,
                  "shareImg"=>$shareImg,
                  "type"=>$type,
                  "class"=>$class,
           ]);
          
         
      }
      public function actionSweepCode()
      {
          $this->layout=false;
          $result="";
          if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')!==false)
          {
            	if($_GET["code"]=="")
                {
                  	//获取code
                	$appid=Yii::$app->params['WECHAT']['app_id'];
                    $redirect_uri=urlencode("https://shop.qmmayi.com/af-code/sweep-code.html");
                    $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
                    header("Location:".$url);
                    die();    
                }else{
                    //获取openid
                 	$code=$_GET["code"];
                    $appid=Yii::$app->params['WECHAT']['app_id'];
                    $secret=Yii::$app->params['WECHAT']['secret'];
                    $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
                    $res=file_get_contents($url);
                    $res=json_decode($res);
                  	//通过openid获得用户资料
                  	$urlInfo="https://api.weixin.qq.com/sns/userinfo?access_token=".$res->access_token."&openid=".$res->openid."&lang=zh_CN";
                    $result=file_get_contents($urlInfo);
                    $result=json_decode($result);
                    //$this->dump($result);
                }
          		
          }
          
          return $this->render('sweep-code', [
                  "result"=>$result,
           ]);
          
         
      }
      
}
