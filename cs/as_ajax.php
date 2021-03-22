<?php
include "../_header.php";


$cateNo=$_POST['cateNo'];

$data['as_contents']=$cfg_as_contents[$cateNo];
$data['sub_cate']=$cfg_as_sub_cate[$cateNo];

echo json_encode($data);
?>