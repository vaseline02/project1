<?
include "../_header.php";


/*리스트 . 구 재고 어드민에 올리는 형식을 다운받기 위해서 임시로 만들어서 사용.*/

$codedata= get_codedata('place','1');

foreach($codedata as $v){

	$place_name[$v['no']]=$v['cd'];
}

if($_POST['order_search_invo_chk'])$add_where=" and (o.invoice='' || o.invoice='0' )";

$param = $db->inqry_param($_POST['chk_no']);

$qry="select o.*,ml.mall_code,ml.wms_mallnm company_name ".$cfg_select_gcl." from order_list o
join goods g on o.goodsnm=g.goodsnm
join goods_cnt_loc gcl on g.no=gcl.goodsno
join mall_list ml on o.mall_no=ml.no

where o.no in (".implode(",",array_keys($param)).")
".$add_where."
";

$res = $db->query($qry,$param);


$bf_ordno='';
$color_key=0;
$list_num=1;

foreach($res->results as $v){
	$v['place_name']=$place_name[$v['deli_codeno']];
	$v['tot_price']=$v['settle_price'];

	if($v['upload_form_type']=='B2B'){
		$v['company_name']='도매';
	}else if($v['upload_form_type']=='스토어팜'){
		$v['company_name']='스토어팜';
	}


	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>