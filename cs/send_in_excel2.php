<?
include "../_header.php";


/*리스트 . 구 재고 어드민에 올리는 형식을 다운받기 위해서 임시로 만들어서 사용.*/

$codedata= get_codedata('place','1');

foreach($codedata as $v){

	$place_name[$v['no']]=$v['cd'];
}

if($_POST['order_search_invo_chk'])$add_where=" and (o.invoice='' || o.invoice='0' )";

$param = $db->inqry_param($_POST['chk_no']);

$qry="select o.*,ml.mall_code,ml.wms_mallnm company_name, ci.return_type, ci.goods_bad_memo, ci.admin_name, ci.return_type_sub, cd.exchange_goods_num, cd.in_reg_date ".$cfg_select_gcl." from 
cs_detail cd
join cs_info ci on cd.cs_info_no=ci.no
join order_list o on cd.order_list_no=o.no
join goods g on o.goodsnm=g.goodsnm
join goods_cnt_loc gcl on g.no=gcl.goodsno
join mall_list ml on o.mall_no=ml.no

where cd.no in (".implode(",",array_keys($param)).")
".$add_where."
";

$res = $db->query($qry,$param);


$bf_ordno='';
$color_key=0;
$list_num=1;

foreach($res->results as $v){
	$v['return_type_nm']=$cfg_retrun_type_sub[$v['return_type']][$v['return_type_sub']];

	$v['place_name']=$place_name[$v['deli_codeno']];
	$ex_order_cost=explode("^",$v['order_cost']);
	if(is_array($ex_order_cost))$v['order_cost']=$ex_order_cost[1];
	else $v['order_cost']='0';

	if($v['return_type_sub']=='2') $v['bad_memo']=$v['goods_bad_memo'];

	$v['invoice_text']=str_replace("-","",reset(explode(" ",$v['in_reg_date'])))."_".$v['ordno']."/".$v['admin_name'];
	$v['mall_name']=chk_mallnm($v['mall_name']);

	if($v['upload_form_type']=='B2B'){
		$v['company_name']='도매';
	}else if($v['upload_form_type']=='스토어팜'){
		$v['company_name']='스토어팜';
	}else if($v['upload_form_type']=='사방넷'){
		$v['company_name']='EC';
	}


	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>