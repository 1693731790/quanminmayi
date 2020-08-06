<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JSSDK;
$this->title = '免费拿';
$class=new JSSDK(Yii::$app->params['WECHAT']["app_id"],Yii::$app->params['WECHAT']["secret"]);
$wxconfig=$class->getSignPackage();
/*echo "<pre>";
var_dump($wxconfig);
die();*/
?>
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
    <link rel="stylesheet" type="text/css" href="/webstatic/css/zhuli.css">
     <link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />



<header style="background:none;">
         <a href="javascript:;" onClick="history.go(-1)"><div class="_lefte"><i class="iconfont icon-back is"></i></div></a>
          邀请好友助力
</header>
<div class="beiji"><img class="pico" src="/webstatic/images/zhuli_02.jpg"/></div>
<div class="beij">助力规则</div>
<div class="beijii">
<div class="beijiione">
<div class="beijiion">
<div class="one"><img class="piq" src="/webstatic/images/4-9_05.png"/> <div class="ones">邀请好友</div></div>
<div class="two"><img class="piq" src="/webstatic/images/4-9_05.png"/> <div class="ones">免费拿</div> </div>
<div class="three"><img class="pio" src="/webstatic/images/jiantou_08.png"/>
</div><div class="four"><img class="piq" src="/webstatic/images/4-9_05.png"/> <div class="ones">成功注册APP</div></div>
<div class="five"><img class="pio" src="/webstatic/images/jiantou_08.png"/></div></div>
<div class="beijiitw">
邀请<?=$goods->user_num?>个好友助力,即可免费拿哦~
</div>
<div class="beijiifour"> <?=$goods->salecount?>人免费领取</div>
   <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')===false):?>
    <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')): ?>  
      <div class="beijiifive"><div class="beijiifiveone" id="share">点击分享</div></div>
    <?php endif;?>
     
   <?php else:?>
      <div class="beijiifive" id="searchwx"><div class="beijiifiveone">点击分享</div></div>
    
  <?php endif;?>  
   


</div>
</div>
<div class="last">
<div class="tout">
                    <div class="toutu">
                    我的邀请
                    </div>
                    </div>
    <div class="touto"><div class="toutone"><?=$orderUserCount?>（人）</div><div class="toutotwo">点击查看></div></div>
    <div class="toutt"><div class="touttone">邀请人数</div><div class="toutttwo">邀请记录</div></div>
</div>

<div id="fade" class="black_over">
</div>
<!--弹出层的内容-->
 
<div id="MyDiv" class="white_content" >
 
 <div class="out">
<div class="obox">
 <ul>
    <li>
    <div class="pim" ><img  id="wxshare" class="op" src="/webstatic/images/icon_wechat.png"/></div>
   
      <div class="pioooo">分享给微信好友</div>
    
    </li>
    <ul>
    
</ul> 
       
</div>
<div class="tbox">取消</div>
 </div>
</div>
    <div class="tanchubox"><div class="tanchuboxone"><img class="pnm" src="/webstatic/images/guizee_03.png"/>
            <div class="box-close"><img class="box-close-pic" src="/webstatic/images/qwo.png"/></div>

  </div></div>

  <div class="tan-chu-box">
    <div class="tanchuboxone">
        <div class="touts">
            <div class="toutus">邀请记录</div>
        </div>
        <div class="tanchubox-tal">
          <div class="tanchubox-tal-name">账号</div>
          <div class="tanchubox-tal-width">时间</div>
        </div>
        <?php foreach($orderUser as $orderUserVal):?>
        <div class="tanchubox-tals">
          <div class="tanchubox-tal-names"><?=$orderUserVal['username']?></div>
          <div class="tanchubox-tal-widths"><?=date("Y-m-d",$orderUserVal['create_time'])?></div>
        </div>
        <?php endforeach;?>
    </div>
  <div class="box-close-button"><img class="box-close-pic" src="/webstatic/images/qwo.png"/></div>

  </div>
  
