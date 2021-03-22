<?
include "../_header.php";

if(!$_SESSION['login_no']){
	msg("잘못된 접근입니다.",'../member/login.php');
}
$tpl->print_('tpl');
?>