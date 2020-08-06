<?php


function dikaer($arr){
 $arr1 = array();
 $result = array_shift($arr);
 while($arr2 = array_shift($arr)){
  $arr1 = $result;
  $result = array();
  foreach($arr1 as $v){
   foreach($arr2 as $v2){
    $result[] = $v.','.$v2;
   }
  }
 }
 return $result;
}





// 定义集合
$arr = array(
	array('男款'),
	array('32G'),
    array('白色','黑色','红色'),
    array('透气','防滑'),
        
);

//$arr	= array(array(1),array(2,3),array(4,5,6));

$a=dikaer($arr);


//$result = CartesianProduct($sets);
echo "<pre>";
var_dump($a);



?>

