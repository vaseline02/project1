<?
include "../_header.php";

if($_POST['order_search_invo_chk'])$add_where=" and (o.invoice='' || o.invoice='0' )";
$add_where.="and o.upload_form_type not in('타임메카','스토어팜','오피셜')";

/*리스트*/
$param = $db->inqry_param($_POST['chk_no']);

$qry="select o.*,ml.mall_code,ml.wms_mallnm company_name from 
cs_bad cb 
join order_list o on cb.order_list_no=o.no
join mall_list ml on o.mall_no=ml.no
where cb.no in (".implode(",",array_keys($param)).")
".$add_where."
";

$res = $db->query($qry,$param);


foreach($res->results as $v){

    $v['tot_price']=$v['settle_price'];

	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>