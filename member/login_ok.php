<?php
include "../_header.php";

$m_id = (string)$_POST['userid'];
$password = (string)$_POST['passwd'];
$result = $session->login_ori($m_id, $password);

if($result!==true)msg("아이디,패스워드 불일치",'../member/login.php');
else if($_SESSION['sess']['level']=='50') go('../wholesale/main.php');
else go('../main/index.php');
/*
if($_POST['mode']=="mail_chk"){
	$mno = $_POST['mno'];
	$code = $_POST['code'];
	$login_chk = $session->login2($mno,$code);

	if($login_chk=="3"){
		msg("이메일이 존재하지않습니다.",'../member/login2.php');
	}else if($login_chk=="2"){
		msg("아이디,패스워드 불일치",'../member/login2.php');
	}else if($login_chk=="4"){
		msg("인증코드 불일치(3분이내에 입력)",'../member/login2.php');
	}else{
		go('../main/index.php');
	}
}else{
	$m_id = (string)$_POST['userid'];
	$password = (string)$_POST['passwd'];
	$login_chk = $session->login($m_id, $password);

	if($login_chk=="3"){
		msg("이메일이 존재하지않습니다.",'../member/login.php');
	}else if($login_chk=="2"){
		msg("아이디,패스워드 불일치",'../member/login.php');
	}else if($_SESSION['sess']['level']=='50'){
		go('../wholesale/main.php');
	}else{
		//go('../main/index.php');
		go('../member/login2.php');
	}
}
*/

?>