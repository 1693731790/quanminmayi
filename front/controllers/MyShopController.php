<?php
namespace front\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\helpers\FileHelper;
use common\models\Goods;
use common\models\GoodsCate;
use common\models\Shops;
use common\models\Wallet;
use common\models\Order;
use common\models\User;
use common\models\UserBank;
use common\models\WithdrawCash;
use common\models\Express;
use common\models\GoodsFavorite;


/**
 * Site controller
 */
class MyShopController extends CommonController
{
  		 public function actionOpenShop()//一键开店
        {       
          
            return $this->render("open-shop",[
                //"shop"=>$shop,
                    
            ]);
        }
        public function actionRegShop()//申请店铺
        {       
          
            $user_id=Yii::$app->user->identity->id;
            $user=User::findOne($user_id);
            if($user->is_upgrade!="1")
            {

                return $this->redirect(['my-shop/message'])->send();
                //$this->redirect(['my-shop/message']);
                die();
            }

            if($data=Yii::$app->request->get()){    
                //$this->dump($data);
            
                $res=[];
                $shops=Shops::findOne(["user_id"=>$user_id]);
                if(!empty($shops))
                {
                    if($shops->status==0)
                    {
                        $res["success"]=false;
                        $res["message"]="您已提交过了，请耐心等待审核";
                        return json_encode($res);   
                    }else if($shops->status==200)
                    {
                        $res["success"]=false;
                        $res["message"]="您已经有店铺了";
                        return json_encode($res);   
                    }
                    
                    
                }
                $model=new Shops();
                if($model->addShop($data))
                {
                    $res["success"]=true;
                    $res["message"]="提交成功,等待工作人员审核";
                    return json_encode($res);
                }else{
                    $res["success"]=false;
                    $res["message"]="提交失败";
                    return json_encode($res);
                }
            }
            return $this->render("reg-shop",[
                //"shop"=>$shop,
                    
            ]);
        }
        public function actionIndex()//主页
        {
            
            $user_id=Yii::$app->user->identity->id;
            $user=User::findOne($user_id);
            $shop=Shops::findOne(["user_id"=>$user_id]);
            if(empty($shop))
            {
                    return $this->redirect(['my-shop/reg-shop']);
            }
            $countFee=Wallet::find()->where(["user_id"=>$user_id])->sum("fee");
            $countOrder=Order::find()->where(["shop_id"=>$shop->shop_id])->count();
            $untreatedOrder=Order::find()->where(["shop_id"=>$shop->shop_id])->andWhere(["in",'status',[1,4]])->count();

            $startTime=strtotime(date('Y-m-01 00:00:01', strtotime(date("Y-m-d"))));
            $mOrder=Order::find()->where(["shop_id"=>$shop->shop_id])->andWhere(['between','create_time',$startTime,time()])->count();
            $mFee=Wallet::find()->where(["user_id"=>$user_id])->andWhere(['between','create_time',$startTime,time()])->sum("fee");
            //$this->dump($untreatedOrder);
                
            return $this->render("index",[
                    "shop"=>$shop,
                    "countFee"=>$countFee,
                    "mFee"=>$mFee,
                    "mOrder"=>$mOrder,
                    "balance"=>$user->wallet,
                    "countOrder"=>$countOrder,
                    "untreatedOrder"=>$untreatedOrder,
            ]);
        
        }
        public function actionWithdrawCashCreate()//申请提现
    {
        $user_id=Yii::$app->user->identity->id;
            $user=User::findOne($user_id);
            $res=[];
        if($data=Yii::$app->request->get()){
            $fee=(float)$data["fee"];
            $balance=(float)$user->wallet;
            if($fee>$balance)
                {
                    $res["success"]=false;
                            $res["message"]="提现金额不能大于余额";
                            return json_encode($res);
                }
                $withdrawCash=new WithdrawCash();
                $isok=$withdrawCash->cashAdd($data,$user_id);
            if($isok)
            {
                $res["success"]=true;
                            $res["message"]="提现申请已提交，等待审核";
                            return json_encode($res);
            }else{
                $res["success"]=false;
                            $res["message"]="提现申请提交失败";
                            return json_encode($res);
            }
                }
        
            $userBank=UserBank::find()->all();
        return $this->render("withdraw-cash-create",[
                    "balance"=>$user->wallet,
                    "userBank"=>$userBank,
            ]);
    }

