<?
include "../_header.php";


/*리스트 . 구 재고 어드민에 올리는 형식을 다운받기 위해서 임시로 만들어서 사용.*/

$codedata= get_codedata('place','1');

foreach($codedata as $v){

	$place_name[$v['no']]=$v['cd'];
}

if($_POST['order_search_invo_chk'])$add_where=" and (o.invoice='' || o.invoice='0' )";

$param = $db->inqry_param($_POST['chk_no']);

$qry="select o.*, g.goodsnm as g_goodsnm, ml.mall_code,ml.wms_mallnm company_name ".$cfg_select_gcl." from 
cs_bad cb 
join goods g on cb.goods_no=g.no
join goods_cnt_loc gcl on g.no=gcl.goodsno
left join order_list o on cb.order_list_no=o.no
left join mall_list ml on o.mall_no=ml.no

where cb.no in (".implode(",",array_keys($param)).")
".$add_where."
";

$res = $db->query($qry,$param);


$bf_ordno='';
$color_key=0;
$list_num=1;

foreach($res->results as $v){
	$v['return_type_nm']=$cfg_retrun_type_sub[$v['return_type']][$v['return_type_sub']];

	$v['place_name']=$place_name[$v['deli_codeno']];
	$v['tot_price']=$v['settle_price'];

	if($v['return_type_sub']=='2') $v['bad_memo']=$v['goods_bad_memo'];


	$v['mall_name']=chk_mallnm($v['mall_name']);

	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>