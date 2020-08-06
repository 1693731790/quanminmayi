<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title ="提交订单";
?>
<style type="text/css">
.ConsigneeInfo .text1 .tel {width: 7.375rem;padding-left: 30px;}
</style>
    <link rel="stylesheet" type="text/css" href="/webstatic/css/mianfeina.css">
    <link rel="stylesheet" type="text/css" href="/webstatic/css/area.css"/>
   

<div class="Web_Box">
  <div class="ConfirmationOrder">
    
      <?php if(!empty($address)):?>
      <div class="ConsigneeInfo addressdiv" onclick="showAddress()">
      <input type="hidden" name="address_id" value="<?=$address->aid?>">
      <p class="text1"> <span class="name fl">收货人：<?=$address->name?> </span> <span class="tel fl"><?=$address->phone?></span> </p>
      <div class="Address-con" >
        <span class="default fl" style="margin-top: 5px;">[默认地址]</span><div class="Address slh2"><?=$address->region?> &nbsp;&nbsp;<?=$address->address?></div>
      </div>
      </div>
      <?php else:?>
        <div class="ConsigneeInfo addressdiv" >
        <div class="Address-con">
          <span class="default fl">[收货地址]</span>
          <div class="Address slh2">
            <span onclick="address()" style="display:inline-block;height: 30px;line-height:30px;text-align:center;font-size: 14px; width:85px;color: #FFF;background: #fd6847;border: 0;border-radius:5px;">填写地址</span>
          </div>
        </div>
        </div>
      <?php endif;?>
    
    <div class="ShopGoods EditPro bg_f5f5f5 hidden bor_b_dcdddd mt15">
      <div class="ProList bg_f5f5f5">
        <ul>
          <li>
            <div class="Pic"><img src="<?=Yii::$app->params['imgurl'].$goods->goods_thums?>" alt=""/></div>
            <div class="Con">
              
              <div class="pl20">
                <h2 class="slh2"><?=$goods->goods_name?></h2>
                
              </div>
              <div class="pl20">
                <h2 class="slh2"><?=$goods->desc?></h2>
              </div>
            </div>
          </li>
          
        </ul>
      </div>
    </div>
  </div>
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
      <?php foreach($addressList as $addressVal):?>
        <div class="outname" onclick="selectAddress(<?=$addressVal->aid?>,'<?=$addressVal->name?>','<?=$addressVal->phone?>','<?=$addressVal->region?>','<?=$addressVal->address?>')">
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
  <div style="width:100%;height: 100%;background: #fff;">
  <div class="hes">
    <i class="iconfont icon-leftdot" id="tan_chu_box_hide" style="color:#fff;float: left;margin-left: 1rem;"></i>
            
            添加收货地址
  </div> 

  <div class="ui-form-item ui-border-b">
    <label>收货人</label>
    <div class="ui-select">
      <input id="expressArea12" data-name="custRa"  placeholder="姓名" name="name" style="padding-left:0;">
    </div>
  </div>

  <div class="ui-form-item ui-border-b">
    <label>联系电话</label>
    <div class="ui-select">
      <input id="expressArea12" data-name="custRa"  placeholder="电话"  name="phone" style="padding-left:0;">
    </div>
  </div>
  <div class="ui-form-item ui-border-b">
    <label>所在地区</label>
    <div class="ui-select">
      <input id="expressArea" data-name="custUa" data-required="true" data-label="单位地址" placeholder="选择省市区" name="address_name" readonly style="padding-left:0;">
      <input type="hidden" name="address_name_province">
      <input type="hidden" name="address_name_city">
      <input type="hidden" name="address_name_county">
      <input type="hidden" name="address_name_jie" >
      
      <input type="hidden" name="address_region">
      <input type="hidden" name="address_region_province">
      <input type="hidden" name="address_region_city">
      <input type="hidden" name="address_region_county">
      <input type="hidden" name="address_region_jie" >
      <input type="hidden" name="address_ok" value="0">
    </div>
    <div class="browser">

      <!-- 选择地区弹层 -->
      <section id="areaLayer" class="express-area-box">
        <header>
          <h3 style="color:#4d525d">选择省市区</h3>
          <div class="selet-area-wrap">
            <p style="color:#4d525d;font-size: 20px;" class="one" id="area_province"></p>
            <p style="color:#4d525d;font-size: 20px;" class="two" id="area_city"></p>
            <p style="color:#4d525d;font-size: 20px;" class="three" id="area_county"></p>
          </div>
          
        </header>
        <article id="areaBox" style="margin-top: 2rem">
          <ul id="areaList" class="area-list">
           <?php foreach($region as $regionVal):?>
                      <li onclick="showAreaList(<?=$regionVal->region_id?>,'<?=$regionVal->region_name?>','<?=$regionVal->level?>')"><?=$regionVal->region_name?></li>
                 <?php endforeach;?>
          
          </ul>
          
        </article>
      </section>
      <!-- 遮罩层 -->
      <div id="areaMask" class="mask"></div>
    </div>
  </div> 
  
  <div class="ui-form-item ui-border-b">
    <label>详细地址</label>
    <div class="ui-select">
      <input id="expressArea12" data-name="custRa"  name="address" placeholder="请填写详细地址楼栋层" style="padding-left:0;">
    </div>
  </div>
  <div class="buttom" id="addressSunmit">确定</div>
  </div>
