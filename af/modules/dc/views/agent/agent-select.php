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

    

    <div class="col-md-10" style="padding:0px; ">
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
                      <th><?=AgentGrade::getGrade($val->level)?></th>
                      <th><?=$val->userName->realname?></th>
                      <th><?=$val->phoneAuth->identifier?></th>
                      <th>
                          <span class="btn btn-success" onclick="view(<?=$val->user_id?>)">确定</span>
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
  function view(user_id)
    {
        $(window.parent.document).find("#shops-user_id").val(user_id);
        parent.layer.closeAll();
    }
</script>