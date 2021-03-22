<?
include "../_header.php";

$session->logout();	
$_SESSION = array();
go("../member/login.php");
?>