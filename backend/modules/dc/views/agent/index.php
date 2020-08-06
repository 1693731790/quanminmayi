<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\AgentGrade;
use yii\widgets\LinkPager;;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AgentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '代理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="col-md-12" style="padding:0px; ">
            <div class="panel panel-info">
              <div class="panel-heading">代理商信息</div>
              <div class="panel-body">
                <table class="table table-bordered" style="float:left;">
                 
                  <tr>
                      <th>ID</th>
                      <th>用户ID</th>
                      <th>上级代理商ID</th>
                      <th>代理等级</th>
                      <th>真实姓名</th>
                      <th>用户手机号</th>
                      <th>操作</th>
                  </tr>
                  <?php foreach($agent as $val): ?>
                  <tr>
                      <th><?=$val->agent_id?></th>
                      <th><?=$val->user_id?></th>
                      <th><?=$val->parent_id?></th>
                      <th><?=$val->type=="1"?"合伙人":AgentGrade::getGrade($val->level)?></th>
                      <th><?=$val->name?></th>
                      <th><?=$val->phoneAuth->identifier?></th>
                      <th>
                          <a class="btn btn-success" href="<?=Url::to(["agent/view","agent_id"=>$val->agent_id])?>">详细信息</a>
                          <a class="btn btn-warning" href="<?=Url::to(['agent/update','agent_id'=>$val->agent_id])?>">修改信息</a>
                          <a class="btn btn-warning" href="<?=Url::to(['agent/update-pwd','agent_id'=>$val->agent_id])?>">修改密码</a>
                        <?php if($val->type=="1"):?>
                          <a class="btn btn-warning" href="<?=Url::to(['agent/recharge','agent_id'=>$val->agent_id])?>">充值</a>
                          <a class="btn btn-warning" href="<?=Url::to(['agent-balance-record/index','user_id'=>$val->user_id])?>">预充值金额记录</a>
                        <?php endif;?>
                          <a class="btn btn-warning" href="<?=Url::to(['agent/import-card','agent_id'=>$val->agent_id])?>">导入充值卡卡号</a>
                      </th>
                      
                      
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
<script type="text/javascript">
  function view(agent_id)
    {
        var url="<?=Url::to(['agent-fee-record/index'])?>"+"?agent_id="+agent_id;
        layer.open({
          type: 2,
          title: '用户销售额',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: url //iframe的url
        }); 
    }
  function fee(user_id)
    {
        var url="<?=Url::to(['wallet/index'])?>"+"?user_id="+user_id;
        layer.open({
          type: 2,
          title: '钱包记录',
          shadeClose: true,
          shade: 0.8,
          area: ['1200px', '90%'],
          content: url //iframe的url
        }); 
    }
</script>