        public function actionGoodsLowerframe($goods_id,$sale)//下架商品
    {
        $user_id=Yii::$app->user->identity->id;
            $shop=Shops::findOne(["user_id"=>$user_id]);
            $goods=Goods::findOne(["goods_id"=>$goods_id]);
            $res=[];
            if($goods->shop_id!=$shop->shop_id)
            {
                $res["success"]=false;
                        $res["message"]="操作失败";
                        return json_encode($res);
            }
            $goods->issale=$sale;
            if($goods->update(true,['issale']))
            {
                $res["success"]=true;
                        $res["message"]="操作成功";
                        return json_encode($res);
            }else{
                $res["success"]=false;
                        $res["message"]="操作失败";
                        return json_encode($res);
            }
    }
        public function actionGoodsDelete($goods_id)//删除商品
    {
        $user_id=Yii::$app->user->identity->id;
            $shop=Shops::findOne(["user_id"=>$user_id]);
            $goods=Goods::findOne(["goods_id"=>$goods_id]);
            $res=[];
            if($goods->shop_id!=$shop->shop_id)
            {
                $res["success"]=false;
                        $res["message"]="删除失败";
                        return json_encode($res);
            }
            $goods->status="-1";
            if($goods->update(true,['status']))
            {
                $res["success"]=true;
                        $res["message"]="删除成功";
                        return json_encode($res);
            }else{
                $res["success"]=false;
                        $res["message"]="删除失败";
                        return json_encode($res);
            }
    }
        public function actionGoods($salecount="",$browse="",$new="")//商品列表
            {
                    
                    $this->layout="nofooter";
                    $user_id=Yii::$app->user->identity->id;
                    $shop=Shops::findOne(["user_id"=>$user_id]);
                    $model=Goods::find();
                    $orderby='browse DESC';
                    if($salecount!="")
                    {
                             $orderby='salecount '.$salecount;
                    }
                    if($browse!="")
                    {
                             $orderby='browse '.$browse;
                    }
                    if($new!="")
                    {
                             $orderby='create_time '.$new;
                    }
                    //$this->dump($orderby);
                    $goods=$model->asArray()->where(["shop_id"=>$shop->shop_id,"status"=>"200"])->orderBy($orderby)->limit(5)->all();

                    foreach ($goods as $key => $goodsval)
                    {
                            $favorite=GoodsFavorite::find()->where(['goods_id'=>$goodsval['goods_id']])->count();
                            $goods[$key]["favorite"]=$favorite;
                    }  
                    //$this->dump($goods);
                    return $this->render("goods",[
                            "goods"=>$goods,
                            "salecount"=>$salecount,
                            "browse"=>$browse,
                            "new"=>$new,

                    ]);
            }

            function actionGoodsList($page="",$salecount="",$browse="",$new="")////异步调用商品列表
            {
                 
                    $page=($page-1)*5;
                    $model=Goods::find();
                    $user_id=Yii::$app->user->identity->id;
                $shop=Shops::findOne(["user_id"=>$user_id]);
                    $orderby='browse DESC';
                    if($salecount!="")
                    {
                             $orderby='salecount '.$salecount;
                    }
                    if($browse!="")
                    {
                             $orderby='browse '.$browse;
                    }
                    if($new!="")
                    {
                             $orderby='create_time '.$new;
                    }
                    $goods=$model->asArray()->where(["shop_id"=>$shop->shop_id,"status"=>"200"])->orderBy($orderby)->offset($page)->limit(5)->all();
                    
                    $str=""; 
                 
                    foreach($goods as $goodsval)
                    {
                            $favorite=GoodsFavorite::find()->where(['goods_id'=>$goodsval['goods_id']])->count();
                            $issale="";
                            if($goodsval['issale']=="1"){
                                $issale='<span type="button" style="" class="xiajia" onclick="lowerFrame('.$goodsval['goods_id'].',this,0)">下架</span>';
                            }else{
                                $issale='<span type="button" style="" class="xiajia" onclick="lowerFrame('.$goodsval['goods_id'].',this,1)">上架</span>';
                            }
                        
                    
                            $str.='<li><a href="'.Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']]).'"><div class="Pic"><img src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'" alt=""/></div><div class="Con"><h2 class="slh2">'.$goodsval['goods_name'].'</h2><p class="Price"><span class="cr_f84e37">￥'.$goodsval['price'].'</span><span class="ml40" style="text-decoration:line-through;">￥'.$goodsval['old_price'].'</span></p><p class="Statistics"><span class="ml15">销量'.$goodsval['salecount'].'</span><span class="ml15">收藏'.$favorite.'</span></p></div></a>'.$issale.'<span type="button" style="" class="delete" onclick="deleteGoods('.$goodsval['goods_id'].',this)">删除</span></li>';
                            
                    } 
                    //$this->dump($str);
                    echo $str;
                    //return json_encode($orders);
                 
            }

