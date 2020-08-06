<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="发货";
?>

<style type="text/css">
   select{height:25px;}
</style>
<div class="Web_Box">
  <div class="EditReceiptAddress">
      <ul>
        <li class="sli">
          <div class="lefticon"> <i class="iconfont icon-detailedaddress"></i></div>
          <div class="fl w550">
            
            <select id="express_type">
              <?php foreach($express as $val):?>
                <option value="<?=$val->code?>"><?=$val->name?></option>
              <?php endforeach;?>  
            </select>
            <input type="text" class="inp" name="" placeholder="填写收货人姓名">
          </div>
        </li>
        <li class="sli">
          <div class="lefticon"> <i class="iconfont icon-address3"></i></div>
          <div class="fl w550">
            <input type="tel" class="inp" name="express_num"  placeholder="填写快递单号">
          </div>
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
          var express_num=$("input[name=express_num]").val();
          var express_type=$("#express_type").val();
          
          var check=true;
          
          if(express_num=="")
          {
              layer.msg("快递单号不能为空");
              check=false;
          }

          if(check)
          {
              $.post("<?=Url::to(['my-shop/order-status'])?>",{"express_num":express_num,"express_type":express_type,"order_id":<?=$order_id?>},function(r){
                  if(r.success)
                  {              
                      layer.msg(r.message);        
                      setTimeout(function(){
                         // $(window.parent.document).find(".addressdiv").empty();
                          window.parent.location.reload();
                          parent.layer.closeAll();  
                      },1000);
                      
                      
                  }else{
                      layer.msg(r.message);
                  }
              },'json')
          }
          //alert(province+"---"+city+"---"+county);
      })
  })
</script>
