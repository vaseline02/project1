<?
include "../_header.php";

$page_title='재고조정';

$popup_chk=1; //메뉴 컨트롤
$codedata=get_codedata('place');
asort($codedata);

$GOODS=NEW goods();

$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($_POST['mode']=='change'){
	try
    {
		$db->beginTransaction();

		$_POST['goodsnm']=trim($_POST['goodsnm']);

		$qry="select * from goods g where goodsnm='".$_POST['goodsnm']."'";
		$res=$db->query($qry);
		$goods_data=$res->results[0];

		if(!$goods_data){
			msg('상품이 없습니다.','stock_change_reg.php');	exit;
		}

		//증가 (평균원가 구해옴)
		if($_POST['stock_type']=='0'){
			
			/*
			$cost=$GOODS->avg_price($goods_data['no']);

			if(!$cost){
				msg('입고된적이 없는 상품입니다.','stock_change_reg.php');	exit;
			}
			*/

			$cost=$_POST["cost"];

			$qry="insert into stock_list set
			brandno=:brandno
			,goodsno=:goodsno
			,goodsnm=:goodsnm
			,stock_num=:stock_num
			,now_cnt=:now_cnt
			,cost=:cost
			,state=1
			,memo='재고조정으로인한 입고'
			,return_order=1
			,reg_date=now()
			,admin_no=:admin_no
			,admin_name=:admin_name
			";
			
			$param[":brandno"]=$goods_data['brandno'];
			$param[":goodsno"]=$goods_data['no'];
			$param[":goodsnm"]=$_POST['goodsnm'];
			$param[":stock_num"]=$_POST['quantity'];
			$param[":now_cnt"]=$_POST['quantity'];
			$param[":cost"]=$cost;
			$param[":admin_no"]=$_SESSION['sess']['m_no'];
			$param[":admin_name"]=$_SESSION['sess']['name'];

			$res=$db->query($qry,$param);

			$lastStockNo=$res->lastId;

			$re_cost=$lastStockNo."^".$cost."^".$_POST['quantity'];

			stock_io('stock_change',$goods_data['no'],$_POST['goodsnm'],$_POST['quantity'],$lastStockNo,$_SERVER['REQUEST_URI'],$_POST['code_no']);

		//차감 (선입선출)
		}else if($_POST['stock_type']=='1'){
			$sqry="select * from goods_cnt_loc gcl where goodsno='".$goods_data['no']."'";
			$sres=$db->query($sqry);
			$s_stock=$sres->results[0]['codeno_'.$_POST['code_no']];
			
			if($s_stock < $_POST['quantity']){
				msg('차감할 재고가 부족합니다.','stock_change_reg.php');	exit;
			}
				
			$re_cost= $GOODS->calc_stock($goods_data['no'],$_POST['quantity']);	

			stock_io('stock_change',$goods_data['no'],$_POST['goodsnm'],-$_POST['quantity'],0,$_SERVER['REQUEST_URI'],$_POST['code_no']);
		}



		$iqry="insert into stock_change_log set
		stock_list_no='".$lastStockNo."'
		,goodsno='".$goods_data['no']."'
		,goodsnm='".$_POST['goodsnm']."'
		,quantity='".$_POST['quantity']."'
		,memo='".$_POST['memo']."'
		,cost='".$re_cost."'
		,code_no='".$_POST['code_no']."'
		,stock_type='".$_POST['stock_type']."'
		,admin_no='".$_SESSION['sess']['m_no']."'
		,admin_name='".$_SESSION['sess']['name']."'
		,reg_date=now()
		";

		$db->query($iqry);
		
		$db->commit();

		MsgViewCloseReload('처리되었습니다.');
//		msg('처리되었습니다.','stock_move_reg.php?'.$QUERY_STRING);

		
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
