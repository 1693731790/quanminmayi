<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Goods;

/* @var $this yii\web\View */
/* @var $searchModel common\models\JdGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '京东商品';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="jd-goods-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel,"cate_cateone"=>$cate_cateone,"cate_catetwo"=>$cate_catetwo,"cate_catethree"=>$cate_catethree]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id'=>'grid',
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            //['class' => 'yii\grid\SerialColumn'],

           // 'id',
            
           ['attribute' => 'thumbnailImage',
                 'label' => '商品主图',
                 'format' => ['image',['width'=>'110','height'=>'110','title'=>'商品图片']],
                 'value'  => function($model){
                    return $model->thumbnailImage;
                 }
            ],
            'jdgoods_id',
            'name',
            'brand',
            ["attribute"=>"type",
            	 'filter'=>Yii::$app->params['goods_source'],
            ],
          
            //
            // 'productCate',
            // 'productCode',
            // 'status',
             'marketPrice',
             'retailPrice',
           ['attribute'=>'profitPCT',
               'label' => '利润百分比',
                'value'  => function($model){
                    return $model->profitPCT;
                 },
                  'options'=>[
                    'width'=>'100',
                ],
            ],  
           ['attribute'=>'',
               'label' => '商品库状态',
                 'format' => 'raw',
                 'value'  => function($model){
                  // $aa=Goods::getGoods($model->jdgoods_id);
                   
                    if(Goods::getGoods($model->jdgoods_id)==false)
                    {
                        return "<a onclick='tcdiv(".$model->id.")' class='btn btn-sm btn-success marr5' >加入商品库</a>";
                    }else{
                        return "<a class='btn btn-sm btn-warning marr5' >已加入商品库</a>";
                    }
                    
                 }
                 
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',//
                'buttons'=>[
                    
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                  
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>

<span class="btn btn-success" onclick="tcdivs()">批量加入商品库</span>
</div>





<style type="text/css">
  .gtdiv{padding-top: 20px; padding-left: 50px;  border-radius:20px;  height:280px; width:450px;background: #70bcd4;border: 1px solid #ccc;position: fixed;top:30%;left:35%;display:none;-moz-box-shadow:0px 1px 20px #333333; -webkit-box-shadow:0px 1px 20px #333333; box-shadow:0px 1px 20px #333333;}
  .gtdiv .tcdiv{margin-top:15px;height:30px;}
  .gtdiv .subdiv{margin-top:15px;margin-left:30px;}
  .gtdiv input{height:30px;} 
  .one{height:30px;}
  .two{height:30px;}
  .three{height:30px;}
</style>

<div class="gtdiv">
  <div class="tcdiv">
    <span style="color:#fff">分类</span>
     <select id="one" class="one" >
         <option>顶级分类</option>
     </select>
     <select id="two" class="two" >
         <option>二级分类</option>
     </select>
     <select id="three" class="three" >
          <option>三级分类</option>
     </select>
    
  </div>
  <div class="tcdiv">
    <span style="color:#fff">商品品牌</span>
    <input type="text" id="goodsbrand" readonly="readonly" placeholder="选择品牌" value=""><span onclick="brandselect()" class="btn btn-success">选择品牌</span>
  </div>
  <div class="tcdiv">
   <span style="color:#fff"> 改价百分比</span>
    <input type="text" id="newprice" value="<?=$config->value?>" >
  </div>
  <div class="tcdiv">
    <span style="color:#fff"> 利润百分比</span>
    <input type="text" id="profitPCT" value="" placeholder="最多保留两位小数">
  </div>
  <div class="subdiv">
  
    <span onclick="submitldh()" class="btn btn-success">确 定</span>
    <span id="qx" class="btn btn-warning">取 消</span>
  </div>
</div>

<input type="hidden"  id="ids" value="">



<script type="text/javascript">

function submitldh(){
  var ids=$("#ids").val();
  var check=true;
  if(ids=="")
  {
      layer.msg("请选择商品");
      check=false;
  }
  
  var goodsbrand=$("#goodsbrand").val();
  
  var newprice=$("#newprice").val();
  if(newprice=="")
  {
      layer.msg("请填写改价百分比");
      check=false;
  }
  var profitPCT=$("#profitPCT").val();
  if(profitPCT=="")
  {
      layer.msg("请填写利润百分比");
      check=false;
  }

  var profitPCT=$("#profitPCT").val();
  if(profitPCT=="")
  {
      layer.msg("请填写利润百分比");
      check=false;
  }
  var cate1=$('#one option:selected').val();
  var cate2=$('#two option:selected').val();
  var cate3=$('#three option:selected').val();
  
  if(cate1==""||cate3==""||cate3=="")
  {
      layer.msg("请选择分类");
      check=false;
  }

  if(check)
  {
     $.get("<?=Url::to(['goods/goods-create'])?>",{"ids":ids,"newprice":newprice,"profitPCT":profitPCT,"goodsbrand":goodsbrand,"cate1":cate1,"cate2":cate2,"cate3":cate3},function(r){

          if(r.success)
          {
              layer.msg(r.message);
              setTimeout(function(){
                window.location.reload();
              },1500)
          }
      },'json')

  }
  
  
  
             
}
function tcdivs(){
      var keys = $('#grid').yiiGridView('getSelectedRows');
      $("#ids").val(keys);
      $(".gtdiv").show();
}



function tcdiv(id){
      $("#ids").val(id);
      $(".gtdiv").show();
}

$(function(){
    $("#qx").click(function(){
        $(".gtdiv").hide();
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
    if("<?=$model->cate_id1?>"!=""&&"<?=$model->cate_id1?>"==arr1[i].goods_cat_id)
    {
        str+="<option value="+arr1[i].goods_cat_id+" selected='selected'>"+arr1[i].goods_cat_name+"</option>"
    }else{
        str+="<option value="+arr1[i].goods_cat_id+">"+arr1[i].goods_cat_name+"</option>"
    }
    
  }
  oone.innerHTML=str;
  var arr2 = <?=$catetwo?>;
   select2();
  oone.onchange=function(){
    var val=this.value;
   
    var arrA = arr2[val];
    
    
    var str1='<option>二级分类</option>';
    for(var j=0;j<arrA.length;j++){
      if("<?=$model->cate_id2?>"==arrA[j].goods_cat_id)
      {
        str1+="<option value="+arrA[j].goods_cat_id+" selected='selected'>"+arrA[j].goods_cat_name+"</option>";
      }else{
        str1+="<option value="+arrA[j].goods_cat_id+">"+arrA[j].goods_cat_name+"</option>";
      }
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
      if("<?=$model->cate_id3?>"==arr3[val][l].goods_cat_id)
      {
        str2+="<option value='"+arr3[val][l].goods_cat_id+"' selected='selected'>"+arr3[val][l].goods_cat_name+"</option>";
      }else{
        str2+="<option value='"+arr3[val][l].goods_cat_id+"'>"+arr3[val][l].goods_cat_name+"</option>";
      }
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
          if("<?=$model->cate_id2?>"==arrA[j].goods_cat_id)
          {
            str1+="<option value="+arrA[j].goods_cat_id+" selected='selected'>"+arrA[j].goods_cat_name+"</option>";
          }else{
            str1+="<option value="+arrA[j].goods_cat_id+">"+arrA[j].goods_cat_name+"</option>";
          }
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
              if("<?=$model->cate_id3?>"==arr3[val][l].goods_cat_id)
              {
                str2+="<option value='"+arr3[val][l].goods_cat_id+"' selected='selected'>"+arr3[val][l].goods_cat_name+"</option>";
              }else{
                str2+="<option value='"+arr3[val][l].goods_cat_id+"'>"+arr3[val][l].goods_cat_name+"</option>";
              }
            }
            three.innerHTML=str2;
            three.disabled=false;
        }
    }
</script>

<script>
   function brandselect()
    {

        layer.open({
          type: 2,
          title: '选择品牌',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: "<?=Url::to(['/goods-brand/brand-select',"type"=>"jd"])?>" //iframe的url
        }); 
    }
</script>
  