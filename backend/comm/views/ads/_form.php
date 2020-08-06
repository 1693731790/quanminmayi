<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<style>
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .el-upload{border:1px solid #ccc;width:150px!important;height:150px!important;position: relative;}
  .el-upload .hover{display: none;}
  .el-upload:hover .hover{display: block;}
  .el-upload>img{width:150px!important;height:150px!important;}
  .el-icon-view{position: absolute;left:35px;display: block;z-index: 999;line-height: 150px;font-size: 25px;color:#fff;}
  .el-icon-plus{position: absolute;display: block;z-index: 999;line-height: 150px;font-size: 25px;color:#fff;}
  .el-upload:hover .hover.el-icon-plus{right:35px;}
  .avatar-uploader-icon{
    position: absolute;left:0!important;
    display: block;
  }
  .avatar-uploader .el-upload:hover .view{
    width: 150px;height:150px;position: absolute;top:0;left:0;opacity: .4;
   background: #000;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #20a0ff;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 150px;
    height: 150px;
    line-height: 150px;
    text-align: center;
  }

  input[type='file']{display: none;}
</style>
<div id="app">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'images')->hiddenInput() ?>
    <span class="btn btn-sm btn-primary pull-right" @click="add">添加一行</span><br><br>
    <table class="table table-bordered">
        <tr>
            <th>图片</th><th>跳转网址</th><th>操作</th>
        </tr>
        <tr v-for="(item,index) in images">
            <td>
              <div class="avatar-uploader">
                <div class="el-upload el-upload--text">
                  <i v-if="!item.url" class="el-icon-plus avatar-uploader-icon" @click="upload(index)"></i>
                  <i v-if="item.url" class="hover el-icon-view" @click="handleView(item)"></i>
                  <i v-if="item.url" class="hover el-icon-plus" @click="upload(index)"></i>
                  <div v-if="item.url" class="view"></div>
                  <img :src="item.url" alt="" v-if="item.url">
                </div>
              </div>
              <el-dialog :visible.sync="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
              </el-dialog>
            </td>

            <td><input type="text" v-model="item.link"></td><td><span class="btn btn-sm btn-danger" @click="remove(index)">删除</span></td>
        </tr>
    </table>

    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'remark')->textInput() ?>
    <?= $form->field($model, 'sort')->textInput() ?>
    <?=$form->field($model, 'allow_delete')->dropdownList([0=>'禁止删除',1=>'允许删除']
);?>
    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="hidden">
      <el-upload
        class="avatar-uploader"
        action="<?=Url::to(['upload/image-upload','dir'=>'ads'])?>"
        name="File[imageFile]"
        accept="jpg,png,gif"
        :show-file-list="false"
        :on-success="handleSuccess"
        :before-upload="beforeUpload">
      </el-upload>
     </div>

</div>


<script>
    var _csrf_backend = $('meta[name="csrf-token"]').attr('content');
    var vm=new Vue({
        el:'#app',
        data:{
          images:<?=$model->images?>,
          dialogImageUrl: '',
          dialogVisible: false,
          tmp:'',
        },
        methods:{
            add:function(){
               this.images.push({url:null,path:null,link:null}); 
            },
            remove:function(index){
                if(this.images[index].id>0){
                    this.del_list.push(this.images[index].id);
                }
                this.images.splice(index,1);
            },
            save:function(){
                $.post('',{_csrf_backend:_csrf_backend,del_list:vm.del_list,images:vm.images},function(res){
                    if(res.success){
                        vm.$message({
                            message:'操作成功',
                            type:'success',
                        });
                        vm.images=res.images;
                    }else{
                        vm.$message({
                            message:res.msg,
                            type:'error',
                        });
                    }
                },'json');
            },

            upload:function(index){
              this.tmp=this.images[index];
              $("input[type='file']").click();
            },
            handleView(file){
              this.dialogImageUrl = file.url;
              this.dialogVisible = true;
            },
            handleSuccess(response,file, fileList) {
             this.tmp.path=response.files[0].url;
             this.tmp.url="<?=Yii::$app->params['setting']['common']['domain_pc']?>"+response.files[0].url;
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
    });
    
        $(function(){
            <?php if($model->isNewRecord):?>
            vm.images.push({url:null,path:null,link:null});
            <?php endif?>

            $('form').on('submit',function(){
                var imgs=JSON.stringify(vm.images);
                $('#ads-images').val(imgs);
            });
        });
    


</script>