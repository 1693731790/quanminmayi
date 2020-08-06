<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="订单列表";
?>
<style type="text/css">
    .user_order_list_div{width: 100%;height: 4rem; margin-top:5px;}
    
</style>

<div class="Web_Box nb">
  <div class="DistributionOrder">
    <div class=" gd lt0 wauto z100">
      <header class="header2"> <i class="iconfont icon-leftdot" onclick="javascript:history.go(-1)"></i>
        <div class="SearchBox SearchBox3 fl">
        
    <h2 style="text-align: center;font-size: 0.75rem;color: #f84e37;margin-top: 5px;">订单列表</h2>
  
        </div>
        
      </header>
      <div class="Tabs2">
        <ul>
          <li <?=$status==""?'class="on"':''?> onclick="tourl(200)">全部</li>
          <li <?=$status=="0"?'class="on"':''?> onclick="tourl(0)">未付款</li>
          <li <?=$status=="1"?'class="on"':''?> onclick="tourl(1)">待发货</li>
          <li <?=$status=="2"?'class="on"':''?> onclick="tourl(2)">待收货</li>
          <li <?=$status=="3"?'class="on"':''?> onclick="tourl(3)">已完成</li>
        </ul>
      </div>
    </div>
<script type="text/javascript">
  function tourl(type){
    var url="<?=Url::to(["my-shop/order"])?>";
    if(type!=200)
    { 
        window.location.href=url+"?status="+type;
    }else{
        window.location.href=url;
    }
    
  }
</script>    
    <!--待发货Start-->
    <div class="ProList bg_f5f5f5">
      <ul id="list_box">
      <?php foreach($model as $modelkey=>$modelval):?>
        <li>
          <div class="tit"> <span class="fl">订单号：<?=$modelval->order_sn?></span>  <span class="fr cr_f84e37"><?=Yii::$app->params["order_status"][$modelval->status]?></span> </div>
          <?php foreach($modelval->orderGoods as $goodskey=>$goodsval):?>
          <div class="user_order_list_div">
            <div class="Pic"><img src="<?=Yii::$app->params['imgurl'].$goodsval->goods_thums?>" alt=""/></div>
            <div class="Con">
              <div class="fl">
                <h2 class="slh2"><?=$goodsval->goods_name?></h2>
                <p class="Attributes slh mb10"><?=$goodsval->attr_name?></p>
              </div>
              <div class="fr tr"> <span class="Prices">￥<?=$goodsval->price?></span> <span class="Num">×<?=$goodsval->num?></span></div>
              
            </div>
          </div>
          <?php endforeach;?>
         
          <p class="Total tr">共<?=count($modelval->orderGoods)?>件商品  合计：￥<?=$modelval->total_fee?></p>
        
          <div class="Operation">
            <span class="fl ml30">下单时间：<?=date("Y-m-d H:i:s",$modelval->create_time)?></span>
            <div class="fr">
              <?php if($modelval->status=="1"): ?>
              <span class="but1 cr_f95d47" onclick="orderstatus(<?=$modelval->order_id?>)"><!-- <i class="iconfont icon-customerservice"></i> --> 发货 </span> 
              <?php endif;?>
            </div>
          </div>
        </li>
        <?php endforeach;?>
      </ul>
    </div>
    <!--待发货End--> 
<script type="text/javascript">
  function orderstatus(order_id)
  {
      var url="<?=Url::to(['my-shop/order-status'])?>"+"?order_id="+order_id;
      layer.open({
        type: 2,
        title: '发货',
        shadeClose: true,
        shade: 0.8,
        area: ['90%', '50%'],
        content: url //iframe的url
      }); 
    
  }
</script>  
    
  </div>
</div>



<script>


var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['my-shop/order-list'])?>",{"page":page,"status":"<?=$status?>"},function(da){
             $('#list_box').append(da);                                      
    })
   
    
    off_on = true; //[重要]这是使用了 {滚动加载方法1}  时 用到的 ！！！[如果用  滚动加载方法1 时：off_on 在这里不设 true的话， 下次就没法加载了哦！]
};

$(window).scroll(function() {
    //当时滚动条离底部60px时开始加载下一页的内容
    if (($(window).height() + $(window).scrollTop() + 60) >= $(document).height()) {
        clearTimeout(timers);
        timers = setTimeout(function() {
            page++;
            
            LoadingDataFn();
        }, 300);
    }
});
</script>
