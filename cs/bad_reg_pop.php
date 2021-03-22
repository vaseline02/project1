<?
include "../_header.php";

$page_title='하자등록';
$popup_chk=1; //메뉴 컨트롤

if($_POST['mode']=='ins'){

	$GOODS=new goods();
	$chk_goods=$GOODS->get_goodsno($_POST['goodsnm']);

	if($_POST['qty'] && $chk_goods){
		
		try
    	{
			$db->beginTransaction();
			/*
			for($i=0;$i<$_POST['qty'];$i++){
				unset($param);
				$qry="insert into cs_bad set
				goods_no=:goods_no
				,goodsnm=:goodsnm
				,quantity=1
				,cost=:cost
				,memo=:memo
				";
				
				$param[':goods_no']=$chk_goods;
				$param[':goodsnm']=$_POST['goodsnm'];
				$param[':cost']="^".$_POST['cost']."^";
				$param[':memo']=$_POST['memo'];

				$db->query($qry,$param);

				//재고 빼야하고 엑셀도 처리할때 재고체크 해야됨. 재고 빠지는 위치도 파학
				//입고순으로 재고차감처리후 원가 리턴
				$order_cost= $GOODS->calc_stock($chk_goods,$_POST['qty']);	
				$okd=stock_io('bad_reg',$chk_goods,$v['goodsnm'],'-1',$db->lastId,$_SERVER['REQUEST_URI'],$stock_place);
			}
			*/


			//$db->rollBack();
			$db->commit();
			//msg("처리되었습니다.");
		}
		catch(Exception $e)
		{
			$db->rollBack();	
			$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';	
			tydebug($s);
		} 


	}else{
		msg('입력값 오류');
	}
}

$qry="select * from cs_bad where no=:no";
$res = $db->query($qry,array(":no"=>$_GET['no']));
foreach($res->results as $v){

	$loop[]=$v;	
}



$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	));

$tpl->print_('tpl');
?>
