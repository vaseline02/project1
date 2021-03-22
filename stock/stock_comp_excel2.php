<?
include "../_header.php";

$codedata= get_codedata('place','1');
$stock_type=$_GET['stock_type'];

foreach($codedata as $v){
	$place_name[$v['no']]=$v['cd'];
}

$codedata = get_codedata('IN');
foreach($codedata as $v){
	$codedata_no[$v['no']]=$v['cd'];
}


$param = $db->inqry_param($_POST['chk_no']);

$qry="select sl.*, cal.title, g.goodsnm as g_goodsnm ".$cfg_select_gcl." from 
stock_list sl
left join calendar cal on sl.group_id = cal.group_id
left join goods g on (sl.goodsno=g.no)
left join goods_cnt_loc gcl on g.no=gcl.goodsno

where sl.no in (".implode(",",array_keys($param)).")
".$add_where."
";

$res = $db->query($qry,$param);

foreach($res->results as $v){

	$v['invoice']=date("ymd")."_".$v['title'];
	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>