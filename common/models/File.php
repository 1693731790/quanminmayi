<?php

namespace common\models;

use Yii;

class File extends \yii\base\Model
{
    public $imageFile;// 单图
    public $imageFiles;// 多图
    
	
    public function rules()
    {
        return [
            [['imageFile'], 'safe'],
            /*[['appFile'], 'file', 'skipOnEmpty' => true],*/
        ];
    }
}
