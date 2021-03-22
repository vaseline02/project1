<?
include "../_header.php";

$page_title='교환반품입출고관리(처리완료)';
$formType='cs';
$step='4';
$CANCEL=NEW cancel();

//몰명
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-3 month", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

/**
 * s_mall_no : 몰번호
 * s_receiver : 고객명
 * s_invoice : 송장번호
 * s_date : 주문일자 (시작)
 * e_date : 주문일자 (종료)
 * s_mall_goodsnm : 모델명
 * s_ordno : 주문번호
 */
if($_GET['s_return_invoice'])$add_where[]="ci.return_invoice like '%".$_GET['s_return_invoice']."%' ";
if(count($_GET['s_mall_no']))$add_where[]="ol.mall_no in ('".implode("','",$_GET['s_mall_no'])."')";
if($_GET['s_order_no'])$add_where[]="ci.order_no like '%".$_GET['s_order_no']."%' ";
if($_GET['s_return_type'])$add_where[]="ci.return_type='".$_GET['s_return_type']."' ";
if($_GET['s_return_type_sub'])$add_where[]="(ci.return_type in ('60','70') and ci.return_type_sub='".$_GET['s_return_type_sub']."') ";

if($_GET['s_send_type'])$add_where[]="cd.send_type='".$_GET['s_send_type']."' ";
if($_GET['s_date'] && $_GET['e_date'])$add_where[]="ci.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";
if($_GET['s_date2'] && $_GET['e_date2'])$add_where[]="cd.end_reg_date between '".$_GET['s_date2']." 00:00:00' and '".$_GET['e_date2']." 23:59:59'";
if($_GET['s_admin'])$add_where[]="(m.id like '%".$_GET['s_admin']."%' or m.name like '%".$_GET['s_admin']."%') ";
if($_GET['s_goodsnm'])$add_where[]="ol.goodsnm like '%".$_GET['s_goodsnm']."%'";
//$add_where[]="ci.return_type in ('60','70','90')";
$add_where[]="((ci.return_type in ('60','70') and ci.return_type_sub!='3') or ci.return_type='40' or ci.return_type='90')";
$add_where[]="cd.send_type='".$step."'";
//$add_where[]="cd.return_confirm='1'";
$add_where[]="cd.order_list_no > '0'";
$add_where[]="ci.add_type in ('1')";

if(count($add_where)){
    /*리스트*/	
    if($_POST['print_xls']) $pagenum='99999';
    else  $pagenum='50';
    
    $selectClaim=$CANCEL->selectClaim($add_where,'cd.end_reg_date desc','1',$pagenum);
    
	$tpl->assign(array(	
    'loop' => $selectClaim
	,'pg' => $CANCEL->pg_return()
    ,'delivery_list' => $delivery_list
    ,'mall_list' => $mall_list
	));
}


foreach($_GET['s_mall_no'] as $v){
	$checked['mall_no'][$v]="checked";
}
$selected['ing_type'][$_GET['s_ing_type']]="selected";
$selected['return_type'][$_GET['s_return_type']]="selected";
$selected['return_type_sub'][$_GET['s_return_type_sub']]="selected";
$selected['send_type'][$_GET['s_send_type']]="selected";
$selected['return_type_sub'][$_GET['s_return_type_sub']]="selected";
    
$tpl->print_('tpl');
?>
