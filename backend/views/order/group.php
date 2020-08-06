<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => '订单', 'url' => ['index']];
$this->params['breadcrumbs'][] = "订单信息";

?>

<div class="order-search">

    <form id="w0" action="/order/group" method="get">
    <div class="form-group field-ordersearch-order_id has-success">
      <label class="control-label" for="ordersearch-order_id">订单号</label>
      <input type="text" id="ordersearch-order_id" class="form-control" name="order_sn" aria-invalid="false">

      <div class="help-block"></div>
     </div>


    <div class="form-group">
        <button type="submit" class="btn btn-primary">搜索</button> </div>

    </form>
</div>

<?php if($order_sn!=""):?>
<div class="app">
    <div class="row">
       <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">订单信息</div>
          <div class="panel-body">
            <table class="table table-bordered" style="float:left;">
              
              <tr>
                  <th>备注</th>
                  <td colspan="3">没有此订单</td>
              </tr> 
              
              
             
              
            </table>
          </div>
        </div>
       </div>
      
    </div>
</div>
<?php endif;?>