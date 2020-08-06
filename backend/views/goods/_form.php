<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \kucha\ueditor\UEditor;
use dosamigos\fileupload\FileUploadUI;
use dosamigos\fileupload\FileUpload;
use common\models\GoodsCate;
use common\models\Goods;

//var_dump($site);
?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">

<style>
 
   #one,#two,#three{height: 35px;}
   .error{text-align: left;color:red;}
   .jq_uploads_img{height: 220px;width:100%;border:#ccc 1px solid;margin-bottom: 10px;}
</style>

<ul class="nav nav-tabs">
    <?php if($model->isNewRecord): ?>
        <li class="active"><a href="#default-tab-1" data-toggle="tab">通用信息</a></li>
    <?php else:?>
       <li class="<?=$attr==""?'active':''?>"><a href="#default-tab-1" data-toggle="tab">通用信息</a></li>
       <li class="<?=$attr=="1"?'active':''?>"><a href="#default-tab-2" data-toggle="tab">商品规格</a></li>
       <li class="<?=$attr=="2"?'active':''?>"><a href="#default-tab-3" data-toggle="tab">商品SKU</a></li>
    <?php endif;?>
</ul>
   

<div class="tab-content" >
    <div class="tab-pane fade <?=$attr==""?'active in':''?>" id="default-tab-1">
 <?php $form = ActiveForm::begin([
        'id'=>'goods_form',
        'fieldConfig'=>[
            'template'=>'<div class="row"><div class="col-md-2 text-right">{label}</div><div class="col-md-8">{input}{hint}</div><div class="col-md-2">{error}</div></div>',
        ],
    ]); ?>
 
<?php if(isset($is_agent_buy)&&$is_agent_buy=="1"):?>
<input type="hidden"  name="Goods[shop_id]" value="1" >
<input type="hidden"  name="Goods[is_agent_buy]" value="1" >
<?php else:?>
<div class="form-group field-goods-shop_id required">
    <div class="row">
        <div class="col-md-2 text-right">
            <label class="control-label" for="goods-shop_id">店铺ID</label>
        </div>
        <div class="col-md-8">
            <input type="text" id="goods-shop_id" readonly='readonly' class="form-control" name="Goods[shop_id]" value="<?=$model->shop_id!=""?$model->shop_id:''?>" aria-required="true">
             <span class="btn btn-success" onclick="shopsselect()">选择店铺</span>

        </div>
        <div class="col-md-2">
            <?=Html::error($model , 'shop_id' , ['class' => 'error'])?>
        </div>
    </div>
</div>   
<?php endif;?>
     
    <div class="form-group required">
        <div class="row">
            <div class="col-md-2 text-right"><label>商品分类</label></div>
            <div class="col-md-10">
                <select id="one" name="Goods[cate_id1]">
                  <option>顶级分类</option>
                </select>
                <select id="two" name="Goods[cate_id2]">
                  <option>二级分类</option>
                </select>
                <select id="three" name="Goods[cate_id3]">
                  <option>三级分类</option>
                </select>
            <?=Html::error($model , 'cate_id1' , ['class' => 'error'])?>
            <?=Html::error($model , 'cate_id2' , ['class' => 'error'])?>
            <?=Html::error($model , 'cate_id3' , ['class' => 'error'])?>
            </div>
           
        </div>
    </div>
    
    <?= $form->field($model, 'goods_brand')->textInput(['readonly' => 'readonly']) ?>
  <div class="form-group">
        <div class="row">
            <div class="col-md-2 text-right"><label></label></div>
            <div class="col-md-10">
                <span class="btn btn-success" onclick="brandselect()">选择品牌</span>
               
                        
            </div>
           
        </div>
    </div>
    <input type="hidden" name="Goods[source]" value="<?=$model->source!=""?$model->source:"qmmy"?>" > 
     <?= $form->field($model, 'source_id')->textInput(['readonly' => 'readonly']) ?>
  <div class="form-group">
        <div class="row">
            <div class="col-md-2 text-right"><label></label></div>
            <div class="col-md-10">
                <span class="btn btn-success" onclick="supplierselect()">选择供货商</span>
               
                        
            </div>
           
        </div>
    </div> 
    <?= $form->field($model, 'goods_sn')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'goods_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_keys')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_thums')->textInput(['readonly' => 'readonly']) ?>

    <div class="form-group">
        <div class="row">
            <div class="col-md-2 text-right"><label></label></div>
            <div class="col-md-10">
                <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
                    <img  id="goods_thums" width="212" height="152"  src="<?=$model->isNewRecord?'/uploads/default.jpg':$model->goods_thums?>" />  
                </div>
                <input  id="photo_file_goods_thums"  type="file" multiple="true" value="" />
                        
            </div>
           
        </div>
    </div>
    <?= $form->field($model, 'jdis_update_goods_thums')->checkBox() ?>
    <div class="row">
            <div class="col-md-2 text-right"><label>商品相册</label></div>
            <div class="col-md-10">  
                <div class="jq_uploads_img" >
                   <?php if($model->goods_img):?>
                      <?php for($i=0;$i<count($model->goods_img);$i++):?>
                        <span style="width: 150px; height: 100px;float: left; margin-left: 5px; margin-top: 10px;">  <img width="80" height="80" src="<?=$model->goods_img[$i]?>">  <input type="hidden" name="Goods[goods_img][]" value="<?=$model->goods_img[$i]?>" /><a href="javascript:void(0);">取消</a>  </span>
                       <?php endfor;?>                
                    <?php endif;?>
                </div>
                <input id="file_upload_goods_img" name="file_upload" type="file" multiple="true"  />
            </div>

    </div>        
         <div class="form-group"> 
            
        </div>   
   
                 <script>

                        $("#photo_file_goods_thums").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'goods'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#goods-goods_thums").val(data);

                                $("#goods_thums").attr('src', data).show();

                            }

                        });

                    </script>
    
    
   
                  <script>
                    $("#file_upload_goods_img").uploadify({

                        'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                        'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'goods'])?>',

                        'cancelImg': '/static/uploadify/uploadify-cancel.png',

                        'buttonText': '上传图片',

                        'fileTypeExts': '*.gif;*.jpg;*.png;',

                        'queueSizeLimit': 10,
                        'fileObjName':'photo',
                        'onInit': function () {            
                            $("#upload_excel-queue").hide();
                         },
                        'onUploadSuccess': function (file, data, response) {
                        

         var str = '<span style="width: 150px; height: 100px; float: left; margin-left: 5px; margin-top: 10px;">  <img width="80" height="80" src="' + data + '">  <input type="hidden" name="Goods[goods_img][]" value="' + data + '" />    <a href="javascript:void(0);">取消</a>  </span>';

                            $(".jq_uploads_img").append(str);
                            
                        }
                        

                    });

                    $(document).on("click", ".jq_uploads_img a", function () {

                        $(this).parent().remove();

                    });
                    
             </script>
    
    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model, 'salecount')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'old_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
  <?= $form->field($model, 'profitPCT')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'profitFee')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'parent_profit')->textInput(['maxlength' => true]) ?>
      
    <?= $form->field($model, 'stock')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_seckill')->checkBox() ?>
     <?= $form->field($model, 'seckill_img')->textInput(['readonly' => 'readonly']) ?>

    <div class="form-group">
        <div class="row">
            <div class="col-md-2 text-right"><label></label></div>
            <div class="col-md-10">
                <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
                    <img  id="seckill_img" width="212" height="152"  src="<?=$model->isNewRecord?'/uploads/default.jpg':$model->seckill_img?>" />  
                </div>
                <input  id="photo_file_seckill_img"  type="file" multiple="true" value="" />
                        
            </div>
           
        </div>
    </div>      
      <script>

                        $("#photo_file_seckill_img").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'goods'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#goods-seckill_img").val(data);

                                $("#seckill_img").attr('src', data).show();

                            }

                        });

                    </script>
      
    <?= $form->field($model, 'seckill_stock')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'seckill_surplus')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'seckill_start_time')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'seckill_end_time')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'seckill_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'freight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'issale')->checkBox() ?>
   

    <?= $form->field($model, 'ishot')->checkBox() ?>

    <?= $form->field($model, 'isnew')->checkBox() ?>
    <?= $form->field($model, 'istuijian')->checkBox() ?>
    <?= $form->field($model, 'istodaynew')->checkBox() ?>
    <?= $form->field($model, 'isselected')->checkBox() ?>
    <?= $form->field($model, 'isdigital')->checkBox() ?>
    <?= $form->field($model, 'isdiscount')->checkBox() ?>
    <?= $form->field($model, 'is_group')->checkBox() ?>
      

    
    
    <?= $form->field($model,'content')->widget('kucha\ueditor\UEditor',[]); ?>
    
 
    

    
   
    
        <div class="form-group text-center">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary ']) ?><!-- goods_submit -->
            
        </div>

    </div>
   <?php ActiveForm::end(); ?> 
    <div class="tab-pane fade <?=$attr=="1"?'active in':''?>" id="default-tab-2">
  

    
