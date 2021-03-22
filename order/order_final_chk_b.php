<?
include "../_header.php";

$page_title='묶음발송 최종확인';

$comp_cnt=0;
$codedata=get_codedata('place','1');
$ORDER=new order();
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
	            msg('처리되었습니다.'.$dmsg,'order_final_chk_b.php?'.$QUERY_STRING);

			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
        }        
    }
}


if($_POST['mode']=='order_settle' ){

	$scount=0;
	foreach($_POST['chk_no'] as $v){		
		$sqry="select * from order_list where step!='4' and no='".$v."'";	
		$sres=$db->query($sqry);			
		foreach($sres->results as $sv){
			$step_return=$ORDER->order_step_chg($sv['ordno'],'4','0',$sv['no'],$_POST['place_code']);
			if($step_return){
				foreach($step_return as $k=>$v){
					//$mag.="[".$k."]";
					$scount++;
				}					
			}
		}
	}

	if($scount==count($_POST['chk_no'])){
		$mag="전체 재고부족";				
	}else if($scount>0){
		$mag="처리되었습니다.(".$scount."개상품 재고부족 제외)";				
	}else{
		$mag="처리되었습니다.";
	}
	msg($mag,'order_final_chk_b.php?'.$QUERY_STRING);


	//기존꺼 주석처리
	/*
	try{
		$db->beginTransaction();

		$GOODS=new goods();
		//묶음변호별 체크되어 넘어온 주문건(주문수량 아님) 카운트
		foreach($_POST['chk_no'] as $v){

			$cnt_ordno[$_POST['hid_ordno'][$v]]++;
			$arr_ordno[$_POST['hid_ordno'][$v]][]=$v;
		}
		//실제 묶음 총 수량과 같은지 체크  
		foreach($arr_ordno as $k=>$v){
				
			if($_POST['hid_bundle_cnt'][$k]!=$cnt_ordno[$k]){
				unset($arr_ordno[$k]);

				$msg.=$k." ";
			}
		}
		
	
		if($_POST['place_code']=='all'){
			foreach($codedata as $v){
				$place_code[]=$v['no'];
			}
		}else{
			$place_code[]=$_POST['place_code'];
		}

		foreach($arr_ordno as $key=>$val){
			
			$stock_loc=$stock_order_num=$chk_stock=array();
			foreach($val as $v){  //주문번호별 묶음상품 그룹

				foreach($place_code as $pcv){
					//stock_io() 에서도 재고 체크는 하지만 오류시 롤백되기때문에 전체를 한번에 처리할때 가능한 데이터들은 모두 처리하고 불가능한 데이터만 남기기 위해서 재고 체크
					$stock_deli_av=$GOODS->get_stock_deli_av(array($_POST['hid_goodsnm'][$v]),$pcv);
					
					if($stock_deli_av->results['0']['totstock']<$_POST['hid_ord_num'][$v]+$stock_order_num[$_POST['hid_goodsnm'][$v]][$pcv]  ){ 
						$chk_stock[$v]=0; //재고부족
					}else{
						$chk_stock[$v]=1;
						$stock_loc[$v]=$pcv;
						//복사본이 있을수 있으므로 모델별 위치별 선차감 재고를 기억해두고, 후에 같은 모델의 같은 위치를 체크할때 수량을 더해준다.
						$stock_order_num[$_POST['hid_goodsnm'][$v]][$pcv]+=$_POST['hid_ord_num'][$v]; 
						break;
					}
				}
			}
		
			if(!in_array('0',$chk_stock)){  //재고가 부족한 주문이 없으면
				foreach($val as $v){
					$comp_cnt++;
					$goodsno=$GOODS->get_goodsno($_POST['hid_goodsnm'][$v]);

					//입고순으로 재고차감처리후 원가 리턴
					$order_cost= $GOODS->calc_stock($goodsno,$_POST['hid_ord_num'][$v]);	

					$qry="update order_list set 
					step='4'
					,deli_codeno=:deli_codeno
					,order_cost='".$order_cost."'
					,mod_date=now()
					where no=:no
					";

					$db->query($qry,array(":no"=>$v,":deli_codeno"=>$stock_loc[$v]));
					$okd=stock_io('order',$goodsno,$_POST['hid_goodsnm'][$v],-$_POST['hid_ord_num'][$v],$v,$_SERVER['REQUEST_URI'],$stock_loc[$v]);
				}
			}else{
				$msg.=$key." ";
			}
		}
		if($msg)$msg.=" 처리실패";
		//$db->rollBack();
		$db->commit();
		msg($comp_cnt."건 처리되었습니다 ".$msg,"order_final_chk_b.php");		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
		
	}	
	*/
}else if($_POST['mode']=='cp_order' ){
	
	$qry="SHOW FULL COLUMNS FROM order_list";
	$res=$db->query($qry);
	
	foreach($res->results as $v){
		
		if($v['Field']!='no' && $v['Field']!='copy_seq' && $v['Field']!='order_num')$col_name[]=$v['Field'];
	}

	try{
		$db->beginTransaction();

		foreach($_POST['chk_no'] as $v){
			
			if($_POST['hid_ord_num'][$v]>$_POST['cp_num'] && $_POST['cp_num']>0){
				$comp_cnt++;
				$qry="insert into order_list (".implode(",",$col_name).",order_num,copy_seq) select ".implode(",",$col_name).",:order_num,:copy_seq from order_list where no=:no";

				$ORDER->set_bundle_cnt($_POST['hid_ordno'][$v]);

				if($db->query($qry,array(":no"=>$v,":order_num"=>$_POST['cp_num'],":copy_seq"=>$v))){
					//원본주문 주문수량 조절
					$up_qry="update order_list set
					order_num=:cp_num
					where no=:no
					";

					$db->query($up_qry,array(":no"=>$v,":cp_num"=>$_POST['hid_ord_num'][$v]-$_POST['cp_num']));
				}
			}
		}

		//$db->rollBack();
		$db->commit();
		msg($comp_cnt."건 처리되었습니다","order_final_chk_b.php?".$QUERY_STRING);		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());		
	}	

}else if($_POST['mode']=='goback' ){

	try{
		$db->beginTransaction();
		
		foreach($_POST['chk_no'] as $v){
			$ginfo=0;
			$ginfo=$_POST['hid_goodsno'][$v];
			
			if($ginfo){
				
				$now_stock=now_stock($ginfo,array('3'));
				if($now_stock['codeno_3']>0)$chg_step2=1;
				else $chg_step2=0;

				$ORDER->order_step_chg('','2',$chg_step2,$v);	
			}else{
				$err_msg[]=$_POST['hid_ordno'][$v].'모델명or모델번호 오류/';
			}
		}

		//$db->rollBack();
		$db->commit();
		if($err_msg)msg(implode(" ",$err_msg),'order_final_chk_b.php?'.$QUERY_STRING);
		else msg("처리되었습니다","order_final_chk_b.php?".$QUERY_STRING);		
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());		
	}
}else if($_POST['mode']=='memoIns'){
	$QUERY_STRING.=order_return_url();

	try{
		$db->beginTransaction();

		$ORDER->admin_memo($_POST['chk_no'],$_POST['i_memo']);

		$db->commit();
		msg('처리되었습니다.','order_final_chk_b.php?'.$QUERY_STRING);

	}catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
		
	}	
}else if($_POST['mode']=='hold_order'){
	foreach($_POST['chk_no'] as $v){
		$sqry="select * from order_list where no='".$v."'";	
		$sres=$db->query($sqry);
		foreach($sres->results as $sv){
			$step_return=$ORDER->order_step_chg($sv['ordno'],'8','0',$sv['no']);	
		}
	}
	msg('처리되었습니다.','order_final_chk_b.php?'.$QUERY_STRING);
}


$data_search = $ORDER->order_search_where();
$selected['place_code']['51']='selected';
/*리스트*/
$qry="select ol.* ".$cfg_select_gcl.", gcl.codeno_130, gcl.codeno_55 from order_list ol
join goods g on ol.goodsnm=g.goodsnm
join goods_cnt_loc gcl on g.no=gcl.goodsno
where ol.step='1'
and ol.step2<40
and bundle!='0'
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
