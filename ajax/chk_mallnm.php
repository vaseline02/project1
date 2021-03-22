<?php
include "../_header.php";

$mallnm=$_POST['mallnm'];
$arr_mallnm=array();
if($mallnm){

	$qry="select d_code,d2_name from mall_list m where  m.d2_name like '".$mallnm."%'";
	$res=$db->query($qry);
	foreach($res->results as $v){
		$arr_mallnm[]=$v['d_code']."^".$v['d2_name'];
	}
}

echo json_encode($arr_mallnm);
?>
