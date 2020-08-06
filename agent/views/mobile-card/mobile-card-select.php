<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="电话卡列表";
?>


<div class="PopBg disn" id="PopBg"></div>
<style type="text/css">
  
  .jiajian{display:inline-block;height:20px;width:20px;cursor:pointer;border: 1px solid #ccc;border-radius:5px;text-align: center;}
  .AttributeSelectionPop .AttributeList li{ cursor:pointer;}
  .on{color: #fff;background: #fd6847;}
</style>

<div class="row">
  
   <div class="col-md-12" >
    <div class="panel panel-info">
      <div class="panel-heading">电话卡列表</div>
      <div class="panel-body">
        <table class="table table-bordered">
            <tr>
              <th>商品名称</th>
              <th>商品图片</th>
              <th>选择数量</th>
              <th>操作</th>
            </tr>
           <?php foreach($mobileCard as $mobileCardVal):?>
           <tr>
              <th><?=$mobileCardVal->name?></th>
              <th><img style="height:50px;width:100px;" src="<?=$mobileCardVal->title_pic?>"/></th>
              <th><input type="number" id="<?=$mobileCardVal->mid?>"></th>
              <th><span class="btn btn-success" onclick="add(<?=$mobileCardVal->mid?>,'<?=$mobileCardVal->name?>')">加入</span></th>
            </tr>
          <?php endforeach;?>
      </table>

      </div>
    </div>
   </div>
    
</div>




<script>

function add(mid,name) {//加入

    var num=$("#"+mid).val();
    if(num==""||num==0)
    {
        layer.msg("请填写购买的数量");
        return false;
    }

    var pmid=$(window.parent.document).find("#mid"+mid).val();
    if(pmid==mid)
    {
        layer.msg("已添加过了,如需增加数量,请删除重新添加");
        return false;
    }
    
   var orderstr='<tr><th>'+name+'</th><th class="num">'+num+'</th><th><span class="btn btn-danger btn-sm goodsDelete" >删除</span><span><input type="hidden" name="data['+mid+'][mid]" value="'+mid+'"><input type="hidden" name="data['+mid+'][num]" value="'+num+'"><input type="hidden" id="mid'+mid+'" value="'+mid+'"></span></th></tr>';

    $(window.parent.document).find("#order_list").append(orderstr);

    var oldFee=parseFloat($(window.parent.document).find("#countPrice").text());
    var onePrice=parseFloat($(window.parent.document).find("#onePrice").val());
    var fee=parseFloat(num*onePrice);

    $(window.parent.document).find("#countPrice").text(oldFee+fee);
    
    parent.layer.closeAll(); 



   
}

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


