<?
include "../_header.php";

$depth=$_POST['depth'];
$depth_1=$_POST['depth_1'];
$depth_2=$_POST['depth_2'];

if($depth=="1"){
	$catelist=get_cate_info($depth_1);
}else if($depth=="2"){  
	$catelist=get_cate_info($depth_1,$depth_2);
}

echo json_encode($catelist);

?>