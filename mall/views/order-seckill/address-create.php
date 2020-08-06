<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="添加收货地址";
?>

<div class="Web_Box">
  <div class="EditReceiptAddress">
      <ul>
        <li class="sli">
          <div class="lefticon"> <i class="iconfont icon-user2"></i></div>
          <div class="fl w550">
            <input type="text" class="inp" name="name" placeholder="填写收货人姓名">
          </div>
        </li>
        <li class="sli">
          <div class="lefticon"> <i class="iconfont icon-tel"></i></div>
          <div class="fl w550">
            <input type="tel" class="inp" name="phone"  placeholder="填写手机号码">
          </div>
        </li>
        
        <li class="sli"  style="height:auto">
          
          <div class="fl w550 areaselect" style="width:100%;">
            <select id="s_province" name="s_province">
                <option value="">请选择省</option>
                <?php foreach($region as $regionVal):?>
                <option value="<?=$regionVal->region_id?>"><?=$regionVal->region_name?></option>
                <?php endforeach;?>
            </select> 
            <select id="s_city" name="s_city" >
                <option>请选择市</option>
            </select>  
            <select id="s_county" name="s_county">
                <option>请选择县</option>
            </select>
            <select id="s_jie" name="s_jie" >
                <option>请选择街</option>
            </select>  
<script type="text/javascript">
  $(function(){
    $("#s_province").change(function(){
        var regionId=$(this).val();
        if(regionId!="")
        {
            $.get("<?=Url::to(['user/region'])?>",{"region_id":regionId},function(data){
                console.log(data);
                $("#s_city").empty();
                var str="<option value=''>请选择市</option>";
                for (var i =0;i<data.length;i++) {
                    str+="<option value='"+data[i].region_id+"'>"+data[i].region_name+"</option>"    
                }
                $("#s_city").append(str);

            },'json')
        }
    })
    $("#s_city").change(function(){
        var regionId=$(this).val();
        if(regionId!="")
        {
            $.get("<?=Url::to(['user/region'])?>",{"region_id":regionId},function(data){
               $("#s_county").empty();
                console.log(data);
                var str="<option value=''>请选择县</option>";
                for (var i =0;i<data.length;i++) {
                    str+="<option value='"+data[i].region_id+"'>"+data[i].region_name+"</option>"    
                }
                $("#s_county").append(str);

            },'json')
        }
    })
    $("#s_county").change(function(){
        var regionId=$(this).val();
        if(regionId!="")
        {
            $.get("<?=Url::to(['user/region'])?>",{"region_id":regionId},function(data){
                console.log(data);
                $("#s_jie").empty();
                var str="<option value=''>请选择街</option>";
                for (var i =0;i<data.length;i++) {
                    str+="<option value='"+data[i].region_id+"'>"+data[i].region_name+"</option>"    
                }
                $("#s_jie").append(str);

            },'json')
        }
    })
  })
</script>            
            <!-- <select id="s_province" name="s_province"></select>  
            <select id="s_city" name="s_city" ></select>  
            <select id="s_county" name="s_county"></select>
            <script type="text/javascript">_init_area();</script> -->
            
          </div>
        </li>
  
    
        <!--选择地址End-->
        <li class="sli">
          <div class="lefticon"> <i class="iconfont icon-detailedaddress"></i></div>
          <div class="fl w550">
            <input type="text" class="inp" name="address"  placeholder="填写详细地址">
          </div>
        </li>
        
        <li class="sli SetDefault">
          <div class="lefticon">
            <input type="checkbox" style="-webkit-appearance:checkbox;" id="isdefault" >
          </div>
          <div class="fl text"> 设为默认地址 </div>
        </li>
      </ul>
    </div>
    
</div>
<div class="AddProductOperation BottomGd">
  
    <button class="but_2 wauto but submit" type="button">保 存</button>

</div>
<script type="text/javascript">
  $(function(){
      $(".submit").click(function(){
          var name=$("input[name=name]").val();
          var phone=$("input[name=phone]").val();
          var address=$("input[name=address]").val();
          var isdefault=$("#isdefault").is(':checked');
          
          if(isdefault)
          {
              isdefault="1";
          }else{
              isdefault="0";
          }
          
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
                              
                      setTimeout(function(){
                          $(window.parent.document).find(".addressdiv").empty();
                          var str='<input type="hidden" name="address_id" value="'+r.message.aid+'"><p class="text1"> <span class="name fl">收货人：'+r.message.name+' </span> <span class="tel fl">'+r.message.phone+'</span> </p><div class="Address-con"><span class="default fl" style="margin-top: 5px;">[默认地址]</span><div class="Address slh2">'+r.message.region+' &nbsp;&nbsp;'+r.message.address+'</div></div>';
                          //console.log(str);
                          $(window.parent.document).find(".addressdiv").append(str);
                          parent.layer.closeAll();  
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
