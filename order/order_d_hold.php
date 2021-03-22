<?
include "../_header.php";

$page_title='보류';
$ORDER=new order();
$GOODS=new goods();
$mode=$_POST['mode'];
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
	            msg('처리되었습니다.'.$dmsg,'order_d_hold.php?'.$QUERY_STRING);

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

	try{
	$db->beginTransaction();
	
		if($_POST['mode']=='cancel'){
			//$ORDER->order_cancel($_POST['chk_no'],'8','45');
			$step_return=$ORDER->order_step_chg('','8','45',$_POST['chk_no']);	

			$qry="select no,wno,mall_name,mall_no,bundle,ordno,order_num,goodsno,settle_price from order_list where no in (".implode(",",$_POST['chk_no']).")";
			$res=$db->query($qry);
					
			foreach($res->results as $v){
				if($v['wno']){
					wholesale_payment_ins('soldout',$v['no'],$v['order_num'],$v['settle_price']);
				}
			}


		}else if($_POST['mode']=='goback'){
			
			foreach($_POST['chk_no'] as $v){
				$ginfo=0;
				$ginfo=$_POST['hid_goodsno'][$v];
				
				if($ginfo){
					$ORDER->order_step_chg('','1','0',$v);	
				}else{
					$err_msg[]=$_POST['hid_ordno'][$v].'모델명or모델번호 오류/';
				}
			}
		}else if($_POST['mode']=='go_soldout'){
			
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
		}else if($_POST['mode']=='outside_deli'){

			foreach($_POST['chk_no'] as $v){
				$qry="update order_list set deli_codeno='outside' where no='".$v."'";
				$res=$db->query($qry);
			}
			
			$step_return=$ORDER->order_step_chg('','6','0',$_POST['chk_no']);	

		}else if($_POST['mode']=='memoIns'){
			$QUERY_STRING.=order_return_url();

			$ORDER->admin_memo($_POST['chk_no'],$_POST['i_memo']);
		}else if($_POST['mode']=='soldout'){ //예약재고잡힘

			$step_return=$ORDER->order_step_chg('','3','0',$_POST['chk_no']);	
		}
		//$db->rollBack();
		$db->commit();

		if($err_msg)msg(implode(" ",$err_msg),'order_d_hold.php?'.$QUERY_STRING);
		else msg('처리되었습니다.','order_d_hold.php?'.$QUERY_STRING);
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
	}
}

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
//tydebug($chk_stand_stock);


/*리스트*/
$data_search = $ORDER->order_search_where();
$qry="select ol.* ".$cfg_select_gcl." from order_list ol
left join goods g on ol.goodsno=g.no
left join goods_cnt_loc gcl on g.no=gcl.goodsno
where step='8' and step2<40
".$data_search['where']."
";


$res = $db->query($qry,$data_search['param']);

$bf_ordno='';
$color_key=0;
$list_num=1;
foreach($res->results as $v){

	$v = infoMasking($v, 'order_list'); //마스킹

	$v['list_num']=$list_num++;

	if($bf_ordno!=$v['ordno']){
		$bf_ordno=$v['ordno'];
		$color_key++;
	}
	$orderType=orderType($v['no']);
	$v['order_type']=$orderType;
	$v['line_color']="table_tr".$color_key%2;

	if($v['bundle']>0)$v['bundle_color']="red";
	$v['place_name']=$place_name[$v['deli_codeno']];
	
	//if($v['upload_form_type']=='오피셜')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
	$loop[]=$v;
}

if($_SESSION['sess']['h_level']<'10'){
	$nav_view="1";	
}

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
