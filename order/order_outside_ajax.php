<?php
include "../_header.php";


$mode=$_POST['mode'];
if($mode=='mod'){
    $no=$_POST['no'];
	$brandno=$_POST['brandno'];

    $qry="update order_outside_brand_mat set brandno='".$brandno."' where no='".$no."'";
    $db->query($qry);

	$sqry="select * from mall_brand mb
	left join mall_list ml on (mb.mall_no=ml.no)
	where mb.brand_no='".$brandno."'
	order by mb.no desc limit 1
	";
	$sres=$db->query($sqry);
	$mallData=$sres->results[0];

	echo json_encode($mallData);
}
?>