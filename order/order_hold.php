<?
include "../_header.php";

$page_title='발송대기';
$ORDER=new order();
$GOODS=new goods();
if($_SESSION['sess']['h_level']<'10'){
	$nav_view="1";	
}

$codedata=get_codedata('place','1');

$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($_FILES && $_POST['mode']=="memoupdate"){
	$excel_data=excel_read('unlink','2');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){
			if(!$v[0])$err_msg[]=$k."번열 상품명이 존재하지않습니다.";            
			if(!$v[6])$err_msg[]=$k."번열 주문번호가 존재하지않습니다.";            
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{
			try{
				
				$db->beginTransaction();
				$dmsg=memo_indb($excel_data);

				//$db->rollBack();
                $db->commit();
	            msg('처리되었습니다.'.$dmsg,'order_hold.php?'.$QUERY_STRING);

			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
        }        
    }
}

if($_POST["mode"]=="send"){

	foreach($_POST["chk_no"] as $v){
		try
		{
			$db->beginTransaction();

			#기존에 보류잡혀있던 재고를 돌린다.
			$sql="select sil.* from 
			stock_io_log sil where sil.reference_no in (select concat(no) from order_hold_list ohl where ohl.order_list_no='".$v."' and ohl.close_yn='n' group by ohl.order_list_no ) 
			and sil.io_type='order_hold'
			";
			$res=$db->query($sql);

			foreach($res->results as $hv){
				$okd=stock_io('order_hold_cancel',$hv["goodsno"],$hv["goodsnm"],$hv["cnt"],$hv['reference_no'],$_SERVER['REQUEST_URI'],$hv['loc_b'],$hv['loc_f']);
				$uSql="update order_hold_list set close_yn='y' where no='".$hv['reference_no']."'";
				$db->query($uSql);

				//예약재고 업데이트
				$uqry="update reserve_list set state='1', rel_date=now(), rel_admin_no='".$_SESSION['sess']['m_no']."' where reference_no='".$v."' and  order_hold_no='".$hv['reference_no']."'";
				$db->query($uqry);

				if($hv["cnt"]>0){
					//구어드민 재고 복원등록
					guadmin_stock_ctl($hv["goodsno"],$hv["cnt"],$hv['loc_b'],'in',$v,'교환예약 해제');
				}

			}
			
			#주문을 다시돌려서 재고차감을한다.
			$cqry="select ol.no,ol.mall_name,ol.ordno,ol.order_num,g.goodsnm,g.no goodsno from order_list ol 
			join goods g on ol.goodsnm=g.goodsnm
			where ol.no='".$v."'";
			$cres=$db->query($cqry);
						
			foreach($cres->results as $val){

				$deli_codeno='';
				$tmp = now_stock($val['goodsno']);
				
				foreach($codedata as $cv){							
					if($tmp['codeno_'.$cv['no']] && $tmp['codeno_'.$cv['no']] >=$val['order_num']  ){
						$deli_codeno=$cv['no']; 
						break;
					}
				}

				if($deli_codeno){ 
					//입고순으로 재고차감처리후 원가 리턴
					$order_cost= $GOODS->calc_stock($val['goodsno'],$val['order_num']);	

					$qry="update order_list set 
					step='4'
					,step2='0'
					,deli_codeno=:deli_codeno
					,order_cost='".$order_cost."'
					,mod_date=now()
					where no=:no
					";
					
					$db->query($qry,array(":no"=>$val['no'],":deli_codeno"=>$deli_codeno));

					$okd=stock_io('order',$val['goodsno'],$val['goodsnm'],-$val['order_num'],$val['no'],$_SERVER['REQUEST_URI'],$deli_codeno);
				}else{			
					throw new Exception('주문재고부족 : '.$val['no']." ".$val['goodsno'].":".$val['goodsnm'], 1); 
				}
			}
			//$db->rollBack();
			$db->commit();
		}
		catch(Exception $e)
		{
			
			$errorCount++;
			$db->rollBack();
			
			//$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
			//msg($s,"order_hold.php");
		}  


	}

	if($errorCount){
		msg($errorCount."개의 주문건이 실패하였습니다.","order_hold.php");
	}else{
		msg("발송처리되었습니다.","order_hold.php");
	}

}else if($_POST['mode']=='memoIns'){
	$QUERY_STRING=order_return_url();

	try{
		$db->beginTransaction();

		$ORDER->admin_memo($_POST['chk_no'],$_POST['i_memo']);

		$db->commit();
		msg('처리되었습니다.','order_hold.php?'.$QUERY_STRING);

	}catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
		
	}	
}else if($_POST['mode']=='copy'){
	try{
		
		$qry="SHOW FULL COLUMNS FROM order_list";
		$res=$db->query($qry);
		
		foreach($res->results as $v){
			
			if($v['Field']!='no' && $v['Field']!='copy_seq' )$col_name[]=$v['Field'];
		}

		$db->beginTransaction();
		foreach($_POST['chk_no'] as $v){
			
			$qry="insert into order_list (".implode(",",$col_name).",copy_seq) select ".implode(",",$col_name).",:copy_seq from order_list where no=:no";
			$res=$db->query($qry,array(":no"=>$v,":copy_seq"=>$v));

			$ORDER->set_bundle_cnt($_POST['hid_ordno'][$v]);
		}

		//$db->rollBack();
		$db->commit();
		msg("처리되었습니다","order_hold.php");
		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}		
}else if($_POST['mode']=='del_copy'){
		
	try{
		$db->beginTransaction();
		$param=$db->inqry_param($_POST['chk_no']);
		$qry="select no,copy_seq,ordno from order_list where no in (".implode(",",array_keys($param)).")";
		$res=$db->query($qry,$param);
		
		foreach($res->results as $v){
			if($v['copy_seq']){
				
				$qry="delete from order_list where no='".$v['no']."'";
				if($db->query($qry)){
					$ORDER->set_bundle_cnt($_POST['hid_ordno'][$v['no']],'','m');
				}
				
			}
		}
		$db->commit();
		msg("처리되었습니다","order_hold.php");
		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}
}else if($_POST['mode']=='hold_order'){
	try{
		$db->beginTransaction();
		foreach($_POST['chk_no'] as $v){
			$sqry="select * from order_list where no='".$v."'";	
			$sres=$db->query($sqry);
			foreach($sres->results as $sv){
				$step_return=$ORDER->order_step_chg($sv['ordno'],'8','0',$sv['no']);	
			}
		}
		$db->commit();
		msg('처리되었습니다.','order_hold.php');
	}
	catch( Exception $e ){
//		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());	
	}
	
}
$data_search = $ORDER->order_search_where();

