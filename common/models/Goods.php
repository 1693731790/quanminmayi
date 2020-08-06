<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $goods_id
 * @property integer $shop_id
 * @property integer $cate_id1
 * @property integer $cate_id2
 * @property integer $cate_id3
 * @property string $goods_sn
 * @property string $goods_name
 * @property string $goods_keys
 * @property string $goods_thums
 * @property string $goods_img
 * @property string $desc
 * @property string $old_price
 * @property string $price
 * @property integer $salecount
 * @property integer $issale
 * @property integer $ishot
 * @property integer $isnew
 * @property integer $status
 * @property string $content
 * @property integer $create_time
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['shop_id', 'cate_id1', 'cate_id2', 'cate_id3', 'goods_sn', 'goods_name', 'goods_keys', 'goods_thums',  'desc','old_price', 'price','stock', 'freight'], 'required'],
            [['shop_id',"", 'cate_id1', 'cate_id2', 'cate_id3', 'salecount', 'issale', 'ishot', 'isnew','istuijian','istodaynew','isselected',  'create_time','freight','stock','is_agent_buy',"jdgoods_id"], 'integer'],
            [['content','mobile_content','status',], 'string'],
            [['old_price', 'price','profitPCT','profitFee'], 'number'],
            [['goods_sn','source',"goods_brand"], 'string', 'max' => 50],
            [['goods_name', 'goods_keys', 'goods_thums','status_info'], 'string', 'max' => 200],
            [['desc'], 'string', 'max' => 250],
            [['goods_img'],'safe'],
        ];
    }*/
    public function rules()
    {
        return [
            [['source_id', 'shop_id', 'is_agent_buy', 'cate_id1', 'cate_id2', 'cate_id3', 'stock', 'salecount', 'browse', 'issale', 'ishot', 'isnew', 'ishome', 'istuijian', 'istodaynew', 'isselected', 'isdigital', 'isdiscount', 'freight', 'create_time'], 'integer'],
            [['shop_id', 'cate_id1', 'cate_id2', 'cate_id3', 'goods_sn', 'goods_name', 'goods_keys', 'goods_thums', 'desc', 'old_price', 'price', 'stock', 'freight'], 'required'],
            [[ 'content', 'mobile_content',"desc"], 'string'],
            [['old_price', 'price', 'profitPCT', 'profitFee', 'jd_price', 'xy_price'], 'number'],
            [[ 'source', 'goods_sn', 'goods_brand'], 'string', 'max' => 50],
            [['goods_name', 'goods_keys', 'goods_thums', 'status_info'], 'string', 'max' => 200],
            
            [['status'], 'string', 'max' => 10],
            [['goods_img',"jdgoods_id","jdis_update_goods_thums","parent_profit","is_seckill","seckill_stock","seckill_surplus","seckill_start_time","seckill_hour","seckill_price","seckill_end_time","seckill_img","is_group","shops_limit","shops_cate","shops_class1","shops_class2"],'safe'],
          
        ];
    }
 
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => '商品ID',
            'shop_id' => '店铺ID',
            'cate_id1' => '顶级分类',
            'cate_id2' => '二级分类',
            'cate_id3' => '三级分类',
            "goods_brand"=>"系统商品品牌",
            'goods_sn' => '商品编号',
            'goods_name' => '商品名称',
            'goods_keys' => '关键字',
            'goods_thums' => '商品缩略图',
            'goods_img' => '商品相册',
            'desc' => '商品描述',
            'old_price' => '商品原价',
            'price' => '现价',
            'profitPCT'=>'利润百分比',
            'profitFee'=>'利润金额',
            'stock' => '库存',

            "is_seckill"=>"是否秒杀商品",
            "seckill_img"=>"秒杀商品缩略图",
          
            'seckill_stock' => '秒杀库存个数',
            'seckill_surplus' => '秒杀剩余个数',
            'seckill_start_time' => '秒杀开始时间',
            'seckill_end_time' => '秒杀结束时间',
            'seckill_hour' => '秒杀时间',
            'seckill_price' => '秒杀价格',

            'salecount' => '销量',
            'issale' => '是否上架',
            'ishot' => '是否热卖',
            'isnew' => '是否新品',
            'istuijian' => '是否推荐',
            'istodaynew' => '是否今日上新',
            'isselected' => '是否精选',
            'isdigital' => '是否数码管',
            'isdiscount' => '是否特价馆',
            'is_group' => '是否团购',
           
            'status' => '状态',
            'content' => '详情',
            "mobile_content"=>"手机版详情",
            'freight' => '运费',
            'browse' => '浏览量',
            'status_info' => '状态说明',
            'create_time' => '添加时间',
            "is_agent_buy"=>"是否专属代理商购买的商品",
            "source"=>"商品来源",
            "source_id"=>"供货商",
            "jdis_update_goods_thums"=>"是否修改京东商品缩略图",
            "parent_profit"=>"上级用户获得利润的百分比",
          
          	"shops_limit"=>"是否限量商品",
          	"shops_cate"=>"店铺品牌",
        ];
    }

    
    public static function getGoods($jdgoods_id)
    {
      $goods=self::find()->where(["jdgoods_id"=>$jdgoods_id])->count();
        if($goods>0)
        {
            return true;
        }else{
          return false; 
        }
      
    }


    public function beforeSave($insert)
    {
        
        if(parent::beforeSave($insert))
        {  
          
          	if($this->is_seckill=="1")
                {
                 	 	 $this->seckill_start_time=strtotime($this->seckill_start_time);
           				 $this->seckill_end_time=strtotime($this->seckill_end_time);
                }
            if($insert)
            {
              	
                if($this->jdgoods_id=="")
                {
                    if(!empty($this->goods_img))
                    {
                      $this->goods_img=json_encode($this->goods_img);
                    }
                    $this->status="0";
                    $this->create_time=time();
                }
                
            }else{
              
              if(!empty($this->goods_img))
              {
                $this->goods_img=json_encode($this->goods_img);
              }
              
             /*if($this->is_seckill=="1")
              {
                $this->is_seckill=="1";
               echo "<pre>";
                var_dump($this);
                die();
              }else{
                 $this->is_seckill=="0";
              }*/
              
            }
            return true;

        }
        else
        {
          
            return false;
        }
    }


    public function updateGoods()
    {
        $yunzhonghe=new Yunzhonghe();
        
        $getPriceRes=$yunzhonghe->getGoodsPrice($this->jdgoods_id);
      	
      /*	echo "<pre>";
      var_dump($getPriceRes);
      die();*/
        
        if($getPriceRes->RESPONSE_STATUS=="true")//profitPCT
        {
          	if($getPriceRes->RESULT_DATA->retail_price!="$this->xy_price" || $getPriceRes->RESULT_DATA->market_price!="$this->jd_price")
            {
              	  $this->jd_price=$getPriceRes->RESULT_DATA->market_price;
                  $this->xy_price=$getPriceRes->RESULT_DATA->retail_price;
                  //$this->profitPCT=round(($getPriceRes->RESULT_DATA->market_price-$getPriceRes->RESULT_DATA->retail_price)/$getPriceRes->RESULT_DATA->retail_price*100,2);  
                  $this->profitPCT="30";  

                 // $this->price=round($getPriceRes->RESULT_DATA->retail_price+($getPriceRes->RESULT_DATA->retail_price*($this->profitPCT/100)),2);
                  $this->price=round($getPriceRes->RESULT_DATA->retail_price+($getPriceRes->RESULT_DATA->retail_price*(30/100)),2);
                  $this->old_price=round($this->price+($this->price*0.3),2);
                  $this->profitFee=round($getPriceRes->RESULT_DATA->retail_price*(30/100),2);
                  //$this->profitFee=round($getPriceRes->RESULT_DATA->retail_price*($this->profitPCT/100),2);
              	  $this->update(true,["jd_price","xy_price","profitPCT","price","old_price","profitFee"]);
            }
            
           
           /* echo "jd_price:".$this->jd_price."---xy_price:".$this->xy_price."---profitPCT:".$this->profitPCT."---price:".$this->price."---old_price:".$this->old_price."----profitPCT:".$this->profitPCT."----profitFee:".$this->profitFee;
            die();*/
        }else{
            $this->delete();
            return false;
        }
        $getStatusRes=$yunzhonghe->getGoodsStatus($this->jdgoods_id); 
        if($getStatusRes->RESPONSE_STATUS!="true"||$getStatusRes->RESULT_DATA->status!=true)
        {
            $this->delete();
            return false; 
        }
        
        
        //echo $this->createCommand()->getRawSql();
          //die();
        return true;
 
    }
}
