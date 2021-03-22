<?
include "../_header.php";

if($_POST['order_search_invo_chk'])$add_where=" and (o.invoice='' || o.invoice='0' )";
$add_where.="and o.upload_form_type in('타임메카','스토어팜','오피셜')";
$add_where.="and cd.send_type='2' and ci.return_type in ('40','70','90')";

/*리스트*/
$param = $db->inqry_param($_POST['chk_no']);
	try{
	$db->beginTransaction();
	
$qry="select o.*,ml.mall_code,ml.wms_mallnm company_name from 
cs_detail cd
join cs_info ci on cd.cs_info_no=ci.no
join order_list o on cd.no=o.csno
join mall_list ml on o.mall_no=ml.no
where cd.no in (".implode(",",array_keys($param)).")
".$add_where."
";


$res = $db->query($qry,$param);

		$db->commit();
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
	}

foreach($res->results as $v){

	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>