<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\WithdrawCash */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => '提现管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-info">
          <div class="panel-heading">提现信息</div>
          <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th width="20%">申请时间</th><td width="30%"><?=date("Y-m-d H:i:s",$model->create_time)?></td>
                    <th width="20%">状态</th><td width="30%"><?=Yii::$app->params['withdraw_cash_status'][$model->status]?></td>
                </tr>
                <tr>
                    <th width="20%">提现金额</th><td width="30%"><?=$model->fee?></td>
                    <th width="20%">联系电话</th><td width="30%"><?=$model->phone?></td>
                </tr>
                <tr>
                    <th width="20%">处理时间</th><td width="30%"><?=$model->handle_time!=""?date("Y-m-d H:i:s",$model->handle_time):''?></td>
                    <th width="20%">备注</th><td width="30%"><?=$model->remark?></td>
                    
                    
                </tr>
                
          </table>
            <table class="table table-bordered">
                <tr>
                    <th width="20%">持卡人</th><td width="30%"><?=$bank->name?></td>
                    <th width="20%">手机号</th><td width="30%"><?=$bank->phone?></td>
                </tr>
                <tr>
                    <th width="20%">银行</th><td width="30%"><?=$bank->bank_name?></td>
                    <th width="20%">卡号</th><td width="30%"><?=$bank->account?></td>
                    
                </tr>
          </table>
          </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-info">
          <div class="panel-heading">会员信息</div>
          <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th width="20%">会员id</th><td width="30%"><?=$model->user_id?></td>
                    <th width="20%">用户名</th><td width="30%"><?=$model->user->username?></td>
                </tr>
                <tr>
                  <th>手机号</th><td><?=$model->user->phone?></td>
                  
                </tr>
                <tr>
                  <th>真实姓名</th><td><?=$model->user->realname?></td>
                 
                </tr>

                <tr>
                  <th>钱包余额</th><td><?=$model->user->wallet?></td>
                 
                </tr>
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
                <?php $form = ActiveForm::begin(['id'=>'form_status']); ?>
                
                <select name="status" style="height:30px;margin-bottom: 10px;">
                    <option value="10">同意提现</option>
                    <option value="-1">拒绝提现</option>
                </select>
                        
                   
                
                <input class="form-control " id="remarks" placeholder='备注信息' name="remark">
               
               

                <div class="form-group">
                    <input type="button" class="btn btn-danger submits" value="提交"  >
                    
                </div>
                <?php ActiveForm::end(); ?>
              </div>
            </div>
        </div>
    <?php endif;?>
    </div>
    <script>
   
        $(function(){
            $(".submits").click(function(){

                
                var remarks=$("#remarks").val();
                            
                if(remarks=="")
                {
                    alert("请填写备注");
                    return false;    
                }
             
                $("#form_status").submit();
            })
        })
       
    </script>