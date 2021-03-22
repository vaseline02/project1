<?php /* Template_ 2.2.8 2020/01/20 17:42:06 /www/html/ukk_test/data/skin/goods/outside_reg_cate.htm 000002337 */ 
$TPL_arr_menu_1=empty($TPL_VAR["arr_menu"])||!is_array($TPL_VAR["arr_menu"])?0:count($TPL_VAR["arr_menu"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<form method="post" >
<input type="hidden" name="mode" value="<?php echo $GLOBALS["mode"]?>">
<input type="hidden" name="m_no" value="<?php echo $GLOBALS["m_no"]?>">
<table class="table table-bordered" >
	<tbody>
		<tr>
			<th>카테고리 추가</th>
			<td>
				<select id="sel_cate">
					<option value="">카테고리 선택</option>
					<option value="001">의류</option>
					<option value="002">구두/신발</option>
					<option value="003">가방</option>
					<option value="004">패션잡화</option>
					<option value="">직접입력</option>
				</select>
				<input type="text" name="code" id="code" required>
				<input type="text" name="name" required placeholder="실제 데이터명 입력">
				
			</td>
		</tr>

	</tbody>
</table>
<center>
	<button class="btn btn-primary">등 록</button>
</center>
</form>


<h1 class="page_title" style="margin-top:100px;">카테고리 리스트</h1>

<hr>

<form method="post" >
<table class="table table-bordered" >
	<tr>
		<th style="width:150px;">카테고리 코드</th>
		<th style="width:auto;">실제 데이터명</th>
	</tr>
<?php if($TPL_arr_menu_1){foreach($TPL_VAR["arr_menu"] as $TPL_K1=>$TPL_V1){?>
		<tr>
			<td><?php echo $TPL_K1?></td>
			<td>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<div style="text-align:left;padding:4px;display:inline-block">
				<input type="checkbox" name="del_menu[]" value="<?php echo $TPL_V2["no"]?>" id="<?php echo $TPL_V2["no"]?>"> 
				<label for="<?php echo $TPL_V2["no"]?>"><?php echo $TPL_V2["name"]?></label>
			</div>
<?php }}?>
			</td>
		</tr>
<?php }}?>
</table>
<center>
	<button class="btn btn-danger">선택 삭제</button>
</center>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
	
	$("#sel_cate").change(function(){
		$("#code").val( $(this).val());
	});
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>