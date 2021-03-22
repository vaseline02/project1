<?
include "../_header.php";

$page_title='하자등록';

$popup_chk=1; //메뉴 컨트롤
$codedata=get_codedata('place');
asort($codedata);

$QUERY_STRING = $_SERVER['QUERY_STRING'];

$GOODS=NEW goods();

if($_FILES){
	$excel_data=excel_read('unlink','2');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){			
			$gqry="select no from goods g where goodsnm='".$v[0]."'";
			$gres=$db->query($gqry);
			$gno=$gres->results[0]['no'];
			if(!$gno){
				$err_msg[]=$k."번열 모델이 존재하지않습니다.";
			}else{
				$goods_stock[$gno]++;
				$goodsnm[$gno]=$v[0];
			}
		}

		foreach($goods_stock as $gk=>$gv){
			
			$sqry="select * from goods_cnt_loc gcl where goodsno='".$gk."'";
			$sres=$db->query($sqry);
			//재고차감은 사무실
			$s_stock=$sres->results[0]['codeno_1'];
			
			if($s_stock < $gv) $err_msg[]='['.$goodsnm[$gk].']상품의 재고가 부족합니다.(보유재고 : '.$s_stock.')';
		
		}

		if (!sizeof($err_msg)) {
			foreach($excel_data as $k=>$v){			
				$gqry="select no from goods g where goodsnm='".$v[0]."'";
				$gres=$db->query($gqry);
				$gno=$gres->results[0]['no'];
				$num='1';

				$order_cost=implode("|",$order_cost);
				$excel_loop[$k]['goodsnm']=$v[0];
				$excel_loop[$k]['memo']=$v[1];
			}			
		}
    }
}

if($_POST['mode']=='excel_bad'){
	try{
				
		$db->beginTransaction();
		foreach($_POST['no'] as $v){

			$goodsnm=$_POST['goodsnm'][$v];
			$quantity='1';
			$memo=$_POST['memo'][$v];
			
			$gqry="select * from goods g where goodsnm='".$goodsnm."'";
			$gres=$db->query($gqry);
			$goods_data=$gres->results[0];

			if(!$goods_data){
				msg('상품명['.$goodsnm.']이 없습니다.','bad_list_excel_reg.php');
				exit;
			}

				
			$sqry="select * from goods_cnt_loc gcl where goodsno='".$goods_data['no']."'";
			$sres=$db->query($sqry);
			$s_stock=$sres->results[0]['codeno_1'];
			
			if($s_stock < $quantity){
				msg('재고가 부족합니다.['.$goodsnm.']','bad_list_excel_reg.php');
				exit;
			}

			$re_cost= $GOODS->calc_stock($goods_data['no'],$quantity);	

			$qry="insert into cs_bad set
			goods_no=:goods_no
			,goodsnm=:goodsnm
			,quantity=:quantity
            ,reg_date=now()
            ,admin_no=:admin_no
			,step=:step
			,memo=:memo
			,mod_admin_no=:mod_admin_no
			,cost=:cost
			";

			$param[':goods_no']=$goods_data['no'];
			$param[':goodsnm']=$goodsnm;
			$param[':quantity']=$quantity;
			$param[':admin_no']=$_SESSION['sess']['m_no'];
			$param[':memo']=$memo;
			$param[':step']='1';
			$param[':mod_admin_no']=$_SESSION['sess']['m_no'];
			$param[':cost']=$re_cost;

			$db->query($qry,$param);

			stock_io('repairing',$goods_data['no'],$goodsnm,-$quantity,0,$_SERVER['REQUEST_URI'],'1');			
				
		}
		

		//$db->rollBack();
		$db->commit();
	   
		MsgViewCloseReload('처리되었습니다.');
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
