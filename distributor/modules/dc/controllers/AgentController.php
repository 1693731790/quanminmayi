<?php

namespace admin\modules\dc\controllers;
use Yii;

use common\models\Agent;
use common\models\User;
use common\models\GoodsSku;
use common\models\Goods;
use common\models\UserAddress;
use common\models\UserAuth;
use common\models\OrderAllPay;
use common\models\Order;
use common\models\OrderGoods;
use common\models\AgentGrade;
use common\models\AgentSearch;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use common\models\AgentBalanceRecord;
use common\models\Excel;




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
          
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionUpdatePwd($agent_id="")  //添加
    {
        if ($data=Yii::$app->request->post()) {
            $password=$data["user_password"];
            $agent=Agent::findOne($data["agent_id"]);

            $user_id=$agent->user_id;

            $user_auth_all=UserAuth::find()->where(['user_id'=>$user_id])->all();
            foreach($user_auth_all as $user_auth_model){
                $user_auth_model->setCredential($password);
                $user_auth_model->save();
            }
            $res['success']=true;
            $res['message']="修改成功";
            return json_encode($res);
        }else{
            return $this->render('update-pwd', [
               "agent_id"=>$agent_id,
            ]);
        }

    }
   
    public function actionCreate()  //添加
    {
        $agentGrade=AgentGrade::find()->all();
        
        if ($data=Yii::$app->request->get()) {
           // $this->dump($data);
            $res=[];
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
            //开启事务保存数据
            $transaction=Yii::$app->db->beginTransaction();
            try{
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
                $agent_model->type=$data["type"];
                $agent_model->id_num=$data["Agent_id_num"];
                $agent_model->name=$data["user_name"];
                $agent_model->id_front=$data["Agent_id_front"];
                $agent_model->id_back=$data["Agent_id_back"];
                $agent_model->user_id=$openUserId;
                $agent_model->parent_id=$data["Agent_parent_id"];
                $agent_model->ispay="1";
                $agent_model->create_time=time();
                /*$agent_model->save();
                $this->dump($agent_model->getErrors());*/
                if(!$agent_model->save())
                {
                    throw new \yii\db\Exception('创建失败');
                    //return $this->redirect(['pay', 'id' => $model->agent_id]);    
                }

               
                $transaction->commit();
                         
                return json_encode([
                    'success'=>true,
                    'message'=>'创建成功',
                    
                
                ]);
            }catch(\Exception $e){
                $transaction->rollBack();
                throw $e;
                return json_encode([
                    'success'=>false,
                    'message'=>'创建失败，请稍后再试。',
                ]);
            }
            
        } else {
            return $this->render('create', [
                "agentGrade"=>$agentGrade,
            ]);
        }
    }
    public function actionRecharge($agent_id="") 
    {
        
        if ($data=Yii::$app->request->post())
        {
            $agent=Agent::findOne(["agent_id"=>$data["agent_id"]]);

            $agentBalanceRecord=new AgentBalanceRecord();
            $agentBalanceRecord->add($data["agent_id"],$agent->user_id,"1",$data["fee"],"后台充值");
            
            $agent->balance=round($agent->balance+$data["fee"],2);
            if($agent->update(true,["balance"]))
            {
                return json_encode([
                    'success'=>true,
                    'message'=>'成功',
                ]);                
            }else{
                return json_encode([
                    'success'=>false,
                    'message'=>'失败',
                ]);    
            }

            
        }
        $agent=Agent::findOne(["agent_id"=>$agent_id]);
        $user=User::findOne($agent->user_id);
        $userAuthPhone=UserAuth::findOne(["user_id"=>$agent->user_id,"identity_type"=>"phone"]);
        return $this->render('recharge', [
            "userAuthPhone"=>$userAuthPhone->identifier,
            "agentBalance"=>$agent->balance,
            "agent_id"=>$agent_id,
            
        ]);
    }
    public function actionUpdate($agent_id="") 
    {
        if($agent_id!="")
        {
            $agent=Agent::findOne($agent_id);
            $user=User::findOne($agent->user_id);
            $agentGrade=AgentGrade::find()->all();    
        }
        
        if ($data=Yii::$app->request->post()) {
            $agent=Agent::findOne($data['agent_id']);
            $user=User::findOne($agent->user_id);
           // $this->dump($data);
            
            $user->realname=$data["user_name"];
            $user->update(true,['realname']);
            
            $agent->level=$data["Agent_level"];
            $agent->name=$data["user_name"];
            $agent->id_num=$data["Agent_id_num"];
            $agent->id_front=$data["Agent_id_front"];
            $agent->id_back=$data["Agent_id_back"];
            $agent->goods_card=0;
            if($agent->save())
            {
                return json_encode([
                            'success'=>true,
                            'message'=>'修改成功',
                        ]);   
            }else{
                return json_encode([
                            'success'=>false,
                            'message'=>'修改失败',
                        ]);
            }

           
            
        } else {
            return $this->render('update', [
                "agent"=>$agent,
                "user"=>$user,
                "agentGrade"=>$agentGrade,
            ]);
        }
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
    public function actionAgentSelect()
    {
       
        $model=Agent::find();
        $count=$model->where(['ispay'=>"1"])->count();
        $pagination = new Pagination(['totalCount' => $count,'pageSize'=>'20']);
        $agent=$model->with(["phoneAuth","userName"])->where(['ispay'=>"1"])->orderBy("agent_id desc")->offset($pagination->offset)->limit($pagination->limit)->all();
       // $this->dump($agent);
        
        return $this->render('agent-select', [
            "agent"=>$agent,
            "pagination"=>$pagination,
        ]);
    }


    /**
     * Lists all Agent models.
     * @return mixed
     */
    public function actionIndex($type="")
    {
        if($type=="")
        {
            $type="2";
        }else{
            $type="1";
        }
        $model=Agent::find();
        $count=$model->where(['ispay'=>"1","type"=>$type])->count();
        $pagination = new Pagination(['totalCount' => $count,'pageSize'=>'20']);
        $agent=$model->with(["phoneAuth","userName"])->where(['ispay'=>"1","type"=>$type])->orderBy("agent_id desc")->offset($pagination->offset)->limit($pagination->limit)->all();
       // $this->dump($agent);
        
        return $this->render('index', [
            "agent"=>$agent,
            "pagination"=>$pagination,
        ]);
    }

    /**
     * Displays a single Agent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($agent_id)
    {
        $agent=Agent::findOne(["agent_id"=>$agent_id]);
        $user=User::findOne($agent->user_id);
        $userAuthPhone=UserAuth::findOne(["user_id"=>$agent->user_id,"identity_type"=>"phone"]);
        $userAuthAccount=UserAuth::findOne(["user_id"=>$agent->user_id,"identity_type"=>"username"]);
        return $this->render('view', [
            "agent"=>$agent,
            "user"=>$user,
            "userAuthPhone"=>$userAuthPhone,
            "userAuthAccount"=>$userAuthAccount,
        ]);
    }

   
    public function actionImportCard($agent_id="")
    {
        if($data=Yii::$app->request->post())
        {
            $agent=Agent::findOne(["agent_id"=>$data["agent_id"]]);
            $link=".".$data["excel"];
            $excel=new Excel();
            $result=$excel->getExcel($link);
            if($result!="-1"&&!empty($result))
            {
                $temp_data=[];
                foreach($result as $resultVal){
                    $temp=[];
                    $temp['agent_id']=$agent->agent_id;
                    $temp['user_id']=$agent->user_id;
                    $temp['card_num']=$resultVal["id"];
                    
                    $temp_data[]=$temp;
                }

                $r=Yii::$app->db->createCommand()->batchInsert('shop_agent_mobile_card_num', ['agent_id','user_id','card_num'],$temp_data)->execute();
                
                if($r>1)
                {
                    return json_encode([
                                'success'=>true,
                                'message'=>'成功',
                            ]);   
                }else{
                    return json_encode([
                                'success'=>false,
                                'message'=>'失败',
                            ]);
                }
                //$this->dump($result);    
            }
            
        }
        
        $agent=Agent::findOne(["agent_id"=>$agent_id]);
        
        $userAuthPhone=UserAuth::findOne(["user_id"=>$agent->user_id,"identity_type"=>"phone"]);
        return $this->render('import-card', [
            'agent_id' => $agent_id,
            'userAuthPhone' => $userAuthPhone,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Agent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
