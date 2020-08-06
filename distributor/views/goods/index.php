<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\GoodsCate;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">

    <h1><?= Html::encode($this->title) ?></h1>


  <div class="goods-search" >
	  <div class="col-md-12">
                <select id="one"  >
                  <option>顶级分类</option>
                </select>
                <select id="two" >
                  <option>二级分类</option>
                </select>
                <select id="three" >
                  <option>三级分类</option>
                </select>
      </div>   
   

    <div class="col-md-12">
     <button type="button" class="btn btn-primary searchSubmit">搜索</button>
     <button type="button" class="btn btn-success searchAll">全部</button>
    </div>

    <!--start分类js-->
 <script type="text/javascript">
   
   $(function(){
     
       $(".searchAll").click(function(){
          	window.location.href="<?=Url::to(["goods/index"])?>";
        })
     
   		$(".searchSubmit").click(function(){
        	var cate1=$("#one").val();
            var cate2=$("#two").val();
            var cate3=$("#three").val();
          	if(cate1=="" || cate2=="" || cate3=="")
            {
             	 layer.msg("请选择完整分类");
                 return false;
            }
          	window.location.href="<?=Url::to(["goods/index"])?>"+"?cate1="+cate1+"&cate2="+cate2+"&cate3="+cate3;
        })
   })
   
  var oone=document.getElementById("one");
  var otwo=document.getElementById("two");
  var three=document.getElementById("three");
  var str='<option value="">顶级分类</option>';
  otwo.disabled=true;
  three.disabled=true;
  var arr1=<?=$cateone?>;
  for(var i=0;i<arr1.length;i++){
        str+="<option value="+arr1[i].goods_cat_id+">"+arr1[i].goods_cat_name+"</option>"
    
  }
  oone.innerHTML=str;
  var arr2 = <?=$catetwo?>;
   select2();
  oone.onchange=function(){
    var val=this.value;
   
    var arrA = arr2[val];
    
    
    var str1='<option>二级分类</option>';
    for(var j=0;j<arrA.length;j++){
    
        str1+="<option value="+arrA[j].goods_cat_id+">"+arrA[j].goods_cat_name+"</option>";
    
    }
    otwo.innerHTML=str1;
    otwo.disabled=false;
    three.innerHTML='<option>三级分类</option>';
    three.disabled='disabled';
  }
  var arr3 = <?=$catethree?>;
  select3();
  otwo.onchange = function(){
    var val=this.value;
    
    var str2='<option>三级分类</option>';
    
    for(var l=0;l<arr3[val].length;l++){
     
        str2+="<option value='"+arr3[val][l].goods_cat_id+"'>"+arr3[val][l].goods_cat_name+"</option>";
     
    }
    three.innerHTML=str2;
    three.disabled=false;
  }
  function select2(){
    if("<?=$model->cate_id2?>"!="")
    {
        var val="<?=$model->cate_id1?>";
        var arrA = arr2[val];
        console.log(val);
        var str1='<option>二级分类</option>';
        for(var j=0;j<arrA.length;j++){
         
            str1+="<option value="+arrA[j].goods_cat_id+">"+arrA[j].goods_cat_name+"</option>";
         
        }
        otwo.innerHTML=str1;
        otwo.disabled=false;
        three.innerHTML='<option>三级分类</option>';
        three.disabled='disabled';
    }
  }
   function select3(){
        if("<?=$model->cate_id3?>"!="")
        {
            var val="<?=$model->cate_id2?>";
    
            var str2='<option>三级分类</option>';
            
            for(var l=0;l<arr3[val].length;l++){
             
                str2+="<option value='"+arr3[val][l].goods_cat_id+"'>"+arr3[val][l].goods_cat_name+"</option>";
             
            }
            three.innerHTML=str2;
            three.disabled=false;
        }
    }
</script>
  

</div>


    <p>
        <?php  Html::a('添加商品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           
            
        
          
            
            ['attribute' => 'goods_thums',
                 'label' => '商品主图',
                 'format' => ['image',['width'=>'110','height'=>'110','title'=>'商品图片']],
                 'value'  => function($model){
                    return $model->goods_thums;
                 },
               
            ],
            
           
            [
                "attribute"=>'cate_id1',
                "value"=>function($model){
                    return GoodsCate::getCateName($model->cate_id1);
                }
            ],
            [
                "attribute"=>'cate_id2',
                "value"=>function($model){
                    return GoodsCate::getCateName($model->cate_id2);
                }
            ],
            [
                "attribute"=>'cate_id3',
                "value"=>function($model){
                    return GoodsCate::getCateName($model->cate_id3);
                }
            ],
            
           
            'goods_name',
           
            'old_price',
             'price',
           
            
     
                      
           
            

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',//
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('购买',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                  
                    
                   
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>


</div>
<script type="text/javascript">
  function statusAll()
  {
      var keys = $('#w0').yiiGridView('getSelectedRows');
      
      $.get("<?=Url::to(['goods/status-all'])?>",{"keys":keys},function(r){
        layer.msg(r.message);
        if(r.success)
        {
              setTimeout(function(){
                window.location.reload();
              },2000)
              
        }
          
           
      },'json')

  }
  function deleteAll()
  {
      var keys = $('#w0').yiiGridView('getSelectedRows');
      
      $.get("<?=Url::to(['goods/delete-all'])?>",{"keys":keys},function(r){
        layer.msg(r.message);
        if(r.success)
        {
              setTimeout(function(){
                window.location.reload();
              },2000)
              
        }
          
           
      },'json')

  }
 
   
 
</script>