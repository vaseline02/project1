<?php /* Template_ 2.2.8 2020/12/18 16:34:32 /www/html/ukk_test2/data/skin/goods/iframe_goods_deal.htm 000003305 */ 
$TPL__err_msg_1=empty($GLOBALS["err_msg"])||!is_array($GLOBALS["err_msg"])?0:count($GLOBALS["err_msg"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<?php if($GLOBALS["err_msg"]){?>
<div style="overflow: auto; height:400px;">
<?php if($TPL__err_msg_1){foreach($GLOBALS["err_msg"] as $TPL_V1){?>
	<?php echo $TPL_V1?><br>
<?php }}?>
</div>
<?php }?>

<form method="post" id="listForm" name="listForm">
<input type="hidden" name="mode" value="">
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th>모델명</th>
			<th>제안수량</th>
			<th>가격</th>
			<th>EC행사가</th>
			<th>수수료</th>
			<th>원가</th>
			<th>수익율</th>
			<th>수익원</th>
			<th>쿠폰율</th>
			<th>메모</th>
			<th>재고메모</th>
			<th>재고설정가</th>
			<th>7일</th>
			<th>15일</th>
			<th>1달</th>
			<th>2달</th>
			<th>3달</th>
			<th>팀장메모</th>
			<th>가격변경</th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>				
		<tr>			
			<input type="hidden" name="deal_no[]" value="<?php echo $TPL_V1["no"]?>">
			<td><?php echo $TPL_V1["g_goodsnm"]?></td>
			<td><?php echo $TPL_V1["quantity"]?></td>
			<td><?php echo number_format($TPL_V1["price"])?></td>
			<td><?php echo number_format($TPL_V1["ec_price"])?></td>
			<td><?php echo $TPL_V1["comm"]?></td>
			<td><?php echo $TPL_V1["per_cost"]?><br><?php echo number_format($TPL_V1["now_cost"])?></td>
			<td><?php echo $TPL_V1["revenue_per"]?></td>
			<td><?php echo $TPL_V1["revenue_price"]?></td>
			<td><?php echo $TPL_V1["coupon_rate"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td><?php echo $TPL_V1["stock_memo"]?></td>			
			<td></td>
			<td><?php echo $TPL_V1["order_7day"]?></td>
			<td><?php echo $TPL_V1["order_15day"]?></td>
			<td><?php echo $TPL_V1["order_1month"]?></td>
			<td><?php echo $TPL_V1["order_2month"]?></td>
			<td><?php echo $TPL_V1["order_3month"]?></td>
			<td><input type="text" style="width:200px;" name="leader_memo[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["leader_memo"]?>"></td>
			<td><input type="text" style="width:100px;" name="change_price[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["change_price"]?>"></td>
		</tr>
<?php }}?>
	</tbody>
</table>
<div class="bottom_btn_box">
	<div class="box_left">
		
	</div>
	<div  class="box_right">		
		<button type="button" class="btn btn-primary chkForm" data-mode="mod" data-mess="정보수정">정보수정</button>
		<button type="button" class="btn btn-primary chkForm" data-mode="confirm" data-mess="승인">승인</button>
	</div>
</div>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(".chkForm").click(function (){
	var mode=$(this).data("mode");
	var mess=$(this).data("mess");

	if(confirm(mess+" 처리하시겠습니까?")){
		$("input[name='mode']").val(mode);
		$("#listForm").submit();
	}
	
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>