<?
include "../_header.php";

$page_title='품절관리';
$formType='cs';

$time = time(); 
$s_date_value=$_POST['s_date']?$_POST['s_date']:date("Y-m-d",strtotime("-15 day", $time)); 
$e_date_value=$_POST['e_date']?$_POST['e_date']:date("Y-m-d",strtotime("now", $time)); 


//몰명리스트 함수
$mall_list=get_mall_info();

/**
 * s_mall_no : 몰번호
 * s_receiver : 고객명
 * s_invoice : 송장번호
 * s_date : 주문일자 (시작)
 * e_date : 주문일자 (종료)
 * s_mall_goodsnm : 모델명
 * s_ordno : 주문번호
 */

if($_POST['s_complete']=='')$_POST['s_complete']='1';

if($_POST['s_ordno']){
	$add_where[]="ol.ordno like '%".$_POST['s_ordno']."%' ";
}else{

	if($_POST['s_receiver']) $add_where[]=nameMasking($_POST['s_receiver']);
	if(count($_POST['s_mall_no']))$add_where[]="ol.mall_no in ('".implode("','",$_POST['s_mall_no'])."')";
	if($_POST['s_mobile'])$add_where[]="concat(ol.buyer_mobile,' ',ol.mobile) like '%".$_POST['s_mobile']."%' ";
	if($_POST['s_date'] && $_POST['e_date'])$add_where[]="ol.reg_date between '".$_POST['s_date']."' and '".$_POST['e_date']."'";
	if($_POST['s_mall_goodsnm'])$add_where[]="ol.mall_goodsnm like '%".$_POST['s_mall_goodsnm']."%' ";
	if($_POST['s_invoice'])$add_where[]="ol.invoice like '%".$_POST['s_invoice']."%' ";
	if($_POST['s_admin'])$add_where[]="(m.id like '%".$_POST['s_admin']."%' or m.name like '%".$_POST['s_admin']."%') ";
	if($_POST['s_ing_type']!='')$add_where[]="cc.ing_type = '".$_POST['s_ing_type']."' ";

	if($_POST['s_complete']=='1'){
		$add_where[]="((ol.step='3' and ol.step2='0') or (ol.step='2' and ol.step2='41')) ";	
	}else if($_POST['s_complete']=='2'){
		$add_where[]="ol.step2='141'";
	}else{
		$add_where[]="((ol.step='3' and ol.step2='0') or (ol.step='2' and ol.step2='41') or (ol.step2='141')) ";
	}

}
if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}
if($_POST && $add_where){
    
	/*리스트*/
	$qry="select ol.*,g.goodsnm,b.brand_img_folder from 
	order_list ol 
    left join goods g on (ol.goodsno=g.no) 
	left join brand b on g.brandno = b.no	
    where 1=1 ".$add_where." order by mod_date desc ";
    $res = $db->query($qry);
	$bf_ordno='';
	$color_key=0;
	foreach($res->results as $v){

		if($bf_ordno!=$v['ordno']){
			$bf_ordno=$v['ordno'];
			$color_key++;
		}
        $v['line_color']="table_tr".$color_key%2;

        if(!$_POST['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
        
		if($v['bundle']>0)$v['bundle_color']="red";
		if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
		if(isset($v['ing_type'])) $v['ing_type']=$cfg_ing_type[$v['ing_type']];
		$loop[]=$v;
	}

	$tpl->assign(array(	
    'loop' => $loop
	));
}

foreach($_POST['s_mall_no'] as $v){
	$checked['mall_no'][$v]="checked";
}

$selected['ing_type'][$_POST['s_ing_type']]="selected";
$selected['s_complete'][$_POST['s_complete']]="selected";

$tpl->assign(array(	
    'mall_list' => $mall_list
));
    
$tpl->print_('tpl');
?>
