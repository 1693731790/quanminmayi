<?php

namespace api\controllers;

use Yii;
use common\models\File;
use yii\web\Controller;
use yii\web\UploadedFile;

use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\Url;
/**
 * 上传插件公用控制器
 */
 
class UploadController extends Controller
{
    public $enableCsrfValidation = false;
    
    
    public function beforeAction($action){
        if(parent::beforeAction($action)){
            header('Access-Control-Allow-Origin:*');
            return true;
        }
        return false;
    }

    public function actionImgs($dirpath)    //上传图片方法，返回上传图片的名字
    {

        $photo =UploadedFile::getInstanceByName("photo");
        $name = date('Y-m-d', time());
        $dir =Yii::getAlias('@uploads')."/".$dirpath."/". $name . '/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $new_name=time().rand(0,99999);
        $dir=$dir. $new_name. '.' . $photo->extension;
        $photo->saveAs($dir);
        echo "/uploads/".$dirpath."/".$name."/". $new_name. '.' . $photo->extension;
    }
	

}

