<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="店铺收藏";
?>

    <link rel="stylesheet" type="text/css" href="/webstatic/css/guanzhudianpu.css">
    <link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />

<header>
          <a href="javascript:;" onclick="javascript:history.go(-1)"><div class="_lefte"><i class="iconfont icon-back "></i></div></a>
          关注的店铺
</header>

<?php foreach($model as $key=>$val):?>
  <a href="<?=Url::to(['shops/shop-info',"shop_id"=>$val['shop_id']])?>">
  <div class="outer">
    <div class="outerone">
      <img class="cen" src="<?=Yii::$app->params["imgurl"].$val->shops->img?>"/>
    </div>
    <div class="outertwo">
      <span class="name"><?=$val->shops->name?></span>
    </div>
    <div class="outerthree" onclick="fdelete(<?=$val->shops_favorite_id?>,this)">取消关注</div>
  </div>
   </a>
<?php endforeach;?>



<script>
function fdelete(id,obj){
  $.get("<?=Url::to(['favorite/shops-favorite-delete'])?>",{"shops_favorite_id":id},function(r){
      layer.msg(r.message);
      if(r.success)
      {
          $(obj).parent().remove();
      }
  },'json')
}


var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['favorite/shops-favorite-list'])?>",{"page":page},function(da){
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