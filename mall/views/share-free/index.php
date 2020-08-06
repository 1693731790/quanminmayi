<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '免费拿';
?>

    <link rel="stylesheet" type="text/css" href="/webstatic/css/mianfeina.css">
    <link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />

<header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/><!-- <i class="iconfont icon-back is"></i> --></div></a>
</header>

<div class="header"><img class="shop-search" src="/webstatic/images/bjcolor_01.jpg"/></div>
<div id="list_box">
<?php foreach($goods as $key=>$val):?>
    <a href="<?=Url::to(["share-free/detail","goods_id"=>$val->goods_id])?>">
<div class="centers">
  <div class="centerone"><img class="centertwos" src="<?=$val->goods_thums?>"/></div>
  <div class="centertwo">
    <div class="centertwoone"><?=$val->goods_name?></div>
    <div class="centertwotwo">需<?=$val->user_num?>人助力</div>
    <div class="centertwothree">
      <div class="centertwothrees"><?=$val->salecount?>人已免费拿</div>
      <div class="centertwothreea" >免费获得</div>
    </div>
  </div>
</div>
</a>
<?php endforeach;?>
<input type="hidden" id="order_goods_id" >
<div id="fade" class="black_over">
</div>
<!--弹出层的内容-->
<div id="MyDiv" class="white_content" >
  <div class="out">
      <div class="outaddress">
        <div class="outtitle">
          <span class="address">选择收货地址</span>
        </div>
        <div class="outclose"><img class="shop-so" src="/webstatic/images/c-lose.png"/></div>
      </div>
      <div id="address_list">
      <?php foreach($address as $addressVal):?>
        <div class="outname" onclick="addorder(<?=$addressVal->aid?>)">
          <div class="outleft">
            <div class="outleftname">
              <?=$addressVal->name?>,&nbsp&nbsp
              <span class="outleftiphone"><?=$addressVal->phone?></span>
            </div>
            <div class="outleftaddress"><?=$addressVal->address?></div>
          </div>
          <!-- <div class="outright">></div> -->
        </div>
      <?php endforeach;?>
     </div>


      <div class="outnames">
        <div class="outlefts">+&nbsp&nbsp添加收货地址</div>
        <!-- <div class="outrights">></div> -->
      </div>
   </div>
</div>


<div class="tan-chu-box">
  <div class="tanchuboxone">
  
    <div class="outaddress">
      <div class="outtitle">
        <span class="addresss">选择收货地址</span>
      </div>
       <div class="outcloses"><img class="shop-so" src="/webstatic/images/c-lose.png"/></div> 
    </div>

    <div class="outerthreetwo"><input id="shop-input" type="text" placeholder="姓名" name="name"  /></div>
    <div class="outerthreetwo"><input id="shop-input" type="text" placeholder="电话" name="phone" /></div>
    <div class="outerthreetwo">
        <select id="s_province" name="s_province" style="width:45%;float:left;">
            <option value="">请选择省</option>
            <?php foreach($region as $regionVal):?>
            <option value="<?=$regionVal->region_id?>"><?=$regionVal->region_name?></option>
            <?php endforeach;?>
        </select> 
        <select id="s_city" name="s_city" style="width:45%;float: right;margin-right: 5px;">
            <option>请选择市</option>
        </select>  
        <select id="s_county" name="s_county" style="width:45%;float:left;">
            <option>请选择县</option>
        </select>
        <select id="s_jie" name="s_jie" style="width:45%;float: right;margin-right: 5px;">
            <option>请选择街</option>
        </select>  

    </div>
    <div class="outerthreetwo"><input id="shop-input" type="text" placeholder="详细地址" name="address" /></div>

    <div class="box-close-button" id="addressSunmit">保存</div>

  </div>
</div>
</div>
  <div class="bobbom-btn"><a href="javascript:;"> <div class="bobbom-left">免费拿频道</div></a><a href="<?=Url::to(["order-free-take/index"])?>"> <div class="bobbom-right">我的免单</div></a></div>


<script type="text/javascript">
  function addorder(aid){
      var order_goods_id=$("#order_goods_id").val();
      window.location.href="<?=Url::to(["order-free-take/order-create"])?>?goods_id="+order_goods_id+"&aid="+aid;
  }
  function showAddress(goods_id)
  {
      ShowDiv('MyDiv','fade');
      $("#order_goods_id").val(goods_id);
  }
  $(function () {
    $("#addressSunmit").click(function(){
          var name=$("input[name=name]").val();
          var phone=$("input[name=phone]").val();
          var address=$("input[name=address]").val();
          var isdefault=0;
          
          var province=$("#s_province option:selected").text(); 
          var city=$("#s_city option:selected").text(); 
          var county=$("#s_county option:selected").text(); 
          var province_id=$("#s_province option:selected").val(); 
          var city_id=$("#s_city option:selected").val(); 
          var county_id=$("#s_county option:selected").val(); 
          var jie_id=$("#s_jie option:selected").val(); 
          var check=true;
          var region=province+"-"+city+"-"+county;
          var region_id=province_id+"-"+city_id+"-"+county_id+"-"+jie_id;
          if(name=="")
          {
              layer.msg("收货人姓名不能为空");
              check=false;
          }
          if(address=="")
          {
              layer.msg("收地址详情不能为空");
              check=false;
          }
          if(phone=="")
          {
              layer.msg("收货人电话不能为空");
              check=false;
          }

          if(check)
          {
              $.get("<?=Url::to(['user/address-create'])?>",{"name":name,"address":address,"phone":phone,'region':region,"region_id":region_id,"isdefault":isdefault},function(r){
                  if(r.success)
                  {              
                      layer.msg("添加成功");        
                      //console.log(r);
                      var str='<div class="outname" onclick="addorder('+r.message.aid+')"><div class="outleft"><div class="outleftname">'+r.message.name+',&nbsp&nbsp<span class="outleftiphone">'+r.message.phone+'</span></div><div class="outleftaddress">'+r.message.address+'</div></div><div class="outright">></div></div>';
                      $("#address_list").append(str);
                      $(".tan-chu-box").hide();
                       ShowDiv('MyDiv','fade');
                  }else{
                      layer.msg("添加失败");
                  }
              },'json')
          }
          //alert(province+"---"+city+"---"+county);
      })
$(".bobbom-left").click(function () {
$(".bobbom-left").css("color", "#fc3b3e"); 
})

$(".bobbom-right").click(function () {
$(".bobbom-right").css("color", "#fc3b3e"); 
})

    $(".outclose").click(function () {
        CloseDiv('MyDiv','fade')
    });

    $(".outlefts").click(function(){
        $(".tan-chu-box").show();
        CloseDiv('MyDiv','fade')
    });

    $(".outcloses").click(function(){
        $(".tan-chu-box").hide();
    });
    
  
  });
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

   

 
</script>


<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['share-free/list'])?>",{"page":page},function(da){
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

/*$(".bobbom-btn").click(function(){

$(".bobbom-btn").toggleClass(".bobbom-lefts");

})
$(".bobbom-right").click(function(){

$(".bobbom-right").toggleClass(".bobbom-lefts");

$(".bobbom-right").siblings().removeClass(".bobbom-lefts");

})*/
</script>
