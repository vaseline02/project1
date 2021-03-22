<?
include "../_header.php";

$page_title='CS관리(접수)';
$formType='cs';
$step='2';
$CANCEL=NEW cancel();

$time = time(); 
$s_date_value=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-3 month", $time)); 
$e_date_value=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 

if($_POST['mode']=="cancel"){
	if($_POST['no']){
		try
		{
			$db->beginTransaction();
			//교환건 철회할경우 상품의 재고 다시 넣어준다.
			$cqry="select * from cs_claim cc 
			join stock_io_log sil on (cc.no=sil.reference_no)
			where cc.no='".$_POST["no"]."' and sil.io_type='cs_hold'";
			$cres=$db->query($cqry);
			
			foreach($cres->results as $v){
				if($v['return_type']>='40' && $v['return_type']<'50' && $_POST["code"]=='91'){
					$okd=stock_io('cs_hold_cancel',$v["goodsno"],$v["goodsnm"],$v["cnt"],$v["reference_no"],$_SERVER['REQUEST_URI'],$v['loc_b'],$v['loc_f']);
				}
			}

			$param=array(
				":code"=>$_POST["code"]
				,":no"=>$_POST["no"]			
			);	
			$qry="update cs_claim set send_type=:code where no=:no";
			if(!$db->query($qry,$param)){
                throw new Exception('정상처리되지 않았습니다.', 1);
            }            
			$db->commit();
       	 	msg("철회 되었습니다.",-1);	
		}
		catch(Exception $e)
		{
			$db->rollBack();

			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
			msg($s,-1);
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
			msg("처리되었습니다.",-1);
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			msg($s,-1);		
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
if($_GET['s_invoice'])$add_where[]="ol.invoice like '%".$_GET['s_invoice']."%' ";
if($_GET['s_order_no'])$add_where[]="cc.order_no like '%".$_GET['s_order_no']."%' ";
if($_GET['s_return_type'])$add_where[]="cc.return_type='".$_GET['s_return_type']."' ";
if($_GET['s_send_type'])$add_where[]="cc.send_type='".$_GET['s_send_type']."' ";
if($_GET['s_date'] && $_GET['e_date'])$add_where[]="cc.reg_date between '".$_GET['s_date']." 00:00:00' and '".$_GET['e_date']." 23:59:59'";

if(count($add_where)){
    $add_where=" and ".implode(" and ",$add_where);
}

if($_GET && $add_where){
    /*리스트*/	
    $selectClaim=$CANCEL->selectClaim($step, $add_where);
    
	$tpl->assign(array(	
    'loop' => $selectClaim
	));
}

$selected['mall_no'][$_GET['s_mall_no']]="selected";
$selected['ing_type'][$_GET['s_ing_type']]="selected";
$selected['return_type'][$_GET['s_return_type']]="selected";
$selected['send_type'][$_GET['s_send_type']]="selected";

    
$tpl->print_('tpl');
?>
