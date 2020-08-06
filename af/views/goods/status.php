<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '商品审核';
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="/static/bootstrap.min.css" rel="stylesheet">
<script src="/static/jquery1.72.min.js"></script>
<script src="/static/layer/layer.js"></script>


<div class="goods-create">

<div style="padding:20px;">
    <div>
        <select style="height:30px;" id="status">
            <?php foreach (Yii::$app->params['goods_status'] as $key=>$value):?>
                <?php if($key!=0):?>
                <option value="<?=$key?>"><?=$value?></option>    
                <?php endif; ?>
            <?php endforeach;?>
            
        </select>
        
    </div> 
    <br>
    <div>
        
        <input type="" id="status_info"  class="form-control" placeholder="操作说明">
        
    </div> 
    <br>
    <div class="text-center">
        <span class="btn btn-primary" onclick="submit()">保存</span>
    </div>
</div>
  

</div>
<script type="text/javascript">
    function submit(){
        var status_info=$("#status_info").val();
        var goods_id="<?=$id?>";
        var status= $("#status option:selected").val();
        
        if(status_info=="")
        {
            layer.msg("请填写操作说明原因");
            return false;
        }else{

            $.post("<?=Url::to(['goods/status'])?>",{"id":goods_id,"status_info":status_info,'status':status},function(r){
                if(r!="1")
                {
                    layer.msg("操作失败");
                    return false;
                }
                layer.msg("操作成功");
                setTimeout(function(){
                    parent.location.reload();
                },2000);
            })    
        }
        
    }
</script>