<script src="/hbuilderplusto/share/plusShare.js" type="text/javascript" charset="utf-8"></script>
<script>
$(function(){
$("#searchwx").click(function(){
     wx.miniProgram.getEnv(function(res) {
       if(res.miniprogram){
         // true代表在小程序里
 	//alert("123");
           wx.miniProgram.navigateTo({url:"/pages/share/share?title=好友助力&imagelink=<?=Yii::$app->params['webLink'].$goods->goods_thums?>&goods_sn=no&goods_id=no&type=2&user_code=no&order_sn=<?=$model->order_sn?>&price=0.00&old_price=<?=$goods->old_price?>&salecount=<?=$goods->salecount?>"});
         
       }else{
         //alert("小程序与1");
         //false代表在公众号里
     	layer.msg("点击右上角分享到微信");   
       }
     })
     
    //alert(123);
  })
})


    document.getElementById("share").addEventListener("click", function() {
        if(navigator.userAgent.indexOf("Html5Plus") > -1) {
            //5+ 原生分享
            window.plusShare({
                title: "好友助力",//应用名字
                content: "好友助力",
                href: "<?=$shareUrl?>",//分享出去后，点击跳转地址
                thumbs: ["<?=Yii::$app->params['webLink'].$goods->goods_thums?>"] //分享缩略图
            }, function(result) {
                //分享回调
            });
        } else {
            //原有wap分享实现 
        }
    });
 

</script>

 <script type="text/javascript">

            wx.config({
                debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                appId: '<?=$wxconfig["appId"]?>', // 必填，公众号的唯一标识
                timestamp: '<?=$wxconfig["timeStamp"]?>', // 必填，生成签名的时间戳
                nonceStr: '<?=$wxconfig["nonceStr"]?>', // 必填，生成签名的随机串
                signature: '<?=$wxconfig["signature"]?>',// 必填，签名，见附录1
                jsApiList: [
                    'onMenuShareAppMessage',
                    'onMenuShareTimeline',
                ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
            });
		 wx.ready(function(){
             
                  wx.onMenuShareAppMessage({
                       title: '好友助力', // 分享标题
                       desc:"好友助力",
	                   link: '<?=$shareUrl?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	                   imgUrl: '<?=Yii::$app->params['webLink'].$goods->goods_thums?>', // 分享图标
                      success: function (res) {
                          alert('已分享');
                      },
                      cancel: function (res) {
                          alert('已取消');
                      },
                      fail: function (res) {
                          alert("分享失败");
                      }
                  });
                  //alert('已注册获取“发送给朋友”状态事件');
              	
              wx.onMenuShareTimeline({
                    title: '好友助力', // 分享标题
                    desc:"好友助力",
	                link: '<?=$shareUrl?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	                imgUrl: '<?=Yii::$app->params['webLink'].$goods->goods_thums?>', // 分享图标
                  
                  success: function (res) {
                     alert('已分享');
                  },
                  cancel: function (res) {
                     alert('已取消');
                  },
                  fail: function (res) {
                     alert("分享失败");
                  }
              });
            });	
   			
               /* wx.onMenuShareAppMessage({
                    title: 'test1', // 分享标题
                    desc: 'test1的描述', // 分享描述
                    link: 'http://www.baidu.com', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                    imgUrl: 'https://www.baidu.com/img/baidu_jgylogo3.gif', // 分享图标
                    type: 'link', // 分享类型,music、video或link，不填默认为link
                    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                        alert('分享成功');
                    // 用户确认分享后执行的回调函数
                    },
                    cancel: function () {
                        alert('分享失败');
                    // 用户取消分享后执行的回调函数
                    }
                });*/

              


            
           

          
        </script> 



 <script type="text/javascript">
        $(function () {
            //弹出隐藏层
            function ShowDiv(show_div,bg_div){
                document.getElementById(show_div).style.display='block';
                document.getElementById(bg_div).style.display='block' ;
 
                var _windowHeight = $(window).height(),//获取当前窗口高度
                        _windowWidth = $(window).width(),//获取当前窗口宽度
                        _popupHeight = $("#"+show_div).height(),//获取弹出层高度
                        _popupWeight = $("#"+show_div).width();//获取弹出层宽度
                _posiTop = (_windowHeight - _popupHeight)/2;
                _posiLeft = (_windowWidth - _popupWeight)/2;
                $("#"+show_div).css({"left": _posiLeft + "px","top":_posiTop + "px","display":"block"});//设置position
            };
            //关闭弹出层
            function CloseDiv(show_div,bg_div)
            {
                document.getElementById(show_div).style.display='none';
                document.getElementById(bg_div).style.display='none';
            };
 
          /*  $(".beijiifiveone").click(function () {
                var src = $(this).attr("src");
                $("#showcont").attr("src",src);
                ShowDiv('MyDiv','fade')
            });//--*/


          $(".tbox").click(function () {
                CloseDiv('MyDiv','fade')
            });//--
          $(".btn").click(function(){
              $(".tanchubox").show();
          });

          $(".toutotwo").click(function(){
             $(".tan-chu-box").show();
            });//--
          $(".box-close-button").click(function(){
             $(".tan-chu-box").hide();
          });
        
        });

          

  

 
    </script>