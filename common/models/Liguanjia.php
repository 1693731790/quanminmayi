<?php
namespace common\models;

use Yii;

define('USERNAME','yunmayi');
define('PASSWORD','111111');
define('API_NAME','yunmayi');
define('API_SECRET','111111');
define('API_URL','http://www.liguanjia.com/index.php/api');

/*
define('USERNAME','yunmayi');
define('PASSWORD','111111');
define('API_NAME','yunmayi');
define('API_SECRET','111111');
define('API_URL','http://www.liguanjia.com/index.php/api');
*/

class Liguanjia extends \yii\base\Model
{
    private $_token;

    public function init(){
        parent::init();
        $this->_token=$this->getToken();
    }
    
    // 获取总页数
     public function getTotalPage($page=1){
        $data=[
        'func' =>'GetSku',
        "token" =>$this->_token,
        "page" => $page,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        if($res->result==0){
            return $res->total_page;
        }else{
            return $res->msg;
        }
    }

    // 分页获取全部商品id
     public function getSkuId(){
        $page=intval(Config::getConfig('sku_page_already'))+1;
        if($page===1){
            Sku::deleteAll();
            $total_page=self::getTotalPage();
            Config::setConfig('sku_total_page',$total_page);
        }else{
            $total_page=Config::getConfig('sku_total_page');
        }
        
        if($page>$total_page){
            return false;
        }
        
        $data=[
        'func' =>'GetSku',
        "token" =>$this->_token,
        "page" => $page,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        
        if($res->result==0){
            $temp_data=[];
            $skus_id=explode(',',$res->skus);
            $time=time();
            foreach($skus_id as $v){
                $temp=[];
                $temp['sku_id']=intval($v);
                if($temp['sku_id']==0){
                    $end=true;
                    break;
                }
                $temp['create_time']=$time;
                $temp_data[]=$temp;
            }
            Yii::$app->db->createCommand()->batchInsert('sku', ['sku_id','create_time'],$temp_data)->execute();
            Config::setConfig('sku_page_already',$page);
            
            return true;
        }else{
            return $res->msg;
        }
    }
     // 商品价格
     public function getPriceOne($skuId){
        $data=[
                'func' =>'getPrice',
                "token" =>$this->_token,
                "sku" => $skuId,
        ];
        $post_data=['param'=>json_encode($data)];
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        return $res;
        
    }
    
    // 分页获取全部商品id
     public function getSkuIdByPage($page){
        $data=[
        'func' =>'GetSku',
        "token" =>$this->_token,
        "page" => $page,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        if($res->result==0){
            $temp_data=[];
            $sku_arr=[];
            $skus_id=explode(',',$res->skus);
            $time=time();
            $num=0;
            foreach($skus_id as $k=>$v){
                $temp=[];
                $temp['sku_id']=intval($v);
                if($temp['sku_id']==0){
                    $end=true;
                    break;
                }
                $num++;
                $next_key=$k+1;
                $temp['create_time']=$time;
                $temp_data[]=$temp;
                $sku_arr[]=$temp['sku_id'];
                if($num==100||(!isset($skus_id[$next_key]))){
                    Yii::$app->queue->delay(30)->push(new \console\models\LiguanjiaJob([
                    'act'=>'get_sku_info_by_array',
                    'sku_arr' => $sku_arr,
                    ]));
                    $num=0;
                    $sku_arr=[];
                }
            }
            //Yii::$app->db->createCommand()->batchInsert('sku', ['sku_id','create_time'],$temp_data)->execute();
            return true;
        }else{
            return $res->msg;
        }
    }
    
    // 商品价格
     public function getPrice(){
        // echo "<pre>";
        // var_dump($aaabbbb);
        // die();
        $null_count=Sku::find()->where('price is null')->count();

        if($null_count==0){
            return false;
        }
        if($null_count<=100){
            $offset=0;
            $limit=$null_count;
        }else{
            $offset=rand(0,100)*100;
            $limit=100;
        }
        $r=rand(0,100);
        if($r<20){
            $orderby='id desc';
        }elseif($r<50){
            $orderby='id asc';
        }elseif($r<70){
            $orderby='name desc';
        }else{
            $orderby='name asc';
        }

        //$skus=Sku::find()->where('price is null')->orderby($orderby)->offset($offset)->limit(100)->all();
        $skus=Sku::find()->where('price is null')->andWhere(["state"=>1])->orderBy("id desc")->limit(100)->all();
       
        $sku_str=null;
        foreach($skus as $v){
            $sku_str.=$v->sku_id.',';
        }
        $sku_str=rtrim($sku_str,',');
                
        $data=[
                'func' =>'getPrice',
                "token" =>$this->_token,
                "sku" => $sku_str,//$sku_str,'100401',
        ];
         /*ho "<pre>";
         var_dump($data);
       die();*/
         
        
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
         /*echo "<pre>";
         var_dump($res);
         die();*/
        if($res->result==0){
            $prices=$res->info;
        }else{
            return false;
        }
        
        foreach($prices as $p){
            $model=Sku::find()->where('sku_id = :skuId',[':skuId'=>$p->skuId])->one();
            if($model){
                $model->price=$p->price;
                $model->jdPrice=$p->jdPrice;
                $model->lirun_baifenbi = ($p->jdPrice-$p->price)/$p->price;
                $model->save();
            }
        }
        return true;
    }

    //商品详情
     public function getInfo($sku){
        $data=[
        'func' =>'skuDetail',
        "token" =>$this->_token,
        "sku" => $sku,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
         /*echo "<pre>";
         var_dump($res);
         die();*/
        if($res->result==0){
            return $res;
        }else{
            return $res->msg;
        }
    }

    //商品详情
     public function getCate(){
        $data=[
        "func"=>"getCategorys",
        "token" =>$this->_token,
        "pageNo" => "1",
        "pageSize" => "2071",
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);

        // echo "<pre>";
        // var_dump($res);
        // die();
        foreach($res->info->categorys as $val)
        {
            //echo $val->catId."<br/>";
            if($val->state==1)
            {
                $goodscate=new GoodsCate();
                $goodscate->goods_cat_id=$val->catId;
                $goodscate->goods_cat_pid=$val->parentId;
                $goodscate->goods_cat_name=$val->name;
                $goodscate->goods_cat_is_show=1;
                $goodscate->save();
            }
            

        }

        echo "ok";
    }
    
    // 获取所有信息(价格和商品详情)
     public function getSku($sku_id){
        $data=[
        'func' =>'skuDetail',
        "token" =>$this->_token,
        "sku" => $sku_id,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        $sku=[];
        $sku['sku_id']=$sku_id;
        if($res->result==0){
            $sku['name']=$res->info->name;
            $sku['brandName']=$res->info->brandName;
            $sku['state']=$res->info->state;
            $sku['imagePath']=$res->info->imagePath;
            $sku['introduction']=$res->info->introduction;
            $sku['weight']=$res->info->weight;
            $sku['saleUnit']=$res->info->saleUnit;
            $sku['productArea']=$res->info->productArea;
            $sku['category']=$res->info->category;
            $sku['param']=$res->info->param;
        }else{
            var_dump($res);
        }
        $data=[
                'func' =>'getPrice',
                "token" =>$this->getToken(),
                "sku" => $sku_id,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        if($res->result==0){
            $price_arr=$res->info;
            if(!empty($price_arr)){
                $sku['price']=$price_arr[0]->price;
                $sku['jdPrice']=$price_arr[0]->jdPrice;
                $sku['lirun_baifenbi']= ($sku['jdPrice']-$sku['price'])/$sku['price'];
            }
        }else{
            var_dump($res);
        }
        
        return $sku;
    }

    // 获取所有信息(价格和商品详情)
     public function getInfoSave($sku_id){
        $data=[
        'func' =>'skuDetail',
        "token" =>$this->_token,
        "sku" => $sku_id,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        $model =new \common\models\Sku();

        if($res->result==0){
            $model->sku_id=$sku_id;
            $model->name=$res->info->name;
            $model->brandName=$res->info->brandName;
            $model->state=$res->info->state;
            $model->imagePath=$res->info->imagePath;
            $model->introduction=$res->info->introduction;
            $model->weight=$res->info->weight;
            $model->saleUnit=$res->info->saleUnit;
            $model->productArea=$res->info->productArea;
            $model->category=$res->info->category;
            $model->param=$res->info->param;

        }else{
            var_dump($res);
        }
        $data=[
                'func' =>'getPrice',
                "token" =>$this->_token,
                "sku" => $sku_id,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        if($res->result==0){
            $price_arr=$res->info;
            if(!empty($price_arr)){
                $model->price=$price_arr[0]->price;
                $model->jdPrice=$price_arr[0]->jdPrice;
                $model->lirun_baifenbi=($model->jdPrice-$model->price)/$model->price;
                $model->create_time=time();
            }
        }else{
            var_dump($res);
        }

        if($model->save()){
            return true;
        }
        return false;
    }



    // 获取地区
     public function getRegion($pid=0){
        $data=[
                'func' =>'GetAdress',
                "token" =>$this->_token,
                "parent_id" => $pid,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        if($res->result==0){
            return $res->info;
        }else{
            return $res->msg;
        }
    }

    // 获取礼管家订单号
     public function getOrderSn($order_sn){
        $data=[
                'func' =>'GetOrderSn',
                "token" =>$this->_token,
                "thirdsn" => $order_sn,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        if($res->result==0){
            return $res;
        }else{
            return $res;
        }
    }
     // 确认提交礼管家
     public function getConfirmOrder($ordersn){
        $data=[
                'func' =>'confirmOrder',
                "token" =>$this->_token,
                "ordersn" => $ordersn,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
       
        return $res;
       
    }
     // 获取礼管家物流信息
     public function getOrderTrack($ordersn){
        $data=[
                'func' =>'orderTrack',
                "token" =>$this->_token,
                "ordersn" => $ordersn,
        ];
        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
       
        return $res;
       
    }
    // 订单提交到礼管家
     public function getOrderSubmit($order_id){
        $order=Order::findOne($order_id);
        $orderGoods=OrderGoods::find()->with(['goods'])->where(["order_id"=>$order->order_id])->all();
           //echo "<pre>";
            //   var_dump($orderGoods);
          //    die();
        $address=UserAddress::findOne($order->address_id);
        $region=explode("-",$address->region_id);
       
        $sku=[];
        $totalFee=0;
        foreach($orderGoods as $key=>$val)
        {
            if($val->goods->sku_id!="")
            {
                $sku[$key]["skuId"]=$val->goods->sku_id;
                $sku[$key]["num"]=$val->num;
                $totalFee+=round($val->goods->xy_price*$val->num,2);    
            }
            
        }
        
        $data=[
                'func' =>'OrderSubmit',
                "token" =>$this->_token,
                "thirdsn" => $order->order_sn,
                "ordersn" => $order->order_lgj_sn,
                "sku" => json_encode($sku),
                "order_amount" => $totalFee,
                "name" => $address->name,
                "mobile" => $address->phone,
                "province" => $region[0],
                "city" => $region[1],
                "county" => $region[2],
                "town" => $region[3]!=""?$region[3]:'',
                "address" => $address->address,
                
        ];
        
        // echo "<pre>";
        // var_dump($data);
        // die();

        $post_data=['param'=>json_encode($data)];
        
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        return $res;
        /*echo "<pre>";
        var_dump($res);*/
        
        // if($res->result==0){
        //     return $res;
        // }else{
        //     return $res;
        // }
    }

    
    // 获取安全码
     public function getTokenSafeCode(){
        $data=[
        'func' =>'GetTokenSafeCode',
        "username" => USERNAME,
        "password" => PASSWORD,
        "api_name" => API_NAME,
        "api_secret" => API_SECRET,
        ];
        $post_data=['param'=>json_encode($data)];
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
       
        if($res->result==0){
            return $res->safecode;
        }else{
            return $res->msg;
        }
    }
    

    // 获取token
     public function getToken(){
            $cache=Yii::$app->cache;
            $token=$cache->get('lgj_token');
            if($token==false){
                $data=[
                    'func' =>'GetApiToken',
                    "username" => USERNAME,
                    "password" => PASSWORD,
                    "api_name" => API_NAME,
                    "api_secret" => API_SECRET,
                    "safecode" => $this->getTokenSafeCode(),
                ];
                $post_data=['param'=>json_encode($data)];
                
                $ch =curl_init();
                curl_setopt($ch, CURLOPT_URL, API_URL);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                curl_setopt($ch,CURLOPT_POST,1);
                curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
                $output = curl_exec($ch);
                curl_close($ch);
                $res=json_decode($output);

                if($res->result==0){
                    $cache->set('lgj_token',$res->token,3600); // 礼管家token 2小时有效
                    return $res->token;
                }else{
                    var_dump($res->msg);
                    return false;
                }
            }else{
                return $token;
            }

        
    }

     // 获取礼管家物流信息
     public function getNewStockById($area,$skuNums){
        $data=[
                'func' =>'getNewStockById',
                "token" =>$this->_token,
                "area" => $area,
                "skuNums" => $skuNums,
        ];

        $post_data=['param'=>json_encode($data)];
        // echo "<pre>";
        // var_dump($post_data);
        // die();
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        
        return $res;
       
    }
    

}
