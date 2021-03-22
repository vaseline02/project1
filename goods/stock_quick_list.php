<?
include "../_header.php";
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);

$page_title='퀵시트';

$mode=$_POST["mode"];
$no=$_POST["no"];

$QUERY_STRING = $_SERVER['QUERY_STRING'];

//발송코드
$codedata=get_codedata('place','1');

if($_FILES){
	$excel_data=excel_read('unlink');

	foreach($excel_data as $k=>$v){
		$sqry="select no from goods g where goodsnm='".$v[0]."'";
		$sres=$db->query($sqry);
		$g_no=$sres->results[0]['no'];

		if($g_no){
			$sqry="select no from codedata c where type='PLACE' and v2='1' and cd='".$v[1]."'";
			$sres=$db->query($sqry);
			$c_no=$sres->results[0]['no'];

			if($c_no){
				$sqry="select codeno_".$c_no." as cnt_loc from goods_cnt_loc gcl where gcl.goodsno='".$g_no."' ";
				$sres=$db->query($sqry);
				$stock_no=$sres->results[0]['cnt_loc'];

				if($v[2]>$stock_no){
					$err_msg[]=$k."번열 재고수량 부족";
				}

				if($v['4']!='요청' && $v['4']!='홀드'){
					$err_msg[]=$k."번열 잘못된 구분";
				}
			}else{
				$err_msg[]=$k."번열 존재하지않는 차감위치";
			}
		
		}else{
			$err_msg[]=$k."번열 존재하지않는 상품명";
		}		
	}
	if (sizeof($err_msg) > 0) {
		tydebug($err_msg);
	}else{
		try{
			//  tydebug($excel_data);
			$db->beginTransaction();
			foreach($excel_data as $k=>$v){
				$sqry="select no from goods g where goodsnm='".$v[0]."'";
				$sres=$db->query($sqry);
				$g_no=$sres->results[0]['no'];

				if($g_no){

					$goodsnm = strtoupper($v[0]);

					if($v['4']=="홀드"){
						$state="1";
					}else if($v['4']=="요청"){
						$state="2";
					}

					$sqry="select no from codedata c where type='PLACE' and v2='1' and cd='".$v[1]."'";
					$sres=$db->query($sqry);
					$c_no=$sres->results[0]['no'];

					$iqry="insert into stock_quick set 
					goodsno='".$g_no."'
					,goodsnm='".$goodsnm."'
					,quantity='".$v[2]."'
					,memo='".$v[3]."'
					,stock_move='".$c_no."'
					,state='".$state."'
					,admin_no='".$_SESSION['sess']['m_no']."'
					,admin_name='".$_SESSION["sess"]["name"]."'
					,reg_date=now()
					";
					$res=$db->query($iqry);
					$lastNo=$res->lastId;
				
					stock_io('quick_move',$g_no,$goodsnm,-$v[2],$lastNo,$_SERVER['REQUEST_URI'],$c_no,'133');
					stock_io('quick_move',$g_no,$goodsnm,$v[2],$lastNo,$_SERVER['REQUEST_URI'],'133',$c_no);			
					
					// guadmin_stock_ctl($g_no,$v[2],$c_no,'out','0',$v[3]);
				}
		
			}

			//$db->rollBack();
			$db->commit();
			msg('처리되었습니다.','stock_quick_list.php?'.$QUERY_STRING);
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage().":".$e->getFile());	
		}
	}
}

