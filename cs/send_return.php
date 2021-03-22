<?
include "../_header.php";

$page_title='기타발송관리(CS회수확인-반품)';
$returnType='return';
$step='2';
$CANCEL=NEW cancel();


//몰명
$mall_list=get_mall_info();
/*매장코드*/
$codedata=get_codedata('place','1'); 
//택배사 함수
$delivery_list=get_delivery_info();

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-3 month", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

if($_POST['mode']=="allCancel"){
	if(count($_POST['chk_no'])){
		try
    	{
			$db->beginTransaction();
			
			foreach($_POST['chk_no'] as $v){                
                //상태변경
				$CANCEL->stepChange($v,$_POST['code']);
				if($_POST['code']=='4'){
					if($_POST['codeSelect']=='bad'){
						$CANCEL->badIns($v, 'cs_return_bad');
					}else{
						//재고등록
						$CANCEL->stockChange($v,$_POST['codeSelect'],'cs_return');
						//order_list 교환재고업데이트
						$CANCEL->cancelStock($v,'return_num');

						//stock_list 복원
						$CANCEL->order_stock_list($v);

					}
				}
			}
			//$db->rollBack();
			$db->commit();
			msg("처리되었습니다.","send_return.php");
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,"send_return.php");		
		}  
	}
}
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
if($_GET['s_send_type'])$add_where[]="cd.send_type='".$_GET['s_send_type']."' ";
if($_GET['s_date'] && $_GET['e_date'])$add_where[]="ci.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";
if($_GET['s_admin'])$add_where[]="(m.id like '%".$_GET['s_admin']."%' or m.name like '%".$_GET['s_admin']."%') ";
$add_where[]="ci.return_type='60'";
$add_where[]="cd.send_type='".$step."'";
$add_where[]="cd.return_confirm='1'";
$add_where[]="cd.order_list_no > '0'";

if(count($add_where)){
    /*리스트*/	
	$selectClaim=$CANCEL->selectClaim($add_where);

	$tpl->assign(array(	
	'loop' => $selectClaim
	,'delivery_list' => $delivery_list
	,'mall_list' => $mall_list
	));
}

foreach($_GET['s_mall_no'] as $v){
	$checked['mall_no'][$v]="checked";
}
$selected['ing_type'][$_GET['s_ing_type']]="selected";
$selected['return_type'][$_GET['s_return_type']]="selected";
$selected['send_type'][$_GET['s_send_type']]="selected";

    
$tpl->print_('tpl');
?>
