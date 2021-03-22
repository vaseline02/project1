<?
include "../_header.php";

$qry="update new_erp.goods_cnt_loc set
cur_cnt=cur_cnt-codeno_114
,codeno_114=0;
";
//tydebug($qry);
//$db->query($qry);


$qry="select m_no,sum(cur_cnt) cnt from timemecca1.stock s where cur_cnt>0 and place='현대백화점 위탁' 
group by m_no
";

$res=$db->query($qry); 

foreach($res->results as $v){

	$qry="update new_erp.goods_cnt_loc set
	codeno_114='".$v['cnt']."'
	,cur_cnt=cur_cnt+".$v['cnt']."
	where goodsno='".$v['m_no']."'
	";
	//$db->query($qry); 
}

tydebug('end');
?>
