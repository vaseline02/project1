<?
include "../_header.php";

$page_title='완료주문검색';

$codedata=get_codedata('place','1');

foreach($codedata as $v){
	$place_name[$v['no']]=$v['cd'];
}

if($_POST['s_mall'])$add_where[]="mall_name like '%".$_POST['s_mall']."%' ";
if($_POST['s_model'])$add_where[]="goodsnm like '%".$_POST['s_model']."%' ";
if($_POST['s_receiver'])$add_where[]=nameMasking($_POST['s_receiver']);
if($_POST['s_mobile'])$add_where[]="mobile like '%".$_POST['s_mobile']."%' ";
if($_POST['s_ordno'])$add_where[]="ordno like '%".$_POST['s_ordno']."%' ";
if($_POST['s_cancel'])$add_where[]="step2 >= '40' ";
if($_POST['s_date'] && $_POST['e_date']){
    
}else{
	$tday=date('Y-m-d');
	$_POST['s_date']=$tday;
	$_POST['e_date']=$tday;
}

if($_POST)$add_where[]="reg_date between '".$_POST['s_date']."' and '".$_POST['e_date']."'";


if($add_where)$add_where=" and ".implode(" and ",$add_where);


if($_POST){
	/*리스트*/
	$qry="select * from order_list where 1 ".$add_where." ";

	$res = $db->query($qry);

	$bf_ordno='';
	$color_key=0;
	foreach($res->results as $v){

		if($bf_ordno!=$v['ordno']){
			$bf_ordno=$v['ordno'];
			$color_key++;
		}
		$v['line_color']="table_tr".$color_key%2;

		if($v['bundle']>0)$v['bundle_color']="red";
		$v['place_name']=$place_name[$v['deli_codeno']];
		if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
		$loop[]=$v;
	}

	$tpl->assign(array(	
	'loop' => $loop
	));
}

$checked["s_cancel"][$_POST["s_cancel"]]="checked";
$tpl->print_('tpl');
?>