<?php $formattr = ActiveForm::begin([
        'id'=>'goods_attr_form',
        'action'=>Url::to(['goods/attr-add']),
    ]); ?>        
    
<div class="row" >
    <div class="col-md-8">

    <table class="table table-bordered" id="attributeResult">
        <tr><th colspan="2" class="text-center">商品规格</th></tr>
        <input type="hidden" name="goods_id" value="<?=$model->goods_id?>">

    <?php if(isset($attrData)&&!empty($attrData)):?>
    <?php foreach ($attrData as $key => $value):?>

        <tr>
            <td><?=$value['attrkey']?></td>
            <td>
            <?php for ($attri=0;$attri<count($value['attrval']);$attri++):?>
                <span class="btn btn-success" style="margin-right: 15px;"><?=$value['attrval'][$attri]?></span>
                
            <?php endfor;?> 
                <span class="btn btn-danger" title="移除" onclick="del_arrt_val(this)" ><i class="fa fa-trash"></i></span>
                <input type="hidden" name="attr[]" value='<?=json_encode($value)?>'>
            </td>
        </tr>
    <?php endforeach;?>    
    <?php endif;?>
        
    </table>

    <div class="form-group text-center">
        <span class="btn btn-success" onclick="addAttribute()"><i class="fa fa-plus"></i>添加规格</span>
    </div>
    
    

