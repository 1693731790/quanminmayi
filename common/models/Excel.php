<?php
namespace common\models;

use Yii;

class Excel 
{
   public function getExcel($link)
   {
        //$link="./uploads/agentmobilecardnum/2019118.xlsx";
        //建立reader对象 ，分别用两个不同的类对象读取2007和2003版本的excel文件
        $PHPReader = new \PHPExcel_Reader_Excel2007();
        if( ! $PHPReader->canRead($link))
        {
            $PHPReader = new \PHPExcel_Reader_Excel5();
            if( ! $PHPReader->canRead($link)){
                return '-1';
                die();
            }
        }
        
        $PHPExcel = $PHPReader->load($link); //读取文件
        $currentSheet = $PHPExcel->getSheet(0); //读取第一个工作簿
        $allColumn = $currentSheet->getHighestColumn(); // 所有列数
        $allRow = $currentSheet->getHighestRow(); // 所有行数
        //$this->dump($PHPExcel);
        $data = []; //下面是读取想要获取的列的内容
        for ($rowIndex = 1; $rowIndex <= $allRow; $rowIndex++)
        {
            $data[] = array(
                'id' => $cell = $currentSheet->getCell('A'.$rowIndex)->getValue(),
                
            );
        }
        return $data;
   }
}
