<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = "购买商品";



?>
<style type="text/css">
   .jq_uploads_img{height: auto;px;width:100%;border:#ccc 1px solid;margin-bottom: 10px;}
</style>
 
<div class="app" >
<div class="row">
   <div class="col-md-6">
    <div class="panel panel-info">
      <!-- Default panel contents -->
      <div class="panel-heading">商品详情</div>
      <div class="panel-body">
        <table class="table table-bordered">

        
        <tr>
            <th>商品标题图片</th>
            <td colspan="3">
                <img src="<?=$afGoods->goods_thums?>" style="width:150;height: 100px;">
            </td>
            
        </tr>
   
       
        <tr>
            <th>商品名称</th>
            <td colspan="3"><?=$afGoods->goods_name?></td>
            
        </tr> 
       
         <tr>
          
            <th>价格</th><td><?=$afGoods->price?></td>
        </tr>
       
        <tr>
          
            <th>收货人姓名</th><td><input id="address_name" name="address_name" type="text" /></td>
        </tr>
          <tr>
          
            <th>收货人手机号</th><td><input id="address_phone" name="address_phone" type="text" /></td>
        </tr>
          
           <tr>
          
            <th>收货人地区</th><td>
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
             
             </td>
        </tr>
 <script type="text/javascript">
  $(function(){
    $("#s_province").change(function(){
        var regionId=$(this).val();
        if(regionId!="")
        {
            $.get("<?=Url::to(['order/region'])?>",{"region_id":regionId},function(data){
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
            $.get("<?=Url::to(['order/region'])?>",{"region_id":regionId},function(data){
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
            $.get("<?=Url::to(['order/region'])?>",{"region_id":regionId},function(data){
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
          <tr>
          
            <th>收货人详细地址</th><td><input style="width:300px;" id="address_address" name="address_address" type="text" /></td>
        </tr>
          
          <tr>
          
            <th>备注</th><td><input style="width:300px;" id="remarks" name="remarks" type="text" /></td>
        </tr>
       
        
           
        
       
      </table>
        
        <div>
          购买数量
          <span id="reduce" style="width:30px;height:30px;border:1px solid #ddd; border-radius:100%; text-align:center; line-height:30px;font-size:22px; color:#333;display:inline-block;cursor:pointer;">-</span>
          <input id="num"  name="num" readonly="readonly" type="text" value="1" style="width:50px;height:30px ; line-height:30px;font-size:20px;text-align: center;border: none; color:#848181" >
          <span id="plus" style="width:30px;height:30px;border:1px solid #ddd; border-radius:100%; text-align:center; line-height:30px;font-size:22px; color:#333;display:inline-block;cursor:pointer;">+</span>
        </div>
        
        <div style="margin-top:30px;">
          总价：<span id="countPrice" style="color:red;"><?=$afGoods->price?></span>
        </div>
      </div>
      
     
    </div>
    
<script>
	$(function(){
       var priceOne="<?=$afGoods->price?>";
    	$("#reduce").click(function(){
        	var num=$("#num").val();
            if(num>1)
            {
             	 $("#num").val(Math.abs(parseInt(num))-1);
                 var price=parseFloat(num-1)*parseFloat(priceOne);
            }else{
             	 var price=parseFloat(num)*parseFloat(priceOne); 
            }
            $("#countPrice").text(price.toFixed(2));
          	
        })
        $("#plus").click(function(){
        	var num=$("#num").val();
            $("#num").val(Math.abs(parseInt(num))+1);
            var price=parseFloat($("#countPrice").text())+parseFloat(priceOne); 
            $("#countPrice").text(price.toFixed(2));
           
        })
    })  
  
</script>

   </div>

 <div class="col-md-6">
    <div class="panel panel-info">
      <!-- Default panel contents -->
      <div class="panel-heading">商品相册</div>
      <div class="panel-body">
       
        <div class="jq_uploads_img" >
           <?php if($afGoods->goods_img):?>
              <?php for($i=0;$i<count($afGoods->goods_img);$i++):?>
                <span style="width: 150px; height: 100px;float: left; margin-left: 5px; margin-top: 10px;">  <img width="80" height="80" src="<?=$afGoods->goods_img[$i]?>">  </span>
               <?php endfor;?>                
            <?php endif;?>
        </div>
         
      </div>
    </div>
    


   </div>
  
  
  
</div>
 <div class="col-md-6">
     <div class="btn btn-warning marr5" id="submitOrder">提交订单</div>
	</div>     

</div>

<script>
  $(function(){
  		$("#submitOrder").click(function(){
           var address_name=$("#address_name").val();
           var address_phone=$("#address_phone").val();
           var address_address=$("#address_address").val();
           var remarks=$("#remarks").val();
          
           var num=$("#num").val();
           var check=true;       
           var province=$("#s_province option:selected").text(); 
           var city=$("#s_city option:selected").text(); 
           var county=$("#s_county option:selected").text(); 
           var province_id=$("#s_province option:selected").val(); 
           var city_id=$("#s_city option:selected").val(); 
           var county_id=$("#s_county option:selected").val(); 
           var jie_id=$("#s_jie option:selected").val(); 
           var region=province+"-"+city+"-"+county;
           var region_id=province_id+"-"+city_id+"-"+county_id+"-"+jie_id;
          if(address_name=="")
          {
              layer.msg("收货人姓名不能为空");
              check=false;
          }
          if(address_address=="")
          {
              layer.msg("收地址详情不能为空");
              check=false;
          }
          if(address_phone=="")
          {
              layer.msg("收货人电话不能为空");
              check=false;
          }
		  var jie_num=$("#s_jie").find("option").length; 
          //layer.msg(jie_id);
          if(jie_num>1&&jie_id=="")
          {
              layer.msg("请选择街道");
              check=false;
          }
          if(check)
          {
              $.get("<?=Url::to(['order/create'])?>",{"address_name":address_name,"address_address":address_address,"remarks":remarks,"address_phone":address_phone,'region':region,"region_id":region_id,"num":num,"goods_id":"<?=$afGoods->goods_id?>"},function(r){
                  layer.msg(r.message);
                  if(r.success)
                  {              
                      setTimeout(function(){
                          window.location.href="<?=Url::to(['order/pay'])?>"+"?order_id="+r.id;
                      },2000);
                      
                  }
              },'json')
          }
            
            
        })
  })
</script>
