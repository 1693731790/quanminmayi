<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="全民蚂蚁";
?>
<style type="text/css">
  .rem49{}
  body{padding:0px;margin:0px;width: 100%;}
</style>

<div class="Web_Box index">
  <header class="bg_f84e37 xd z99">
    <div class="logo fl">
      <div class="pic"><img src="/static/images/logo.png" alt=""/></div>
      <!--<i class="iconfont icon-logotext"></i>-->
      
      </div>
   
    
    <div class="SearchBox fl"> 
      
      <!--搜索类型切换（商品与店铺）Start-->
      <div class="fl xd">
        <div class="SearchType" id="SearchType" onClick="SearchType('#TypePop')"><span class="fl">商品</span><i class="iconfont icon-downdot"></i></div>
        <div class="TypePop disn" id="TypePop">
          <ul>
             <li onclick="searchType(1)"><i class="iconfont icon-home" ></i>商品</li>
              <li onclick="searchType(2)"><i class="iconfont icon-shop" ></i>店铺</li>
              <input type="hidden" id="searchType" value="1">
          </ul>
        </div>
      </div>
      <!--搜索类型切换（商品与店铺）End-->
        <input class="InputBor" placeholder="搜索您想要的商品" name="" id="searchKey" value="" type="text">
        <i class="iconfont icon-search" id="searchSub"></i></div>
    <div class="ShoppingCart fl" style="float: right;" onClick="GoToUrl('<?=Url::to(['shopcar/shopcar-list'])?>')"> <i class="iconfont icon-shoppingcart"></i> <span>购物车</span> </div>

    <script type="text/javascript">
      function searchType(type)
      {
          $("#searchType").val(type);
      }
      $(function(){
        $("#searchSub").click(function(){
            var type=$("#searchType").val();
            
            var key=$("#searchKey").val();

            if(key=="")
            {
                layer.msg("请输入要搜索的内容");
                return false;
            }
            if(type==1)
            {
                var url="<?=Url::to(['search/goods'])?>";
                window.location.href=url+"?searchKey="+key;
            }else{
                var url="<?=Url::to(['search/shops'])?>";
                window.location.href=url+"?searchKey="+key;
            }
            
        })
    })
    </script> 
  </header>
  <div class="banner swiper-container">
    <div class="swiper-wrapper">
      <?php foreach($banner as $bannerval):?>
        <div class="swiper-slide"><a href="<?=$bannerval->url?>"><img src="<?=yii::$app->params['imgurl'].$bannerval->img?>" alt=""/></a></div>
      <?php endforeach;?>
    </div>
    <div class="swiper-pagination2 tc"></div>
  </div>
  <script>
  $(window).load(function(){
      var mySwiper = new Swiper('.banner.swiper-container', {
        autoplay: 3000,//可选选项，自动滑动
        pagination : '.swiper-pagination2',
        loop : true,
        autoplayDisableOnInteraction : false
        })
      }) 
    
  </script> 
  <!--分类导航Start-->
  <div class="tubiao">
        <ul class="clearfix">
            <li>
                <a href="<?=URL::to(["search/goods","isselected"=>1])?>">
                    <p><img src="/static/images/img/1.png"></p>
                    精选商品
                </a>
            </li>
            <li>
                <a href="<?=URL::to(["search/goods","istodaynew"=>1])?>">
                    <p><img src="/static/images/img/2.png"></p>
                    今日上新
                </a>
            </li>
            <li>
                <a href="#">
                    <p><img src="/static/images/img/3.png"></p>
                    优惠券
                </a>
            </li>
            <li>
                <a href="<?=URL::to(["user-upgrade/goods"])?>">
                    <p><img src="/static/images/img/5.png"></p>
                    大礼包
                </a>
            </li>
            <li>
                <a href="<?=URL::to(["goods/index","goods_cate_id"=>"17805"])?>">
                    <p><img src="/static/images/img/7.png"></p>
                    生活家电
                </a>
            </li>
            <li>
                <a href="<?=URL::to(["goods/index","goods_cate_id"=>"17808"])?>">
                    <p><img src="/static/images/img/8.png"></p>
                    时尚生活
                </a>
            </li>
            <li>
                <a href="<?=URL::to(["signin-log/index"])?>">
                    <p><img src="/static/images/img/9.png"></p>
                    签到领话费
                </a>
            </li>
            <li>
                <a href="#">
                    <p><img src="/static/images/img/10.png"></p>
                    邀请赚话费
                </a>
            </li>
        </ul>
    </div>
  <!--分类导航End-->
  <!--广告start-->
  <div class="gguangt"><a href="#"><img src="/static/images/img/3.jpg" alt=""></a></div>
  <div class="gguangt"><a href="#"><img src="/static/images/img/4.jpg" alt=""></a></div>
  <!--广告End-->

  <!--首页活动入口Start-->
  <!--div class="ActiveEntry mb20" style="height: 10.2rem;">
    <div class="EveryDayBerserk fl bg_fff" style="height: 10.2rem;">
      <a href="<?=$adv[0]->url?>">
        <div class="pic"> 
          <img style="margin-top: 0.1rem;" src="<?=Yii::$app->params['imgurl'].$adv[0]->img?>" alt=""/> 
        </div>
      </a>
       <a href="<?=$adv[3]->url?>">
        <div class="pic"> 
          <img style="margin-top: 0.2rem;" src="<?=Yii::$app->params['imgurl'].$adv[3]->img?>" alt=""/> 
        </div>
      </a>  
       
     
    </div>
    <div class="right fr" style="height: 10.2rem;">
      <div>
         <a href="<?=$adv[1]->url?>">
          <img class="fl w174 rem49" style="height: 4.9rem" src="<?=Yii::$app->params['imgurl'].$adv[1]->img?>" alt=""/>
        </a>
         <a href="<?=$adv[2]->url?>">
          <img class="fr w174 rem49" style="height: 4.9rem" src="<?=Yii::$app->params['imgurl'].$adv[2]->img?>" alt=""/>
        </a>
      </div>
      <div>
         <a href="<?=$adv[4]->url?>">
          <img class="fl w174 rem49" style="height: 4.9rem" src="<?=Yii::$app->params['imgurl'].$adv[4]->img?>" alt=""/>
        </a>
         <a href="<?=$adv[5]->url?>">
          <img class="fr w174 rem49" style="height: 4.9rem" src="<?=Yii::$app->params['imgurl'].$adv[5]->img?>" alt=""/>
        </a>
      </div>
     
    </div>
  </div-->
  <!--首页活动入口End--> 

  
  <!-- 秒杀 start -->
  <!--div class="indexSecondKill">
    <div class="swiper-container" id="miaosha">
      <div class="ms mb20"><i class="iconfont"></i><span>秒杀专区</span><a href="<?=Url::to(["rob-buy/index"])?>"><i class="fr f1266">查看全部 <i class="iconfont icon-rightdot" style="position:relative;top:1px;"></i><em class="iconfont"></em></i></a></div>
      <div class="swiper-wrapper mb20">
        <?php foreach($robgoods as $robgoodsVal):?>
        <div class="swiper-slide mslist">
          <a href="<?=Url::to(["rob-buy/detail",'rob_id'=>$robgoodsVal->rob_id])?>">
            <img src="<?=Yii::$app->params['imgurl'].$robgoodsVal->goods->goods_thums?>" class="avatar-radius pic_size" style="height: 3.5rem;" />
            <h4 class="text-overflow"><?=$robgoodsVal->goods->goods_name?></h4>
            <h6>¥<?=$robgoodsVal->price?></h6>
            <h5 class="dell">¥<?=$robgoodsVal->goods->price?></h5>
          </a>
        </div>
       <?php endforeach;?>
      </div>
    </div>
  </div-->
  <!-- 秒杀 end -->
  
  <!--专题活动Start-->
  <!--div class="big_tit">
    <h1 class="cr_00a0e9"><i class="iconfont icon-label mr15"></i>专题活动</h1>
    <a class="disb" href=" ThematicList.php">
    <div class="more"><a href="<?=Url::to(["special/index"])?>">更多</a><i class="iconfont icon-rightdot"></i></div>
    </a> </div>
  <div class="ThematicActivities">
    <ul>
      <?php foreach($special as $specialval):?>
      
      <li>
        <a href="<?=Url::to(["special/detail","id"=>$specialval->special_id])?>">
          <div class="pic"><img src="<?=yii::$app->params['imgurl'].$specialval->img?>" alt=""/></div>
          <div class="tit">
            <h2 class="cr_fd6b4b"><?=$specialval->name?></h2>
            
          </div>
        </a>
      </li>
      <?php endforeach;?>
    </ul>
  </div-->
  <!--专题活动End--> 
  
  <!--商品分类Start-->
  <div class="CommodityClassification">
    <div class="big_tit">
      <h1 class="cr_d42d00"><i class="iconfont icon-shoppingbag mr15"></i>推荐分类</h1>
      <a class="disb" href="<?=Url::to(["goods-cate/index"])?>">
      <div class="more">更多<i class="iconfont icon-rightdot"></i></div>
      </a> </div>
    <div class="tabs" id="ClassificationTab">
      <div class="phone_gdt">
        <ul>
          <?php foreach($goodsCate as $goodsCateVal):?> 
              <li  style="width:auto"><a href="<?=Url::to(["goods/index","goods_cate_id"=>$goodsCateVal['goods_cat_id']])?>"><?=$goodsCateVal['goods_cat_name']?></a></li>
          <?php endforeach;?>
        </ul>
      </div>
    </div>
    <div class="con">
      <ul id="content">
       <?php foreach($goods as $goodsVal):?>  
        <li> <a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal->goods_id])?>">
          <div class="pic"> <img src="<?=Yii::$app->params['imgurl'].$goodsVal->goods_thums?>" alt=""/> </div>
          <h3 class="slh2"><?=$goodsVal->goods_name?></h3>
          <p class="Price">￥<?=$goodsVal->price?><span class="OriginalPrice">￥<?=$goodsVal->old_price?></span></p>
          
          </a> 
        </li>
       <?php endforeach;?>
      </ul>
    </div>
    
  </div>
  <!--商品分类End--> 
</div>
<script type="text/javascript">
    $(function(){
  //      $("body").width("100%");
    })
</script>