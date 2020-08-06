<?php
namespace common\models;
use Yii;

class Yunzhonghe extends \yii\db\ActiveRecord
{
    public $wid="2339"; 
    public $secret="45PwnSC6fTrm9CSVy4hB4FDWePxcDH"; 
    public $jdurl="http://open.fygift.com"; 
  
    /*public $wid="1393"; 
    public $secret="EAkMq25xCRd46mMT4mrYasFvuuyrcD"; 
    public $jdurl="http://beta.open.limofang.cn"; */
  	 //查询订单物流信息（我方订单号）
    public function getOrderTrack($order_sn)
    {

        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        
        $url=$this->jdurl."/api/order/orderTrack.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "thirdOrder" => $order_sn,
          
        ];
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $res=json_decode($data);

        return $res;
    }
    //分页获取商品id
    public function getPageGoodsId(){
        $sku_page_already=JdConfig::findOne(["label"=>"sku_page_already"]);
        $page=$sku_page_already->value+1;
        $token=$this->getToken(); 
        $timestamp=$this->getTimestamp();
      
        $url=$this->jdurl."/api/product/v2/getProductIdsByPage.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "page" => $page,
          
        ];
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $res=json_decode($data);
       
        
       /* echo "<pre>";
        var_dump($res);
        die();*/
    
        //修改以获取页数
        $sku_page_already->value+=1;
        $sku_page_already->save();

        $temp_data=[];
        $time=time();
        for($i=0;$i<count($res->RESULT_DATA);$i++){
            
            $jdGoods=JdGoods::findOne(["jdgoods_id"=>$res->RESULT_DATA[$i]]);
            if(empty($jdGoods))
            {
                $jdGoods=new JdGoods();
                $jdGoods->jdgoods_id=intval($res->RESULT_DATA[$i]);
                $jdGoods->create_time=time();
                $jdGoods->save();
                $this->getGoodsDetail($jdGoods->jdgoods_id);
            }
            /*$temp['jdgoods_id']=intval($res->RESULT_DATA[$i]);
            $temp['create_time']=$time;
            $temp_data[]=$temp;*/
        }
        
        //Yii::$app->db->createCommand()->batchInsert('{{%jd_goods}}', ['jdgoods_id','create_time'],$temp_data)->execute();
        
    }
     //获取商品总页数
    public function getPageCount(){
        $sku_total_page=JdConfig::findOne(["label"=>"sku_total_page"]);
       
        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        
        $url=$this->jdurl."/api/product/v2/getProductIdsByPage.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "page" => 1,
        ];
        
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
      
        $res=json_decode($data);
      	/*echo "<pre>";
        var_dump($res);     
        die(); */

        //return $res;
        $sku_total_page->value=$res->TOTAL_PAGE;
        $sku_total_page->save();

        $sku_page_already=JdConfig::findOne(["label"=>"sku_page_already"]);
        $sku_page_already->value=0;
        $sku_page_already->save();
        
        $connection=Yii::$app->db;
        //删除所有京东商品
        $sql="TRUNCATE shop_jd_goods";
        $commandKey=$connection->createCommand($sql);
        $commandKey->execute();
       
        //$this->dump($res);
    }
     //查询地区
    public function getArea($id,$type)
    {
        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        switch ($type) {
            case 'province':
                $url=$this->jdurl."/api/area/province.php";
                $data=[
                  'wid' =>$this->wid,
                  "token" =>$token,
                  "timestamp" => $timestamp,
                  
                ];
                break;
            case 'city':
                
                $url=$this->jdurl."/api/area/city.php";
                $data=[
                  'wid' =>$this->wid,
                  "token" =>$token,
                  "timestamp" => $timestamp,
                  "province" => $id,
                ];
                break;
            case 'county':

                $url=$this->jdurl."/api/area/county.php";
                $data=[
                  'wid' =>$this->wid,
                  "token" =>$token,
                  "timestamp" => $timestamp,
                  "city" => $id,
                ];
                break;
            case 'town':

                $url=$this->jdurl."/api/area/town.php";
                $data=[
                  'wid' =>$this->wid,
                  "token" =>$token,
                  "timestamp" => $timestamp,
                  "county" => $id,
                ];
                break;
            default:
                # code...
                break;
        }
        
        
        
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $res=json_decode($data);

        return $res;
    }

    //查询订单第三方
    public function getOrder($order_sn)
    {

        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        
        $url=$this->jdurl."/api/order/detail.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "orderKey" => $jdorder_sn,
          
        ];
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $res=json_decode($data);

        return $res;
    }

   //获取物流信息（第三方订单号）
    public function getSystemOrderTrack($jdorder_sn)
    {
        
        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        
        $url=$this->jdurl."/api/order/systemOrderTrack.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "orderKey" => $jdorder_sn,
          
        ];
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $res=json_decode($data);

        return $res;
    }


    //确认是否创建成功订单第三方
    public function getThirdOrder($jdorder_sn)
    {
        
        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        
        $url=$this->jdurl."/api/order/thirdOrder.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "thirdOrder" => $order_sn,
          
        ];
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $res=json_decode($data);

        return $res;
    }

     //创建订单  第三方下单
    public function getSubmit($order_sn)
    {
        $order=Order::findOne(["order_sn"=>$order_sn]);
        $orderGoods=OrderGoods::find()->with(['goods'])->where(["order_id"=>$order->order_id])->all();
        $regionData=explode("-",$order->address_region_id);
        $pid_nums="";
        foreach($orderGoods as $key=>$val)
        {
            $pid_nums.=$val->goods->jdgoods_id."_".$val->num.",";
        }

        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        
        $url=$this->jdurl."/api/order/submit.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "thirdOrder" => $order_sn,
          "pid_nums" => $pid_nums,
          "receiverName" => $order->address_name,
          "province" => $regionData[0],
          "city" => $regionData[1],
          "county" => $regionData[2],
          "town" => $regionData[3],
          "address" => $order->address_address,
          "mobile" => $order->address_phone,
          
        ];
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $res=json_decode($data);

        return $res;
    }

    //获取商品库存
    public function getGoodsStock($jd_goods_id,$num,$address)
    {
        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
      
        
        $url=$this->jdurl."/api/product/stock.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "pid" => $jd_goods_id,
          "num" => $num,
          "address" => $address,
          
        ];
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $res=json_decode($data);
        return $res;
    }
    //获取商品可售状态
    public function getGoodsStatus($jd_goods_id)
    {
        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        $url=$this->jdurl."/api/product/saleStatus.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "pid" => $jd_goods_id,
        ];
        /*echo "<pre>";
        var_dump($data);*/
        
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,3000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        /*echo "<pre>";
        var_dump($data);*/
        $res=json_decode($data);
      
        return $res;
    }
    //获取商品价格
    public function getGoodsPrice($jd_goods_id)
    {
        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        
        $url=$this->jdurl."/api/product/getPrice.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "pid" => $jd_goods_id,
          
        ];
        
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $res=json_decode($data);
        return $res;
    }
    //获取商品详情 
    public function getGoodsDetail($jd_goods_id)
    {
        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        
        $url=$this->jdurl."/api/product/detial.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "pid" => $jd_goods_id,
          "mobile"=>"true",
        ];
        
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
      
        $res=json_decode($data);
                
        
        //return $res;
        /*echo "<pre>";
        var_dump($res);
        die();*/
        $jdgoods=JdGoods::findOne(["jdgoods_id"=>$jd_goods_id]);
        $jdgoods->name=isset($res->RESULT_DATA->PRODUCT_DATA->name)?$res->RESULT_DATA->PRODUCT_DATA->name:"";
        $jdgoods->brand=isset($res->RESULT_DATA->PRODUCT_DATA->brand)?$res->RESULT_DATA->PRODUCT_DATA->brand:"";
        $jdgoods->type=isset($res->RESULT_DATA->PRODUCT_DATA->type)?$res->RESULT_DATA->PRODUCT_DATA->type:"";
        $jdgoods->thumbnailImage=isset($res->RESULT_DATA->PRODUCT_DATA->thumbnailImage)?$res->RESULT_DATA->PRODUCT_DATA->thumbnailImage:"";
        $jdgoods->productCate=isset($res->RESULT_DATA->PRODUCT_DATA->productCate)?$res->RESULT_DATA->PRODUCT_DATA->productCate:"";
        $jdgoods->productCode=isset($res->RESULT_DATA->PRODUCT_DATA->productCode)?$res->RESULT_DATA->PRODUCT_DATA->productCode:"";
        $jdgoods->status=isset($res->RESULT_DATA->PRODUCT_DATA->status)?$res->RESULT_DATA->PRODUCT_DATA->status:"";
        $jdgoods->marketPrice=isset($res->RESULT_DATA->PRODUCT_DATA->marketPrice)?$res->RESULT_DATA->PRODUCT_DATA->marketPrice:"";
        $jdgoods->retailPrice=isset($res->RESULT_DATA->PRODUCT_DATA->retailPrice)?$res->RESULT_DATA->PRODUCT_DATA->retailPrice:"";
        
        
      
        if($jdgoods->marketPrice==$jdgoods->retailPrice)
        {   
            $jdgoods->profitPCT="0";  
        }else{
      //echo round(($jdgoods->marketPrice-$jdgoods->retailPrice)/$jdgoods->retailPrice*100,2);
            //echo $jdgoods->marketPrice.";;;;".$jdgoods->retailPrice;
            $jdgoods->profitPCT=round(($jdgoods->marketPrice-$jdgoods->retailPrice)/$jdgoods->retailPrice*100,2);  
            
        }
        
        
        $jdgoods->productPlace=isset($res->RESULT_DATA->PRODUCT_DATA->productPlace)?$res->RESULT_DATA->PRODUCT_DATA->productPlace:"";
        $jdgoods->features=isset($res->RESULT_DATA->PRODUCT_DATA->features)?$res->RESULT_DATA->PRODUCT_DATA->features:"";
        $jdgoods->imageUrl=isset($res->RESULT_DATA->PRODUCT_IMAGE->imageUrl)?$res->RESULT_DATA->PRODUCT_IMAGE->imageUrl:"";
        $jdgoods->orderSort=isset($res->RESULT_DATA->PRODUCT_IMAGE->orderSort)?$res->RESULT_DATA->PRODUCT_IMAGE->orderSort:"";
        $jdgoods->content=isset($res->RESULT_DATA->PRODUCT_DESCRIPTION)?$res->RESULT_DATA->PRODUCT_DESCRIPTION:"";
        $jdgoods->mobile_content=isset($res->RESULT_DATA->MOBILE_PRODUCT_DESCRIPTION)?$res->RESULT_DATA->MOBILE_PRODUCT_DESCRIPTION:"";

        $jdgoods->save();
        
       /* echo "<pre>";
        var_dump($jdgoods->getErrors());
        die();*/

    }
   
  
  //获取分类
    public function getCate1(){
      
        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        
        $url=$this->jdurl."/api/cate/rootCate.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
        ];
        
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
      
        $res=json_decode($data);
                
        
        return $res;
       
        //$this->dump($res);
    }
  //获取分类
    public function getCate2($parentCate){
      
        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        $url=$this->jdurl."/api/cate/childs.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          "parentCate" => $parentCate,
        ];
        
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
      
        $res=json_decode($data);
                
        return $res;
       
        //$this->dump($res);
    }
	
  //获取预存款余额
    public function getRemain(){
      
        $token=$this->getToken();
        $timestamp=$this->getTimestamp();
        $url=$this->jdurl."/api/finance/remain.php";
        $data=[
          'wid' =>$this->wid,
          "token" =>$token,
          "timestamp" => $timestamp,
          
        ];
        
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
      
        $res=json_decode($data);
                
        return $res;
       
        //$this->dump($res);
    }


    function getToken()
    {
         $timestamp = time()."000";
        $token=strtoupper(MD5($this->wid.$this->secret.$timestamp));
        return $token;
    }

    function getTimestamp()
    {
        $timestamp = time()."000";
        
        return $timestamp;
    }
   

}
