<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkusSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.form-inline .form-control{
	width:80px;
}
select{height:30px;}
</style>
<div class="skus-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
  		"id"=>"search",
        'method' => 'get',
    	'fieldConfig'=>[
    		'template'=>'{label}{input}',
    			
    ],
    		'options'=>[
    				'class'=>'form-inline',
    ],
    ]); ?>
	
    <?php  echo $form->field($model, 'marketPrice_min') ?>
    <?php  echo $form->field($model, 'marketPrice_max') ?>
  
  	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  
  	<?php  echo $form->field($model, 'retailPrice_min') ?>
  	<?php  echo $form->field($model, 'retailPrice_max') ?>
  
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  
  	<?php  echo $form->field($model, 'profitPCT_min') ?>
  	<?php  echo $form->field($model, 'profitPCT_max') ?>

  	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
  
<div class="form-group field-jdgoodssearch-retailprice_min">
	<label class="control-label" for="jdgoodssearch-retailprice_min">分类</label>
    <select id="cate_one" >
        <option>顶级分类</option>
    </select>
    <select id="cate_two">
      <option>二级分类</option>
    </select>
    <select id="cate_three" >
      <option>三级分类</option>
    </select>
</div>
<input type="hidden" id="productCate" name="JdGoodsSearch[productCate]" value="">	


    <?php // echo $form->field($model, 'productArea') ?>

    <div class="form-group">
      	<a class="btn btn-primary" onclick="tijiao()" >搜索</a>
        
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
  function tijiao()
  {	
    	if($("#cate_one").val()!="")
        {
         	 $("#productCate").val($("#cate_one").val());
         	 if($("#cate_two").val()!="")
              {
                	//alert($("#cate_two").val());
                   $("#productCate").val($("#cate_two").val());
					if($("#cate_three").val()!="")
                    {
                         $("#productCate").val($("#cate_three").val());
                    } 
              } 	 
        }
    
   		$("#search").submit();
  }
  
  
  var cate_oone=document.getElementById("cate_one");
  var cate_otwo=document.getElementById("cate_two");
  var cate_three=document.getElementById("cate_three");
  var cate_str='<option value="">顶级分类</option>';
  cate_otwo.disabled=true;
  cate_three.disabled=true;
  var cate_arr1=<?=$cate_cateone?>;
  for(var i=0;i<cate_arr1.length;i++){
  		cate_str+="<option value="+cate_arr1[i].goods_cat_id+">"+cate_arr1[i].goods_cat_name+"</option>";
   }
  cate_oone.innerHTML=cate_str;
  var cate_arr2 = <?=$cate_catetwo?>;
  //cate_select2();
  cate_oone.onchange=function(){
    var val=this.value;
   
    
    var cate_str1='<option value="">二级分类</option>';
   
    for(var j=0;j<cate_arr2[val].length;j++){
        cate_str1+="<option value="+cate_arr2[val][j].goods_cat_id+">"+cate_arr2[val][j].goods_cat_name+"</option>";
    }
    cate_otwo.innerHTML=cate_str1;
    cate_otwo.disabled=false;
    cate_three.innerHTML='<option value="">三级分类</option>';
    cate_three.disabled='disabled';
  }
  var cate_arr3 = <?=$cate_catethree?>;
 // cate_select3();
  cate_otwo.onchange = function(){
    var val=this.value;
    
    var cate_str2='<option value="">三级分类</option>';
    
    for(var l=0;l<cate_arr3[val].length;l++){
    cate_str2+="<option value='"+cate_arr3[val][l].goods_cat_id+"'>"+cate_arr3[val][l].goods_cat_name+"</option>";
    }
    cate_three.innerHTML=cate_str2;
    cate_three.disabled=false;
  }
  
</script>