        public function actionOrderStatus($order_id="")//发货
        {
        
                $this->layout="nofooter";
                if($data=Yii::$app->request->post()){
                     
                        $user_id=Yii::$app->user->identity->id;
                        $shop=Shops::findOne(["user_id"=>$user_id]);
                        $order=Order::findOne($data['order_id']);
                        if($order->shop_id!=$shop->shop_id)
                        {
                            $res["success"]=true;
                                $res["message"]="发货失败";
                                return json_encode($res);
                        }
                        $order->express_num=$data["express_num"];
                        $order->express_type=$data["express_type"];
                        $order->status=2;
                        if($order->update(true,["express_num","express_type",'status']))
                        {
                                $res["success"]=true;
                                $res["message"]="发货成功";
                                return json_encode($res);
                        }else{
                                $res["success"]=false;
                                $res["message"]="发货失败";
                                return json_encode($res);
                        }
                     
                }else{
                    $express=Express::find()->all();
                        return $this->render("order-status",[
                            "order_id"=>$order_id,
                            "express"=>$express,
                        ]);  
                }

         
        
        }

        public function actionOrder($status="")////订单页面
        {
            $this->layout="nofooter";
            $user_id=Yii::$app->user->identity->id;
            $shop=Shops::findOne(["user_id"=>$user_id]);
            $model=Order::find()->with(['orderGoods'])->where(["shop_id"=>$shop->shop_id])->andFilterWhere(["status"=>$status])->orderBy(['create_time'=>SORT_DESC])->limit(6)->all();
                return $this->render("order",[
                    "model"=>$model,
                    "status"=>$status,
            ]);
        
        }
        public function actionOrderList($page,$status)//异步调用订单
        {
            $page=($page-1)*6;

            $user_id=Yii::$app->user->identity->id;
            $shop=Shops::findOne(["user_id"=>$user_id]);
                $model=Order::find()->with(['orderGoods'])->where(["shop_id"=>$shop->shop_id])->andFilterWhere(["status"=>$status])->orderBy(['create_time'=>SORT_DESC])->offset($page)->limit(6)->all();
                $str=""; 
            
            foreach($model as $modelval)
                {
                        $goodsstr="";
                        foreach($modelval->orderGoods as $goodskey=>$goodsval)
                    {
                        $goodsstr.='<div class="user_order_list_div"><div class="Pic"><img src="'.Yii::$app->params['imgurl'].$goodsval->goods_thums.'" alt=""/></div><div class="Con"><div class="fl"><h2 class="slh2">'.$goodsval->goods_name.'</h2><p class="Attributes slh mb10">'.$goodsval->attr_name.'</p></div><div class="fr tr"> <span class="Prices">￥'.$goodsval->price.'</span> <span class="Num">×'.$goodsval->num.'</span></div></div></div>';
                    }
                    $status1="";
                        if($modelval->status=="1")
                        {
                            $status1='<span class="but1 cr_f95d47" onclick="orderstatus('.$modelval->order_id.')"> 发货 </span> ';    
                        }

                        $str.='<li><div class="tit"> <span class="fl">订单号：'.$modelval->order_sn.'</span>  <span class="fr cr_f84e37">'.Yii::$app->params["order_status"][$modelval->status].'</span> </div>'.$goodsstr.'<p class="Total tr">共'.count($modelval->orderGoods).'件商品  合计：￥'.$modelval->total_fee.'</p><div class="Operation"><span class="fl ml30">下单时间：'.date("Y-m-d H:i:s",$modelval->create_time).'</span><div class="fr">'.$status1.'</div></div></li>';
                        
                        
                } 
                //$this->dump($str);
                echo $str;
                //return json_
                
        
        }

