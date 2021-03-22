<?php
include "../_header.php";

list($chkid)=$db->fetch("select id from mp_member where id='".$_POST['id']."' ");
list($chkmail)=$db->fetch("select email from mp_member where email='".$_POST['email']."' ");


if($chkid){
	msg("이미 사용중인 아이디 입니다.",-1);
}else if($chkmail){
	msg("이미 사용중인 이메일 입니다.",-1);
}else{
	
	$mobile=$_POST['mobile'][0]."-".$_POST['mobile'][1]."-".$_POST['mobile'][2];
	
	$qry="insert into mp_member set
	id='".$_POST['id']."'
	,password='".strtolower($_POST['passwd'])."'
	,name='".$_POST['name']."'
	,mobile='".$mobile."'
	,email='".$_POST['email']."'
	";
	
	if($db->query($qry)){
		msg("가입되었습니다. 로그인 해주세요.","login.php");
	}
}

?>