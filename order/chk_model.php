<?php
include "../_header.php";


$model_name=$_POST['model_name'];
$chkyn="N";
$qry="select count(*) cnt from goods g where g.goodsnm='".$model_name."'";
$res=$db->query($qry);
$data=$res->results['0']['cnt'];
if($data){
    $chkyn="Y";
}

echo json_encode($chkyn);
?>