/*수량초과*/
$qry="select ol.*, gcl.* from order_list ol
join goods g on ol.goodsnm=g.goodsnm
join goods_cnt_loc gcl on g.no=gcl.goodsno
where ((ol.step='8' and ol.step2<40) or (ol.step='3' and ol.step2 in ('0')))
and (gcl.codeno_125+gcl.codeno_130) > 0
order by ol.mall_name,ol.ordno
";
$res = $db->query($qry);
foreach($res->results as $v){
	$chk_stand_stock[$v['goodsnm']]['cnt']+=$v['order_num'];
	$chk_stand_stock[$v['goodsnm']]['s_cnt']=$v['codeno_125']+$v['codeno_130'];
}
foreach($chk_stand_stock as $k=>$v){
	if($v['cnt'] <= $v['s_cnt']) unset($chk_stand_stock[$k]);
}

/*리스트*/
$qry="select ol.* ".$cfg_select_gcl.",gcl.codeno_116 from order_list ol
join goods g on ol.goodsnm=g.goodsnm
join goods_cnt_loc gcl on g.no=gcl.goodsno
where ol.step='3'
and ol.step2 in ('1','0')
#and bundle!='0'
".$data_search['where']."
order by ol.mall_name,ol.ordno
";

$res = $db->query($qry,$data_search['param']);


$bf_ordno='';
$color_key=0;
foreach($res->results as $v){
	
	$v = infoMasking($v, 'order_list'); //마스킹

	if($bf_ordno!=$v['ordno']){
		$bf_ordno=$v['ordno'];
		$color_key++;
	}
	$orderType=orderType($v['no']);
	$v['order_type']=$orderType;
	$v['line_color']="table_tr".$color_key%2;
	//if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
	$loop[]=$v;
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
