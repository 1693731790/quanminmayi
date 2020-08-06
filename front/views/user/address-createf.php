<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="添加收货地址";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/area.css"/>
<style type="text/css">
  .areaselect select{height:25px;}
</style>
<?php if(empty($_GET["token"])):?>
<div class="Head88 " style="padding-bottom:68px;">
   <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff">收货地址</h2>
  </header>
</div>
<?php endif;?>
<div class="Web_Box">

  <div class="tan-chu-box">
  <div style="width:100%;height: 100%;background: #fff;">
  

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
        <article id="areaBox" >
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
  <div class="ui-form-item ui-border-b">
    <label>设为默认地址</label>
    <div class="ui-select" style="margin-left:0px; ">
       <input type="checkbox" style="min-height:0px;" id="isdefault" >
    </div>
  </div>
  
  <div class="buttom" id="submit">确定</div>
  </div>
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
<script type="text/javascript">
  $(function(){
      $("#submit").click(function(){
         
          var name=$("input[name=name]").val();
          var phone=$("input[name=phone]").val();
          var address=$("input[name=address]").val();
                   
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
            
          var isdefault=$("#isdefault").is(':checked');
          
          if(isdefault)
          {
              isdefault="1";
          }else{
              isdefault="0";
          }
          

          if(check)
          {
              $.get("<?=Url::to(['user/address-createf'])?>",{"name":name,"address":address,"phone":phone,'region':region,"region_id":region_id,"isdefault":isdefault},function(r){
                  if(r.success)
                  {              
                      layer.msg("添加成功");        
                      setTimeout(function(){
                          //console.log(str);
                         window.location.href="<?=Url::to(['user/address-list'])?>";
                      },1000);
                      
                      
                  }else{
                      layer.msg("添加失败");
                  }
              },'json')
          }
          //alert(province+"---"+city+"---"+county);
      })
  })
</script>
