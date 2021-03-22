<?
include "../_header.php";

$page_title='취소처리목록';
$ORDER=new order();

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
	            msg('처리되었습니다.'.$dmsg,'order_cancel.php?'.$QUERY_STRING);

			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
        }        
    }
}

if($mode=='recovery'){
	try{
		$db->beginTransaction();
		
		/*체크로 넘어온 주문*/
		foreach($_POST['chk_no'] as $v){
			$arr_ordno[$_POST['hid_ordno'][$v]]=$_POST['hid_ordno'][$v];
		}
		$qry="update order_list set step='2', step2='0' where ordno in ('".implode("','",$arr_ordno)."') and step2<100 and step2>39";
		$db->query($qry);

		$db->commit();
		msg('처리되었습니다.','order_cancel.php');
	}catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
		
	}	
}else if($mode=='memoIns'){
	$QUERY_STRING=order_return_url();

	try{
		$db->beginTransaction();

		$ORDER->admin_memo($_POST['chk_no'],$_POST['i_memo']);

		$db->commit();
		msg('처리되었습니다.','order_cancel.php?'.$QUERY_STRING);
	}catch( Exception $e ){
		tydebug('err');
		$db->rollBack();
		tydebug($e->getMessage());
		
	}	
}else if($mode=='hold_order'){
	foreach($_POST['chk_no'] as $v){
		$sqry="select * from order_list where no='".$v."'";	
		$sres=$db->query($sqry);
		foreach($sres->results as $sv){
			$step_return=$ORDER->order_step_chg($sv['ordno'],'8','0',$sv['no']);	
		}
	}
	msg('처리되었습니다.','order_outside.php');
}

/*리스트*/
$data_search = $ORDER->order_search_where();


if(!$_POST['order_search_ordno'])$add_where=" and (reg_date=curdate() || LEFT(mod_date,10)=curdate()) ";

$qry="select ol.* from (
select no from order_list ol
where step2 between 39 and 100 
".$add_where."
".$data_search['where']."
) a join order_list ol on a.no = ol.no
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

$tpl->assign(array(	
'loop' => $loop
));

$tpl->print_('tpl');
?>
