<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title ="提交订单";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/mianfeina.css">
<form id="orderform" action="<?=Url::to(['shopcar/confirm-add-order-all'])?>" method="post">
<div class="Web_Box">
  <div class="ConfirmationOrder">
    
      <?php if(!empty($address)):?>
      <div class="ConsigneeInfo addressdiv" onclick="showAddress()">
      <input type="hidden" name="address_id" value="<?=$address->aid?>">
      <p class="text1"> <span class="name fl">收货人：<?=$address->name?> </span> <span class="tel fl"><?=$address->phone?></span> </p>
      <div class="Address-con">
        <span class="default fl" style="margin-top: 5px;">[默认地址]</span><div class="Address slh2"><?=$address->region?> &nbsp;&nbsp;<?=$address->address?></div>
      </div>
      <?php else:?>
        <div class="ConsigneeInfo addressdiv">
        <div class="Address-con">
          <span class="default fl">[收货地址]</span>
          <div class="Address slh2">
            <span onclick="address()" style="display:inline-block;height: 30px;line-height:30px;text-align:center;font-size: 14px; width:85px;color: #FFF;background: #fd6847;border: 0;border-radius:5px;">填写地址</span>
          </div>
        </div>
      <?php endif;?>
      
    </div>

<?php foreach($shopcar as $key=>$val):?>

    <div class="ShopGoods EditPro bg_f5f5f5 hidden bor_b_dcdddd mt15">
      <div class="Tit">
        <div class="ShopName"><span class="Name"><a href="<?=Url::to(['shops/shop-info','shop_id'=>$val['shop']['shop_id']])?>"><?=$val['shop']['name']?></a></span><i class="iconfont icon-franchisedstore"></i><i class="iconfont icon-rightdot"></i></div>
      </div>
      <div class="ProList bg_f5f5f5">
        <ul>
         <?php $countprice=0; ?>
          <?php foreach($val['shop']['data'] as $goodskey=>$goodsval):?>
          <li>
            <div class="Pic"><img src="<?=Yii::$app->params['imgurl'].$goodsval['goods_thums']?>" alt=""/></div>
            <div class="Con">
              
              <div class="pl20">
                <h2 class="slh2"><?=$goodsval['goods_name']?></h2>
                <?php if($goodsval['sku']!=""):?>
                <p class="Attribute"><?=$goodsval['sku']['sku_name']?></p>
                
                <?php endif;?>
                
                <p class="PriceQuantity"><span class="fl cr_f84e37">￥<?=$goodsval['sku']!=""?$goodsval['sku']['price']:$goodsval['price']?></span><span class="fr cr_282828">×<?=$goodsval['goodsnum']?></span></p>
              </div>
            </div>
          </li>
          <input type="hidden" name="data[<?=$key?>][goods][<?=$goodskey?>][goods_id]" value="<?=$goodsval['goods_id']?>">
          <input type="hidden" name="data[<?=$key?>][goods][<?=$goodskey?>][skuid]" value="<?=$goodsval['sku']['sku_id']?>">
          <input type="hidden" name="data[<?=$key?>][goods][<?=$goodskey?>][num]" value="<?=$goodsval['goodsnum']?>">
          <input type="hidden" name="data[<?=$key?>][goods][<?=$goodskey?>][shopcar_id]" value="<?=$goodsval['shopcar_id']?>">
          <?php 

          $oneprice=$goodsval['sku']!=""?$goodsval['sku']['price']:$goodsval['price'];
          $countprice+=round($oneprice*$goodsval['goodsnum'],2);    
          ?>
          <?php endforeach; ?>
          
        </ul>
      </div>
    </div>

    
    <input type="hidden" name="data[<?=$key?>][shop_id]" value="<?=$val['shop']['shop_id']?>">
    
   
    <div class="OtherInfo bg_fff mt20">
      <ul>
          
        
        <li>
          <div class="tit">买家留言：</div>
          <div class="LeaveMessage">
            <input type="text" name="data[<?=$key?>][remarks]" placeholder="选填,可填写您和卖家达成一致的要求">
          </div>
        </li>
        <li class="Total"> 合计：<span class="cr_fd6847">￥
          <?=number_format($countprice,2)?></span> </li>
      </ul>
    </div>

