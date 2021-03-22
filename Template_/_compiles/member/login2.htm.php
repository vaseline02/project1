<?php /* Template_ 2.2.8 2021/02/19 12:04:47 /www/html/ukk_test2/data/skin/member/login2.htm 000000821 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div id="mem_wrap">
<form name="frm" action="login_ok.php" method="post" >
	<input type="hidden" name="mode" value="mail_chk">
	<input type="hidden" name="mno" value="<?php echo $_SESSION['login_no']?>">

	<div class="mem_div1">
		<div>2차인증(Email)<br>* 가입시 등록된 이메일로 인증번호가 발송되었습니다.</div>
		<div><input type="text" name="code" value="" size="120" maxlength="120" style="width:100%" placeholder="인증번호" tabindex="1" required></div>
		<div class="text_right"><button class="btn btn-sm btn-lg btn-primary">인증하기</button></div>
	</div>
</div>
</form>
<?php $this->print_("footer",$TPL_SCP,1);?>