if($mode=="confirm"){
	try
	{
		$db->beginTransaction();
		
		$sqry="select * from stock_quick sq where sq.no='".$_POST['no']."'";
		$sres=$db->query($sqry);
		$quick_data=$sres->results[0];

		$uqry="update stock_quick set
		confirm_admin_no='".$_SESSION['sess']['m_no']."'
		,confirm_admin_name='".$_SESSION['sess']['name']."'
		,confirm_admin_date=now()
		where no='".$_POST['no']."' order by no asc";
		$db->query($uqry);

		$siqry="select * from stock_io_log sil where sil.io_type='quick_move' and sil.reference_no='".$_POST['no']."'";
		$sires=$db->query($siqry);
		foreach($sires->results as $siv){
			stock_io('quick_move',$siv['goodsno'],$siv['goodsnm'],$siv['cnt'],$siv['reference_no'],$_SERVER['REQUEST_URI'],$siv['loc_b'],$siv['loc_f']);
		}

		$db->commit();
		msg('처리되었습니다.','stock_quick_list.php?'.$QUERY_STRING);
	}
	catch(Exception $e)
	{
		$db->rollBack();

		$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
		msg($s,'stock_quick_list.php?'.$QUERY_STRING);
	}  
}else if($mode=="v_confirm"){
	try
	{
		$db->beginTransaction();

		foreach($_POST['chk_no'] as $v){			
			$sqry="select * from stock_quick sq where sq.no='".$v."'";
			$sres=$db->query($sqry);
			$quick_data=$sres->results[0];

			$uqry="update stock_quick set
			confirm_admin_no='".$_SESSION['sess']['m_no']."'
			,confirm_admin_name='".$_SESSION['sess']['name']."'
			,confirm_admin_date=now()
			,confirm_stock_move='".$_POST['place_code']."'
			where no='".$v."'";
			$db->query($uqry);

			stock_io('quick_move',$quick_data['goodsno'],$quick_data['goodsnm'],-$quick_data['quantity'],$quick_data['no'],$_SERVER['REQUEST_URI'],'133',$_POST['place_code']);
			stock_io('quick_move',$quick_data['goodsno'],$quick_data['goodsnm'],$quick_data['quantity'],$quick_data['no'],$_SERVER['REQUEST_URI'],$_POST['place_code'],'133');

			// guadmin_stock_ctl($quick_data['goodsno'],$quick_data['quantity'],$_POST['place_code'],'in','0',$quick_data['memo']);
			
			/*
			$siqry="select * from stock_io_log sil where sil.io_type='quick_move' and sil.reference_no='".$v['no']."'";
			$sires=$db->query($siqry);
			foreach($sires->results as $siv){
				stock_io('quick_move',$siv['goodsno'],$siv['goodsnm'],$siv['cnt'],$siv['reference_no'],$_SERVER['REQUEST_URI'],$siv['loc_b'],$siv['loc_f']);
			}*/
		}		

		$db->commit();
		msg('처리되었습니다.','stock_quick_list.php?'.$QUERY_STRING);
	}
	catch(Exception $e)
	{
		$db->rollBack();

		$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
		msg($s,'stock_quick_list.php?'.$QUERY_STRING);
	}  
}else if($mode=="request_confirm"){
	try
	{
		$db->beginTransaction();

		foreach($_POST['chk_no'] as $v){		
			$uqry="update stock_quick set
			request_admin_no='".$_SESSION['sess']['m_no']."'
			,request_admin_name='".$_SESSION['sess']['name']."'
			,request_date=now()
			where no='".$v."'";
			$db->query($uqry);
		}		

		$db->commit();
		msg('처리되었습니다.','stock_quick_list.php?'.$QUERY_STRING);
	}
	catch(Exception $e)
	{
		$db->rollBack();

		$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
		msg($s,'stock_quick_list.php?'.$QUERY_STRING);
	}  
}



/*리스트*/	
$_GET[page_num]=50;
$field="sq.*, c.cd";
$db_table="stock_quick sq
left join codedata c on (sq.stock_move=c.no)
";
$pg = new page($_GET[page],$_GET[page_num]);
$pg->field = $field;
$pg->setQuery($db_table,$add_where,'(case when sq.confirm_admin_no=0  then 1 else 2 end), sq.reg_date desc');

$pg->exec();
$qry=$pg->query;

$res = $db->query($qry);
foreach($res->results as $v){
	$s_move=get_codedata('place','',$v['stock_move']);
	$v['s_move']=$s_move[0]['cd'];
	if($v['confirm_stock_move']){
		$e_move=get_codedata('place','',$v['confirm_stock_move']);
		$v['e_move']=$e_move[0]['cd'];
	}
	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	
));

$tpl->print_('tpl');
?>
