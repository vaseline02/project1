<?php
include "../_header.php";

/*
$brand_name=$_POST['brand_name'];
$chkyn="N";
$qry="select count(*) cnt from brand b where b.type in ('O','A') and b.brandnm='".$brand_name."'";
$res=$db->query($qry);
$data=$res->results['0']['cnt'];
if($data){
    $chkyn="Y";
}
*/
$brand_name=$_POST['brand_name'];
$mode=$_POST['mode'];
$brandnm=array();

if($brand_name){
	$chkyn="N";
	if($mode=="allbrand"){
		$qry="select * from brand b where b.brandnm like '".$brand_name."%'";
		$res=$db->query($qry);
		foreach($res->results as $v){
			$brandnm[]=$v['brandnm'];
		}
	}else{
		$qry="select * from brand b where b.type in ('O','A') and b.brandnm like '".$brand_name."%'";
		$res=$db->query($qry);
		foreach($res->results as $v){
			$brandnm[]=$v['brandnm'];
		}
	}
}

echo json_encode($brandnm);
?>