<?php /* Template_ 2.2.8 2020/12/01 19:21:09 /www/html/ukk_test2/data/skin/bbs_default/cate_set.htm 000001760 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<form method="post" name="cateform">

<input type="hidden" name="board_id" value="<?php echo $GLOBALS["board_id"]?>">
<input type="hidden" name="mode" id="mode" value="ins">
<input type="hidden" name="sn" id="sn" >
<table class="table table-bordered" >
	<tr>
		<th>분류명</th>
		<th><button type="button" id="cate_add">+</button></th>
	</tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr>
		<td><input type="text" name="cate[<?php echo $TPL_V1["sn"]?>]" value="<?php echo $TPL_V1["cate_name"]?>"></td>
		<td style="text-align:center">
<?php if($TPL_V1["state"]=='none'){?>
		<button type="button" class="btn btn-danger" onclick="del_cate('<?php echo $TPL_V1["sn"]?>')">삭제</button>
<?php }else{?>
		삭제되었습니다.
<?php }?>
		</td>
	</tr>
<?php }}?>
</table>

<div style="text-align:center;margin:30px">
<button class="btn btn-primary">등록</button>
<button type="button" class="btn btn-primary" onclick="pop_close();">닫기</button>
</div>

</form>


<script>

function pop_close(){
	opener.location.reload();
	self.close();
}

function del_cate(sn){
	if(confirm('삭제하시겠습니까')){
		$("#mode").val('del');
		$("#sn").val(sn);
		$("form[name='cateform']").submit();
	}
}


$(function(){
	$("#cate_add").click(function(){
		$(".table-bordered").append("<tr><td><input type='text' name='add_cate[]' value=''></td><td></td></tr>");
	});

});
</script>


<?php $this->print_("footer",$TPL_SCP,1);?>