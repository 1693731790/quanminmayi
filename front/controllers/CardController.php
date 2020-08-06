<?php
namespace front\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;

use common\models\ProductCate;
use common\models\Product;
use common\models\Card;
use common\models\Orders;
use common\models\Adv;
use common\models\Orderdetail;
use Omnipay\Omnipay;


/**
 * Site controller
 */
class CardController extends CommonController
{
      public function actionPaystatus($oid)
      {
          $orders=orders::findOne($oid);
          if($orders->status!="0")
          {
            echo "1";
          }else{
            echo "2";
          }
      }
      public function actionGopay($paytype,$oid,$ismobile)
      {
         
         $orders=orders::findOne($oid);
        // $this->dump($orders);
         if($paytype=="2")
         {
            //微信支付
              // 司机确认订单前支付--微信
    
              $onlinepay_fee=$orders->price*100;
             // $this->dump($onlinepay_fee);
          
              $gateway=Omnipay::create('WechatPay_Native');
              $gateway->setAppId(Yii::$app->params['WECHAT']['app_id']);
              $gateway->setMchId(Yii::$app->params['WECHAT']['mch_id']);
              $gateway->setApiKey(Yii::$app->params['WECHAT']['api_key']);
             
              $gateway->setNotifyUrl('https://shop.chelunzhan.top/pay/weixin-notify');

            
              $order = [
                  'body'              => "若水堂支付",
                  'out_trade_no'      => $orders->ordernumber,
                  'total_fee'         => $onlinepay_fee,
                  'spbill_create_ip'  => Yii::$app->request->userIp,
                  'fee_type'          => 'CNY',

                 // 'open_id'           => $openid,
              ];
             // $this->dump($order);
              $request  = $gateway->purchase($order);
              $response = $request->send();
              
              if($response->isSuccessful()){
                  $qrCodeContent = $response->getCodeUrl(); //For Native Trade Type
                  
              }else{
                 
                 $this->dump($response->getData()); //For debug
                  //var_dump($data);
              }
              ob_start();
              \PHPQRCode\QRcode::png($qrCodeContent,false,'L', 4, 2);
              $imageString = base64_encode(ob_get_contents());
              ob_end_clean();

              $imgurl='data:image/png;base64,'.$imageString;

              //echo $data;
              //$this->dump($res);
    
       
  
         }else{
          if($ismobile=="1")
          {
            $gateway = Omnipay::create('Alipay_AopWap');
            $gateway->setSignType('RSA2'); //RSA/RSA2
            $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
            $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
            $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
            $gateway->setReturnUrl('http://hzapi.chelunzhan.top/user/index');
            $gateway->setNotifyUrl("https://m.chelunzhan.top/pay/alipay-notify");
            
            

            $request = $gateway->purchase();
            $request->setBizContent([
                'subject'      => '若水堂支付',
                'out_trade_no' => $orders->ordernumber,
                'total_amount' => $orders->price,
                'product_code' => 'QUICK_MSECURITY_PAY',
            ]);
            $response = $request->send();
            $redirectUrl = $response->getRedirectUrl();
//or 
            $response->redirect();
            die();
          }else{
              //支付宝支付
             $gateway = Omnipay::create('Alipay_AopF2F');
             $gateway->setSignType('RSA2'); //RSA/RSA2
             $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
             $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
             $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
             $gateway->setNotifyUrl("https://m.chelunzhan.top/pay/alipay-notify");
             $request = $gateway->purchase();
             $request->setBizContent([
                 'subject'      => '若水堂支付',
                 'out_trade_no' => $orders->ordernumber,
                 'total_amount' =>  $orders->price,
             ]);

             $response = $request->send();

             // 获取收款二维码内容
             $qrCodeContent = $response->getQrCode();
             ob_start();
             \PHPQRCode\QRcode::png($qrCodeContent,false,'L', 4, 2);
             $imageString = base64_encode(ob_get_contents());
             ob_end_clean();

             $imgurl='data:image/png;base64,'.$imageString;

          }
            

         
        }
         $adv=Adv::findOne(3);
         return $this->render("paycode",[
            "imgurl"=>$imgurl,
              "adv"=>$adv,
              "oid"=>$oid,
            "procate"=>ProductCate::find()->all(),
         ]);
      }
      public function actionGopaytype($oid,$ismobile)
      {
         $adv=Adv::findOne(3);
         return $this->render("paytype",[
            "adv"=>$adv,
            "oid"=>$oid,

            "ismobile"=>$ismobile,
            "procate"=>ProductCate::find()->all(),
         ]);
      }
      public function actionOrdercreate()
      {
         $user_id=Yii::$app->user->identity->id;
         $price=Card::find()->where(["user_id"=>$user_id])->sum("price");
         
         $data=Yii::$app->request->post();
         //echo $data["pay_type"];
         //
         $model=new Orders();
         $model->user_id=$user_id;        
         $model->region=$data["province"].$data["city"].$data["county"];
         $model->area=$data["area"];
         $model->name=$data["name"];
         $model->phone=$data["phone"];
         $model->liuyan=$data["liuyan"];
         $model->ordernumber=time().Yii::$app->user->identity->id.rand(1000,99999);
         $model->price=$price;

         $model->create_time=time();
         $model->save();
         $order_id=$model->order_id;
       
         $card=Card::find()->With("product")->where(["user_id"=>$user_id])->all();
         foreach($card as $cardv)
         {
            $orderdetail=new Orderdetail();
            $orderdetail->order_id=$order_id;
            $orderdetail->proid=$cardv->proid;
            $orderdetail->count=$cardv->num;
            $orderdetail->price=$cardv->price;
            $orderdetail->save();
            Card::findOne($cardv->card_id)->delete();
         }
         
         if($data["pay_type"]=="2")
         {
            //微信支付
              // 司机确认订单前支付--微信
    
              $onlinepay_fee=$price*100;
             // $this->dump($onlinepay_fee);
          
              $gateway=Omnipay::create('WechatPay_Native');
              $gateway->setAppId(Yii::$app->params['WECHAT']['app_id']);
              $gateway->setMchId(Yii::$app->params['WECHAT']['mch_id']);
              $gateway->setApiKey(Yii::$app->params['WECHAT']['api_key']);
             
              $gateway->setNotifyUrl('https://shop.chelunzhan.top/pay/666');

            
              $order = [
                  'body'              => "若水堂支付",
                  'out_trade_no'      => $model->ordernumber,
                  'total_fee'         => $onlinepay_fee,
                  'spbill_create_ip'  => Yii::$app->request->userIp,
                  'fee_type'          => 'CNY',

                 // 'open_id'           => $openid,
              ];
             // $this->dump($order);
              $request  = $gateway->purchase($order);
              $response = $request->send();
              
              if($response->isSuccessful()){
                  $qrCodeContent = $response->getCodeUrl(); //For Native Trade Type
                  
              }else{
                 
                 $this->dump($response->getData()); //For debug
                  //var_dump($data);
              }
              ob_start();
              \PHPQRCode\QRcode::png($qrCodeContent,false,'L', 4, 2);
              $imageString = base64_encode(ob_get_contents());
              ob_end_clean();

              $imgurl='data:image/png;base64,'.$imageString;

              //echo $data;
              //$this->dump($res);
    
       
  
         }else{
            if($data['ismobile']=="1")
            {
              $gateway = Omnipay::create('Alipay_AopWap');
              $gateway->setSignType('RSA2'); //RSA/RSA2
              $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
              $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
              $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
              $gateway->setReturnUrl('http://hzapi.chelunzhan.top/user/index');
              $gateway->setNotifyUrl("https://m.chelunzhan.top/pay/alipay-notify");
              
              

              $request = $gateway->purchase();
              $request->setBizContent([
                  'subject'      => '若水堂支付',
                  'out_trade_no' => $model->ordernumber,
                  'total_amount' => $price,
                  'product_code' => 'QUICK_MSECURITY_PAY',
              ]);
              $response = $request->send();
              $redirectUrl = $response->getRedirectUrl();
  //or 
              $response->redirect();
              die();
            }else{
            //支付宝支付
              $gateway = Omnipay::create('Alipay_AopF2F');
              $gateway->setSignType('RSA2'); //RSA/RSA2
              $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
              $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
              $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
              $gateway->setNotifyUrl("https://m.chelunzhan.top/pay/alipay-notify");
              $request = $gateway->purchase();
              $request->setBizContent([
                  'subject'      => '若水堂支付',
                  'out_trade_no' => $model->ordernumber,
                  'total_amount' =>  $price,
              ]);

              $response = $request->send();

              // 获取收款二维码内容
              $qrCodeContent = $response->getQrCode();
              ob_start();
              \PHPQRCode\QRcode::png($qrCodeContent,false,'L', 4, 2);
              $imageString = base64_encode(ob_get_contents());
              ob_end_clean();

              $imgurl='data:image/png;base64,'.$imageString;
            }
         }


          

         //$model->name=$data["area"];
        $adv=Adv::findOne(3);
         //$this->dump($model);
         return $this->render("paycode",[
            "adv"=>$adv,
            "oid"=>$order_id,

            "imgurl"=>$imgurl,
            "procate"=>ProductCate::find()->all(),
         ]);
      
      }
      function actionCardview()
      {
         $this->layout="no";
         $user_id=Yii::$app->user->identity->id;
         $model=Card::find()->With("product")->where(["user_id"=>$user_id])->all();
        // $cardids=Card::find()->where(["user_id"=>$user_id])->select("cardid")->all();                  
         //$this->dump($model);
         $adv=Adv::findOne(3);
         return $this->render("cardview",[
            "adv"=>$adv,
            "model"=>$model,
            "procate"=>ProductCate::find()->all(),
         ]);
        
      }
      public function actionCardupdate($data)
      {
         
         $id=explode("-",$data);
         for($i=0;$i<count($id)-1;$i++)
         {
            $nums=explode(",",$id[$i]);   
            $model=Card::findOne($nums[0]);
            $pro=Product::find()->where(["bookid"=>$model->proid])->select(["shichangjia"])->one();
            $newprice= $nums[1]*$pro->shichangjia;
            $model->price=(string)$newprice;
            $model->num=$nums[1];
            $model->save();
         }

         
        // $this->dump($id);

         return $this->redirect(['card/cardview']);  
      }      

   	public function actionIndex()
      {
         $this->layout="no";
         $user_id=Yii::$app->user->identity->id;
         $model=Card::find()->With("product")->where(["user_id"=>$user_id])->all();
         $adv=Adv::findOne(3);
        // $cardids=Card::find()->where(["user_id"=>$user_id])->select("cardid")->all();                  
         //$this->dump(count($model));
         return $this->render("index",[
            "count"=>count($model),
            "model"=>$model,
              "adv"=>$adv,
            "procate"=>ProductCate::find()->all(),
         ]);
      
      }
     
      function actionDelete($cardid)
      {
         $model=Card::findOne($cardid)->delete();
         return $this->redirect(['card/index']);  
      }
      function actionDeletes($cardids)
      {
         $id=explode(",",$cardids);
         //$id=array_pop($ids);
        // $this->dump($id);
         for($i=0;$i<count($id)-1;$i++)
         {
            Card::findOne($id[$i])->delete();   
         }
         
         echo "1";
      }

}
