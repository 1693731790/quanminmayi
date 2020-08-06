<?php
//用于使用延时消息队列检查优惠券过期状态
use Yii;
use common\models\Coupon;
class Coupon extends BaseObject implements \yii\queue\JobInterface
{
    public $id;
	
    public function execute($queue)
    {
		$model=Coupon::finOne($this->id);
		if($model==null){
			return false;
		}
		$time=time();
		if($model->status==0){
			if($time-$model->end_time>=0){
				$model->status=-1;
				if(!$model->save()){
					Yii::$app->queue->delay(5*60)->push(new Coupon(['id'=>$this->id]));
				}
			}else{
				$delay_time=$time-$model->end_time+1;
				Yii::$app->queue->delay($delay_time)->push(new Coupon(['id'=>$this->id]));
			}
		}
    }
}