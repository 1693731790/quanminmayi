<?php
namespace af\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AfCode;

/**
 * UserController implements the CRUD actions for User model.
 */
class ExcelDownController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function actionAll($batch_num="",$distributor_id="",$goods_id="",$status="")
    {   
         set_time_limit(0);
         ini_set('memory_limit', '1024M');
         $title="二维码导出";
         $objPHPExcel = new \PHPExcel();
         
        \PHPExcel_Settings::setLocale('zh_cn');
        $objPHPExcel->getProperties()
            ->setCreator("")
            ->setLastModifiedBy("")
            ->setTitle($title)
            ->setSubject($title)
            ->setDescription($title)
            ->setKeywords("excel");
 
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . 1, '编号')
            ->setCellValue('B' . 1, '批号')
            ->setCellValue('C' . 1, '卡号')
            ->setCellValue('D' . 1, '经销商id')
            ->setCellValue('E' . 1, '产品id')
            ->setCellValue('F' . 1, '状态')
            ->setCellValue('G' . 1, '二维码')
            ->setCellValue('H' . 1, '添加时间');
      
      
            
             
        
        $objActSheet = $objPHPExcel->getActiveSheet();
        
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:k1')
            ->getFont()
            ->applyFromArray(array(
            'name' => 'Arial',
            'bold' => TRUE,
            'italic' => FALSE,
            'strike' => FALSE,
            'color' => array(
            'rgb' => 'ffffffff'
            )
        ));
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension('A')
            ->setWidth(20);
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension('B')
            ->setWidth(20);
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension('C')
            ->setWidth(20);
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension('D')
            ->setWidth(20);
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension('E')
            ->setWidth(20);
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension('F')
            ->setWidth(20);
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension('G')
            ->setWidth(20);
       $objPHPExcel->getActiveSheet()
            ->getColumnDimension('H')
            ->setWidth(20);
   
        
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:K1')
            ->getFill()
            ->applyFromArray(array(
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            
            'startcolor' => array(
                'rgb' => '00004d8f'
            ),
            'endcolor' => array(
                'argb' => 'FFFFFFFF'
            )
        ));
        
       $afCode=AfCode::find()->andFilterWhere(['batch_num'=>$batch_num,"distributor_id"=>$distributor_id,"goods_id"=>$goods_id,"status"=>$status])->orderBy("id desc")->all();
         
      //->setCellValueExplicit('F' . $num, " ".$v->id_num,\PHPExcel_Cell_DataType::TYPE_STRING)
      //   $this->dump($rechargeCard);
        
        foreach ($afCode as $key => $v) {
          	$num = $key + 2;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $num, $v->id)
                ->setCellValue('B' . $num, $v->batch_num)
                ->setCellValue('C' . $num, $v->number)
                ->setCellValue('D' . $num, $v->distributor_id)
                ->setCellValue('E' . $num, $v->goods_id)
                ->setCellValue('F' . $num, $v->status==1?"已使用":"未使用")
                ->setCellValue('G' . $num, $v->number)
                ->setCellValue('H' . $num, date("Y-m-d",$v->create_time));
          
           
              	
            $num ++;
        }
      
        $objPHPExcel->getActiveSheet()->setTitle('sheet1');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $title . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    
           
        
       
    }

   

}
