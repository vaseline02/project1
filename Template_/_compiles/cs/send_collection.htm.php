<?php /* Template_ 2.2.8 2020/03/31 11:38:49 /www/html/ukk_test/data/skin/cs/send_collection.htm 000003791 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<style>
.search_td_width{width:800px;}
</style>

<?php if($GLOBALS["print_xls"]!= 1){?>
    <?php echo $this->define('tpl_include_file_1',"outline/table_width_cancel.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<?php }?>
<form id="sendForm" method="POST">
<input type="hidden" name="mode" value="">
<input type="hidden" name="no" value="">
<input type="hidden" name="code" value="">
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>			
			<th width='200'>주문번호</th>
			<th width='150'>모델명</th>
			<th>이미지</th>
			<th>수량</th>
			<th width='150'>모델명<br>(교환)</th>
			<th>이미지<br>(교환)</th>
			<th>수량<br>(교환or반품)</th>
			<th width='50'>차액</th>
			<th width='100'>송장번호</th>
			<th width='100'>교환반품</th>
			<th width='70'>진행상태</th>
			<th width='90'>등록일</th>
			<th></th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="<?php echo $TPL_V1["line_color"]?>">			
			<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td>
			<td><?php echo $TPL_V1["order_no"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["order_num"]?></td>
			<td><?php if($TPL_V1["return_type"]>='40'&&$TPL_V1["return_type"]<'50'){?><?php echo $TPL_V1["exchange_goodsnm"]?><?php }?></td>
			<td class="td_img"><?php if($TPL_V1["return_type"]>='40'&&$TPL_V1["return_type"]<'50'){?><?php echo $TPL_V1["exchange_img_url"]?><?php }?></td>
			<td><?php echo $TPL_V1["exchange_goods_num"]?></td>
			<td><?php echo number_format($TPL_V1["diff_price"])?></td>
			<td><?php if($TPL_V1["invoice"]!= 0){?><?php echo $TPL_V1["invoice"]?><?php }?></td>
			<td><?php echo $TPL_V1["return_type_nm"]?></td>
			<td><?php echo $TPL_V1["send_type_nm"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td>
				<!--<button type="button" class="btn btn-sm btn-warning" onclick="popup('send_reg.php?no=<?php echo $TPL_V1["no"]?>','','1100','900')">상세</button>-->
<?php if($TPL_V1["send_type"]=='90'){?>
				<div type="button" class="btn btn-sm btn-danger cancelCs" data-no=<?php echo $TPL_V1["no"]?>>철회</div>
<?php }?>
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>

<div class="bottom_btn_box">
	<div  class="box_left">
		<div type="button" class="btn btn-primary cancelChange" id="order_settle" data-code='2'>회수확인</div>
	</div>
</div>

</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".cancelCs").click(function(){
	if(confirm("철회하시겠습니까?")){
		$("input[name='mode']").val('cancel');
		$("input[name='code']").val('91');
		$("input[name='no']").val($(this).data("no"));
		$("#sendForm").submit();
	}
});
$(".cancelChange").click(function(){
	if(!$(".chk_no").is(":checked")){
		alert("선택된 상품이 없습니다.");
		return false;
	}else{
        if(confirm('회수확인으로 변경하시겠습니까?')){
            $("input[name='mode']").val('allCancel');
            $("input[name='code']").val($(this).data('code'));
            $("#sendForm").submit();
        }
    }
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>