</div>

<script>

function showAreaList(regionId,regionName,level)
{
  $.get("<?=Url::to(['user/region'])?>",{"region_id":regionId},function(data){
            console.log(data);
            $("input[name=address_region_jie]").val("");
            $("input[name=address_name_jie]").val("");  
            $("input[name=address_name]").val("");  
            
            $("input[name=address_ok]").val("0");
            var area_html="<span style='color: #1590ce;border-bottom: solid 2px #1590ce;' onclick='showAreaList("+regionId+",\""+regionName+"\",\""+level+"\")'>"+regionName+"</span>";
            if(level=="1")
            {
              $("#area_province").html(area_html);
              $("#area_city").html("");
              $("#area_county").html("");

              $("input[name=address_region_province]").val(regionId); 

              $("input[name=address_name_province]").val(regionName); 

            }else if(level=="2"){
              $("#area_province span").attr('style','color:none;border-bottom:none');
              $("#area_city").html(area_html);
              $("#area_county").html("");

              $("input[name=address_region_city]").val(regionId);
              $("input[name=address_name_city]").val(regionName); 
            }else if(level=="3"){
              $("#area_province span").attr('style','color:none;border-bottom:none');
              $("#area_city span").attr('style','color:none;border-bottom:none');
              $("#area_county").html(area_html);

              $("input[name=address_region_county]").val(regionId);
              $("input[name=address_name_county]").val(regionName); 
            }else{
              $("input[name=address_region_jie]").val(regionId);
              $("input[name=address_name_jie]").val(regionName);  
            }

            
            if(data.length>0)
            {
              $("#areaList").empty();
              var str="";
              for (var i =0;i<data.length;i++) {
                  str+='<li onclick="showAreaList('+data[i].region_id+',\''+data[i].region_name+'\',\''+data[i].level+'\')">'+data[i].region_name+'</li>';
              }
              $("#areaList").append(str);
            }else{
            
        var address_name_province=$("input[name=address_name_province]").val();
        var address_name_city=$("input[name=address_name_city]").val();
        var address_name_county=$("input[name=address_name_county]").val();
        var address_name_jie=$("input[name=address_name_jie]").val();
        var address_name=address_name_province+"-"+address_name_city+"-"+address_name_county;
        if(address_name_jie!="")
        {
          address_name=address_name+"-"+address_name_jie;
        }

        var address_region_province=$("input[name=address_region_province]").val();
        var address_region_city=$("input[name=address_region_city]").val();
        var address_region_county=$("input[name=address_region_county]").val();
        var address_region_jie=$("input[name=address_region_jie]").val();
        var address_region=address_region_province+"-"+address_region_city+"-"+address_region_county;
        if(address_region_jie!="")
        {
          address_region=address_region+"-"+address_region_jie;
        }
        $("input[name=address_region]").val(address_region);
              $("input[name=address_name]").val(address_name);
              

              $("input[name=address_ok]").val(1); 
              $("#areaMask").fadeOut();
        $("#areaLayer").animate({"bottom": "-100%"});

        //$('.selet-area-wrap .one,.selet-area-wrap .two').html("").removeClass("current");
            }
            
    },'json')
}


