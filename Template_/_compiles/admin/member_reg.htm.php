<?php /* Template_ 2.2.8 2021/02/24 16:02:53 /www/html/ukk_test2/data/skin/admin/member_reg.htm 000005717 */ 
$TPL__arr_posi_1=empty($GLOBALS["arr_posi"])||!is_array($GLOBALS["arr_posi"])?0:count($GLOBALS["arr_posi"]);
$TPL_arr_menu_1=empty($TPL_VAR["arr_menu"])||!is_array($TPL_VAR["arr_menu"])?0:count($TPL_VAR["arr_menu"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<form method="post" id="mainForm" >
<input type="hidden" name="mode" value="<?php echo $GLOBALS["mode"]?>">
<input type="hidden" name="m_no" value="<?php echo $GLOBALS["m_no"]?>">
<table class="table table-bordered" >
	<tbody>
		<tr>
			<th>아이디</th>
			<td>
<?php if($GLOBALS["mode"]=='ins'){?>
				<input type="text" name="id" value="<?php echo $TPL_VAR["id"]?>" required>
<?php }else{?>
				<?php echo $TPL_VAR["id"]?>

<?php }?>
			</td>
		</tr>

<?php if($GLOBALS["mode"]=='ins'){?>
		<tr>
			<th>비밀번호</th>
			<td><input type="password" class="keyup_chk" name="pw" id="passwd" value="<?php echo $TPL_VAR["pw"]?>" required>
			<div class="chk_passwd" ></div>
			<input type="hidden" name="chk_passwd" class="submit_ok" alt="비밀번호" value=0>
			</td>
		</tr>
<?php }elseif($GLOBALS["mode"]=='mod'){?>
		<tr>
			<th>비밀번호변경</th>
			<td><input type="password" class="keyup_chk" name="pw_chg" id="passwd"> (변경시에만 입력하세요)
			<div class="chk_passwd" ></div>
			<input type="hidden" name="chk_passwd" class="submit_ok" alt="비밀번호" value=1>
			</td>
		</tr>		
<?php }?>
		<tr>
			<th>이름</th>
			<td><input type="text" name="name" value="<?php echo $TPL_VAR["name"]?>" required></td>
		</tr>
		<tr>
			<th>이메일</th>
			<td><input type="text" name="email" value="<?php echo $TPL_VAR["email"]?>"></td>
		</tr>
		<tr>
			<th>모바일</th>
			<td>
				<input type="text" class="number_only" name="mobile[]" maxlength="4" size="4" value="<?php echo $TPL_VAR["mobile"][ 0]?>"> -
				<input type="text" class="number_only" name="mobile[]" maxlength="4" size="4" value="<?php echo $TPL_VAR["mobile"][ 1]?>"> -
				<input type="text" class="number_only" name="mobile[]" maxlength="4" size="4" value="<?php echo $TPL_VAR["mobile"][ 2]?>">
			</td>
		</tr>
		<tr>
			<th>직급</th>
			<td><input type="text" name="position" value="<?php echo $TPL_VAR["position"]?>"></td>
		</tr>
		<tr>
			<th>부서</th>
			<td>
				<select name="team" id="">
<?php if($TPL__arr_posi_1){foreach($GLOBALS["arr_posi"] as $TPL_K1=>$TPL_V1){?>
						<optgroup label="<?php echo $TPL_K1?>">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>	
							<option value="<?php echo $TPL_K1?>-<?php echo $TPL_V2?>" <?php echo $GLOBALS["selected"]['team'][$TPL_K1][$TPL_V2]?>><?php echo $TPL_V2?> </option>
<?php }}?>
						</optgroup>	
<?php }}?>
				</select>
			</td>
		</tr>
<?php if($GLOBALS["h_control"]['memu']){?>
		<tr>
			<th>권한설정</th>
			<td>
			<select name="level" id="">
				<option value="3" <?php echo $GLOBALS["selected"]['level']['3']?>>일반</option>	
				<option value="2" <?php echo $GLOBALS["selected"]['level']['2']?>>팀장</option>	
				<option value="1" <?php echo $GLOBALS["selected"]['level']['1']?>>임원</option>	
			</select>
			</td>
		</tr>
<?php }?>
		<tr>
			<th>사용여부</th>
			<td>
			<label style="font-weight: normal;"><input type="radio" name="state" value="y" <?php echo $GLOBALS["checked"]['state']['y']?>>사용</label>
			<label style="font-weight: normal;"><input type="radio" name="state" value="n" <?php echo $GLOBALS["checked"]['state']['n']?>>미사용</label>
			</td>
		</tr>
	</tbody>
</table>

<?php if($GLOBALS["h_control"]['memu']){?>
<h1 class="page_title">메뉴설정</h1>

<hr>
<table class="table table-bordered" >
	<tbody>
<?php if($TPL_arr_menu_1){foreach($TPL_VAR["arr_menu"] as $TPL_K1=>$TPL_V1){?>
		<tr>
			<th><?php echo $TPL_K1?></th>
			<td>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<div style="width:24%;text-align:left;padding:4px;display:inline-block">
				<input type="checkbox" name="chk_menu[]" value="<?php echo $TPL_V2["sn"]?>" id="<?php echo $TPL_V2["sn"]?>" <?php echo $GLOBALS["checked"]['menu'][$TPL_V2["sn"]]?>> 
				<label for="<?php echo $TPL_V2["sn"]?>"><?php echo $TPL_V2["menu_snm"]?></label>
			</div>
<?php }}?>
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>
<?php }?>
<center>
	<div class="btn btn-lg btn-primary chkForm">등록/수정</div>
</center>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
	$(".keyup_chk").keyup(function(){
		var chk=$(this).attr("id");
		if(chk=='passwd'){
			var pwMess=chkPW();
	
			if(pwMess=="ok"){
				//$(".chk_"+chk).html("<span style='color:blue'>사용가능</span>");
				$(".chk_"+chk).html("");
				$("input[name='chk_"+chk+"']").val(1);
			}else{
				$(".chk_"+chk).html("<span style='color:red'>"+pwMess+"</span>");
				$("input[name='chk_"+chk+"']").val(0);
			}
		}
	});

})


$(".chkForm").click(function (){
	
	var chksub=1;
	var chk_val='';
	var mess="";
	$(".submit_ok").each(function(){

		if( $(this).val()==0 ){
			chksub=0;
			chk_val=$(this).attr("alt");
			return false;
		}

	});

	if(chksub){
<?php if($GLOBALS["mode"]=='ins'){?>
			mess="등록";
<?php }else{?>
			mess="수정";
<?php }?>
		if(confirm(mess+' 하시겠습니까?')){
			$("#mainForm").submit();
		}
	}else{
		alert('['+chk_val+'] 필수사항');
		return false;
	}

});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>