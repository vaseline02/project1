<?
include "../_header.php";
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);
$page_title='CS등록 통계';

$time = time(); 
$_GET['s_date']=$_GET['s_date']?$_GET['s_date']:date("Y-m-d",strtotime("-7 day", $time)); 
$_GET['e_date']=$_GET['e_date']?$_GET['e_date']:date("Y-m-d",strtotime("now", $time)); 
$week = array("일", "월", "화", "수", "목", "금", "토") ;


if($_GET['s_date'] && $_GET['e_date']){
	$add_where[]="crl.ins_date between '".$_GET['s_date']."' and '".$_GET['e_date']."'";
	/*
	$new_date = date("Y-m-d", strtotime("-1 day", strtotime($_GET['s_date'])));
	while(true) {
		 $new_date = date("Y-m-d", strtotime("+1 day", strtotime($new_date)));		
		 $list_date[$new_date]=$new_date;
		 $new_weekday=$week[date('w', strtotime($new_date))];
		 $weekday[$new_date] = $new_weekday;
		 if($new_weekday=='토') $font_color[$new_date]="style='color:blue'";
		 if($new_weekday=='일') $font_color[$new_date]="style='color:red'";

		 if($new_date == $_GET['e_date']) break;
	}

	$qry="select crl.*, m.name, count(crl.no) sumcount from 
	cs_report_log crl 
	left join member m on (crl.admin_no=m.no)
	where crl.ins_date between '".$_GET['s_date']."' and '".$_GET['e_date']."'
	group by crl.ins_date, crl.admin_no, crl.add_type order by m.name asc
	";	
	$res = $db->query($qry);
	foreach($res->results as $v){      
		$list_name[$v['admin_no']]=$v['name'];
		$data[$v['ins_date']][$v['admin_no']][$v['add_type']]=$v;
		$day_sum[$v['ins_date']]+=$v['sumcount'];
		$admin_sum[$v['admin_no']][$v['add_type']]+=$v['sumcount'];
		//$total_sum[$v['add_type']]+=$v['sumcount'];
		$total_sum+=$v['sumcount'];
	}	
	*/

	
	$qry="select crl.*, m.name, count(crl.no) sumcount from 
	cs_report_log crl 
	left join member m on (crl.admin_no=m.no)
	where crl.ins_date between '".$_GET['s_date']."' and '".$_GET['e_date']."'
	group by crl.ins_date, crl.admin_no, crl.add_type order by crl.ins_date asc
	";	

	$res = $db->query($qry);
	foreach($res->results as $v){      
		//$list_name[$v['name']]=$v['admin_no'];
		$list_name[$v['admin_no']]=$v['name'];
		asort($list_name);

		$new_weekday=$week[date('w', strtotime($v['ins_date']))];
		$weekday[$v['ins_date']] = $new_weekday;
		if($new_weekday=='토') $font_color[$v['ins_date']]="style='color:blue'";
		if($new_weekday=='일') $font_color[$v['ins_date']]="style='color:red'";

		$loop[$v['ins_date']]=$v;
		
		$data[$v['ins_date']][$v['admin_no']][$v['add_type']]=$v;//등록자별 접수 처리 구분
		$day_sum[$v['ins_date']]+=$v['sumcount']; //일별 처리개수
		$admin_sum[$v['admin_no']][$v['add_type']]+=$v['sumcount'];//개인별 처리개수
		$total_sum[$v['add_type']]+=$v['sumcount'];
		//$total_sum+=$v['sumcount'];//총합계
	}	

	$tpl->assign(array(	
	'data' => $data
	,'loop' => $loop
	,'pg'=> $pg	
	//,'list_date'=>$list_date
	));
		
	
}

/*리스트*/		
/*
$_GET[page_num]=50;
$field="crl.*, m.name, count(crl.no) sumcount";
$db_table="cs_report_log crl 
left join member m on (crl.admin_no=m.no)
";
$pg = new page($_GET[page],$_GET[page_num]);
$pg->field = $field;

$pg->setQuery($db_table,$add_where,'crl.ins_date asc', 'group by crl.ins_date, crl.admin_no, crl.add_type');
$pg->exec();
$qry=$pg->query;
$res = $db->query($qry);
foreach($res->results as $v){      
    //$list_name[$v['name']]=$v['admin_no'];
    $list_name[$v['admin_no']]=$v['name'];
	asort($list_name);

	$new_weekday=$week[date('w', strtotime($v['ins_date']))];
	$weekday[$v['ins_date']] = $new_weekday;
	if($new_weekday=='토') $font_color[$v['ins_date']]="style='color:blue'";
	if($new_weekday=='일') $font_color[$v['ins_date']]="style='color:red'";

	$loop[$v['ins_date']]=$v;
	
	$data[$v['ins_date']][$v['admin_no']][$v['add_type']]=$v;//등록자별 접수 처리 구분
	$day_sum[$v['ins_date']]+=$v['sumcount']; //일별 처리개수
	$admin_sum[$v['admin_no']][$v['add_type']]+=$v['sumcount'];//개인별 처리개수
	$total_sum[$v['add_type']]+=$v['sumcount'];
	//$total_sum+=$v['sumcount'];//총합계
}	
tydebug($loop);
$tpl->assign(array(	
'data' => $data
,'loop' => $loop
,'pg'=> $pg	
//,'list_date'=>$list_date
));
    */
$tpl->print_('tpl');
?>


