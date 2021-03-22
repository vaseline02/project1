<?php /* Template_ 2.2.8 2020/11/25 08:16:44 /www/html/ukk_test2/data/skin/goods/stock_move_excel_reg.htm 000003192 */ 
$TPL__err_msg_1=empty($GLOBALS["err_msg"])||!is_array($GLOBALS["err_msg"])?0:count($GLOBALS["err_msg"]);
$TPL_excel_loop_1=empty($TPL_VAR["excel_loop"])||!is_array($TPL_VAR["excel_loop"])?0:count($TPL_VAR["excel_loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>
<form enctype="multipart/form-data" id="excel_form" method="post">
<input type="hidden"name="print_xls" value="">
<table class="table table-bordered" >
    <tr>
		<th>엑셀등록</th>
        <td><input type="file" name="excelFile[]" required/><button class="btn btn-sm btn-primary">업로드</button></td>
    </tr>
</table>
</form>

<?php if($GLOBALS["err_msg"]){?>
<div style="overflow: auto; height:400px;">
<?php if($TPL__err_msg_1){foreach($GLOBALS["err_msg"] as $TPL_V1){?>
	<?php echo $TPL_V1?><br>
<?php }}?>
</div>
<?php }elseif($TPL_VAR["excel_loop"]){?>
<form method="post" id="excelForm" name="excelForm">
<input type="hidden" name="mode" value="excel_move">
<input type="hidden" name="total_cnt" value="<?php echo $GLOBALS["sum_quantity"]?>">
<?php if($TPL_excel_loop_1){foreach($TPL_VAR["excel_loop"] as $TPL_K1=>$TPL_V1){?>
<input type="hidden" name="no[<?php echo $TPL_K1?>]" value='<?php echo $TPL_K1?>'>
<input type="hidden" name="goodsnm[<?php echo $TPL_K1?>]" value='<?php echo $TPL_V1["goodsnm"]?>'>
<input type="hidden" name="quantity[<?php echo $TPL_K1?>]" value='<?php echo $TPL_V1["quantity"]?>'>
<input type="hidden" name="s_move[<?php echo $TPL_K1?>]" value='<?php echo $TPL_V1["s_move"]?>'>
<input type="hidden" name="e_move[<?php echo $TPL_K1?>]" value='<?php echo $TPL_V1["e_move"]?>'>
<input type="hidden" name="memo[<?php echo $TPL_K1?>]" value='<?php echo $TPL_V1["memo"]?>'>
<?php }}?>
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th>모델명</th>
			<th>수량</th>
			<th data-orderable="false">차감위치</th>
			<th>증가위치</th>
			<th>메모</th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_excel_loop_1){foreach($TPL_VAR["excel_loop"] as $TPL_V1){?>		
		<tr>			
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["quantity"]?></td>
			<td><?php echo $TPL_V1["s_move"]?></td>
			<td><?php echo $TPL_V1["e_move"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>
		</tr>
<?php }}?>
	</tbody>

</table>
<div>이동예정수량 : <?php echo number_format($GLOBALS["sum_quantity"])?></div>
<div style="text-align:right"><div class="btn btn-sm btn-primary checkForm">확정</button></div></div>

</form>
<?php }?>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$(".checkForm").click(function(){
	var cnt=$("input[name='total_cnt']").val();
	
	if(confirm(cnt+'개의 재고를 이동 하시겠습니까?')){
		$("form[id='excelForm']").submit();
	}	
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>