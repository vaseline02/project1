<?
include "../_header.php";

$page_title='AS상품접수';
$formType='cs';

$mode=$_POST["mode"];
$no=$_POST["no"];
$returnUrl=$_POST["returnUrl"]?$_POST["returnUrl"]:"cs_receipt.php";
$returnInvoice=$_POST["returnInvoice"];

//몰명리스트 함수
$mall_list=get_mall_info();
//택배사 함수
$delivery_list=get_delivery_info();

foreach($delivery_list as $v){
	$inv_name[]=$v['name'];
	$inv_name[$v['name']]=$v['code'];
}

if($_FILES){
	$excel_data=excel_read('unlink','3');
	
	/*CJ대한통운으로 픽스
	foreach($excel_data as $k=>$v){
		
		if(!in_array($v['0'],$inv_name))$err_msg[]=$k."번열 등록되지않은 택배사명";
	}
	*/
	if (sizeof($err_msg) > 0) {
		tydebug($err_msg);
	}else{
		//tydebug('등록시작');			
		try{
			
			$db->beginTransaction();

			foreach($excel_data as $k=>$v){

				$param[':return_courier_code']=$inv_name['CJ대한통운'];
				$param[':return_invoice']=str_replace("-","",$v['3']);
				$param[':courier_code']=$inv_name['CJ대한통운'];
				$param[':invoice']=str_replace("-","",$v['4']);


				$qry="update order_list set
				return_courier_code=:return_courier_code
				,return_invoice=:return_invoice
				where courier_code=:courier_code
				and invoice=:invoice
				";
				
				$db->query($qry,$param);
				
			}

			//$db->rollBack();
			$db->commit();
			msg('처리되었습니다.','cs_receipt.php');
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage().":".$e->getFile());	
		}
	}
}

if($mode=='del'){

	$qry="delete from cs_receipt where no=:no";
	$param[':no']=$no;

	$db->query($qry,$param);
	
		
	$sqry="select no from as_info where receipt_no='".$no."'";
	$sres=$db->query($sqry);
	$receipt_no=$sres->results[0]['no'];

	if($receipt_no){
		$qry="delete from as_info where receipt_no='".$no."'";
		$db->query($qry);
		$qry="delete from as_detail where info_no='".$receipt_no."'";
		$db->query($qry);
	}


	msg('삭제되었습니다.',$returnUrl);

}else if($mode=='cs_ins'){
	$returnInvoice_array=paste_to_arr($returnInvoice);
	$return_invoice_array=array();
	if($returnInvoice_array){
		$returnInvoice_where=implode("','",$returnInvoice_array);
		$sqry="select ol.* from order_list ol where ol.return_invoice in ('".$returnInvoice_where."') group by ordno";
		$sres=$db->query($sqry);
		foreach($sres->results as $v){
			$iqry="insert into cs_info set
			order_no='".$v['ordno']."'
			,ori_order_no='".$v['ori_ordno']."'
			,return_type='1'
			,return_type_sub='1'
			,contents='택배상품접수'
			,admin_no='".$_SESSION["sess"]["m_no"]."'
			,admin_name='".$_SESSION["sess"]["name"]."'
			,reg_date=now()
            ";	
			$db->query($iqry);
			$return_invoice_array[]=$v['return_invoice'];
			
		}
		$notInvoice=array_diff($returnInvoice_array,$return_invoice_array);		
		$mess="([".implode(",",$notInvoice)."] 제외)";
		msg('등록되었습니다.\r\n'.$mess,$returnUrl);
	}
}

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-7 day", $time)); 
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

if($_GET['s_receiver']) $add_where[]=nameMasking($_GET['s_receiver']);
if(count($_GET['s_mall_no']))$add_where[]="ol.mall_no in ('".implode("','",$_GET['s_mall_no'])."')";
if($_GET['s_mobile'])$add_where[]="concat(ol.buyer_mobile,' ',ol.mobile) like '%".$_GET['s_mobile']."%' ";
//if($_GET['s_mobile'])$add_where[]="(ol.buyer_mobile like '%".$_GET['s_mobile']."%' or ol.mobile like '%".$_GET['s_mobile']."%')";
if($_GET['s_date'] && $_GET['e_date'])$add_where[]="cr.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";
if($_GET['s_mall_goodsnm'])$add_where[]="ol.mall_goodsnm like '%".$_GET['s_mall_goodsnm']."%' ";
if($_GET['s_invoice'])$add_where[]="concat(ol.invoice,ol.return_invoice) like '%".$_GET['s_invoice']."%' ";
if($_GET['s_ordno'])$add_where[]="ol.ordno like '%".$_GET['s_ordno']."%' ";
if($_GET['s_admin'])$add_where[]="(m.id like '%".$_GET['s_admin']."%' or m.name like '%".$_GET['s_admin']."%') ";
if($_GET['not_add'])$add_where[]="cr.return_type in ('1','2') and status='0'";
$add_where[]="cr.return_type='3'";

if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}

if($_GET && count($add_where)){
	/*리스트*/

	$qry="select cr.no as receipt_no, cr.return_type, cr.status, cr.receipt_type, cr.admin_no, cr.goodsnm as cs_goodsnm, cr.customer_name, cr.mobile as cs_mobile, cr.order_list_no
	, cr.memo as cs_memo, cr.reg_date as cs_reg_date, cr.delivery_code as cs_delivery_code, cr.invoice as cs_invoice, cr.account_code as cs_account_code, cr.account_number as cs_account_number

	, ol.*,g.goodsnm,b.brand_img_folder, m.id, m.name from cs_receipt cr
    left join order_list ol on (cr.order_list_no=ol.no) 
    left join goods g on (ol.goodsno=g.no) 
	left join brand b on (g.brandno = b.no)
	left join member m on (m.no=cr.admin_no)
	where 1=1 ".$add_where." order by cr.no desc";
	// tydebug($qry);
	$res = $db->query($qry);

	

    foreach($res->results as $v){
		//as접수 카운트 
		if($v['return_type']=='3'){
			$cqry="select count(no) as cnt, mod_admin_no from as_info where receipt_no='".$v['receipt_no']."'";
			$cres=$db->query($cqry);
			$v['receipt_count']=$cres->results['0']['cnt'];
			$v['mod_admin_no']=$cres->results['0']['mod_admin_no'];
		//cs접수 카운트
		}else{
			$cqry="select count(no) as cnt from cs_info where receipt_no='".$v['receipt_no']."'";
			$cres=$db->query($cqry);
			$v['receipt_count']=$cres->results['0']['cnt'];
		}

        if(!$_GET['search_noimg'])$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);
        
		if($v['bundle']>0)$v['bundle_color']="red";
		if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
		if(isset($v['ing_type'])) $v['ing_type']=$cfg_ing_type[$v['ing_type']];
		$loop[$v['receipt_type']][]=$v;
	}
	$tpl->assign(array(	
	'loop' => $loop	
	));
}
foreach($_GET['s_mall_no'] as $v){
	$checked['mall_no'][$v]="checked";
}

$selected['ing_type'][$_GET['s_ing_type']]="selected";
$checked['not_add'][$_GET['not_add']]="checked";

$tpl->assign(array(	
	'mall_list' => $mall_list
	,'delivery_list'=>$delivery_list
));
    
$tpl->print_('tpl');
?>