/*打开省市区选项*/
$("#expressArea").click(function() {
  $("#areaMask").fadeIn();
  $("#areaLayer").animate({"bottom": 0}).attr("flag","0");
  $("#area_province").html("");
  $("#area_city").html("");
  $("#area_county").html("");
  $.get("<?=Url::to(['user/region'])?>",{"region_id":0},function(data){
    $("#areaList").empty();
        var str="";
        for (var i =0;i<data.length;i++) {
            str+='<li onclick="showAreaList('+data[i].region_id+',\''+data[i].region_name+'\',\''+data[i].level+'\')">'+data[i].region_name+'</li>';
        }
        $("#areaList").append(str);
  },'json')
});

/*关闭省市区选项*/
$("#areaMask, #closeArea").click(function() {
  $("#areaMask").fadeOut();
  $("#areaLayer").animate({"bottom": "-100%"});
  
  $('.selet-area-wrap .one,.selet-area-wrap .two').html("").removeClass("current");
});
  
</script>

  

<div id="fade" class="black_over"></div>

<script type="text/javascript">
  function selectAddress(aid,name,phone,region,address){

       $(".addressdiv").empty();
        var str='<input type="hidden" name="address_id" value="'+aid+'"><p class="text1"> <span class="name fl">收货人：'+name+' </span> <span class="tel fl">'+phone+'</span> </p><div class="Address-con"><span class="default fl" style="margin-top: 5px;">[默认地址]</span><div class="Address slh2">'+region+' &nbsp;&nbsp;'+address+'</div></div>';
                         //console.log(str);
        $(".addressdiv").append(str);
         CloseDiv('MyDiv','fade')

  }
  function showAddress()
  {
      ShowDiv('MyDiv','fade');
      
  }
  $(function () {

    $("#tan_chu_box_hide").click(function(){
      $(".tan-chu-box").hide();
      ShowDiv('MyDiv','fade');
    })

    $("#addressSunmit").click(function(){
          var name=$("input[name=name]").val();
          var phone=$("input[name=phone]").val();
          var address=$("input[name=address]").val();
          var isdefault=0;
          var check=true;
           var region=$("input[name=address_name]").val();

          var region_id=$("input[name=address_region]").val();
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
          var address_ok=$("input[name=address_ok]").val(); 
          if(address_ok!=1)
          {
              layer.msg("地区请填写完整");
              check=false;
          }
          if(check)
          {
              $.get("<?=Url::to(['user/address-create'])?>",{"name":name,"address":address,"phone":phone,'region':region,"region_id":region_id,"isdefault":isdefault},function(r){
                  if(r.success)
                  {              
                      layer.msg("添加成功");        
                      //console.log(r);
                      var str='<div class="outname" onclick="selectAddress('+r.message.aid+',\''+r.message.name+'\',\''+r.message.phone+'\',\''+r.message.region+'\',\''+r.message.address+'\')"><div class="outleft"><div class="outleftname">'+r.message.name+',&nbsp&nbsp<span class="outleftiphone">'+r.message.phone+'</span></div><div class="outleftaddress">'+r.message.address+'</div></div></div>';
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
        document.getElementById(bg_div).style.display='block';

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




<div class="BottomGd" style="z-index:999999">
    <button class="but_2 wauto bg_898989" id="formsubmit" type="button">确定</button>
</div>
<script type="text/javascript">

  function address()
  {
       $(".tan-chu-box").show();
  }
  $(function(){
      $("#formsubmit").click(function(){
          var aid=$("input[name=address_id]").val();
          if(!aid)
          {
              layer.msg("请填写收货地址");
              return false;
          }

          window.location.href="<?=Url::to(['order-free-take/order-create'])?>"+"?goods_id=<?=$goods->goods_id?>&aid="+aid;
          
      })
  })
</script>

<!--右侧导航Start-->
<div class="rightnav">
  <ul>
    
    <li><i class="iconfont icon-back" onClick="javascript :history.back(-1);"></i></li>
  </ul>
</div>