<script type="text/javascript">
    
    function add_arrt_val()//添加规格元素行
    {
        var add_arrt_str='<tr ><td><input type="" name="goodsAttrValue"  class="form-control"></td> <td><span class="btn btn-danger" onclick="del_arrt_val(this)" >删除</span></td></tr>';
        $("#attr_val").append(add_arrt_str);
    } 
    function del_arrt_val(obj)//删除规格元素行
    {
        
        $(obj).parent().parent().remove();
    }  
    function attr_save()//确认添加规格行
    {

        var goodsAttrName=$("input[name='goodsAttrName']").val();
        var goodsAttrStr="";
        var attrData=new Object();
        attrData.attrval=new Array();
        if(goodsAttrName=="")
        {
            layer.msg("规格名称不能为空");
            return false;
        }else{
            goodsAttrStr="<tr><td>"+goodsAttrName+"</td><td>";
            attrData.attrkey=goodsAttrName;
        }
        $("input[name='goodsAttrValue']").each(function(i){
            
            if(this.value=="")
            {
                layer.msg("规格属性值不能为空");
                return false;
            }else{
                goodsAttrStr+='<span class="btn btn-success" style="margin-right: 15px;">'+this.value+'</span>';
                attrData.attrval[i]=this.value;
            }
        });

        
        goodsAttrStr+='<span class="btn btn-danger" title="移除" onclick="del_arrt_val(this)" ><i class="fa fa-trash"></i></span><input type="hidden" name="attr[]" value=\''+JSON.stringify(attrData)+'\'></td></tr>';
        $("#attributeResult").append(goodsAttrStr);

        //console.log(attrData);

        layer.closeAll();
       
        console.log();
        
    }
    
function addAttribute(){
    layer.open({
      type: 1,
      skin: '', //加上边框
      area: ['800px', '500px'], //宽高
      content: '<div style="padding:20px;"><div><input type="" name="goodsAttrName"  class="form-control" placeholder="规格名称"></div>        <br>        <table class="table table-bordered" id="attr_val" >          <tr>            <th>可选值</th><th width="200">操作</th>          </tr>          <tr >            <td><input type="" name="goodsAttrValue"  class="form-control"></td>            <td>                <span  class="btn btn-success" onclick="add_arrt_val()" >新增</span>            </td>          </tr>                  </table>         <div class="text-center"><span class="btn btn-primary" onclick="attr_save()">保存</span></div></div>',
    });   
}
</script>

    


  </div>
    
</div>
  
    
        
   

        <div class="h20"></div>
        <div class="form-group text-center">
           <?= Html::button('提交', ['class' => 'btn btn-primary goods_attr_submit']) ?>
        </div>
    </div>
 <?php ActiveForm::end(); ?> 
<script src="/static/laydate/laydate.js"></script> 
<script type="text/javascript">
   
