<?php

namespace shop\controllers;

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

    public function actionImageUpload($dir)
    {
        $model = new File();
        $model->imageFile = UploadedFile::getInstance($model,'imageFile');
        if(!$model->validate()){
            $res['success']=false;
            foreach($model->errors as $v){
                $res['message']=$v[0];
                break;
            }
        return json_encode($res);
        }
        $imageFile=$model->imageFile;

        $directory = Yii::getAlias('@webroot/uploads/'.$dir);
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        if ($imageFile) {
            $uid = uniqid();
            $fileName = $uid . '.' . $imageFile->extension;
            $filePath = $directory . DIRECTORY_SEPARATOR. $fileName;
            if ($imageFile->saveAs($filePath)) {
                $path = '/uploads/'.$dir.'/'. $fileName;
                $res=[];
                $res['url']=$path;
                return Json::encode([
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $imageFile->size,
                            'url' => $path,
                            'thumbnailUrl' => $path,
                            'deleteUrl' => Url::to(['/uploads/image-delete','path'=>$path]),
                            'deleteType' => 'POST',
                        ],
                    ],
                ]);
            }
        }
        return '';
    }
	
    //上传app安装包
    public function actionAppUpload($dir)
    {
        $res=[];
        $model = new File();
        $model->appFile = UploadedFile::getInstance($model,'appFile');
        if(!$model->validate()){
            $res['success']=false;
            foreach($model->errors as $v){
                $res['message']=$v[0];
                break;
            }
        return json_encode($res);
        }

        $directory = Yii::getAlias('@webroot/uploads/'.$dir);
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }
        $file=$model->appFile;
        if ($file) {
            $uid = uniqid();
            $fileName = $uid . '.' . $file->extension;
            $filePath = $directory . DIRECTORY_SEPARATOR. $fileName;
            if ($file->saveAs($filePath)) {
                $path = '/uploads/'.$dir.'/'. $fileName;
                $res=[];
                $res['url']=$path;
                return Json::encode([
                    'success'=>true,
                    'message'=>'文件上传成功',
                    'file' =>[
                            'name' => $fileName,
                            'size' => $file->size,
                            'path' => $path,
                            'url' => Yii::$app->params['setting']['common']['domain_pc'].$path,
                            'deleteUrl' => Url::to(['/uploads/image-delete','path'=>$path]),
                            'deleteType' => 'POST',
                        ],
                ]);
            }
        }
     
        $res['success']=false;
        $res['message']='文件上传失败';
        return json_encode($res);
    }
	//图片删除
    public function actionImageDelete($path)
    {
        $file = Yii::getAlias('@webroot'.$path);
        if (is_file($file)){
            unlink($file);
        }
		
		$tmp=TmpFile::find()->where('path=:path',[':path'=>$path])->one();
		if($tmp!==null){
			$tmp->delete();
		}
		
        $output =$path;
        return Json::encode($output);
    }

}

