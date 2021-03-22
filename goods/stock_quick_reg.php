<?
include "../_header.php";

$page_title='퀵시트 등록';

$popup_chk=1; //메뉴 컨트롤
$mode=$_GET['mode']?$_GET['mode']:'ins';

$codedata=get_codedata('place','1');

if($_POST['mode']=="ins"){
	try
	{
		$db->beginTransaction();

		$sqry="select * from goods g where goodsnm='".$_POST['goodsnm']."'";
		$sres=$db->query($sqry);
		$g_data=$sres->results[0];

		if($g_data){
			$goodsnm = strtoupper($_POST['goodsnm']);

			$iqry="insert into stock_quick set 
			goodsno='".$g_data['no']."'
			,goodsnm='".$goodsnm."'
			,quantity='".$_POST['quantity']."'
			,memo='".$_POST['memo']."'
			,stock_move='".$_POST['place_code']."'
			,admin_no='".$_SESSION['sess']['m_no']."'
			,admin_name='".$_SESSION["sess"]["name"]."'
			,state='".$_POST['state']."'
			,reg_date=now()
			";
			$res=$db->query($iqry);
			$lastNo=$res->lastId;
		
			stock_io('quick_move',$g_data['no'],$goodsnm,-$_POST['quantity'],$lastNo,$_SERVER['REQUEST_URI'],$_POST['place_code'],'133');
			stock_io('quick_move',$g_data['no'],$goodsnm,$_POST['quantity'],$lastNo,$_SERVER['REQUEST_URI'],'133',$_POST['place_code']);

			//guadmin_stock_ctl($g_data['no'],$_POST['quantity'],$_POST['place_code'],'out','0',$_POST['memo']);

			
			$db->commit();
			MsgViewCloseReload("처리되었습니다.");	

		}else{
			mag("상품이 존재하지않습니다.","qtock_quick_reg.php");
		}

	}
	catch(Exception $e)
	{
		$db->rollBack();

		$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
		msg($s,$returnUrl);
	}  

}

$tpl->print_('tpl');
?>
