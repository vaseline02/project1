<?
include "../_header.php";

$page_title='교환반품입출고관리';
$formType='cs';
$step='1';
$CANCEL=NEW cancel();
$QUERY_STRING = $_SERVER['QUERY_STRING'];
//몰명
$mall_list=get_mall_info();

//택배사 함수
$delivery_list=get_delivery_info();

//발송코드
$codedata=get_codedata('place','1');

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-3 month", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

if($_POST['mode']=="cancel"){
	if($_POST['no']){
		try
		{
			$db->beginTransaction();
			//교환건 철회할경우 상품의 재고 다시 넣어준다.
			$cqry="select cd.exchange_stock_yn, ci.return_type, sil.* from cs_detail cd 
			join cs_info ci on (cd.cs_info_no=ci.no)
			join stock_io_log sil on (cd.no=sil.reference_no)			
			where cd.no='".$_POST["no"]."' and sil.io_type='cs_hold'";
			$cres=$db->query($cqry);
			if(count($cres->results)){
				foreach($cres->results as $v){
					if($v['return_type']=='70' && $_POST["code"]=='91'){
						//$okd=stock_io('cs_hold_cancel',$v["goodsno"],$v["goodsnm"],$v["cnt"],$v["reference_no"],$_SERVER['REQUEST_URI'],$v['loc_b'],$v['loc_f'],$v['exchange_stock_yn']);
					}
				}
			}

			$param=array(
				":code"=>$_POST["code"]
				,":no"=>$_POST["no"]			
			);	
			$qry="update cs_detail set send_type=:code where no=:no";
			if(!$db->query($qry,$param)){
                throw new Exception('정상처리되지 않았습니다.', 1);
            }            
			$db->commit();
       	 	msg("철회 되었습니다.","send_reception.php?".$QUERY_STRING);	
		}
		catch(Exception $e)
		{
			$db->rollBack();

			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
			msg($s,"send_reception.php?".$QUERY_STRING);
		}  
	}
}else if($_POST['mode']=="allCancel"){
	if(count($_POST['chk_no'])){
		try
    	{
			$db->beginTransaction();
			
			foreach($_POST['chk_no'] as $v){                
                //상태변경
                $CANCEL->stepChange($v,$_POST['code']);
			}

			$db->commit();
			msg("처리되었습니다.","send_reception.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,"send_reception.php?".$QUERY_STRING);		
		}  
	}
}else if($_POST['mode']=="restore"){
	if($_POST['no']){
		try
		{
			$db->beginTransaction();
			$param=array(
				":code"=>$_POST["code"]
				,":no"=>$_POST["no"]			
			);	
			$qry="update cs_detail set send_type=:code where no=:no";
			if(!$db->query($qry,$param)){
				throw new Exception('정상처리되지 않았습니다.', 1);
			}            
			$db->commit();
			msg("접수상태로 변경되었습니다.","send_reception.php?".$QUERY_STRING);	
		}
		catch(Exception $e)
		{
			$db->rollBack();

			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
			msg($s,"send_reception.php?".$QUERY_STRING);
		}  
	}
}else if($_POST['mode']=="in"){
	if(count($_POST['chk_no'])){
		try
    	{
			$db->beginTransaction();
			
			foreach($_POST['chk_no'] as $v){          
				//상태변경
                $CANCEL->stepChange($v,$_POST['code']);                
			}
			$db->commit();
			msg("처리되었습니다.","send_reception.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,"send_reception.php?".$QUERY_STRING);		
		}  
	}
}else if($_POST['mode']=="out"){
	if(count($_POST['chk_no'])){
		try
    	{
			$db->beginTransaction();			
			foreach($_POST['chk_no'] as $v){          
				$sqry="select ci.* from cs_info ci
				left join cs_detail cd on (ci.no=cd.cs_info_no)
				where cd.no='".$v."'";
				$sres=$db->query($sqry);
				$csInfo=$sres->results[0];

				//상태변경
                $CANCEL->stepChange($v,$_POST['code']);
                //교환발송
                if($_POST['code']=='2' && ($csInfo['return_type']=='70' || $csInfo['return_type']=='90'))$CANCEL->exchangeStockOut($v, 'cs_exchange', $_POST['place_code']);
			}
			$db->commit();
			msg("처리되었습니다.","send_reception.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,"send_reception.php?".$QUERY_STRING);		
		}  
	}
}else if($_POST['mode']=="return"){
	if(count($_POST['chk_no'])){
		try
    	{
			$db->beginTransaction();			
			foreach($_POST['chk_no'] as $v){          
				$sqry="select ci.*, cd.goods_no from cs_info ci
				left join cs_detail cd on (ci.no=cd.cs_info_no)
				where cd.no='".$v."'";
				$sres=$db->query($sqry);
				$csInfo=$sres->results[0];

				if($csInfo['goods_no']) $place_code='not_stock';
				else $place_code='outside';

				//상태변경
                $CANCEL->stepChange($v,$_POST['code']);
                //교환발송
                if($_POST['code']=='2' && ($csInfo['return_type']=='90' || $csInfo['return_type_sub']=='2'))$CANCEL->exchangeStockOut($v, 'cs_exchange', $place_code);
			}
			$db->commit();
			msg("처리되었습니다.","send_reception.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,"send_reception.php?".$QUERY_STRING);		
		}  
	}
}else if($_POST['mode']=="send"){
	if(count($_POST['chk_no'])){
		try
    	{
			$db->beginTransaction();			
			foreach($_POST['chk_no'] as $v){          
				$sqry="select ci.*, cd.goods_no from cs_info ci
				left join cs_detail cd on (ci.no=cd.cs_info_no)
				where cd.no='".$v."'";
				$sres=$db->query($sqry);
				$csInfo=$sres->results[0];

				//상태변경
                $CANCEL->stepChange($v,$_POST['code']);
                //교환발송
                if($_POST['code']=='2' && ($csInfo['return_type']=='40'))$CANCEL->exchangeStockOut($v, 'cs_send', $_POST['place_code']);
			}
			$db->commit();
			msg("처리되었습니다.","send_reception.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,"send_reception.php?".$QUERY_STRING);		
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
if($_GET['s_return_type_sub'])$add_where[]="(ci.return_type in ('60','70') and ci.return_type_sub='".$_GET['s_return_type_sub']."') ";
if($_GET['s_send_type'])$add_where[]="cd.send_type='".$_GET['s_send_type']."' ";
if($_GET['s_date'] && $_GET['e_date'])$add_where[]="ci.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";
if($_GET['s_admin'])$add_where[]="(m.id like '%".$_GET['s_admin']."%' or m.name like '%".$_GET['s_admin']."%') ";
//$add_where[]="ci.return_type in ('60','70','90')";
$add_where[]="((ci.return_type in ('60','70') and ci.return_type_sub!='3') or ci.return_type='90' or ci.return_type='40')";
$add_where[]="ci.add_type in ('1')";
//$add_where[]="(cd.send_type in ('1','90') OR (cd.send_type='2' and return_confirm='0') )";
$add_where[]="cd.order_list_no > '0'";

if(count($add_where)){
	/*접수리스트*/	
	$claimWhere=$add_where;	
	$claimWhere[]="cd.send_type in ('1','90')";
	$selectClaim=$CANCEL->selectClaim($claimWhere);
	
	foreach($selectClaim as $v){
		$selectClaim2[] = infoMasking($v, 'order_list'); //마스킹
	}
	/*회수확인리스트*/	
	$restoryWhere=$add_where;
	$restoryWhere[]="cd.send_type='2' and return_confirm='0'";	
    $selectRestore=$CANCEL->selectClaim($restoryWhere);
    
	$tpl->assign(array(	
    'loop' => $selectClaim2
	,'pg' => $CANCEL->pg_return()
	,'rloop' => $selectRestore
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
$selected['return_type_sub'][$_GET['s_return_type_sub']]="selected";

$tpl->print_('tpl');
?>
