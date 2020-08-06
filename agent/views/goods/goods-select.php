<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="商品列表";
?>

<link href="/static/agent_goods_select.css" rel="stylesheet">
<div class="PopBg disn" id="PopBg"></div>
<style type="text/css">
  
  .jiajian{display:inline-block;height:20px;width:20px;cursor:pointer;border: 1px solid #ccc;border-radius:5px;text-align: center;}
  .AttributeSelectionPop .AttributeList li{ cursor:pointer;}
  .on{color: #fff;background: #fd6847;}
</style>
<!--选择商品属性弹窗Start-->
<div class="AttributeSelectionPop disn" id="AttributeSelectionPop">
  <div class="BasicInfo">
  <span class="iconfont icon-close " style="height:30px;width:30px;font-size:18px; line-height: 30px;text-align: center;border:1px solid #666;border-radius:5px;background: #ccc;color:#fff;cursor:pointer;"  onclick="ClosePop()">X</span>
  
    <p class="Price fl ">价格 ￥<span class="ml20 skuprice" ></span></p>
    <p class="Stock c">已选 <span class="ml20" id="attrname"></span></p>
  </div>
<div id="attr_div">
  
</div>
<input type="hidden" name="goods_name" value="">
<input type="hidden" name="goods_id" value="">
<input type="hidden" name="shop_id" value="">
<input type="hidden" name="skuPath" value="">

  <div class="Number" >
    <span class="jiajian" id="min">-</span>
     <span class="num fl"><input id="text_box" name="goodsnum" type="text" value="1" style="width:50px;height:25px;font-size:20px;text-align: center;border: none; color:#848181" readonly="readonly" /> </span>
     <span  class="jiajian" id="add">+</span>
    
  </div>
  <div class="AttributeList">
      <span  class="btn btn-success addorder" >确认</span>
  </div>
</div>

<script type="text/javascript">

function goodsAttrOpen(goods_id,shop_id,goods_name,price) {//弹窗打开
    
    $.get("<?=Url::to(['goods/goods-detail'])?>",{"goods_id":goods_id},function(r){

      if(r.success)
      { 
        console.log(r.data);
        if(r.data!="")
        {
            var str='';
            for (var i=0;i < r.data.length; i++) {
               var attrvalstr='';
               for (var j=0;j < r.data[i].attrval.length; j++) {
                  attrvalstr+='<li data-id="'+r.data[i].attrval[j].attr_id+'">'+r.data[i].attrval[j].attr_val_name+'</li>';
               }
               
               str+='<div class="AttributeList attr"><h3>'+r.data[i].attrkey+'</h3><ul>'+attrvalstr+'<input type="hidden" name="attrname" value=""><input type="hidden" name="attrid" value=""></ul></div>';
            }
            $(".skuprice").text("");
            $("#attrname").text("");
            
            $("input[name=goods_name]").val(goods_name);
            $("input[name=goods_id]").val(goods_id);
            $("input[name=shop_id]").val(shop_id);

            $("input[name=attrname]").val("");
            $("input[name=attrid]").val("");
            $("#attr_div").empty();
            $("#attr_div").append(str);  
        }else{
            var str='';
           
            $(".skuprice").text(price);
            
            $("input[name=goods_name]").val(goods_name);
            $("input[name=goods_id]").val(goods_id);
            $("input[name=shop_id]").val(shop_id);
                        
        }
        
      
          $("#PopBg,#AttributeSelectionPop").show();  
      }else{
        layer.msg("数据错误");
      }
      

    },'json')
    
    
}  
      $(function(){
        $(".addorder").click(function(){
            var formok=true;
            $(".attr ul input[name=attrid]").each(function(r){
                if(this.value=="")
                {
                    layer.msg("请选择规格");
                    formok=false;
                }
            })
            if(formok)
            {
                var goods_name=$("input[name=goods_name]").val();
                var shop_id=$("input[name=shop_id]").val();
                var goods_id=$("input[name=goods_id]").val();
                var goodsnum=$("input[name=goodsnum]").val();

                var attrname=$("#attrname").text();

                var skuPath=$("input[name=skuPath]").val();
                var price=parseFloat($(".skuprice").text());
                
                var orderstr='<tr><th>'+goods_name+'</th><th>'+attrname+'</th><th class="oneprice">'+price+'</th><th>'+goodsnum+'</th><th><span class="btn btn-danger btn-sm goodsDelete" >删除</span><span><input type="hidden" name="odata['+shop_id+'][goods]['+goods_id+'][shop_id]" value="'+shop_id+'"><input type="hidden" name="odata['+shop_id+'][goods]['+goods_id+'][goods_id]" value="'+goods_id+'"><input type="hidden" name="odata['+shop_id+'][goods]['+goods_id+'][goodsnum]" value="'+goodsnum+'"><input type="hidden" name="odata['+shop_id+'][goods]['+goods_id+'][skuPath]" value="'+skuPath+'"></span></th></tr>';

                /*<input type="hidden" name="odata['+goods_id+'][shop_id]" value="'+shop_id+'">
                <input type="hidden" name="odata['+goods_id+'][goods_id]" value="'+goods_id+'">
                <input type="hidden" name="odata['+goods_id+'][goodsnum]" value="'+goodsnum+'">
                <input type="hidden" name="odata['+goods_id+'][attrid]" value="'+attrid+'">*/



                $(window.parent.document).find("#order_list").append(orderstr);
                var countPrice=parseFloat($(window.parent.document).find("#countPrice").text());
                
                $(window.parent.document).find("#countPrice").text(countPrice+(price*goodsnum));
                parent.layer.closeAll(); 
            }
        })
        $(document).on("click",'.attr ul li',function(){
         
          $(this).parent().find("li").removeClass("on");
          $(this).addClass("on");

          var attrname=$(this).text();
          $(this).parent().find("input[name=attrname]").val(attrname);
          var attrid=$(this).attr('data-id');
          
          $(this).parent().find("input[name=attrid]").val(attrid);

          var attrstr="";
          $(".attr ul input[name=attrname]").each(function(r){
              attrstr+=this.value+" ";    
          })

          var checkall=true//是否全部选择
          var attridstr="";
          $(".attr ul input[name=attrid]").each(function(r){
              if(this.value=="")
              {
                  checkall=false;
              }
              attridstr+=this.value+"_";
          })
          if(checkall)
          {
              $.get("<?=Url::to(["goods/goods-sku"])?>",{"skuPath":attridstr},function(data){
                  
                   $(".skuprice").text(data.price);
                   //$("input[name=price]").val(data.price);
              },'json')
          }
          //console.log(this.value)  
          //;

          $("#attrname").text(attrstr);
          $("input[name=skuPath]").val(attridstr);
      })


        $("#searchSub").click(function(){
           
            var key=$("#searchKey").val();

            if(key=="")
            {
                layer.msg("请输入要搜索的内容");
                return false;
            }
            var url="<?=Url::to(['goods/goods-select'])?>";
            window.location.href=url+"?searchKey="+key;
            
        })

        
    })
</script> 


<div class="row">
   <div class="col-md-12" style="margin-bottom: 10px;">
      <h3>排序方式</h3>
      <span onclick="screening(1)" class="btn btn-info">销量</span>
      <span onclick="screening(2)" class="btn btn-info">浏览量</span>
      <span onclick="screening(3)" class="btn btn-info">最新</span>
      <span style="margin-left:150px;">
          <input type=""  placeholder="搜索您想要的商品"  id="searchKey">
          <span id="searchSub" class="btn btn-success">搜索</span>
      </span>

   </div>

   <div class="col-md-12" >
    <div class="panel panel-info">
      <div class="panel-heading">订单列表</div>
      <div class="panel-body">
        <table class="table table-bordered">
            <tr>
              <th>商品名称</th>
              <th>商品图片</th>
              <th>价格</th>
              <th>操作</th>
            </tr>
           <?php foreach($goods as $goodsVal):?>
           <tr>
              <th><?=$goodsVal->goods_name?></th>
              <th><img style="height:50px;width:100px;" src="<?=Yii::$app->params["imgurl"].$goodsVal->goods_thums?>"/></th>
              <th><?=$goodsVal->price?></th>
              <th><span class="btn btn-success" onclick="goodsAttrOpen(<?=$goodsVal->goods_id?>,<?=$goodsVal->shop_id?>,'<?=$goodsVal->goods_name?>',<?=$goodsVal->price?>)">加入</span></th>
            </tr>
          <?php endforeach;?>
      </table>

      </div>
    </div>
   </div>
    <div class="col-md-10" style="padding:0px; ">
             <?=LinkPager::widget(["pagination"=>$pagination]);?>  
    </div>
</div>




<script>

function ClosePop() {//关闭
    $("#PopBg,#AttributeSelectionPop").hide();
   
}
$(function(){
  ClosePop();
})
$(document).ready(function(){
     //获得文本框对象
     var t = $("#text_box");
     
     
     //数量增加操作
     $("#add").click(function(){ 
        // 给获取的val加上绝对值，避免出现负数
        t.val(Math.abs(parseInt(t.val()))+1);
        if(t.val()>=1)
        {
              $("#min").removeClass("no");
        }
     }) 
     //数量减少操作
     $("#min").click(function(){
       if(t.val()>1)
       {
          t.val(Math.abs(parseInt(t.val()))-1); 
       }
       if(t.val()==1)
       {
            $(this).addClass("no");
       }else{
            $(this).removeClass("no");
       }
       
       
     })
});
</script>
<script type="text/javascript">
  function screening(type){
    var url;
    if(type==1)
    {
      url="<?=Url::to(['goods/goods-select',"salecount"=>"desc","searchKey"=>$searchKey])?>";
    }else if(type==2)
    {
      url="<?=Url::to(['goods/goods-select',"browse"=>"desc","searchKey"=>$searchKey])?>";
    }else if(type==3){
      url="<?=Url::to(['goods/goods-select',"new"=>"desc","searchKey"=>$searchKey])?>";
    }

    window.location.href=url;
  }

</script>

