<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width,maximum-scale=1.0,initial-scale=1.0,user-scalable=no"/>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta content="telephone=no" name="format-detection" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no, email=no" />
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">
<meta name="full-screen" content="yes">
<meta name="x5-fullscreen" content="true">
<meta name="browsermode" content="application">
<meta name="x5-page-mode" content="app">

<meta content="email=no" name="format-detection" />
<title>拨打电话</title>
  
<head>

<link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont-phone/iconfont.css" />
  

<link rel="stylesheet" type="text/css" href="/webstatic/css/index.css">
<link rel="stylesheet" type="text/css" href="/static/css/swiper.min.css">
<link rel="stylesheet" type="text/css" href="/static/css/css.css">


<script type="text/javascript" src='/webstatic/js/jquery.min.js'></script>

<script type="text/javascript" src='/static/js/swiper.min.js'></script>

  
<style>
 body, p{ margin: 0; padding: 0; }

  
  </style>
    
</head>
<body >


 <div class="change-content change-box" style="margin-bottom: 2rem;">
        <div class="change-main">
            <div class="change-cut flex-row"  style="background: #fff;">
                <ul class="clearfix" style="background: #fff;">
                    <li class="transition tab on">通话</li>
                    <li class="transition tab" style="border-right:0">联系人</li>
                </ul>
                <div class="picu"><a href="<?=Url::to(["signin-log/index"])?>"><img class="shop-search" src="/webstatic/images/index_03.jpg"/></a></div>
            </div>
            <div class="contents clearfix">
                <div class="content flex-row" style="display: block;">
                 <div class="waice"> 
                <div class="firsto">
                  <div class="ipleft">
                      <div class="iplefta"><span class="iconfont">&#xe612;</span></div>
                      <div class="ipleftb">王建林</div>
                      <div class="ipleftc">13436700321</div>
                      <div class="ipleftd">广东 广州</div>
                  </div>
                  <div class="ipright"><div class="timeright">12:20</div><a href="tonghuaxiangqing.html"><div class="tubiaoright"><i class="iconfont icon-xiangqing qing"></i></div></a></div>
                </div>
                <div class="firstoo">
                  <div class="ipleft">
                      <div class="iplefta"><span class="iconfont">&#xe612;</span></div>
                      <div class="ipleftb">王思聪</div>
                      <div class="ipleftc">13436700321</div>
                      <div class="ipleftd">广东 广州</div>
                  </div>
                  <div class="ipright"><div class="timeright">12:20</div><a href="tonghuaxiangqing.html"><div class="tubiaoright"><i class="iconfont icon-xiangqing qing"></i></div></a></div>
                </div>
               
                 </div>
                  <div class="anniu"><img class="anniuu" src="/webstatic/images/shezhi_11.jpg"/></div> 
                
</div>
                <div class="content flex-row" style="display: none;">
                <div class="sousuo"><input id="shop-inputt" type="text" placeholder="搜索" value="" style="border:none;"/></div>
                <div class="fixeds">
    <img class="tpp" src="/webstatic/images/tubiao1_03.jpg"/><div class="headers">
        新建联系人
    </div>
</div>

<div id="letter"></div>
<div class="sort_box">
    <div class="sort_list">
        <div class="num_name">张三</div>
    </div>
    
</div>
<div class="initials">
    <ul>
    </ul>
</div>
         </div>
            </div>
        </div>
    </div>
     <div class="tanchubox" style="display:none;">
       <div class="firstlilte"><input id="shop-inputt" class="phoneNum" type="text" placeholder="" value="" readonly="readonly" /></div>
       <div class="twotlilte">
           <div class="onet">
              <ul>
                 <li onclick="phoneNum('1')">
                    <div class="call">1<span class="calls"></span></div>
                 </li>
                 <li onclick="phoneNum('2')"> 
                    <div class="call">2<span class="calls">ABC</span></div>
                 </li>
                 <li onclick="phoneNum('3')"> 
                    <div class="call">3<span class="calls">DEF</span></div>
                 </li>
                 <li onclick="phoneNum('4')"> 
                    <div class="call">4<span class="calls">GHI</span></div>
                 </li>
                 <li onclick="phoneNum('5')"> 
                    <div class="call">5<span class="calls">JKL</span></div>
                 </li>
                 <li onclick="phoneNum('6')"> 
                    <div class="call">6<span class="calls">MNO</span></div>
                 </li>
                 <li onclick="phoneNum('7')"> 
                    <div class="call">7<span class="calls">PQRS</span></div>
                 </li>
                 <li onclick="phoneNum('8')"> 
                    <div class="call">8<span class="calls">TUV&nbsp</span></div>
                 </li>
                 <li onclick="phoneNum('9')"> 
                    <div class="call">9<span class="calls">WXYZ</span></div>
                 </li>
                 <li onclick="phoneNum('*')"> 
                    <div class="call">*<span class="calls"></span></div>
                 </li>
                 <li onclick="phoneNum('0')"> 
                    <div class="call">0<span class="calls">+</span></div>
                 </li>
                 <li onclick="phoneNum('#')"> 
                    <div class="call">#<span class="calls"></span></div>
                 </li>
              </ul>
           </div>
       </div>

       <div class="threelilte">
        <ul>
        <li><img class="piqa" src="/webstatic/images/iphone3_06.jpg"/></li>
        <li><img class="piqtwo" src="/webstatic/images/iphone3_03.jpg"/></li>
        <li><img class="piqthree" src="/webstatic/images/ipo1_03.jpg"/></li>

        </ul>

       </div>
   </div>
    
 
 
