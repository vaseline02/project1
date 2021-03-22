<?
include "../_header.php";

$page_title='외부연동상품관리-연동로그';
//$popup_chk=1; //메뉴 컨트롤
/* 데이터 입력시
try{
	
	$db->beginTransaction();
	
	$db->commit();
	msg('처리되었습니다.','stock_schedule.php');
}
catch( Exception $e ){
	tydebug('err');
	$db->rollBack();
	tydebug($e->getMessage());
	
}

*/

//phpinfo();

$_GET[page_num]=12;
$field="*";
$db_table="market_solution_sync_log";

//if($_POST['reg_date'])$where[]="reg_date='".$_POST['reg_date']."'";

if($_POST['s_paste'])$no_limit=1;

$pg = new page($_GET[page],$_GET[page_num],$no_limit);

$_GET[sort]="reg_date desc";
//$pg->cntQuery = "select count(distinct m.no) from model";
$pg->field = $field;
$pg->setQuery($db_table,$where,$_GET[sort]);
$pg->exec();


$res = $db->query($pg->query);
foreach($res->results as $v){
	$loop[]=$v;	
}


$tpl->assign(array(	
'loop' => $loop
,'pg'=> $pg	));

$tpl->print_('tpl');
?>
