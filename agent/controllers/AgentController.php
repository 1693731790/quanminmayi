<?php

namespace agent\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use common\models\Agent;
use common\models\User;
use common\models\GoodsSku;
use common\models\Goods;
use common\models\UserAddress;
use common\models\UserAuth;
use common\models\OrderAllPay;
use common\models\Order;
use common\models\OrderGoods;
use common\models\Config;
use common\models\AgentGrade;
use common\models\AgentSearch;
use common\models\UserSearch;
use common\models\Region;
use common\models\MobileCardOrder;
use common\models\MobileCardOrderDetail;
use common\models\MobileCard;
use common\models\MobileCardImg;
use common\models\AgentBalanceRecord;


/**
 * AgentController implements the CRUD actions for Agent model.
 */
class AgentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
   
    public function actionGoPay($all_pay_sn)//选择支付 fangshi
    {
        return $this->render('go-pay', [
                "all_pay_sn"=>$all_pay_sn,
        ]);    
        
        
    }
    public function actionRegion($region_id="")
      {
          $region=Region::find()->asArray()->where(["parent_id"=>$region_id])->all();
         // $this->dump($region);
          //$this->dump(json_encode($region));
          return json_encode($region);
      }

    public function actionCreate()  //添加
    {
        $agentType=Agent::getAgentType();
        if($agentType=="2")
        {
            echo '无法访问';
            die();
        }
        $user_id=Yii::$app->user->identity->id;   
        if ($data=Yii::$app->request->get()) {
            
            $goodsData=[];
            
            $shopIdData=[];
            
            $res=[];
            $user_type=0;

            $phone=$data["user_phone"];
            $username=$data["user_username"];
            $password=$data["user_password"];
           
            if(strlen($username)<4){
                $res['success']=false;
                $res['message']="用户名至少4个字符";
                return json_encode($res);
            }
           

            if(!UserAuth::isPhone($phone)){
                $res['success']=false;
                $res['message']="手机号格式不正确";
                return json_encode($res);
            }
            
            if(!UserAuth::isPassword($password)){
                
                $res['success']=false;
                $res['message']="密码不合法,密码8—20位,由字母、数字组成";
                return json_encode($res);
            }

            if(!isset($data["mi_id"])){
                
                $res['success']=false;
                $res['message']="请选择电话卡封面";
                return json_encode($res);
            }
            if($data["mi_id"]=="0"){
                if($data["phone"]=="")
                {
                    $res['success']=false;
                    $res['message']="请输入电话号";
                    return json_encode($res);
                }
                
            }

            
           
            $userName=UserAuth::findUserByUsername($username);
            $userPhone=UserAuth::findUserByPhone($phone);
            $agentOne="";
            if(isset($userName->user_id))
            {
                $agentOne=Agent::findOne(["user_id"=>$userName->user_id]);
            }
            if(isset($userPhone->user_id))
            {
                $agentOne=Agent::findOne(["user_id"=>$userPhone->user_id]);   
            }
            if(!empty($agentOne))
            {
                $res['success']=false;
                $res['message']="此账号已经是代理商了";
                return json_encode($res);
            }

            $countNum=0;
            foreach($data['data'] as $key=>$val)
            {
                $countNum+=$val["num"];
            }
            
            $agentGrade=AgentGrade::findOne($data["Agent_level"]);
            
            if($countNum<$agentGrade->gt_num)
            {
                $res['success']=false;
                $res['message']="开通的会员类型需要购买".$agentGrade->gt_num."~".$agentGrade->lt_num."个电话卡";
                return json_encode($res);
            }
            //$this->dump($data);
            //$this->dump($countPrice);

            $myAgent=Agent::findOne(["user_id"=>$user_id]);
            $config=Config::findOne(1);
            $onePrice=$config->partner_price;    
            $total_fee=round($countNum*$onePrice,2);  //订单总金额

            if($myAgent->balance<$total_fee)
            {
                $res['success']=false;
                $res['message']="预充值余额不足";
                return json_encode($res);
            }
            //$this->dump($total_fee);
           
            //开启事务保存数据
            $transaction=Yii::$app->db->beginTransaction();
            try{
                $openUserId="";
                if(!isset($userName->user_id)&&!isset($userPhone->user_id))
                {
                  // 注册新用户
                  $user_model=new User();
                  $user_model->realname=$data["user_name"];
                  $user_model->access_token=Yii::$app->security->generateRandomString() . '_' . time();
                 
                  if(!$user_model->save()){
                       throw new \yii\db\Exception('user信息保存失败');
                  }
                  $openUserId=$user_model->id;
                  $user_auth_model_1=new UserAuth();
                  $user_auth_model_1->user_id=$user_model->id;
                  $user_auth_model_1->identity_type='phone';
                  $user_auth_model_1->identifier=$phone;    
                  $user_auth_model_1->setCredential($password);
                  $user_auth_model_1->save();
                  if(!$user_auth_model_1->save()){
                       throw new \yii\db\Exception('手机号登录创建失败');
                  }
                  $user_auth_model=new UserAuth();
                  $user_auth_model->user_id=$user_model->id;
                  $user_auth_model->identity_type='username';
                  $user_auth_model->identifier=$username;
                  $user_auth_model->setCredential($password);
                  if(!$user_auth_model->save()){
                       throw new \yii\db\Exception('用户名登录创建失败');
                  }
                }else{
                    
                    if(isset($userName->user_id))
                    {
                        $openUserId=$userName->user_id;
                    }
                    if(isset($userPhone->user_id))
                    {
                        $openUserId=$userPhone->user_id;  
                    }
                }


                //代理商添加
                $agent_model = new Agent();
                $agent_model->level=$data["Agent_level"];
                $agent_model->type="2";
                $agent_model->id_num=$data["Agent_id_num"];
                $agent_model->name=$data["user_name"];
                $agent_model->id_front=$data["Agent_id_front"];
                $agent_model->id_back=$data["Agent_id_back"];
                $agent_model->user_id=$openUserId;
                $agent_model->parent_id=$user_id;
                $agent_model->create_time=time();
                if(!$agent_model->save())
                {
                    throw new \yii\db\Exception('创建失败');
                    //return $this->redirect(['pay', 'id' => $model->agent_id]);    
                }
               
                $phone="";
                $mi_id="";
                if($data["mi_id"]=="0")
                {
                    $phone=$data["phone"];
                }else{
                    $mi_id=$data["mi_id"];
                }
                $pay_img="";
                if(isset($data["pay_img"]))
                {
                    $pay_img=$data["pay_img"];
                }
                //订单添加
                $mobileOrder=new MobileCardOrder();
               // $this->dump($user_id."--".$agent_model->agent_id."--".$total_fee."--".$mi_id."--".$phone."--".$pay_img);

                
                //throw new \yii\db\Exception($total_fee);
                if(!$mobileOrder->add($user_id,$user_model->id,$total_fee,$mi_id,$phone,$pay_img,"1",$agent_model->agent_id))
                {
                  throw new \yii\db\Exception("保存失败");
                }
                //订单详情添加
                foreach($data['data'] as $key=>$val)
                {
                    $mobileCard=MobileCard::findOne($val["mid"]);
                    $mobileCardOrderDetail=new MobileCardOrderDetail();
                    if(!$mobileCardOrderDetail->add($mobileOrder->mo_id,$mobileCard->mid,$mobileCard->name,$onePrice,$val["num"]))
                    {
                        throw new \yii\db\Exception("保存失败");
                    }
                    //$countNum+=$val["num"];

                }

                //合伙人余额处理

                $agentBalanceRecord=new AgentBalanceRecord();
                if(!$agentBalanceRecord->add($myAgent->agent_id,$user_id,"2",$total_fee,"添加代理"))
                {
                    throw new \yii\db\Exception("保存失败");
                }
                $myAgent->balance=round($myAgent->balance-$total_fee,2);
                if(!$myAgent->update(true,["balance"]))
                {
                    throw new \yii\db\Exception("保存失败");
                }

                


                $transaction->commit();
                         
                return json_encode([
                    'success'=>true,
                    'message'=>'提交成功，等待处理',
                    
                
                ]);
            }catch(\Exception $e){
                $transaction->rollBack();
                throw $e;
                return json_encode([
                    'success'=>false,
                    'message'=>'提交失败，请稍后再试。',
                ]);
            }
            
        } else {
            $mobileCardImg=MobileCardImg::find()->all();
            $agentGrade=AgentGrade::find()->all();
            $myAgent=Agent::findOne(["user_id"=>$user_id]);
            $config=Config::findOne(1);
            return $this->render('create', [
                "agentGrade"=>$agentGrade,
                "mobileCardImg"=>$mobileCardImg,
                "myAgent"=>$myAgent,
                "onePrice"=>$config->partner_price,
            ]);
        }
    }

    public function actionMobileCardCreate()  //购买充值卡
    {
        $user_id=Yii::$app->user->identity->id;   
        if ($data=Yii::$app->request->get()) {
            //$this->dump($data);
            $res=[];
            
            if($data["pay_img"]==""){
                
                $res['success']=false;
                $res['message']="请上传汇款凭证";
                return json_encode($res);
            }
            if(!isset($data["mi_id"])){
                
                $res['success']=false;
                $res['message']="请选择电话卡封面";
                return json_encode($res);
            }
            if($data["mi_id"]=="0"){
                if($data["phone"]=="")
                {
                    $res['success']=false;
                    $res['message']="请输入电话号";
                    return json_encode($res);
                }
            }
            $countNum=0;
            foreach($data['data'] as $key=>$val)
            {
                $countNum+=$val["num"];
            }
            $myAgent=Agent::findOne(["user_id"=>$user_id]);
            $myAgentGrade=AgentGrade::findOne($myAgent->level);
            $onePrice=$myAgentGrade->price;
            $total_fee=round($countNum*$onePrice,2);  //订单总金额


            $phone="";
            $mi_id="";
            if($data["mi_id"]=="0")
            {
                $phone=$data["phone"];
            }else{
                $mi_id=$data["mi_id"];
            }
            $pay_img="";
            if(isset($data["pay_img"]))
            {
                $pay_img=$data["pay_img"];
            }

            //开启事务保存数据
            $transaction=Yii::$app->db->beginTransaction();
            try{
               
                //订单添加
                $mobileOrder=new MobileCardOrder();
                //$this->dump($user_id."金额：".$total_fee."Mid:".$mi_id."phone:".$phone."pay_img".$pay_img);
                
                //throw new \yii\db\Exception($total_fee);
                if(!$mobileOrder->add("0",$user_id,$total_fee,$mi_id,$phone,$pay_img,"2","0"))
                {
                  throw new \yii\db\Exception("保存失败");
                }
                //订单详情添加
                foreach($data['data'] as $key=>$val)
                {
                    $mobileCard=MobileCard::findOne($val["mid"]);
                    $mobileCardOrderDetail=new MobileCardOrderDetail();
                    if(!$mobileCardOrderDetail->add($mobileOrder->mo_id,$mobileCard->mid,$mobileCard->name,$onePrice,$val["num"]))
                    {
                        throw new \yii\db\Exception("保存失败");
                    }
                    //$countNum+=$val["num"];

                }


                $transaction->commit();
                         
                return json_encode([
                    'success'=>true,
                    'message'=>'提交成功，等待处理',
                    
                
                ]);
            }catch(\Exception $e){
                $transaction->rollBack();
                throw $e;
                return json_encode([
                    'success'=>false,
                    'message'=>'提交失败，请稍后再试。',
                ]);
            }
            
        } else {
            $mobileCardImg=MobileCardImg::find()->all();
            $user_id=Yii::$app->user->identity->id;   
            $myAgent=Agent::findOne(["user_id"=>$user_id]);
            $myAgentGrade=AgentGrade::findOne($myAgent->level);
            return $this->render('mobile-card-create', [
                "mobileCardImg"=>$mobileCardImg,
                "onePrice"=>$myAgentGrade->price,
                
            ]);
        }
    }
    //客户列表
    public function actionUserSelect()
    {
        
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('user-select', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTopology()
    {
        $user_id=Yii::$app->user->identity->id;
   
        $agent=Agent::find()->with(["phoneAuth","userName"])->asArray()->where(["parent_id"=>$user_id,'ispay'=>"1"])->all();

        foreach($agent as $key=>$val)
        {
            $agent[$key]["son"]=Agent::find()->with(["phoneAuth","userName"])->asArray()->where(["parent_id"=>$val["user_id"],'ispay'=>"1"])->all();
        }
        //$this->dump($agent);
        return $this->render('topology', [
            "agent"=>$agent,
        ]);
    }

    public function actionPayAgent()//待支付的代理商
    {
        $user_id=Yii::$app->user->identity->id;
        
        $model=Agent::find();
        $count=$model->where(["parent_id"=>$user_id,'ispay'=>"0"])->count();
        $pagination = new Pagination(['totalCount' => $count,'pageSize'=>'20']);
        $agent=$model->with(["phoneAuth","userName",'orderAllPay'])->where(["parent_id"=>$user_id,'ispay'=>"0"])->offset($pagination->offset)->limit($pagination->limit)->all();
       // $this->dump($agent);
        
        return $this->render('pay-agent', [
            "agent"=>$agent,
            "pagination"=>$pagination,
        ]);
    }

    /**
     * Lists all Agent models.
     * @return mixed
     */
    public function actionIndex()
    {
        if($agentType=="2")
        {
            echo '无法访问';
            die();
        }
        $user_id=Yii::$app->user->identity->id;
        
        $model=Agent::find();
        $count=$model->where(["parent_id"=>$user_id,'ispay'=>"1"])->count();
        $pagination = new Pagination(['totalCount' => $count,'pageSize'=>'20']);
        $agent=$model->with(["phoneAuth","userName"])->where(["parent_id"=>$user_id,'ispay'=>"1"])->offset($pagination->offset)->limit($pagination->limit)->all();
       // $this->dump($agent);
        
        return $this->render('index', [
            "agent"=>$agent,
            "pagination"=>$pagination,
        ]);
    }

    public function actionAgentDelete($agent_id)
    {
        $user_id=Yii::$app->user->identity->id;
        $agent=Agent::findOne($agent_id);
        $agentUser_id=$agent->user_id;
        if($agent->parent_id!=$user_id||$agent->ispay=="1")
        {
            return $this->redirect(['index']);
        }
        //开启事务保存数据
        $transaction=Yii::$app->db->beginTransaction();
        try{
            if(!$agent->delete())
            {
                throw new \yii\db\Exception("删除失败");
            }
            $connection=Yii::$app->db;
            //删除所有attrkey
            $sqlkey="DELETE FROM `shop_order` WHERE user_id=".$agentUser_id;
            $commandKey=$connection->createCommand($sqlkey);
            $commandKey->execute();
            
            $transaction->commit();
           
        }catch(\Exception $e){
            $transaction->rollBack();
            throw $e;
           
        }
        return $this->redirect(['index']);
    }

    /**
     * Displays a single Agent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

   
    /**
     * Finds the Agent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
