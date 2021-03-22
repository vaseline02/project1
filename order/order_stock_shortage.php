<?
include "../_header.php";

$page_title='재고부족주문 선택발송';
//$popup_chk=1; //메뉴 컨트롤
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
	            msg('처리되었습니다.'.$dmsg,'order_stock_shortage.php?'.$QUERY_STRING);

			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
        }        
    }
}



if($_POST['chk_no'] ){
	
	if($_POST['mode']=='deli'){
		try{
			$db->beginTransaction();
			
			
			/*체크로 넘어온 주문수량*/
			foreach($_POST['chk_no'] as $v){
				
				$arr_stock_chk[$_POST['hid_goodsnm'][$v]]+=$_POST['hid_ord_num'][$v];
				$arr_goodsnm[]=$_POST['hid_goodsnm'][$v];
				$arr_ordno[$_POST['hid_goodsnm'][$v]][]=$v;
			}

			/*넘어온 모델들의 현재 발송최종확인단계의 주문수량 - 최종확인단계의 수량까지 포함하여 발송가능여부 체크( 아직 재고 차감전이기때문에,총판매와 총재고를 비교.)*/
			unset($param);
			$param = $db->inqry_param($arr_goodsnm);
			$qry="select goodsnm,sum(order_num) sumN from order_list 
			where goodsnm in (".implode(",",array_keys($param)).") 
			and step in ('1') and step2='0'
			group by goodsnm
			";
			$res=$db->query($qry,$param);
			
			foreach($res->results as $v){
				$f_chk[$v['goodsnm']]+=$v['sumN'];
				$arr_stock_chk[$v['goodsnm']]+=$v['sumN'];
			}

			$GOODS= new goods();
			$stock_deli_av=$GOODS->get_stock_deli_av($arr_goodsnm);
			$comp_cnt=0;
			foreach($stock_deli_av->results as $v){
				
				if($arr_stock_chk[$v['goodsnm']]<=$v['totstock']){

					foreach($arr_ordno[$v['goodsnm']] as $ov){
						$update_ordno[]=$ov;
						$comp_cnt++;
					}
					
				}else{
					$msg.=" ".$v['goodsnm']."( 발송확인단계 ".$f_chk[$v['goodsnm']]."개 있음) ";
				}
			}
			
			$qry="update order_list set
			step='1'
			,step2='0'
			,mod_date=now()
			where no in ('".implode("','",$update_ordno)."')

			";
			$db->query($qry);


			//$ORDER->sortOrderSoldout();//품절주문 재정렬
			
			if($msg)$msg.=" 재고부족";

			//$db->rollBack();
			$db->commit();
			msg('처리되었습니다.'.$msg,'order_stock_shortage.php?'.$QUERY_STRING);
		
		
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage());
			
		}	
	}else if($_POST['mode']=='stand'){
		
		$param = $db->inqry_param($_POST['chk_no']);

		$qry="update order_list set
		step2='1'
		,step_fixed=1
		where no in (".implode(",",array_keys($param)).") 
		and step in ('2') and step2='0'
		";
		$db->query($qry,$param);
		msg('처리되었습니다.','order_stock_shortage.php?'.$QUERY_STRING );

	}else if($_POST['mode']=='soldout'){ //예약재고잡힘
		try{
			$db->beginTransaction();

				$step_return=$ORDER->order_step_chg('','3','0',$_POST['chk_no']);	
			
			$db->commit();
			msg('처리되었습니다.','order_stock_shortage.php?'.$QUERY_STRING);

		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage());
			
		}
/*
		try{
			$db->beginTransaction();
			
			//품절주문취소접수
			//$ORDER->order_cancel($_POST['chk_no'],'2');
			
			//$db->rollBack();
			$db->commit();
			msg('처리되었습니다.'.$msg,'order_stock_shortage.php?'.$QUERY_STRING );
		
		
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage());
			
		}*/
	}else if($_POST['mode']=='cancel'){

		try{
			$db->beginTransaction();
			
			//$ORDER->order_cancel($_POST['chk_no'],'2','45');
			$ORDER->order_cancel_seq($_POST['chk_no'],'2');
			
			//$db->rollBack();
			$db->commit();
			msg('처리되었습니다.'.$msg,'order_stock_shortage.php?'.$QUERY_STRING );
		
		
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
			/*
			$i_memo=$_POST['i_memo'];
			$chk_no=$_POST['chk_no'];
			foreach($_POST['chk_no'] as $v){
				$qry="update order_list set memo='".$i_memo."' where no=:no";
				$res=$db->query($qry,array(":no"=>$v));
			}
			*/
			$db->commit();
			msg('처리되었습니다.','order_stock_shortage.php?'.$QUERY_STRING);
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
		msg('처리되었습니다.','order_stock_shortage.php?'.$QUERY_STRING);
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
			msg("처리되었습니다",'order_stock_shortage.php?'.$QUERY_STRING);
			
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage());	
		}		
	}else if($_POST['mode']=='change'){
		try{
			$db->beginTransaction();
			$scount=0;
			$step_return=$ORDER->order_step_chg('','4','2',$_POST['chk_no'],$_POST['place_code']);	
			if($step_return){
				foreach($step_return as $k=>$v){
					//$mag.="[".$k."]";
					$scount++;
				}					
			}

			$db->commit();

			if($scount==count($_POST['chk_no'])){
				$mag="전체 재고부족";				
			}else if($scount>0){
				$mag="처리되었습니다.(".$scount."개상품 재고부족 제외)";				
			}else{
				$mag="처리되었습니다.";
			}
			msg($mag,'order_stock_shortage.php?'.$QUERY_STRING);
			
		}
		catch( Exception $e ){
			tydebug('err');
			$db->rollBack();
			tydebug($e->getMessage());	
		}		
	}

}
$add_where='';

