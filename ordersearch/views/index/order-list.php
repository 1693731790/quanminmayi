<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = '订单列表';
?>

<div class="page-content" >
    <form class="form-inline">
    <div class="panel panel-default">
        <div class="panel-heading"><?=$this->title?> </div>
        <div class="panel-body">
            <div class="pull-left">
              
               
            </div>


        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="10%">订单号</th>
                    <th width="5%">金额</th>
           
                    <th width="10%">状态</th>
                    <th width="5%">支付方式</th>
                    <th width="10%">支付时间</th>
                  <th width="10%">创建时间</th>
                </tr>
                </thead>
                <tbody>
				<?php foreach($model as $val):?>
                    <tr>
                        
                        <td><?=$val->order_id?></td>
                        <td><?=$val->order_sn?></td>
                        <td><?=$val->total_fee ?></td>
                        <td><?=yii::$app->params['order_status'][$val->status]?></td>
                        <td><?=$val->pay_type!=""?Yii::$app->params['pay_method'][$val->pay_type]:"未支付"?></td>
                        <td><?=$val->pay_time!=""?date("Y-m-d H:i:s",$val->pay_time):''?></td>
                        <td><?=$val->create_time!=""?date("Y-m-d H:i:s",$val->create_time):''?></td>
                        
                        
                    </tr>
                 <?php endforeach;?>  

                </tbody>
            </table>
			
           

        </div>
    </div>
    </form>

</div>