<style type="text/css">

.nav li span {
    display: block;
    font-size: 1.2rem;
    line-height: 1.2rem;
    margin-top: 0.375rem;
}

</style>

  
<?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')||strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')!==false):?>
<nav class="nav" style="display: block;">
  <ul style="margin: 0; padding: 0">
    <li <?=$this->context->id=="index"?'class="on"':''?> > 
      <a href="<?=$this->context->id=="index"&&$this->context->action->id=="index"?'javascript:;':Url::to(["index/index"])?>"> <span  class="iconfont">&#xe642;</span> 
      <p>首页</p>
      </a> </li>
    <li <?=$this->context->id=="my-shop"?'class="on"':''?>> 
      <a href="<?=$this->context->id=="my-shop"&&$this->context->action->id=="index"?'javascript:;':Url::to(["my-shop/open-shop"])?>"><span  class="iconfont">&#xe613;</span>
      <p>开店</p>
      </a> </li>
    <li <?=$this->context->id=="phone"?'class="on"':''?>> 
      <a href="<?=$this->context->id=="phone"&&$this->context->action->id=="index"?'javascript:;':Url::to(["phone/index"])?>"><span  class="iconfont">&#xe61b;</span>
      <p>通话</p>
      </a> </li>
    <li <?=$this->context->id=="goods-cate"?'class="on"':''?>>
       <a href="<?=$this->context->id=="goods-cate"&&$this->context->action->id=="index"?'javascript:;':Url::to(["goods-cate/index"])?>"> <span class="iconfont">&#xe606;</span>
      <p>分类</p>
      </a> </li>
    <li <?=$this->context->id=="user"?'class="on"':''?>> 
       <a href="<?=$this->context->id=="user"&&$this->context->action->id=="index"?'javascript:;':Url::to(["user/index"])?>"> <span class="iconfont">&#xe62f;</span>
      <p>我的</p>
      </a> </li>
  </ul>
</nav>
    
<?php endif;?>   

<script type="text/javascript" src="/webstatic/js/jquery.charfirst.pinyin.js"></script>
<script type="text/javascript" src="/webstatic/js/sort.js"></script>

<script type="text/javascript" src='/static/layer/layer.js'></script>      
    

<script type="text/javascript">
function phoneNum(obj)
{
  
   var phoneNum=$(".phoneNum").val();
   $(".phoneNum").val(phoneNum+obj);

}
      
$(function () { 
      
      
      $(".piqtwo").click(function(){//打电话
          var phoneNum=$(".phoneNum").val();
          $.get("<?=Url::to(['phone/get-call-token'])?>",{"target_mobile":phoneNum},function(r){
            
                if(r.success)
                { 
                    layer.msg("呼叫成功");
                }else{
                    layer.msg("呼叫失败");
                    return false;
                }
          },'json')
      });

      $(".piqthree").click(function(){//减少一位电话号
          var phoneNum=$(".phoneNum").val();
          $(".phoneNum").val(phoneNum.substring(0,phoneNum.length-1));
      });

      $('.tab').on('click',function () {
            let i = $(this).index();
            $(this).addClass('on').siblings().removeClass('on');
            $('.contents .flex-row').eq(i).show().siblings().hide();
      })

      $(".anniu").click(function(){
         $(".tanchubox").show();
      });
      $(".piqa").click(function(){
         $(".tanchubox").hide();
         $(".anniu").show();
      });

    $('.anniu').click(function (event) { 
      //取消事件冒泡 
      event.stopPropagation(); 
      //按钮的toggle,如果div是可见的,点击按钮切换为隐藏的;如果是隐藏的,切换为可见的。 
      $('.anniu').toggle('slow'); 
          return false;
    }); 
  //点击空白处隐藏弹出层，下面为滑动消失效果和淡出消失效果。
    $(document).click(function(event){
        var _con = $('.tanchubox');  // 设置目标区域
        if(!_con.is(event.target) && _con.has(event.target).length === 0){ // Mark 1
           //$('#divTop').slideUp('slow');  //滑动消失
           $('.tanchubox').hide(1000);  
            $(".anniu").show();   //淡出消失
        }
   });
})
    
</script>


  <script src="/webstatic/js/TouchSlide.1.1.js"></script>
    <script src="/webstatic/js/jquery.vticker.min.js"></script>

    <script>
        (function (doc, win) {

            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    docEl.style.fontSize = 20 * (clientWidth / 320) + 'px';
                };
            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    </script> 


</body>
</html>
