<?
include "../_header.php";

$page_title='하자정보수정';

$popup_chk=1; //메뉴 컨트롤
$QUERY_STRING = $_SERVER['QUERY_STRING'];

if($_POST['mode']){

	$uqry="update cs_bad set
	memo='".$_POST['memo']."'
	,repair_memo='".$_POST['repair_memo']."'
	,admin_memo='".$_POST['admin_memo']."'
	,repair_type='".$_POST['repair_type']."'	
	,repair_date='".$_POST['repair_date']."'
	,repair_cost='".$_POST['repair_cost']."'
	,send_date='".$_POST['send_date']."'
	,in_date='".$_POST['in_date']."'
	,calcu_date='".$_POST['calcu_date']."'	
	where no='".$_POST['no']."'
	";
	$db->query($uqry);
	MsgViewCloseReload("처리되었습니다","bad_reg.php?".$QUERY_STRING);		
	
}


$qry="select * from cs_bad where no='".$_GET['no']."'";
$res = $db->query($qry,$param);
$data=$res->results[0];

$tpl->assign(array(	
'data' => $data
));

$tpl->print_('tpl');
?>
