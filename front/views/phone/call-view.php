<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title ="呼叫号码";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/call.css">

<div class="back">
    <div class="mnuber"><?=$mobileNum?></div>
     <div class="pictur"> <img class="pictur-img" src="/webstatic/images/lianxiren_06.png"/></div>
      <div class="title">呼叫中，正在为您回拨
可能是陌生号码，请放心接听</div>
       <div class="call-ip" onclick="javascript:history.go(-1)"><img class="pictur-imgs" src="/webstatic/images/anniu_10.png"/></div>
</div>
<audio src="/phoneringing.mp3" autoplay="autoplay"></audio>
<script>
  $(function(){
		  
  })
</script>