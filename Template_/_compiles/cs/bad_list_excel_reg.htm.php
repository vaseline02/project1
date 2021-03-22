<?php /* Template_ 2.2.8 2020/11/13 15:19:33 /www/html/ukk_test2/data/skin/cs/bad_list_excel_reg.htm 000002735 */ 
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
		<td>A: 모델명, B: 하자내용</td>
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
<input type="hidden" name="mode" value="excel_bad">
<input type="hidden" name="total_cnt" value="<?php echo count($TPL_VAR["excel_loop"])?>">
<?php if($TPL_excel_loop_1){foreach($TPL_VAR["excel_loop"] as $TPL_K1=>$TPL_V1){?>
<input type="hidden" name="no[<?php echo $TPL_K1?>]" value='<?php echo $TPL_K1?>'>
<input type="hidden" name="goodsnm[<?php echo $TPL_K1?>]" value='<?php echo $TPL_V1["goodsnm"]?>'>
<input type="hidden" name="memo[<?php echo $TPL_K1?>]" value='<?php echo $TPL_V1["memo"]?>'>
<?php }}?>
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th>모델명</th>
			<th>하자내용</th>
			<th data-orderable="false">수량</th>
			<th>차감위치</th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_excel_loop_1){foreach($TPL_VAR["excel_loop"] as $TPL_V1){?>		
		<tr>			
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td>1</td>
			<td>사무실</td>
		</tr>
<?php }}?>
	</tbody>
</table>
<div style="text-align:right"><div class="btn btn-sm btn-primary checkForm">확정</button></div></div>
</form>
<?php }?>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$(".checkForm").click(function(){
	var cnt=$("input[name='total_cnt']").val();
	
	if(confirm(cnt+'개 리스트를 하자접수 하시겠습니까?')){
		$("form[id='excelForm']").submit();
	}	
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>