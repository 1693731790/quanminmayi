<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="" id="vue">
  <div class="h40"></div>
    <el-dialog :visible.sync="mainDialogVisible" width="50%">
      <img width="100%" :src="mainDialogImageUrl" alt="">
    </el-dialog>
</div>
<script>
    var vmm=new Vue({
        el:'#vue',
        data:{
          mainDialogImageUrl: '',
          mainDialogVisible: false,
        },
        methods:{
            handleView(url){
              this.mainDialogImageUrl = url;
              this.mainDialogVisible = true;
            },
        },
    });
    $(function(){
         App.init();
        $('.app img').on('click',function(){
            var url =$(this).attr('src');
            if(url!='/img/yes.gif'&&url!='/img/no.gif'){
              vmm.handleView(url);
            }
            
        });
        $('#upload_input').on('click',function(){
            $('#goods-imagefile').click();
        });
    });
</script>

    <?php 
    $session=Yii::$app->session;
    if($session->hasFlash('msg')):?>
        <script>
          layer.open({
            content: "<?=$session->getFlash('msg')?>"
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
          });
        </script>
    <?php endif?>
