<?
include "../_header.php";

//if($_POST['order_search_invo_chk'])$add_where=" and (o.invoice='' || o.invoice='0' )";
//$add_where.="and o.upload_form_type in('타임메카','스토어팜','오피셜')";

/*리스트*/
$param = $db->inqry_param($_POST['chk_no']);
	
$qry="select o.*,g.goodsnm as g_goodsnm, ml.mall_code,ml.wms_mallnm company_name from 
cs_bad cb 
join goods g on cb.goods_no=g.no
left join order_list o on cb.order_list_no=o.no
left join mall_list ml on o.mall_no=ml.no

where cb.no in (".implode(",",array_keys($param)).")
".$add_where."
";

$res = $db->query($qry,$param);

foreach($res->results as $v){
	$v['return_type_nm']=$cfg_retrun_type_sub[$v['return_type']][$v['return_type_sub']];

	$v['mall_name']=chk_mallnm($v['mall_name']);
	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>