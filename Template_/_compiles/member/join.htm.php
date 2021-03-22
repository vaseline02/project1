<?php /* Template_ 2.2.8 2019/06/16 22:03:07 /free/home/sevenwatch/wondong/ukk/data/skin/member/join.htm 000002684 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div id="mem_wrap">
<form name="frm" action="join_ok.php" method="post" onsubmit="return chkform();">
	<div class="mem_div1  fcolor2">
		<h1 class="engfont">MEMBER JOIN</h1>
		<div class="title engfont">ID</div>
		<div class="inp">
			<input type="text" name="id" class="keyup_chk numeng_only" value="" size="120" maxlength="120" style="width:100%"  tabindex="1" required>
			<div class="chk_id chk_valdup">dasfad</div>
			<input type="hidden" name="chk_id" class="submit_ok" value=0>
		</div>
		<div class="title engfont">PASSWORD</div>
		<div><input type="password" name="passwd" value="" size="12" maxlength="50" style="width:100%"  tabindex="2" required></div>
		<div class="title engfont">NAME</div>
		<div><input type="text" name="name" value="" size="120" maxlength="120" style="width:100%"  tabindex="3" required></div>
		<div class="title engfont">MOBILE</div>
		<div>
		<input type="text" name="mobile[]" class="number_only " value="" size="4" maxlength="4" style="width:28%"  tabindex="4" required> -
		<input type="text" name="mobile[]" class="number_only " value="" size="4" maxlength="4" style="width:28%"  tabindex="5" required> -
		<input type="text" name="mobile[]" class="number_only " value="" size="4" maxlength="4" style="width:28%"  tabindex="6" required>
		</div>
		<div class="title engfont">MAIL</div>
		<div class="inp">
			<input type="text" name="email" class="keyup_chk" value="" size="12" maxlength="50" style="width:100%"  tabindex="7" required>
			<div class="chk_email chk_valdup" ></div>
			<input type="hidden" name="chk_email" class="submit_ok" value=0>
		</div>

		<div><button class="mem_btn1">JOIN</button></div>
	</div>
</form>
</div>

<script type="text/javascript">

$(function(){
	$(".keyup_chk").keyup(function(){
		var chk=$(this).attr("name");
		var val=$(this).val();				
		var val2=1;
		var chklen=4;
		$.post("../member/ajax_chk_minfo.php",{chk:chk,val:val},function(data){
			
			if(data==1){
				$(".chk_"+chk).html("<span style='color:red'>사용불가</span>");
				$("input[name='chk_"+chk+"']").val(0);
			}else{

				if(chk=='email'){
										
					if(validateEmail(val)) {
						
					}else{
						val2=0;
					}
				}	
				if(chklen >= val.length){
					val2=0;
				}

				if(val2){
					$(".chk_"+chk).html("<span style='color:blue'>사용가능</span>");
					$("input[name='chk_"+chk+"']").val(1);
				}else{
					$(".chk_"+chk).html("<span style='color:red'>사용불가</span>");
				}
			}
			
		});
	});

})


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>