        public function actionWithdrawCash()    //提现记录
        {
            $this->layout="nofooter";
            $user_id=Yii::$app->user->identity->id;
            $model=WithdrawCash::find()->where(["user_id"=>$user_id])->orderBy(['create_time'=>SORT_DESC])->limit(20)->all();
                $user=User::findOne($user_id);
            return $this->render("withdraw-cash",[
                    "model"=>$model,
                    "balance"=>$user->wallet,
                    
            ]);
        
        }
        public function actionWithdrawCashList($page)//异步加载提现记录
        {
            $page=($page-1)*20;
            $user_id=Yii::$app->user->identity->id;
                $model=WithdrawCash::find();
                $wallet=$model->where(["user_id"=>$user_id])->orderBy(['create_time'=>SORT_DESC])->offset($page)->limit(20)->all();
                $str=""; 
            
            foreach($wallet as $val)
                {
                        
                        $str.='<li> <span class="tit pl30">'.date("Y-m-d H:i:s",$val->create_time).'</span><span class="num1 pl18">'.$val->fee.'</span><span class="num2 pl20">'.Yii::$app->params["withdraw_cash_status"][$val->status].'</span></li>';
                        
                } 
                //$this->dump($str);
                echo $str;
                //return json_
                
        
        }

        public function actionWallet()//钱包列表
        {
            $this->layout="nofooter";
            $user_id=Yii::$app->user->identity->id;
            $model=Wallet::find()->where(["user_id"=>$user_id])->orderBy(['create_time'=>SORT_DESC])->limit(20)->all();
                $user=User::findOne($user_id);
            return $this->render("wallet",[
                    "model"=>$model,
                    "balance"=>$user->wallet,
                    
            ]);
        
        }
        public function actionWalletList($page)//异步加载钱包列表
        {
            $page=($page-1)*20;
            $user_id=Yii::$app->user->identity->id;
                $model=Wallet::find();
                $wallet=$model->where(["user_id"=>$user_id])->orderBy(['create_time'=>SORT_DESC])->offset($page)->limit(20)->all();
                $str=""; 
            
            foreach($wallet as $val)
                {
                        
                        $str.='<li> <span class="tit pl30">'.date("Y-m-d H:i:s",$val->create_time).'</span><span class="num1 pl18">'.$val->fee.'</span><span class="num2 pl20">'.Yii::$app->params["wallet_type"][$val->type].'</span></li>';
                        
                } 
                //$this->dump($str);
                echo $str;
                //return json_
                
        
        }

    function actionBaseimgupload()
    {
        if(yii::$app->user->isGuest)
        {
            return $this->redirect(['site/login']);
        }
        $userid=Yii::$app->user->identity->id;

        $dir='user/'. $userid;
        $directory = Yii::getAlias('@uploads/'.$dir);
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }
        $filePath = $directory . DIRECTORY_SEPARATOR;

        //$path = '/upload/'.$dir.'/';
        
        $base64_image_content = $_POST['headimg'];
        //$output_directory = './uploads/headimg/'.date("Y-m-d",time()); //设置图片存放路径
        $output_directory =$filePath;

        // 检查并创建图片存放目录 
        if (!file_exists($output_directory)) {
            mkdir($output_directory, 0777);
        }
        $timepath=md5(time().rand(1000,9999).$userid);
        // 根据base64编码获取图片类型 
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $image_type = $result[2]; //data:image/jpeg;base64,
            $output_file = $output_directory . '/' . $timepath . '.' . $image_type;
            $path = '/uploads/'.$dir.'/'. $timepath . '.' . $image_type;
        }

        //将base64编码转换为图片编码写入文件 
        $image_binary = base64_decode(str_replace($result[1], '', $base64_image_content));
        if (file_put_contents($output_file, $image_binary)) {
           
            echo $path; //写入成功输出图片路径
        }
    }
     
     public function actionMessage()
        {
            //$this->layout="nofooter";
            
            return $this->render("message",[
            
                    
            ]);
        
        }
}
