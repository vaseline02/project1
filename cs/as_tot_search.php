<?
include "../_header.php";

$page_title='AS 통합검색';

$popup_chk=1; //메뉴 컨트롤
$ORDER=new order();
/*리스트*/
$s_total=$_GET['s_total'];
$schedule_3=$_GET['schedule_3'];

$checked['schedule_3'][$schedule_3]="checked";

if($_GET){
	$add_where="";
	if($s_total){
		//통합검색 : 고객명, 옵션명, 주문번호, 출고송장번호, 반품송장번호,사방넷주문번호, 접수자-as,구매자-as, 연락처-as
		$or_where[]=nameMasking($s_total);
		$or_where[]="ol.goodsnm='".$s_total."'";
		$or_where[]="ol.ordno='".$s_total."'";
		$or_where[]="ol.mobile='".$s_total."'";
		$or_where[]="ol.buyer_mobile='".$s_total."'";
		$or_where[]="ol.invoice='".$s_total."'";
		$or_where[]="ol.return_invoice='".$s_total."'";
		$or_where[]="ol.wms_ordno='".$s_total."'";

		$or_where[]="ai.receipt_name='".$s_total."'";
		$or_where[]="ai.receiver='".$s_total."'";
		$or_where[]="ai.mobile='".$s_total."'";

		$add_where[]="(".implode(" or ",$or_where).")";
	}

	if($_GET['schedule_3'])$add_where[]="ad.as_status < 6 and DATEDIFF(ad.schedule_date,NOW()) < 3";

	if($add_where){
		$add_where=" and ".implode(" and ",$add_where);
	}

	$qry="select ol.*, ad.as_status, ad.no as as_no, ad.goodsnm as as_goodsnm, ai.receipt_name from as_info ai
	left join as_detail ad on (ai.no=ad.info_no)
	left join order_list ol on (ad.order_list_no=ol.no)
	where 1 ".$add_where."
	order by ai.no desc
	";
	$res = $db->query($qry);
	
	foreach($res->results as $v){
			
		$loop[]=$v;		
	}

	$tpl->assign('loop',$loop);

}

$tpl->print_('tpl');
?>
