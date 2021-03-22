<?php /* Template_ 2.2.8 2019/12/03 09:22:30 /www/html/ukk_test2/data/skin/member/login.htm 000000726 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div id="mem_wrap">
<form name="frm" action="login_ok.php" method="post" >
	<div class="mem_div1">
		<div>LOGIN</div>
		<div><input type="text" name="userid" value="" size="120" maxlength="120" style="width:100%" placeholder="ID" tabindex="1" required></div>
		<div><input type="password" name="passwd" value="" size="12" maxlength="50" style="width:100%" placeholder="PASSWARD" tabindex="2" required></div>
		<div class="text_right"><button class="btn btn-lg btn-primary">LOGIN</button></div>
	</div>
</div>
</form>
<?php $this->print_("footer",$TPL_SCP,1);?>