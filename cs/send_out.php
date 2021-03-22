<?
include "../_header.php";

$page_title='교환반품입출고관리(발송)';
$returnType='exchange';
$step='2';
$CANCEL=NEW cancel();

$QUERY_STRING = $_SERVER['QUERY_STRING'];
//몰명
$mall_list=get_mall_info();

/*매장코드*/
$codedata=get_codedata('place','1'); 

//택배사 함수
$delivery_list=get_delivery_info();

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-3 month", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

if($_FILES){
	ini_set('memory_limit', -1);
	ini_set('max_execution_time',0);

	$excel_data=excel_read('unlink','2');

	try{
		$db->beginTransaction();

		foreach($excel_data as $k=>$v){
			$delivery_code='';
			if($v['0']!='합계'){
				$c_gubun=substr($v['7'],0,1);
					
				$dqry="select code from delivery_info where c_gubun like '%|".$c_gubun."|%' and c_gubun!=''";
				$dres=$db->query($dqry);
				$delivery_code=$dres->results[0]['code'];

				$sqry="select step from order_list where ordno='".$v['5']."' and goodsnm='".$v['13']."'";
				$sres=$db->query($sqry);
				$step=$sres->results[0]['step'];
								
				//$mall_name=getEntnmToMallname($v['6']);
				
				unset($param);
				$set="";

				if($step!='50' && $step!='55' && $step!='40' && $step!='70'){
					throw new Exception($k."열 교환및출고주문건 오류", 1); 
				}else if(!$delivery_code){
					throw new Exception($k."열 택배사명 오류", 1); 					
				}else{
					if($step=="50"){
						$set=',step=:step';
						$param[':step']='51';
					}

					$qry="update order_list set 
					invoice=:invoice
					,courier_code=:courier_code
					,wms_ordno=:wms_ordno
					,cha_su=:cha_su					
					,comp_date=now()
					".$set."
					where 1
					and ordno=:ordno
					and goodsnm=:goodsnm
					";
	
					//$param[':mall_name']=$mall_name;
					

					$param[':ordno']=$v['5'];
					$param[':goodsnm']=$v['13'];
					$param[':invoice']=$v['7'];
					$param[':cha_su']=$v['3'];
					$param[':wms_ordno']=$v['4'];
					$param[':courier_code']=$delivery_code;

					$res=$db->query($qry,$param);
				}
			}
		}
		
		$db->commit();
		msg('처리되었습니다','send_out.php');
		
	
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
	}
}

if($_POST['mode']=="in"){
	if(count($_POST['chk_no'])){
		try
    	{
			$db->beginTransaction();
			
			foreach($_POST['chk_no'] as $v){          
				$sqry="select ci.return_type from cs_info ci
				left join cs_detail cd on (ci.no=cd.cs_info_no)
				where cd.no='".$v."'
				";
				$sres=$db->query($sqry);
				$info_return_type=$sres->results[0]['return_type'];
				//상태변경
				if($info_return_type=='40' || $info_return_type=='90'){
					$CANCEL->stepChange($v,'4');                
				}else{
					$CANCEL->stepChange($v,$_POST['code']);                
				}
			}
			$db->commit();
			msg("처리되었습니다.","send_out.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,"send_out.php?".$QUERY_STRING);		
		}  
	}
}else if($_POST['mode']=="cancel"){
	if($_POST['no']){
		try
		{
			$db->beginTransaction();
			$CANCEL->cs_cancel($_POST['no'],$_POST['code']);

			$db->commit();

			msg("철회되었습니다.","send_out.php?".$QUERY_STRING);
		}
		catch(Exception $e)
		{
			$db->rollBack();

			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';;

			msg($s,"send_out.php?".$QUERY_STRING);		
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
//if($_GET['s_return_type_sub'])$add_where[]="ci.return_type_sub='".$_GET['s_return_type_sub']."' ";
if($_GET['s_return_type_sub'])$add_where[]="(ci.return_type in ('60','70') and ci.return_type_sub='".$_GET['s_return_type_sub']."') ";
if($_GET['s_send_type'])$add_where[]="cd.send_type='".$_GET['s_send_type']."' ";
if($_GET['s_date'] && $_GET['e_date'])$add_where[]="ci.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";
if($_GET['s_admin'])$add_where[]="(m.id like '%".$_GET['s_admin']."%' or m.name like '%".$_GET['s_admin']."%') ";
//$add_where[]="ci.return_type in ('70','90')";
$add_where[]="((ci.return_type in ('70') and ci.return_type_sub!='3') or ci.return_type='40' or ci.return_type='90')";
$add_where[]="cd.send_type='".$step."'";
//$add_where[]="cd.return_confirm='1'";
$add_where[]="cd.order_list_no > '0'";
$add_where[]="ci.add_type in ('1')";

if(count($add_where)){
    /*리스트*/	
	$selectClaim=$CANCEL->selectClaim($add_where);

	foreach($selectClaim as $v){
		$selectClaim2[] = infoMasking($v, 'order_list'); //마스킹
	}

	$tpl->assign(array(	
	'loop' => $selectClaim2
	,'pg' => $CANCEL->pg_return()
	,'delivery_list' => $delivery_list
	,'mall_list' => $mall_list
	));
}
foreach($_GET['s_mall_no'] as $v){
	$checked['mall_no'][$v]="checked";
}
$selected['mall_no'][$_GET['s_mall_no']]="selected";
$selected['ing_type'][$_GET['s_ing_type']]="selected";
$selected['return_type'][$_GET['s_return_type']]="selected";
$selected['send_type'][$_GET['s_send_type']]="selected";
$selected['return_type_sub'][$_GET['s_return_type_sub']]="selected";
    
$tpl->print_('tpl');
?>
