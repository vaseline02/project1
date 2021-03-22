<?
include "../_header.php";

$page_title='재고조정';

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
			if(!$gno)$err_msg[]=$k."번열 모델이 존재하지않습니다.";

			$cost=$GOODS->avg_price($gno);

			if(!$cost)$err_msg[]=$k."번열 입고된적이 없는 상품입니다.";

			if(!$v['1'])$err_msg[]=$k."번열 수량이 존재하지않습니다.";
			
			$sqry="select no from codedata where type='PLACE' and cd='".$v[3]."'";
			$sres=$db->query($sqry);
			$scode=$sres->results[0]['no'];
			if(!$scode)$err_msg[]=$k."번열 위치가 존재하지않습니다.";

			if($v[2]!='차감' && $v[2]!='증가') $err_msg[]=$k."번열 증감형태가 잘못되었습니다.";         

			if($gno && $scode && $v[2]=='차감'){
				$sqry="select * from goods_cnt_loc gcl where goodsno='".$gno."'";
				$sres=$db->query($sqry);
				$s_stock=$sres->results[0]['codeno_'.$scode];
				
				if($s_stock < $v[1]) $err_msg[]=$k."번열 차감할 재고(보유재고 : ".$s_stock.")가 부족합니다.";         
			}
		}

		if (!sizeof($err_msg)) {
			foreach($excel_data as $k=>$v){			
				$excel_loop[$k]['goodsnm']=trim($v[0]);
				$excel_loop[$k]['quantity']=$v[1];
				$excel_loop[$k]['stock_type']=$v[2];
				$excel_loop[$k]['code_name']=$v[3];
				$excel_loop[$k]['memo']=$v[4];

				if($excel_loop[$k]['stock_type']=="증가"){
					$excel_loop[$k]['cost']=$v[5];
				}else{
					$excel_loop[$k]['cost']="-";
				}
			}			
		}
    }
}

if($_POST['mode']=='excel_change'){
	try{
				
		$db->beginTransaction();
		foreach($_POST['no'] as $v){

			$goodsnm=trim($_POST['goodsnm'][$v]);
			$quantity=$_POST['quantity'][$v];
			$code_name=$_POST['code_name'][$v];
			$memo=$_POST['memo'][$v];
			$cost=$_POST['cost'][$v];

			if($_POST['stock_type'][$v]=='증가') $stock_type='0';
			else if($_POST['stock_type'][$v]=='차감') $stock_type='1';
			
			$gqry="select * from goods g where goodsnm='".$goodsnm."'";
			$gres=$db->query($gqry);
			$goods_data=$gres->results[0];

			if(!$goods_data){
				msg('상품명['.$goodsnm.']이 없습니다.','stock_change_excel_reg.php');
				exit;
			}

			$sqry="select no from codedata where type='PLACE' and cd='".$code_name."'";
			$sres=$db->query($sqry);
			$scode=$sres->results[0]['no'];
		   
			if($scode && $stock_type >=0){
				//증가
				if($stock_type==0){
					
					/*
					$cost=$GOODS->avg_price($goods_data['no']);

					if(!$cost){
						msg('['.$goodsnm.'] 입고된적이 없는 상품입니다.','stock_change_excel_reg.php');	exit;
					}
*/

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
					$param[":goodsnm"]=$goodsnm;
					$param[":stock_num"]=$quantity;
					$param[":now_cnt"]=$quantity;
					$param[":cost"]=$cost;
					$param[":admin_no"]=$_SESSION['sess']['m_no'];
					$param[":admin_name"]=$_SESSION['sess']['name'];

					$res=$db->query($qry,$param);

					$lastStockNo=$res->lastId;

					$re_cost=$lastStockNo."^".$cost."^".$quantity;

					stock_io('stock_change',$goods_data['no'],$goodsnm,$quantity,$lastStockNo,$_SERVER['REQUEST_URI'],$scode);
				
				//차감
				}else if($stock_type==1){
					
					$sqry="select * from goods_cnt_loc gcl where goodsno='".$goods_data['no']."'";
					$sres=$db->query($sqry);
					$s_stock=$sres->results[0]['codeno_'.$scode];
					
					if(($s_stock < $quantity) && $stock_type=='1'){
						msg('재고가 부족합니다.['.$goodsnm.']','stock_change_excel_reg.php');
						exit;
					}
					$re_cost= $GOODS->calc_stock($goods_data['no'],$quantity);	
					stock_io('stock_change',$goods_data['no'],$goodsnm,-$quantity,0,$_SERVER['REQUEST_URI'],$scode);			
				}
			}else{
				msg('증감위치가 잘못되었습니다.','stock_change_excel_reg.php');
				exit;
			}				
			
			$iqry="insert into stock_change_log set
			stock_list_no='".$lastStockNo."'
			,goodsno='".$goods_data['no']."'
			,goodsnm='".$goodsnm."'
			,quantity='".$quantity."'
			,memo='".$memo."'
			,cost='".$re_cost."'
			,code_no='".$scode."'
			,stock_type='".$stock_type."'
			,admin_no='".$_SESSION['sess']['m_no']."'
			,admin_name='".$_SESSION['sess']['name']."'
			,reg_date=now()
			";

			$db->query($iqry);
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
