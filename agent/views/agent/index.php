<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\AgentGrade;
use yii\widgets\LinkPager;;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AgentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的代理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加代理', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="col-md-10" style="padding:0px; ">
            <div class="panel panel-info">
              <div class="panel-heading">代理商信息</div>
              <div class="panel-body">
                <table class="table table-bordered" style="float:left;">
                 
                  <tr>
                      <th>ID</th>
                      <th>用户ID</th>
                      <th>代理等级</th>
                      <th>真实姓名</th>
                      <th>用户手机号</th>

                  </tr>
                  <?php foreach($agent as $val): ?>
                  <tr>
                      <th><?=$val->agent_id?></th>
                      <th><?=$val->user_id?></th>
                      <th><?=AgentGrade::getGrade($val->level)?></th>
                      <th><?=$val->userName->realname?></th>
                      <th><?=$val->phoneAuth->identifier?></th>
                      
                      
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