$(function(){

      //执行一个laydate实例
laydate.render({
  elem: '#goods-seckill_start_time', //指定元素
  type: 'datetime'
});
    //执行一个laydate实例
laydate.render({
  elem: '#goods-seckill_end_time', //指定元素
  type: 'datetime'
});


  
     $(".goods_attr_submit").click(function(){
        var attr_val=false;  //默认规格不存在

       // console.log($("input[name='attr[]']").length);
        if($("input[name='attr[]']").length!=0) //规格存在
        {
            attr_val=true;
        }

        if(attr_val)
        {
            $("#goods_attr_form").submit();
        }else{
            layer.msg("请添加规格");
        }
    })  
     $(".goods_sku_submit").click(function(){
        var sku_val=true;//默认sku未填写完整
        if($("#skuinput").find("input[type=text]").length<=0)
        {
            layer.msg("请先填写提交规格");
            sku_val=false;
            return false;
        }
        $("#skuinput").find("input[type=text]").each(function(){

            if(this.value=="")
            {
                layer.msg("数据请填写完整");
                sku_val=false;
                return false;
            }
        })
        if(sku_val)
        {
            $("#goods_sku_form").submit();    
        }
        
        
           
        
     })

})

</script>



    <div class="tab-pane fade <?=$attr=="2"?'active in':''?>"" id="default-tab-3">
     
    <?php $formattr = ActiveForm::begin([
        'id'=>'goods_sku_form',
        'action'=>Url::to(['goods/sku-add']),
    ]); ?>         
    <input type="hidden" name="goods_id" value="<?=$model->goods_id?>">
         <table id="skuinput" class="table table-bordered " >
        <tr>
            <th ></th>
            <th>价格</th>
            <th>库存</th>
            
        </tr>
<?php if(!$model->isNewRecord):?>        
    <?php if(empty($goodsSku)&&!empty($cartval)):?>
        <input type="hidden" name="isnew" value="1">
        <?php for($carti=0;$carti<count($cartval);$carti++):?>
            <tr>
                <td ><?=$cartval[$carti]?></td>
                <td><input type="text" name="skudata[<?=$carti?>][price]" value=""></td>
                <td><input type="text" name="skudata[<?=$carti?>][stock]" value=""></td>
                <input type="hidden" name="skudata[<?=$carti?>][attr_path]" value="<?=$cartid[$carti]?>">
                <input type="hidden" name="skudata[<?=$carti?>][sku_name]" value="<?=$cartval[$carti]?>">
            </tr>
        <?php endfor;?>

    <?php else:?>
        <input type="hidden" name="isnew" value="0">
        <?php foreach($goodsSku as $skukey=>$skuval):?>
            <tr>
                <td ><?=$skuval['sku_name']?></td>
                <td><input type="text" name="skudata[<?=$skukey?>][price]" value="<?=$skuval['price']?>"></td>
                <td><input type="text" name="skudata[<?=$skukey?>][stock]" value="<?=$skuval['stock']?>"></td>
                <input type="hidden" name="skudata[<?=$skukey?>][attr_path]" value="<?=$skuval['attr_path']?>">
                <input type="hidden" name="skudata[<?=$skukey?>][sku_name]" value="<?=$skuval['sku_name']?>">
                <input type="hidden" name="skudata[<?=$skukey?>][sku_id]" value="<?=$skuval['sku_id']?>">
            </tr>
        <?php endforeach;?>
    <?php endif;?>
<?php endif;?>
    </table>
          
        <div class="form-group text-center">
            <?= Html::button('提交', ['class' => 'btn btn-primary goods_sku_submit']) ?>
        </div>
<?php ActiveForm::end(); ?> 

    </div>
   


   
   
       
    </div>
</div>
 





<!--start分类js-->
 <script type="text/javascript">
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
<!--end分类js-->
<script type="text/javascript">
   function shopsselect()
    {

        layer.open({
          type: 2,
          title: '选择店铺id',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: "<?=Url::to(['shops/shops-select'])?>" //iframe的url
        }); 
    }
   function brandselect()
    {

        layer.open({
          type: 2,
          title: '选择品牌',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: "<?=Url::to(['goods-brand/brand-select'])?>" //iframe的url
        }); 
    }
     function supplierselect()
    {

        layer.open({
          type: 2,
          title: '选择供货商',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: "<?=Url::to(['supplier/supplier-select'])?>" //iframe的url
        }); 
    }


$(function(){
    

})
</script>
