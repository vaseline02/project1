<?php
include "../_header.php";
//load.php

$qry = "SELECT gdi.*,ml.mall_name FROM goods_deal_info gdi 
join mall_list ml on gdi.mall_no=ml.no
where s_date <= '".$_POST['date_to']."' and e_date >= '".$_POST['date_from']."' order by no desc";

$res=$db->query($qry);


foreach($res->results as $row){
	
	$qry2="select b.brandnm from goods_deal_detail gdd 
	join goods g on g.no =gdd.goodsno
	join brand b on b.no =g.brandno
	where info_no='".$row['no']."'
	group by b.brandnm
	";
	
	$res2=$db->query($qry2);
	
	foreach($res2->results as $v){
		$row['add_title'][]=$v['brandnm'];
	}
	
	$row['deal_name']=$row['mall_name']."-".$row['deal_name']."(".implode(",",$row['add_title']).")";
	
	if($row['confirm_admin_no'])$row['deal_name']="[승인완료] ".$row['deal_name'];

	$data[]=$row;
}
echo json_encode($data);

?>