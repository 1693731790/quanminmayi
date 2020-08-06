<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '查询结果';
use yii\web\JSSDK;

$jsSdk=new JSSDK(Yii::$app->params['WECHAT']["app_id"],Yii::$app->params['WECHAT']["secret"]);
$wxconfig=$jsSdk->getSignPackage();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?=$this->title?></title>

<link rel="stylesheet" type="text/css" href="/afstatic/css/index.css">
<link rel="stylesheet" type="text/css" href="/afstatic/css/mshare.css">
<script type="text/javascript" src="/afstatic/js/jquery.min.js"></script>
<script type="text/javascript" src="/afstatic/js/public.js"></script>

<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
  
</head>
  
  
<body>


<!--头部-->
  
<?php if($type!="2" || $class=="1"):?>
<header > 
    <div class="security-header">
    	辨伪说明
    	<a href="javascript:;"><em></em></a>
    </div>
</header>
  <?php endif;?>
<section>
	<div class="security-z">
		<em><img src="/afstatic/images/security_z.png"></em>
		<p>您所查询的是<?=$goods->goods_name?>
属于正牌产品，请放心使用！</p>
	</div>
	<div class="security-b clearfix">
		<div class="security-b-img">
			<img src="<?=$goods->goods_thums?>">
		</div>
		<div class="security-b-txt">
			<div class="security-b-txt-m"><span>￥</span><?=$goods->price?></div>
			<div class="security-b-txt-t"><?=$goods->goods_name?></div>
          	<div class="security-b-txt-d">
            	
      	

    
          <?php if(!empty($attr)):?>
       		<?php foreach ($attr as $key => $value):?>
            <?php $value=json_decode($value);?>
         		<div>
            		<span class="sp01"><?=$value->attrkey?>：</span>
            		<span class="sp02 text-overflow"><?=$value->attrval?></span>
            	</div>
              <?php endforeach;?>    
    	  <?php endif;?> 	
            </div> 
		</div>
       
	</div>
	<div class="security-l"></div>
	<div class="security-d">
		<div class="security-d-t">
			详情
		</div>
		<?=$goods->content?>
	</div>
</section>
<footer>
	<div class="security-f">
      <?php if($goodsDetail):?>
		<button class="actionSheet" id="searchwx">我要分享</button>
      <?php endif;?>
	</div>
</footer>
<div class="m-share-mask"></div>

<script type="text/javascript">
  
	$(function(){
    	$("#searchwx").click(function(){
        	alert("请点击右上角分享");
        })
    })
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
                       title: '全民蚂蚁商城', // 分享标题
                       desc:"<?=empty($goodsDetail)?"":$goodsDetail->goods_name?>",
	                   link: '<?=empty($searchLink)?"":$searchLink?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	                   imgUrl: '<?=empty($shareImg)?"":$shareImg?>', // 分享图标
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
                      title: '全民蚂蚁商城', // 分享标题
                       desc:"<?=empty($goodsDetail)?"":$goodsDetail->goods_name?>",
	                   link: '<?=empty($searchLink)?"":$searchLink?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	                   imgUrl: '<?=empty($shareImg)?"":$shareImg?>', // 分享图标
                  
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
   			
              
            
           

          
        
</script>
  
  
</body>
</html>