<?php endforeach; ?>


    <div class="OtherInfo bg_fff mt20">
      <ul>
          <li>
              <div class="tit">配送费用</div>
              <div class="freight" style="font-size: -0.4rem;"><!--line-height: 0.6rem;float:none;padding-top:10px;-->
                平台根据不同地区计算运费

              </div>
             
            </li>
         
            <li>
              <div class="tit">配送方式</div>
              <div class="freight">快递 <?=$yunfeiFee=="0"?'免邮':$yunfeiFee?>元</div>
              <i class="iconfont icon-rightdot2"></i> 
            </li>
        

        <?php if(!empty($telFeeDeductions)):?>  
        <li>
          <div class="tit">话费抵扣：</div>
          <div class="LeaveMessage">
            <div style="color:red;font-size: 0.6rem;height: 2.325rem;line-height: 2.325rem;width:30%; float: left;">
                ￥<?=number_format($telFeeDeductions,2)?>  
            </div>
            <div style="color:red;height: 2.325rem;line-height: 2.8rem;width:20%; float: left;">
                <input type="checkbox" name="telFeeDeductions" checked="checked" value="1"  style="height: 1rem;width:1rem;" onclick="telFeeCheck(this)">
            </div>
            <div style="color:red;height: 2.325rem;line-height: 2.325rem;width:50%; float: left;">
                 已减免 <?=number_format($telFeeDeductions,2)?>  
            </div>
            

          </div>
        </li>
       <?php endif;?>
      </ul>
    </div>
     



  </div>
</div>
</form>
<div class="BottomGd">
    <button class="but_2 wauto bg_898989" id="formsubmit" type="button">确定</button>
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
    <div class="outerthreetwo"><input id="shop-input" type="text" placeholder="详细地址" name="address" /></div>

    <div class="box-close-button" id="addressSunmit">保存</div>

  </div>
</div>

  
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
          var jie_num=$("#s_jie").find("option").length; 
          //layer.msg(jie_id);
          if(jie_num>1&&jie_id=="")
          {
              layer.msg("请选择街道");
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



<script type="text/javascript">
    <?php if(!empty($telFeeDeductions)):?> 
  function telFeeCheck(obj)
  {

       if($(obj).is(":checked"))
       {

          var countFee=parseFloat($("#countFee").text());
          var telFeeDeductions=parseFloat("<?=$telFeeDeductions?>");
//          alert(countFee-couponFee);
          $("#countFee").text(countFee-telFeeDeductions);
          $(obj).parent().next().text("已减免 <?=$telFeeDeductions?> 元 ");
       }else{
          var countFee=parseFloat($("#countFee").text());
          var telFeeDeductions=parseFloat("<?=$telFeeDeductions?>");
          $("#countFee").text(countFee+telFeeDeductions);
          $(obj).parent().next().text("");
       }
  }
  <?php endif;?>
  function address()
  {
      /*layer.open({
        type: 2,
        title: '添加收货地址',
        shadeClose: true,
        shade: 0.8,
        area: ['90%', '90%'],
        content: '<?=Url::to(["user/address-create"])?>' //iframe的url
      }); */
      $(".tan-chu-box").show();
  }
  $(function(){
      $("#formsubmit").click(function(){
          if(!$("input[name=address_id]").val())
          {
              layer.msg("请填写收货地址");
              return false;
          }
          $.get("<?=Url::to(["shopcar/get-new-stock-by-id"])?>",$("#orderform").serialize(),function(r){
                if(r.success==false)
                {
                    layer.msg(r.message);
                }else{
                    $("#orderform").submit();
                }
            },'json')
          
      })
  })
</script>
<!--右侧导航Start-->
<div class="rightnav">
  <ul>
    
    <li><i class="iconfont icon-back" onClick="javascript :history.back(-1);"></i></li>
  </ul>
</div>