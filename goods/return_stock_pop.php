<?
include "../_header.php";

$page_title='반품입고내역';

$popup_chk=1; //메뉴 컨트롤
$no=$_GET['no'];

if($_GET['no']){
	// 2차카테고리
	$param=array(":no"=>$_GET["no"]);
	$qry="select * from stock_list where goodsno=:no and return_order=1 and now_cnt>0 order by no desc";

	$res=$db->query($qry,$param);
	$data=$res->results[0];
}
$tpl->assign($data);

$tpl->print_('tpl');
?>
