<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\GoodsCate;
use common\models\AgentGrade;
use common\models\Count;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = "详情";
$this->params['breadcrumbs'][] = ['label' => '合伙人/代理商', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="app">
    <div class="row">
       <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">基本信息</div>
          <div class="panel-body">
            <table class="table table-bordered" style="float:left;">
               <tr>
                  <th>身份证号</th><td><?=$agent->id_num?></td>
                  <th>真实姓名</th><td><?=$agent->name?></td>
              </tr> 
              <tr>
                  <th>身份证正面</th><td><img style="height:100px;width:100px;" src="<?=$agent->id_front?>"></td>
                  <th>身份证反面</th><td><img style="height:100px;width:100px;" src="<?=$agent->id_back?>"></td>
              </tr> 
              <tr>
                  <th>类型</th><td><?=$agent->type=="1"?"合伙人":"代理商"?></td>  
                  <?php if($agent->type=="1"):?>              
                  <th>预存余额</th><td><?=$agent->balance?></td>
                  <?php else:?>
                  <th>等级</th><td><?=AgentGrade::getGrade($agent->level)?></td>
                  <?php endif;?>
              </tr> 
              
              <tr>
                  <th>手机号</th><td><?=$userAuthPhone->identifier?></td>
                  <th>账号</th><td><?=$userAuthAccount->identifier?></td>
              </tr> 
              <tr>
                  <th>用户ID</th><td><?=$user->id?></td>
                  <th>创建时间</th><td><?=date("Y-m-d H:i:s",$agent->create_time)?></td>
              </tr> 

              
            </table>
          </div>
        </div>
       </div>
    
       
       

    </div>

</div>