<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="商品分类";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/reset_m.css">

<link rel="stylesheet" type="text/css" href="/webstatic/css/fenlei.css" >
<style>
 .change-content{margin-top:2rem;}
 .change-box .change-cut{height:1.3rem; position: fixed;margin-top:0rem; background:#fff;padding-top:0.5rem;padding-bottom:0.5rem; z-index: 99} 
 .contents{padding-top:1.8rem;}
 .change-box .change-cut ul{margin-top:0rem;}
 .tout-fixed{ position: fixed;top:4.2rem;z-index: 999;width:100%;  overflow: hidden;}
 .tout-fixed-fen{ backgound:#fff; width:100%; height: 1.6rem}
 .tout,.sideee{margin:0rem;height: 1.4rem; background:#f7f7f7;}
 .toutuu:before,.toutuu:after{top:50%;}
 .toutuu{ line-height: 1.2rem}
</style>

<header class="module-layer">
    <div class="module-layer-content">
        <div class="module-layer-bg"></div>
        <div class="search-box-cover"></div>
        <p class="layer-logo"><img src="/webstatic/images/logo.png"></p>
        <h1 class="layer-head-name">
            <div class="pr search-box">
                <img class="shop-search" id="searchSub" style="z-index:999" src="/webstatic/images/icon_search.png"/>
                <input id="shop-input" type="text" placeholder="" value="" />
                <input type="hidden" id="searchType"  value="1">
            </div>

<script type="text/javascript">
      function searchType(type)
      {
          $("#searchType").val(type);
      }
      $(function(){
        $("#searchSub").click(function(){
          
            var type=$("#searchType").val();
            
            var key=$("#shop-input").val();

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


        </h1>
         <p class="layer-login" >
           <a href="<?=Url::to(['shopcar/shopcar-list'])?>">
             <img class="che" src="/webstatic/images/tuiche.png">
           </a> 
          </p>
    </div>
</header>
<div class="out-big">
 <div class="change-content change-box">
        <div class="change-main">
            <div class="change-cut flex-row">
                <ul class="clearfix">
                    <li class="transition tab on">分类</li>
                    <li class="transition tab" style="border-right:0">品牌</li>
                </ul>
            </div>
            <div class="contents clearfix">
                <div class="content flex-row" style="display: block;">
                  <?php foreach($cate1 as $cate1Val): ?>
                    <div class="tout">
                      <div class="toutu">
                      <?=$cate1Val["goods_cat_name"]?>
                      </div>
                    </div>
                    <div class="tout-fixed-fen"></div>
                    <?php foreach($cate1Val["sonCate"] as $cate2Val): ?>
                    <div class="bigw">
                        <div class="titledh"><div class="reddh"></div><div class="blackwz"><?=$cate2Val["goods_cat_name"]?></div></div>
                        <div class="pil">
                          <ul>
                          <?php foreach($cate2Val["sonCate"] as $cate3Val): ?>
                          <li>
                            <a href="<?=Url::to(["goods/index","goods_cate_id"=>$cate3Val["goods_cat_id"]])?>">
                            <div class="pim"><img class="sho" src="<?=$cate3Val["thumb"]?>"></div>
                            <div class="pio"><?=$cate3Val["goods_cat_name"]?></div>
                            </a>
                          </li>
                          <?php endforeach;?>


                          </ul>
            </div>   
        </div>
        <?php endforeach;?>
        
          <?php endforeach;?>

                </div>
                <div class="content flex-row" style="display: none;">
                <div class="sideee tout-fixed" >
                <div class="toutuu">
                推荐品牌
                    </div>
                    </div>
                    <div class="tout-fixed-fen"></div>
                    <div class="waice">
                        <ul>
                        <?php foreach($goodsBrand as $goodsBrandVal): ?>
                        <li>
                          <a href="<?=Url::to(["goods/index","goods_brand"=>$goodsBrandVal["id"]])?>">
                          <div class="pimn"><img src="<?=$goodsBrandVal->img?>"> </div>
                          </a>
                        </li>
                      <?php endforeach;?>
            
                        </ul>
                    </div>
                </div>
                <div class="content flex-row" style="display: none;">
                </div>
                <div class="content flex-row" style="display: none;">
                </div>
                <div class="content flex-row" style="display: none;">
                </div>
                <div class="content flex-row" style="display: none;">
                </div>
            </div>
        </div>
    </div>
     
    </div>
    
    <script>
     $(document).ready(function(){
       $(window).scroll(function(){
          var scroH = $(this).scrollTop();
            $(".tout").each(function(index, ele) {
              $(this).data('top', $(this).offset().top) 
              if ($(this).data('top') - scroH < 120 ) {
              $(this).addClass("tout-fixed").siblings(".tout").removeClass("tout-fixed");
              $(this).next(".tout-fixed-fen").css("display", "block").siblings(".tout-fixed-fen").css("display", "none");
            } 
          })
        });
      });
      $('.tab').on('click',function () {
        let i = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.contents .flex-row').eq(i).show().siblings().hide();
      })
    </script>
