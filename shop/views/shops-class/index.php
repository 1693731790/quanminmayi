<?php
use yii\helpers\URL;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchShopsClass */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '店铺商品分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shops-class-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
   <table class="table table-striped table-bordered">
	   	<thead>
			<tr>
				<th>ID</th>
			<th>名称</th>	
              <th>缩略图</th>
				
				<th>排序</th>
				<th>操作</th>
			</tr>

		</thead>
     
		 <tbody>
           <?php foreach($class as $val):?>
			<tr >
				<td><?=$val['id']?></td>
				<td><?=$val['name']?></td>	
              <td><img style="width:60px;height:30px;" src="<?=$val['img']?>"/></td>
				
				<td><?=$val['sort']?></td>
				<td><a href="<?=Url::to(["shops-class/update","id"=>$val['id']])?>" class="btn btn-sm btn-info" >修改</a>
              	 <?php if($val['ishome']=="0"):?>
              		<a onclick='ishome(<?=$val['id']?>,1)' class='btn btn-sm btn-success marr5' >设为推荐</a>
              	<?php else:?>
              		<a onclick='ishome(<?=$val['id']?>,0)' class='btn btn-sm btn-warning marr5' >取消推荐</a>
              	<?php endif;?></td>
			</tr>
               <?php foreach($val["class"] as $value):?>
                 <tr>
                      <td><?=$value['id']?></td>
                   	  <td>  |----<?=$value['name']?></td> 
                   <td><img style="width:60px;height:40px;" src="<?=$value['img']?>"/></td>
                    
                      <td><?=$value['sort']?></td>
                      <td><a href="<?=Url::to(["shops-class/update","id"=>$value['id']])?>" class="btn btn-sm btn-info" >修改</a>
                        <a href="<?=Url::to(["shops-class/create-cate","id"=>$value['id']])?>" class="btn btn-sm btn-danger" >关联品牌</a>
                   
                   <?php if($value['ishome']=="0"):?>
              		<a onclick='ishome(<?=$value['id']?>,1)' class='btn btn-sm btn-success marr5' >设为推荐</a>
              	<?php else:?>
              		<a onclick='ishome(<?=$value['id']?>,0)' class='btn btn-sm btn-warning marr5' >取消推荐</a>
              	<?php endif;?></td>
                  </tr>
               <?php endforeach;?>
           <?php endforeach;?>
		</tbody>
     
	</table>
</div>
<script type="text/javascript">
  
    function ishome(id,type)
    {
        $.get("<?=Url::to(['shops-class/ishome'])?>",{"id":id,"type":type},function(r){
            if(r.success)
            {
                layer.msg(r.message);
              	setTimeout(function(){
              		window.location.reload();
              	},1500);
                
            }else{
                layer.msg(r.message);
            }
        },'json')
    }
</script>

