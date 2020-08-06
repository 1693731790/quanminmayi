<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '扫一扫';
use yii\web\JSSDK;
$class=new JSSDK(Yii::$app->params['WECHAT']["app_id"],Yii::$app->params['WECHAT']["secret"]);
$wxconfig=$class->getSignPackage();
?>

<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>


<script>
  
  wx.config({
    debug: false,
    appId: '<?php echo $wxconfig["appId"];?>',
    timestamp: <?php echo $wxconfig["timeStamp"];?>,
    nonceStr: '<?php echo $wxconfig["nonceStr"];?>',
    signature: '<?php echo $wxconfig["signature"];?>',
    jsApiList: [
         'scanQRCode'// 微信扫一扫接口
      // 所有要调用的 API 都要加到这个列表中
    ]
  });
  wx.ready(function () {
    // 在这里调用 API
    wx.scanQRCode({
      needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
      scanType: ["qrCode"], // 可以指定扫二维码还是一维码，默认二者都有
      success: function (res) {
        var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
        var url="<?=Url::to(["af-code/af-code-show"])?>"+"?number="+result+"&type=1"+"&nickname=<?=$result->nickname?>&province=<?=$result->province?>";
        //alert(url);
        window.location.href=url;
      }
    });
  });
</script>