<?php /* Template_ 2.2.8 2020/07/20 10:09:47 /www/html/ukk_test/data/skin/admin/mall_reg.htm 000002229 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>
<form method="post" onsubmit="return checkForm('2');">
<input type="hidden" name="mode" value="<?php echo $GLOBALS["mode"]?>">
<input type="hidden" name="no" value="<?php echo $GLOBALS["no"]?>">

<table class="table table-bordered" >
	<tbody>		
        <tr>
			<th>몰코드</th>
			<td>
<?php if($GLOBALS["mode"]=='ins'){?>
                <input type='text' name='mall_code' value="<?php echo $TPL_VAR["mall_code"]?>">
<?php }else{?>
                <?php echo $TPL_VAR["mall_code"]?>

<?php }?>
			</td>
		</tr>
		<tr>
			<th>몰명</th>
			<td>
				<input type='text' name='mall_name' value="<?php echo $TPL_VAR["mall_name"]?>">
			</td>
		</tr>
		<tr>
			<th>파일구분</th>
			<td>
				<input type='text' name='upload_form_type' value="<?php echo $TPL_VAR["upload_form_type"]?>">
			</td>
		</tr>
		
		<tr>
			<th>정렬번호</th>
			<td>
				<input type='text' name='sort' value="<?php echo $TPL_VAR["sort"]?>">
			</td>
		</tr>
		<tr>
			<th>사용유무</th>
			<td>
				<input type='radio' name='state' value='y' <?php echo $GLOBALS["checked"]['state']['y']?>>사용
				<input type='radio' name='state' value='n' <?php echo $GLOBALS["checked"]['state']['n']?>>사용안함
			</td>
		</tr>
	</tbody>
</table>
<?php if($GLOBALS["mode"]=='mod'){?>
<span style="color:red;">* 몰코드 변경이 필요할경우 개발팀에 문의해주세요.</span>
<?php }?>
<center>
	<button class="btn btn btn-primary">등록/수정</button>
</center>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

	function checkForm($addType){
        if(!$("input[name=mall_code]").val() && $("input[name=mode]").val()=='ins'){
            alert('몰코드를 입력해주세요.');
            return false;
        }
        if(!$("input[name=mall_name]").val()){
            alert('몰명을 입력해주세요.');
            return false;
        }        
    }
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>