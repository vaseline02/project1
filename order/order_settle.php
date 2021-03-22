<?
include "../_header.php";
/*
$sdt = new DateTime('2012-01-01 01:30:30'); // 20120101 같은 포맷도 잘됨

$edt = new DateTime('2012-3-11');

// $차이 는 DateInterval 객체. var_dump() 찍어보면 대충 감이 옴.

$cha    = date_diff($sdt, $edt);
// 284
tydebug1($cha->days);
*/
$page_title='발송확정목록';
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
	            msg('처리되었습니다.'.$dmsg,'order_settle.php?'.$QUERY_STRING);

			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
        }        
    }
}else if($_FILES){
	ini_set('memory_limit', -1);
	ini_set('max_execution_time',0);

	$excel_data=excel_read('unlink','2');

	try{
		$db->beginTransaction();

		foreach($excel_data as $k=>$v){

			$delivery_code='';
			if($v['0']!='합계'){
				$c_gubun=substr($v['7'],0,1);
					
				$dqry="select code from delivery_info where c_gubun like '%|".$c_gubun."|%' and c_gubun!=''";
				$dres=$db->query($dqry);
				$delivery_code=$dres->results[0]['code'];
								
				//$mall_name=getEntnmToMallname($v['6']);
				
				unset($param);
				if($delivery_code){
					$qry="update order_list set 
					invoice=:invoice
					,courier_code=:courier_code
					,wms_ordno=:wms_ordno
					,cha_su=:cha_su
					,comp_date=:comp_date
					where 1
					and ordno=:ordno
					and goodsnm=:goodsnm
					";
	
					//$param[':mall_name']=$mall_name;
					$param[':invoice']=$v['7'];
					$param[':courier_code']=$delivery_code;
					$param[':wms_ordno']=$v['4'];
					$param[':cha_su']=$v['3'];
					$param[':comp_date']=$v['2'];

					$param[':ordno']=$v['5'];
					$param[':goodsnm']=$v['13'];
					
					$res=$db->query($qry,$param);
				}else{
					throw new Exception($k."열 택배사명 오류", 1); 
				}
			}
		}
		
		$db->commit();
		msg('처리되었습니다','order_settle.php');
		
	
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
	}
}


if($_POST['chk_no']){
	try{
	$db->beginTransaction();
	
		if($_POST['mode']=='cancel'){
			//$ORDER->order_cancel($_POST['chk_no'],'4','45');
			$step_return=$ORDER->order_step_chg('','4','45',$_POST['chk_no']);	
		}else if($_POST['mode']=='order_comp'){
			
			

			foreach($_POST['chk_no'] as $v){
				
				if($_POST['hid_invoice'][$v]!=0){
					
					$qry="update order_list set step='5',mod_date=now() where no=:no and invoice!=0";
					$res=$db->query($qry,array(":no"=>$v));
				}
			}
		}else if($_POST['mode']=='goback'){
			
			//$ORDER->ctl_step($_POST['chk_no'],'4');
			$ORDER->order_step_chg('','1','0',$_POST['chk_no']);	
		}else if($_POST['mode']=='memoIns'){
			$QUERY_STRING.=order_return_url();

			$ORDER->admin_memo($_POST['chk_no'],$_POST['i_memo']);
		}else if($_POST['mode']=='hold_order'){
			foreach($_POST['chk_no'] as $v){
				$sqry="select * from order_list where no='".$v."'";	
				$sres=$db->query($sqry);
				foreach($sres->results as $sv){
					$step_return=$ORDER->order_step_chg($sv['ordno'],'8','0',$sv['no']);	
				}
			}			
		}
		//$db->rollBack();
		$db->commit();
		msg('처리되었습니다.','order_settle.php?'.$QUERY_STRING);
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
	}
}

if($_GET['mode']=='go_step'){ //단계변경관련
	try{
	$db->beginTransaction();

		$no=array($_GET['no']);
		$step=$_GET['step'];	
		$ORDER->ctl_step($no,'4',$step);
		
		$db->commit();
		msg('처리되었습니다.','order_settle.php');
	}
	catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
	}
}

/*금일 출고내역과 주문수량 맞는지 체크*/
$qry="select goodsnm,order_num sumN,step,step2 from order_list ol
where ol.step in ('3','4') 
and ol.step2<'40' 
#and ol.reg_date=curdate() 
";
$res = $db->query($qry);
foreach($res->results as $v){

	if($v['step2']<40){
		if($v['step']=='4')$order_chk['판매']+=$v['sumN'];
		else if($v['step']=='3'){

			if($v['step2']=='1')$order_chk['대기(재고처리됨)']+=$v['sumN'];
			$order_chk['대기']+=$v['sumN'];

		}
		else if($v['step']=='5')$order_chk['처리완료']+=$v['sumN'];
	}else{
		$order_chk['취소']+=$v['sumN'];
	}
}



$qry="select sil.cnt,sil.io_type from stock_io_log sil

where 
reg_date > curdate() 
and io_type like 'order%'";
$res = $db->query($qry);
foreach($res->results as $v){

	if($v['io_type']=='order')$log_chk['주문']+=$v['cnt'];
	else if($v['io_type']=='order_cancel')$log_chk['취소']+=$v['cnt'];
	else if($v['io_type']=='order_hold' && $v['cnt']>0)$log_chk['보류']+=$v['cnt'];
	else if($v['io_type']!='order_hold')$log_chk['etc']+=$v['cnt'];


	if($v['io_type']=='order')$log_chk2['주문'][]=$v;
	else if($v['io_type']=='order_cancel')$log_chk2['취소'][]=$v;
	else if($v['io_type']=='order_hold' && $v['cnt']>0)$log_chk2['보류'][]=$v;
	else if($v['io_type']!='order_hold')$log_chk2['etc'][]=$v;
	
}

//$mall_list=get_mall_info();


$codedata=get_codedata('place','1');

foreach($codedata as $v){
	$place_name[$v['no']]=$v['cd'];
}

/*리스트*/
$data_search = $ORDER->order_search_where();


if($_GET['gubun']=='2'){
	$data_search['where'].=" and step2=2";
}else if($_GET['gubun']=='3'){
	$data_search['where'].=" and deli_codeno!='' and deli_codeno in('114','125')";
	$data_search['where'].=" and step2!=2";
}else{
	if($_GET['deli_codeno']!='51'){
		$data_search['where'].=" and deli_codeno='".$_GET['deli_codeno']."'";
	}else{
		$data_search['where'].=" and deli_codeno!='' and deli_codeno not in('1','114','125')";
	}

	$data_search['where'].=" and step2!=2";

}

$qry="select ol.*, di.name as delivery_name from order_list ol
left join delivery_info di on (ol.courier_code=di.code)
where ol.step='4' 
and ol.step2<'40'
and ol.reorder_status=0
".$data_search['where']."
order by ol.mall_name,ol.ordno
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
	
	$invo_upload_mall[$v['upload_form_type']]=$v['upload_form_type'];

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
