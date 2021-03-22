<?
include "../_header.php";

$page_title='일일택배관리';

if($_POST['comp_seq']){
	$qry="update daily_deli_info set comp_type='1',admin_no=:admin_no where no=:no";
	$db->query($qry,array(":no"=>$_POST['comp_seq'],":admin_no"=>$sess['m_no']));
	msg('처리되었습니다.','daily_deli_info.php');
}

$courier=array('0'=>'CJ대한통운(오전,강남)','1'=>'CJ대한통운(오전,동작)','2'=>'CJ대한통운(저녁,동작)','3'=>'우체국','4'=>'롯데택배','5'=>'로젠택배','6'=>'한진택배','7'=>'경동택배','8'=>'대신택배','9'=>'일양택배','11'=>'기타택배');
//$courier=array('중간 CJ 대한','우체국','롯데','로젠','한진','마지막 CJ대한','경동','대신','일양','외부택배','퀵전달받음','방문접수');

$tday=date('Y-m-d');
$time = time();
$s_def_day=date("Y-m-d",strtotime("-7 day",$time));
if(!$_POST['s_date'])$_POST['s_date']=$tday;
if(!$_POST['e_date'])$_POST['e_date']=$tday;

$qry="select * from daily_deli_info where reg_date between :s_date and :e_date order by reg_date desc";

$param[':s_date']=$_POST['s_date'];
$param[':e_date']=$_POST['e_date'];
$res = $db->query($qry,$param);
foreach($res->results as $v){

	if($v['memo'])$date_memo[$v['reg_date']]=$v;
	else if($v['courier_name']=='시제금'){

		$date_sije[$v['reg_date']]=$v;
		if($v['comp_type'])$date_comp[$v['reg_date']]='disabled';

	}else if($v['courier_name']=='반품배송비')$date_return[$v['reg_date']]=$v;
	else{

		if($v['reg_date']==$tday) $loop_t[$v['reg_date']][$v['courier_name']]=$v;
		$loop[$v['reg_date']][$v['courier_name']]=$v;
	}
}

if(!$loop_t){
	foreach($courier as $v){
		$loop_t[$tday][$v]=array();
	}
}

if($loop)$loop=array_merge($loop_t,$loop);
else $loop=$loop_t;

$tpl->assign(array(	
'loop' => $loop
,'date_memo' => $date_memo
,'date_sije' => $date_sije
,'date_return' => $date_return
,'date_comp' =>$date_comp
,'pg'=> $pg	));

$tpl->print_('tpl');
?>
