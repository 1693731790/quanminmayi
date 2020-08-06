<?php
namespace agent\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Omnipay\Omnipay;
use common\models\Shops;
use common\models\RobBuy;
use common\models\Order;
use common\models\Agent;
use common\models\OrderGoods;
use common\models\OrderAllPay;
use common\models\User;
use common\models\AgentGrade;
use common\models\Wallet;
use common\models\Config;
use common\models\AgentFeeRecord;
use common\models\AgentChannel;


/**
 * 支付控制器
 */
class PayController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionGoPayAll($all_pay_sn,$pay_type)//合并付款
    {

        $orderAll=OrderAllPay::findOne(["all_pay_sn"=>$all_pay_sn]);
        $order_all_id=$orderAll->id;
        $countPrice=Order::find()->asArray()->where(['order_all_pay_id'=>$order_all_id])->sum('total_fee');

        //$this->dump($imageString);
        //echo $res['alipay']['qrcode'];
        //die();
       
        //$this->dump($orderAll);
        //1支付宝2微信
        if($pay_type=="1")
        {
            $gateway = Omnipay::create('Alipay_AopF2F');
            $gateway->setSignType('RSA2'); //RSA/RSA2
            $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
            $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
            $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
            $gateway->setNotifyUrl("http://agentmall.chelunzhan.top/pay/alipay-all-notify");     
            $request = $gateway->purchase();

            $request->setBizContent([
                'subject'      => '商城支付',
                'out_trade_no' => $orderAll->all_pay_sn,
                'total_amount' => $countPrice
            ]);
 

            $response = $request->send();
              // 获取收款二维码内容
            $qrCodeContent = $response->getQrCode();
            ob_start();
            \PHPQRCode\QRcode::png($qrCodeContent,false,'L', 4, 2);
            $imageString = base64_encode(ob_get_contents());
            ob_end_clean();

            $imgcode='data:image/png;base64,'.$imageString;

        }else if($pay_type=='2')
        {

            $gateway=Omnipay::create('WechatPay_Native');
            $gateway->setAppId(Yii::$app->params['WECHAT']['app_id']);
            $gateway->setMchId(Yii::$app->params['WECHAT']['mch_id']);
            $gateway->setApiKey(Yii::$app->params['WECHAT']['api_key']);
           
            $gateway->setNotifyUrl('http://agentmall.chelunzhan.top/pay/wxpay-all-notify');
           
            $order = [
                'body'              => "商城支付",
                'out_trade_no'      => $orderAll->all_pay_sn,
                'total_fee'         => $countPrice*100,
                'spbill_create_ip'  => Yii::$app->request->userIp,
                'fee_type'          => 'CNY',

            ];

           // $this->dump($order);
            $request  = $gateway->purchase($order);
            $response = $request->send();
            //$response->getData(); //For debug
            // $response->getCodeUrl(); //For Native Trade Type
           // $this->dump($response->getCodeUrl());
           
            $qrCodeContent = $response->getCodeUrl(); //For Native Trade Type
           
            ob_start();
            \PHPQRCode\QRcode::png($qrCodeContent,false,'L', 4, 2);
            $imageString = base64_encode(ob_get_contents());
            ob_end_clean();

            $imgcode='data:image/png;base64,'.$imageString;

           
        }

        return $this->render('pay-code', [
               'imgcode' => $imgcode,
               "pay_type"=>$pay_type,
        ]);
           
    }


    
     // 支付宝异步通知（二维码）商城购买商品合并支付
    public function actionAlipayAllNotify()
    {
       // Yii::info('支付宝异步通知','pay');
        $gateway = Omnipay::create('Alipay_AopApp');
        $gateway->setSignType('RSA2'); //RSA/RSA2
        $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
        $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
        $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
       
        $request = $gateway->completePurchase();
        $request->setParams($_POST);//Optional
        try {
            $response = $request->send();
            if($response->isPaid()){
                // 订单支付成功
                Yii::info(print_r(@$_POST,true),'pay');
                $order_sn=$_POST['out_trade_no'];
                $pay_type=1;
                $pay_num=$_POST['trade_no'];
                $res=$this->payHandle($order_sn,$pay_type,$pay_num);//订单号，支付方式，流水号
                if($res){
                    return "success";
                }

            }else{
                /**
                 * Payment is not successful
                 */
                die('fail');
            }
        } catch (Exception $e) {
            /**
             * Payment is not successful
             */
            die('fail');
        }

    }

     public function actionWxpayAllNotify(){//微信异步调用
        
        $gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']['app_id']);
        $gateway->setMchId(Yii::$app->params['WECHAT']['mch_id']);
        $gateway->setApiKey(Yii::$app->params['WECHAT']['api_key']);

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();

        if ($response->isPaid()) {
            //支付成功

            $data=$response->getRequestData();
          
            $order_sn=$data['out_trade_no'];
            $pay_type=2;
            $pay_num=$data['transaction_id'];

            
           
            $res=$this->payHandle($order_sn,$pay_type,$pay_num);//订单号，支付方式，流水号

          
            if($res){
               
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
        
    }

    function payHandle($order_sn,$pay_type,$pay_num)
    {
      
        
        $orderAll=OrderAllPay::findOne(["all_pay_sn"=>$order_sn]);
        $orderData=Order::find()->where(["order_all_pay_id"=>$orderAll->id])->select(["order_sn"])->all();
        
      //  $this->dump($orderData);
        $transaction=Yii::$app->db->beginTransaction();
        try {
            //修改代理商为已支付状态
            $agent=Agent::findOne($orderAll->agent_id);
            $agent->ispay="1";
            if(!$agent->update(true,["ispay"]))
            {
                throw new \yii\db\Exception("保存失败");
            }
            //-----------------------------------------------------------------------
            //修改上级代理商总金额
            $agentGrade=AgentGrade::findOne($agent["level"]);//获取代理商升级参数
            //$this->dump($orderAll->id);
            $orderDataPrice=Order::find()->where(["order_all_pay_id"=>$orderAll->id])->sum('total_fee');//订单总价
          
            $orderDataFreight=Order::find()->where(["order_all_pay_id"=>$orderAll->id])->sum("deliver_fee");//订单总运费
            $orderFee=$orderDataPrice-$orderDataFreight;//订单总价减去运费

            $patentAgent=User::findOne($agent->parent_id);//上级代理商

            $agentParent=Agent::findOne(["user_id"=>$agent->parent_id]);//上级代理商分销信息

            $patentAgentBalance=$patentAgent->wallet;//上级代理商钱包余额
            $addFee=$orderFee*(($agentGrade->reward+$agentParent->reward_rate)/100);//需要增加的总金额

            //$this->dump($addFee);
            $patentAgent->wallet=round($patentAgentBalance+$addFee,2);

            if(!$patentAgent->update(true,["wallet"]))
            {

                throw new \yii\db\Exception("保存失败");

            }
           $scale=$agentGrade->reward+$agentParent->reward_rate;
            //-----------------------------------------------------------------------
            //添加钱包记录
            $wallet=new Wallet();
            if(!$wallet->addWallet($agent->parent_id,2,$addFee,$patentAgentBalance,'','',$scale))
            {
                throw new \yii\db\Exception("保存失败");
            }

            //-----------------------------------------------------------------------

            //添加个人业绩金额记录
            $agentFeeRecord=new AgentFeeRecord();
            if(!$agentFeeRecord->add($patentAgent->id,$agentParent->agent_id,$orderFee))
            {
                throw new \yii\db\Exception("保存失败");
            }

            //-----------------------------------------------------------------------

            //个人业绩总金额
            $agentFeeRecordCount=AgentFeeRecord::find()->where(["agent_id"=>$agentParent->agent_id])->sum("fee");
            $agentChannel=AgentChannel::find()->asArray()->where(["<","gt_fee",$agentFeeRecordCount])->max("gt_fee");
            if(!empty($agentChannel))
            {
                $agentChannelOne=AgentChannel::findOne(["gt_fee"=>$agentChannel]);
                $wallet2=new Wallet();
                if(!$wallet2->addWallet($patentAgent->id,3,$agentChannelOne->reward,$patentAgent->wallet))
                {
                    throw new \yii\db\Exception("保存失败");
                }
                $patentAgent->wallet=$patentAgent->wallet+$agentChannelOne->reward;
                if(!$patentAgent->update(true,["wallet"]))
                {
                    throw new \yii\db\Exception("保存失败");

                }
                
                $agentParent->reward_rate=$agentParent->reward_rate+$agentChannelOne->proportion;
                if(!$agentParent->update(true,['reward_rate']))
                {
                    throw new \yii\db\Exception("保存失败");
                }
            }
            //$this->dump($agentChannel);

            //-----------------------------------------------------------------------

            //渠道收益 上上级代理商;
            $agentParentParentDownCount=Agent::find()->where(["parent_id"=>$agentParent->parent_id,"ispay"=>"1"])->count();//上上级代理下的所有代理商总数；

            $agentParentDownCount=Agent::find()->where(["parent_id"=>$agent->parent_id,"ispay"=>"1"])->count();//上级代理下的所有代理商总数（同级代理商）

            //$this->dump($agentParentDownCount%4==0);
            //渠道收益规则：代理商必须完成一组4人后方才收益到渠道分红
            //当第四人产生时执行如下代码（总代理商数取余等于0说明第四人产生）
            //上上级代理商下级人数必须大于4人，同级代理商人数除4和上上级代理商的下级代理商人数除4对应
            //如果同级代理商人数除4小于上上级代理商的下级代理商人数除4,则获得取到收益，反之不获得
            //(如上上级代理商的下级代理商只有4人，那么只能获得同级代理商第四人产生时的渠道收益，)

            if($agentParentParentDownCount>=4&&$agentParentDownCount%4==0)
            {
                
                //$this->dump($agentParentParentDownCount/4);
                if($agentParentParentDownCount/4>=$agentParentDownCount/4)
                {
                    //$this->dump("渠道收益");
                    //渠道收益
                    $config=Config::findOne(1);
                    $patentParentAgent=User::findOne($agentParent->parent_id);//上上级代理商
                    
                    $patentParentAgentBalance=$patentParentAgent->wallet;//上上级代理商钱包余额

                    $addFee1=$addFee*($config->channel/100);

                    $patentParentAgent->wallet=round($patentParentAgentBalance+$addFee1,2);
                     
                    if(!$patentParentAgent->update(true,["wallet"]))
                    {
                        throw new \yii\db\Exception("保存失败");
                    }

                    //添加钱包记录
                    $wallet1=new Wallet();
                    if(!$wallet1->addWallet($agentParent->parent_id,2,$addFee1,$patentParentAgentBalance))
                    {
                        throw new \yii\db\Exception("保存失败");
                    }

                    //$this->dump("yes");
                }
                
            }
            //-----------------------------------------------------------------------
            //$this->dump("exit");


            //修改订单为已支付状态
            foreach ($orderData as $orderDataVal)
            {
                $order=Order::findOne(["order_sn"=>$orderDataVal->order_sn]);
                $order->pay_type=$pay_type;
                $order->pay_num=$pay_num;
                $order->status="1";
                $order->pay_time=time();
                if(!$order->update(true,["pay_type","pay_num","status","pay_time"]))
                {
                    throw new \yii\db\Exception("保存失败");
                } 

            }
            $transaction->commit();

            return true;

        }catch (\Exception $e) {
            $transaction->rollBack();
           
            throw $e;
          
            return false;
            
        }
            
        
    }

}
