<?php
namespace front\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\User;
use common\models\UserAuth;
use common\models\Suibianda;

/**
 * Site controller
 */
class PhoneController extends CommonController
{
    public function actionCallView($mobileNum)
    {
       $this->layout="nofooter";
        return $this->render("call-view",[
          "mobileNum"=>$mobileNum,
       
      ]);
    
    }
     public function actionCallBack($caller){//随便打  拨打电话
       		$user_id=Yii::$app->user->identity->id;
       		$userAuth=UserAuth::find()->where(["user_id"=>$user_id,"identity_type"=>"phone"])->one();
       	
      		$suibianda=new Suibianda($userAuth->identifier);
       		$res=$suibianda->callBack($caller,$userAuth->identifier);
     		
     		if($res)
            {
              	
            	$result['success']=true;
            	$result['res']="电话接通中";  
            }else{
                $result['success']=false;
            	$result['res']="拨打失败";  
            }
            
            
            return json_encode($result);
            
    }
    public function actionIndex()
    {
      $cookies = Yii::$app->request->cookies;//注意此处是request
      $callLog = $cookies->get('callLog');
      //$this->dump($callLog->value[""]);
      $callLog="";
      if(isset($callLog->value))
      {
       	    $callLog=array_reverse($callLog->value);
      }
      
      $this->layout=false;
       $user_id=Yii::$app->user->identity->id;
       $user=User::findOne($user_id);
    
       return $this->render("index",[
          "user"=>$user,
          "callLog"=>$callLog,

      ]);
    
    }
    public function actionCallDetail()
    {
      $cookies = Yii::$app->request->cookies;//注意此处是request
      $callLog = $cookies->get('callLog');
    //  $this->dump($callLog->value);
      $this->layout=false;
       $user_id=Yii::$app->user->identity->id;
       $user=User::findOne($user_id);
    
       return $this->render("call-detail",[
          "user"=>$user,
          "callLog"=>$callLog->value,

      ]);
    
    }
  
     function actionGoodsList($page="")
     {
         
          $page=($page-1)*10;
          //$goods=Goods::find()->asArray()->where(["status"=>"200","issale"=>"1","ishome"=>1])->orderBy("create_time desc")->offset($page)->limit(10)->all();
          $goods=Goods::find()->asArray()->where(["status"=>"200","issale"=>"1","ishome"=>1])->orderBy("price asc")->offset($page)->limit(10)->all();
          $str=""; 
          foreach($goods as $goodsVal)
          {
              $str.='<li><a style="display: block;" href="'.Url::to(["goods/detail","goods_id"=>$goodsVal['goods_id']]).'"><div class="spa"><img class="picee" src="'.Yii::$app->params['imgurl'].$goodsVal['goods_thums'].'"><div class="titlewee">'.$goodsVal['goods_name'].'<div class="pricee">¥'.$goodsVal['price'].'&nbsp<span class="hahae">¥'.$goodsVal['old_price'].'</span></div><div class="shopedsi">'.$goodsVal['salecount'].'人已买</div><div class="shoppingsan"><img class="pqc" src="/webstatic/images/picc_03.jpg"></div></div></div></a></li>';
              //$str.='<li style="margin-top:15px;"><a style="display: block;" href="'.Url::to(["goods/detail","goods_id"=>$goodsVal['goods_id']]).'"><div class="spa" style="margin-top: 20px;"><img class="picee" src="'.Yii::$app->params['imgurl'].$goodsVal['goods_thums'].'"><div class="titlewee"><span >'.$goodsVal['goods_name'].'</span><div class="pricee">¥'.$goodsVal['price'].'&nbsp<span class="hahae">¥'.$goodsVal['old_price'].'</span></div></div></div></a></li>';
              
          } 
          //$this->dump($str);
          echo $str;
          //return json_encode($orders);
         
      }
   
    public function actionGetCallToken($target_mobile,$name="")//打电话token
    {
      	$user_id=Yii::$app->user->identity->id;
        $user=UserAuth::findOne(["user_id"=>$user_id,"identity_type"=>"phone"]);
      	$mobile=$user->identifier;
      	
        $res=[];
        $agent_id="9651";
        $act="call";
        $key="511wHKsKOKY1AtdotV2xnO2xPFen90Zp";
        if(empty($mobile))
        {
            $res["code"]="0";
            $res["message"]="手机号不能为空";
            return json_encode($res);
        }
        if(empty($target_mobile))
        {
            $res["code"]="0";
            $res["message"]="目标手机号不能为空";
            return json_encode($res);
        }
        $params="act=".$act."&agent_id=".$agent_id."&mobile=".$mobile."&target_mobile".$target_mobile.time().$key;
        $token=md5($params);
        $time=time();
        $url="http://mp.d5dadao.com/api/appapi/query?agent_id=9651&mobile=$mobile&target_mobile=$target_mobile&act=call&time=$time&token=$token";
        $res=file_get_contents($url);
        $res=json_decode($res);
      	
        $cookies = Yii::$app->response->cookies;
      
        $cookiesRequest = Yii::$app->request->cookies;//注意此处是request
        $callLog = $cookiesRequest->get('callLog');

         $search = array(" ","　","\n","\r","\t");
         $replace = array("","","","","");
        $target_mobile=str_replace($search, $replace, $target_mobile);

      	//$this->dump($callLog->value);
      	if(isset($callLog->value))
        {
           //$callLog->value[]=array("name"=>$name,"callNum"=>$target_mobile,"time"=>time());
           $callLog=$callLog->value; 
          $callLog[]=array("name"=>$name,"callNum"=>$target_mobile,"time"=>time());
        }else{
           $callLog=array(array("name"=>$name,"callNum"=>$target_mobile,"time"=>time())); 
        }
        $cookies->add(new \yii\web\Cookie([
            'name' => 'callLog',
            'value' =>$callLog,
            'expire'=>time()+60*60*24*30
        ]));
      	if($res->code=="2000")
        {
          	$result["success"]=true;
            return json_encode($result);
        }else{
          	$result["success"]=false;
            return json_encode($result);
        }
      	
      
        //return json_encode($res);
      
    }
  	
  	

   
}
