<?
include "../_header.php";

$page_title='재고이동';

$popup_chk=1; //메뉴 컨트롤
$codedata=get_codedata('place');
asort($codedata);

$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($_FILES){
	$excel_data=excel_read('unlink','2');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){			
			$gqry="select no from goods g where goodsnm='".$v[0]."'";
			$gres=$db->query($gqry);
			$gno=$gres->results[0]['no'];
			if(!$gno)$err_msg[]=$k."번열 모델이 존재하지않습니다.";
			if(!$v['1'])$err_msg[]=$k."번열 수량이 존재하지않습니다.";
			
			$sqry="select no from codedata where type='PLACE' and cd='".$v[2]."'";
			$sres=$db->query($sqry);
			$scode=$sres->results[0]['no'];
			if(!$scode)$err_msg[]=$k."번열 차감위치가 존재하지않습니다.";

			if($gno && $scode){
				$sqry="select * from goods_cnt_loc gcl where goodsno='".$gno."'";
				$sres=$db->query($sqry);
				$s_stock=$sres->results[0]['codeno_'.$scode];
				
				if($s_stock < $v[1]) $err_msg[]=$k."번열 차감할 재고(보유재고 : ".$s_stock.")가 부족합니다.";         
			}

			$eqry="select no from codedata where type='PLACE' and cd='".$v[3]."'";
			$eres=$db->query($eqry);
			$ecode=$eres->results[0]['no'];
			if(!$ecode)$err_msg[]=$k."번열 증가위치가 존재하지않습니다.";            
		}

		if (!sizeof($err_msg)) {
			foreach($excel_data as $k=>$v){			
				$excel_loop[$k]['goodsnm']=$v[0];
				$excel_loop[$k]['quantity']=$v[1];
				$excel_loop[$k]['s_move']=$v[2];
				$excel_loop[$k]['e_move']=$v[3];
				$excel_loop[$k]['memo']=$v[4];

				$sum_quantity+=$v[1];
			}
			
		}
    }
}

if($_POST['mode']=='excel_move'){
	try{
				
		$db->beginTransaction();
		foreach($_POST['no'] as $v){

			$goodsnm=$_POST['goodsnm'][$v];
			$quantity=$_POST['quantity'][$v];
			$s_move=$_POST['s_move'][$v];
			$e_move=$_POST['e_move'][$v];
			$memo=$_POST['memo'][$v];
			
			$gqry="select no from goods g where goodsnm='".$goodsnm."'";
			$gres=$db->query($gqry);
			$gno=$gres->results[0]['no'];

			if(!$gno){
				msg('상품명['.$goodsnm.']이 없습니다.','stock_move_excel_reg.php');
				exit;
			}

			$sqry="select no from codedata where type='PLACE' and cd='".$s_move."'";
			$sres=$db->query($sqry);
			$scode=$sres->results[0]['no'];

			$eqry="select no from codedata where type='PLACE' and cd='".$e_move."'";
			$eres=$db->query($eqry);
			$ecode=$eres->results[0]['no'];
		   
			if($scode && $ecode){
				$sqry="select * from goods_cnt_loc gcl where goodsno='".$gno."'";
				$sres=$db->query($sqry);
				$s_stock=$sres->results[0]['codeno_'.$scode];
				
				if($s_stock < $quantity){
					msg('재고가 부족합니다.['.$goodsnm.']','stock_move_excel_reg.php');
					exit;
				}

				stock_io('move',$gno,$goodsnm,-$quantity,0,$_SERVER['REQUEST_URI'],$scode,$ecode);
				stock_io('move',$gno,$goodsnm,$quantity,0,$_SERVER['REQUEST_URI'],$ecode,$scode);

				$iqry="insert into stock_move_log set
				goodsno='".$gno."'
				,goodsnm='".$goodsnm."'
				,quantity='".$quantity."'
				,memo='".$memo."'
				,s_move='".$scode."'
				,e_move='".$ecode."'
				,admin_no='".$_SESSION['sess']['m_no']."'
				,admin_name='".$_SESSION['sess']['name']."'
				,reg_date=now()
				";

				$db->query($iqry);
			}else{
				msg('증감위치가 잘못되었습니다.','stock_move_excel_reg.php');
				exit;
			}
		}


		//$db->rollBack();
		$db->commit();
	   
		msg('처리되었습니다.','stock_move_excel_reg.php');
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage().":".$e->getFile());	
	}

}

$tpl->assign(array(	
'excel_loop' => $excel_loop
));

$tpl->print_('tpl');
?>
