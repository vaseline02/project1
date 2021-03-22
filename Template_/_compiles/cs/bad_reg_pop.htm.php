<?php /* Template_ 2.2.8 2020/10/19 15:40:40 /www/html/ukk_test2/data/skin/cs/bad_reg_pop.htm 000001248 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>
<form method="post" onsubmit="return checkForm();">
<input type="hidden" name="mode" value="ins">
<input type="hidden" name="no" value="<?php echo $GLOBALS["no"]?>">

<table class="table table-bordered" >
	<tbody>		
        <tr>
			<th>모델명</th>
			<td>
                <input type='text' name='goodsnm' >
			</td>
		</tr>
		<tr>
			<th>원가</th>
			<td>
				<input type='text' name='cost'>
			</td>
		</tr>
		<tr>
			<th>하자수량</th>
			<td>
				<input type='text' name='qty' >
			</td>
		</tr>
		
		<tr>
			<th>하자내용</th>
			<td>
				<textarea name="memo" id="" cols="30" rows="10"></textarea>
			</td>
		</tr>
	</tbody>
</table>

<center>
	<button class="btn btn btn-primary">등록/수정</button>
</center>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

	function checkForm(){

		if(confirm('처리하시겠습니까?')){
			return true;
		}

		return false;
    }
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>