if($_GET['gubunb']!=3){//품절주문확인페이지는 

	if($_GET['tday']==1){
		$add_where=" and ol.reg_date=curdate() ";
	}else if($_GET['tday']==2){
		$add_where=" and ol.reg_date!=curdate() ";
	}


	if($_GET['gubunb']==0){
		$add_where.=" and ol.bundle=0";
	}else{
		$add_where.=" and ol.bundle!=0";
	}
}


$codedata=get_codedata('place','1');

foreach($codedata as $v)$place_data[]=$v['no'];

$data_search = $ORDER->order_search_where();

/*리스트*/
$qry="select ol.* ".$cfg_select_gcl." from order_list ol
join goods g on ol.goodsnm=g.goodsnm
join goods_cnt_loc gcl on g.no=gcl.goodsno
where ol.step='2' and ol.step2='0'
".$add_where."
".$data_search['where']."
order by ol.mall_name,ol.ordno
";

//$loop=array("stock"=>array() , "soldout"=>array());

$loop=array("stock"=>array() );

$res = $db->query($qry,$data_search['param']);

unset($arr_goodsnm);
foreach($res->results as $v){

	$v = infoMasking($v, 'order_list'); //마스킹

	//교환반품이 진행중인 데이터 확인
	$cqry="select count(ci.no) as cnt from cs_info ci 
	left join cs_detail cd on(ci.no=cd.cs_info_no)
	where cd.goods_no='".$v['goodsno']."'
	and cd.send_type between 1 and 3
	and ci.return_type in ('60','70')
	and ci.return_type_sub in ('1')	
	and ci.add_type='1'
	";
	$cres = $db->query($cqry);
	$v['cs_chk']=$cres->results[0]['cnt'];

	$cal_qry="select count(sl.no) as cnt from goods g 
	join stock_list sl on (g.no=sl.goodsno)
	left join calendar c on (sl.group_id=c.group_id)
	where g.no='".$v['goodsno']."' and (sl.state=0 or sl.comp_chk='n')
	and sl.state!=2 and sl.group_id!='' and sl.calendar_date between DATE_ADD(NOW(),INTERVAL -3 DAY ) AND NOW()
	";

	$cal_res=$db->query($cal_qry);
	$v['cal_chk']=$cal_res->results[0]['cnt']; 

	$arr_goodsnm[]=$v['goodsnm'];

	if($v['bundle']>0)$v['bundle_color']="red";
	
	$stock_chk=0;
	foreach($place_data as $pv){
		$stock_chk+=$v['codeno_'.$pv];
	}
	$orderType=orderType($v['no']);
	$v['order_type']=$orderType;
	
	/*
	if($stock_chk>0)$loop['stock'][]=$v;
	else $loop['soldout'][]=$v;
	*/
	$loop['stock'][]=$v;

}

if(is_array($arr_goodsnm)){
	/*모델 주문수량*/
	unset($param);
	$param = $db->inqry_param($arr_goodsnm);
	$qry="select goodsnm,sum(order_num) sumN from order_list ol
	where goodsnm in (".implode(",",array_keys($param)).") 
	and step in ('1','2') and step2='0'
	".$add_where."
	group by goodsnm
	";

	$res=$db->query($qry,$param);
	foreach($res->results as $v){
		$goods_order_cnt[$v['goodsnm']]=$v['sumN'];
	}
}


if($_SESSION['sess']['h_level']<'40'){
	$nav_view="1";	
}

$tpl->assign(array(	
'loop' => $loop
,'goods_order_cnt' => $goods_order_cnt
,'nav_view' => $nav_view
));

$tpl->print_('tpl');
?>
