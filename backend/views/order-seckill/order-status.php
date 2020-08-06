<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '发货';
$this->params['breadcrumbs'][] = ['label' => '订单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="/static/bootstrap.min.css" rel="stylesheet">
<script src="/static/jquery1.72.min.js"></script>
<script src="/static/layer/layer.js"></script>
<style type="text/css">
  #express_type{height: 30px;}
</style>
<div class="goods-create">
<div style="padding:20px;">
    <div>
        <select id="express_type">
              <?php foreach($express as $val):?>
                <option value="<?=$val->code?>"><?=$val->name?></option>
              <?php endforeach;?>  
        </select>
    </div> 
    <br>
    <div>
        <input type="tel" class="inp" name="express_num"  placeholder="填写快递单号">
    </div> 

    <br>
    <div class="text-center">
        <span class="btn btn-primary submit" >保存</span>
    </div>
</div>
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
              $.post("<?=Url::to(['order-seckill/order-status'])?>",{"express_num":express_num,"express_type":express_type,"order_id":<?=$order_id?>},function(r){
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
