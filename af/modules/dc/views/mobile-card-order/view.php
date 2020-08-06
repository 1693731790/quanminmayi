<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->mo_id;
$this->params['breadcrumbs'][] = ['label' => '订单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="app">
    <div class="row">
       <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">订单信息</div>
          <div class="panel-body">
            <table class="table table-bordered" style="float:left;">
               <tr>
                  <th  width="20%">订单ID</th><td width="30%"><?=$model->mo_id?></td>
                  <th  width="20%">订单编号</th><td width="30%"><?=$model->morder_sn?></td>
              </tr> 
             
              <tr>
                  <th>总金额</th><td><?=$model->total_fee?></td>
                  <th>状态</th><td><?=yii::$app->params['mobile_card_order_status'][$model->status]?></td>
              </tr> 
              <tr>
                 <?php if(!empty($mobileImg)):?>
                  <th>电话卡封面</th><td><img src="<?=$mobileImg->img?>" style="height:100px;width:200px;"></td>
                <?php else:?>
                  <th>电话卡封面</th><td>其他，联系：<?=$model->phone?></td>
                <?php endif;?>

                  
              </tr> 
              <tr>
                  <th>订单类型</th><td><?=$model->type=="1"?"合伙人开通代理商":"代理商自行购买"?></td>
                  
              </tr> 
              <?php if($model->type!="1"):?>
              <tr>
                  <th>汇款凭证</th><td><img src="<?=$model->pay_img?>" style="height:100px;width:200px;"></td>
                  
              </tr> 
              <?php endif;?>
              <tr>
                  <th>备注</th><td><?=$model->remarks?></td>
                  
              </tr> 
              
            
             
              
            </table>
          </div>
        </div>
        


       </div>
       <div class="col-md-6">
       <?php if(!empty($partner)):?>
        <div class="panel panel-info">
          <div class="panel-heading">合伙人信息</div>
          <div class="panel-body">
            <table class="table table-bordered">
              <tr>
                  <th width="20%">ID</th><td width="30%"><?=$partner->agent_id?></td>
                  <th width="20%">姓名</th><td width="30%"><?=$partner->name?></td>
              </tr>
              <tr>
                  <th width="20%">手机号</th><td width="30%"><?=$partner->phoneAuth->identifier?></td>
              </tr>
             
            </table>
          </div>
        </div>
        <?php endif;?>

        <div class="panel panel-info">
          <div class="panel-heading">代理商信息</div>
          <div class="panel-body">
            <table class="table table-bordered">
              <tr>
                  <th width="20%">ID</th><td width="30%"><?=$agent->agent_id?></td>
                  <th width="20%">姓名</th><td width="30%"><?=$agent->name?></td>
              </tr>
              <tr>
                  <th width="20%">手机号</th><td width="30%"><?=$agent->phoneAuth->identifier?></td>
              </tr>
             
            </table>
          </div>
        </div>
        
       </div>
      
    </div>

     <div class="col-md-12">
        <div class="panel panel-info">
          <div class="panel-heading">商品列表</div>
          <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th>电话卡id</th>
                    <th>名称</th>
                    <th>单价</th>
                    <th>购买数量</th>
                    
                </tr>
            <?php foreach($mobileDetail as $mobileDetailVal):?>
                <tr>
                    <td><?=$mobileDetailVal->mo_id?></td>
                    <td><?=$mobileDetailVal->name?></td>
                    <td><?=$mobileDetailVal->price?></td>
                    <td><?=$mobileDetailVal->num?></td>
                    
                    
                </tr>
            <?php endforeach; ?>
          </table>
          </div>
        </div>
       </div>

</div>
 <div class="row" >
       <?php if($model->status=="0"): ?>
        <div class="col-lg-12 text-center">
            <div class="panel panel-danger">
              <div class="panel-heading">审核操作</div>
              <div class="panel-body">
                
                <select name="status" id="status" style="height:30px;margin-bottom: 10px;">
                    <option value="1">同意</option>
                    <option value="-1">拒绝</option>```·~/
                </select>
                 
                <input class="form-control " id="remarks" placeholder='备注信息' name="remark">
               
                <div class="form-group">
                    <input type="button" class="btn btn-danger submits" value="提交"  >
                    
                </div>
               
              </div>
            </div>
        </div>
    <?php endif;?>
    </div>
    <script>
   
        $(function(){
            $(".submits").click(function(){

                
                var remarks=$("#remarks").val();
                var status=$("#status option:selected").val()
                var check=true;         
                if(remarks=="")
                {
                    layer.msg("请填写备注");
                    check=false;    
                }
             
                if(check)
                {
                    $.get("<?=Url::to(['mobile-card-order/update-status'])?>",{"status":status,"remarks":remarks,"mid":"<?=$model->mo_id?>"},function(data){
                        if(data.success)
                        {
                            layer.msg(data.message);
                            
                            setTimeout(function(){
                                window.location.reload();   
                            },2000)
                            
                        }else{
                            layer.msg(data.message);
                        }
                    },'json')   
                }
            })
        })
       
    </script>