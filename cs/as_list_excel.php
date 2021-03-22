<?
include "../_header.php";

/*리스트*/
$param = $db->inqry_param($_POST['chk_no']);

$qry="select ai.*,ml.mall_code,ml.wms_mallnm company_name from 
as_info ai
join as_detail ad on ai.no=ad.info_no
left join order_list o on ad.order_list_no=o.no
left join mall_list ml on o.mall_no=ml.no
where ai.no in (".implode(",",array_keys($param)).")
".$add_where."
";
$res = $db->query($qry,$param);


foreach($res->results as $v){

	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>