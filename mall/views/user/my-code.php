<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="我的分享码";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/mySharecode.css" />



<div class="Head88 " style="padding-bottom:68px;<?=$_GET["token"]!=""?"display:none":""?>" >
  
    <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
  <span style="color:#fff; font-size:0.8rem; margin-right:1.5rem;">我的分享码</span>
   </header>  
   <header>
          <a href="gerenzhongxin.html"><div class="_lefte"><i class="iconfont icon-back "></i></div></a>
         在途收益
</header>
</div>

<div class="nav">
    <div class="nav-outer">
         <div class="nav-img">
            <div class="nav-imgleft"><img class="qq" src="<?=$headimgurl?>"/></div>
            <div class="nav-imgright">
                <div class="nav-imgrightone">全民蚂蚁</div>
                <div class="nav-imgrighttwo">我是全民蚂蚁的代言人</div>
            </div>
         </div>
         <div class="nav-erweima">
         <div class="nav-erweima-img">
         <img class="qqs" src="<?=$resQrcode?>"/>
         </div>
         <div class="nav-erweima-title">
         截屏保存二维码分享好友
         </div>
         </div>
    </div>
</div>