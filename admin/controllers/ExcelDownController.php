<?php
namespace admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\RechargeCard;
use common\models\CallRechargeCard;
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
    
    public function actionCallRechargeCard($batch_num="")
    {   
           set_time_limit(0);
          ini_set('memory_limit', '1024M');

         $title="电话充值卡导出";
        
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
            ->setCellValue('D' . 1, '密码')
            ->setCellValue('E' . 1, '金额')
            ->setCellValue('F' . 1, '是否使用')
            ->setCellValue('G' . 1, '创建时间');
           // ->setCellValue('H' . 1, '二维码链接');
             
        
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
    /*  $objPHPExcel->getActiveSheet()
            ->getColumnDimension('H')
            ->setWidth(50);*/
    
        
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
        
       $rechargeCard=CallRechargeCard::find()->andFilterWhere(['batch_num'=>$batch_num])->orderBy("id desc")->all();
         
      //->setCellValueExplicit('F' . $num, " ".$v->id_num,\PHPExcel_Cell_DataType::TYPE_STRING)
//        $this->dump($rechargeCard);
          
        foreach ($rechargeCard as $key => $v) {
          
            $link=yii::$app->params['webLink']."/user/recharge-card.html?card_num=".$v->card_num."&password=".$v->password;
          	$num = $key + 2;
          
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $num, $v->id)
                ->setCellValue('B' . $num, $v->batch_num)
                ->setCellValue('C' . $num, $v->card_num)
                ->setCellValue('D' . $num, $v->password)
                ->setCellValue('E' . $num, $v->fee)
                ->setCellValue('F' . $num, $v->is_use==1?"已使用":"未使用")
                ->setCellValue('G' . $num, date("Y-m-d",$v->create_time));
              	//->setCellValue('H' . $num, $link);
                
                
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
    public function actionRechargeCard($batch_num="")
    {   
           set_time_limit(0);
          ini_set('memory_limit', '1024M');

         $title="充值卡导出";
        
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
            ->setCellValue('D' . 1, '密码')
            ->setCellValue('E' . 1, '金额')
            ->setCellValue('F' . 1, '是否使用')
            ->setCellValue('G' . 1, '创建时间')
            ->setCellValue('H' . 1, '二维码链接');
             
        
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
            ->setWidth(50);
    
        
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
        
       $rechargeCard=RechargeCard::find()->andFilterWhere(['batch_num'=>$batch_num])->orderBy("id desc")->all();
         
      //->setCellValueExplicit('F' . $num, " ".$v->id_num,\PHPExcel_Cell_DataType::TYPE_STRING)
//        $this->dump($rechargeCard);
          
        foreach ($rechargeCard as $key => $v) {
          
            $link=yii::$app->params['webLink']."/user/recharge-card.html?card_num=".$v->card_num."&password=".$v->password;
          	$num = $key + 2;
          
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $num, $v->id)
                ->setCellValue('B' . $num, $v->batch_num)
                ->setCellValue('C' . $num, $v->card_num)
                ->setCellValue('D' . $num, $v->password)
                ->setCellValue('E' . $num, $v->fee)
                ->setCellValue('F' . $num, $v->is_use==1?"已使用":"未使用")
                ->setCellValue('G' . $num, date("Y-m-d",$v->create_time))
              	->setCellValue('H' . $num, $link);
                
                
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
