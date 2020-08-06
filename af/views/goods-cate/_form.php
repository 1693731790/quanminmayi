<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\GoodsCate;

$options=json_encode(GoodsCate::getOptions('|--','作为顶级分类'));
?>

<div id="app" style="width:500px;">
<el-form ref="form" :model="form" label-width="150px">
  <el-form-item label="上级分类">
  <el-select v-model="form.goods_cat_pid" filterable placeholder="请选择" style="width: 100%;">
    <el-option
      v-for="item in options"
      :key="item.goods_cat_id"
      :label="item.goods_cat_name"
      :value="item.goods_cat_id"
      :style="'padding-left:'+((item.level-1)*30+20)+'px;'"
      >
    </el-option>
  </el-select>
  </el-form-item>
  <template>
</template>
  <el-form-item label="分类名称">
    <el-input v-model="form.goods_cat_name"></el-input>
  </el-form-item>
  <el-form-item label="手机显示名称">
    <el-input v-model="form.goods_cat_name_mob"></el-input>
  </el-form-item>
  <el-form-item label="缩略图">

  <el-upload
    class="upload-one"
    action="<?=Url::to(['upload/image-upload','dir'=>'goods_cat_thumb'])?>"
    name="File[imageFile]"
    :before-upload="beforeUpload"
    :on-preview="handlePreview"
    :on-remove="handleRemove"
    :on-success="handleSuccess"
    :file-list="photos"
    :limit=1
    accept="jpg,png"
    list-type="picture-card">
    <span style="font-size: 50px;">+</span>
  </el-upload>
  <el-dialog :visible.sync="dialogVisible" size="tiny">
    <img width="100%" :src="dialogImageUrl" alt="">
  </el-dialog>

  </el-form-item>


  <el-form-item label="排序">
    <el-input v-model="form.goods_cat_sort"></el-input>
  </el-form-item>
  <el-form-item>
  <div style="text-align: center;">
    <span class="btn btn-sm btn-success <?=$model->isNewRecord ? '' : 'hidden'?>" @click="create">提交</span>
     <span class="btn btn-sm btn-success <?=$model->isNewRecord ? 'hidden' : ''?>" @click="create">保存修改</span>
   
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=Url::to(['index'])?>"><span class="btn btn-sm btn-default">返回</span></a>
    </div>
  </el-form-item>
</el-form>
</div>

<script>

    var vm = new Vue({
      el: '#app',
      data: function() {
             return {
              dialogVisible:false,
              dialogImageUrl:null,
              options:<?=$options?>,
              photos:<?=$model->thumb==null?"[]":"[{url:'".$model->thumb."'}]"?>,
            form: {
              goods_cat_id:'<?=$model->goods_cat_id?>',
              goods_cat_name:'<?=$model->goods_cat_name?>',
              goods_cat_name_mob:'<?=$model->goods_cat_name_mob?>',
              goods_cat_pid:'<?=$model->goods_cat_pid?>',
              goods_cat_sort:'<?=$model->goods_cat_sort?>',
              thumb:'<?=$model->thumb?>',
            }
          }
      },
      methods:{
        // 添加
        create (){
     // console.log(vm.form);
     // return false;
          $.ajax({
            url:'',
            data:vm.form,
            success:function(data){
            //  console.log(data);
              if(data.success==1){
                  vm.$confirm('操作成功', '提示', {
                    cancelButtonText: '继续编辑',
                    confirmButtonText: '返回列表',
                   // type: 'warning'
                  }).then(() => {
                    location.href="<?=Url::to(['index'])?>";
        
                  }).catch(() => {
                    if(vm.goods_cat_id==''){
                      vm.form.goods_cat_name='';
                    }
                    
                  });
              }else{
                vm.$notify.error({
                  title: '错误',
                  message: data.msg
                });
              }

            },
            type:'post',
            dataType:'json',
          });

        },
          handleRemove(file, fileList) {
            this.form.thumb="";
          },
          handleSuccess(response,file, fileList) {
           this.form.thumb=response.files[0].url;
          },
          handlePreview(file) {
            this.dialogImageUrl = file.url;
            this.dialogVisible = true;
          },
          beforeUpload(file) {
            const isJPG = file.type === 'image/jpeg';
            const isPNG = file.type === 'image/png';
            const isLt2M = file.size / 1024 / 1024 < 2;

            if (!isJPG && !isPNG) {
              this.$message.error('上传图片只能是 JPG,PNG 格式!');
            }
            if (!isLt2M) {
              this.$message.error('上传图片大小不能超过 2MB!');
            }
            return (isJPG||isPNG) && isLt2M;
          },
      },
      watch:{
        'form.thumb':function(){
          if(this.form.thumb==""){
            $('.el-upload--picture-card').css('display','inline-block');
          }else{
            $('.el-upload--picture-card').css('display','none');
          }
        }
      },
    })

    $(function(){
      if(vm.form.thumb==""){
        $('.el-upload--picture-card').css('display','inline-block');
      }else{
        $('.el-upload--picture-card').css('display','none');
      }
    });
  </script>


</div>
