<?
include "../_header.php";
/*외부 발송건 엑셀출력*/
if($_POST['order_search_invo_chk'])$add_where=" and (o.invoice='' || o.invoice='0' )";

//택배사 함수
$delivery_list=get_delivery_info();

/*리스트*/
$param = $db->inqry_param($_POST['chk_no']);

$qry="select ol.*,ml.mall_code,ml.wms_mallnm company_name, ml.c_mem_name, ml.d_code, ml.d_name, b.brandnm from order_list ol
left join goods g on (ol.goodsno=g.no)
left join brand b on (ol.outside_brand=b.no)
left join mall_list ml on (ml.d_code=ol.ent_code)

where ol.no in (".implode(",",array_keys($param)).")
".$add_where."
";

$res = $db->query($qry,$param);

$bf_ordno='';
$color_key=0;
$list_num=1;
foreach($res->results as $v){

    $v['tot_price']=$v['settle_price'];
	
	$v['mod_date']=substr($v['mod_date'],0,10);
	//$v['mod_date']=date('Y-m-d',strtotime($v['mod_date']));

	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
