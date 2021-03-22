<?php /* Template_ 2.2.8 2020/04/21 10:21:49 /www/html/ukk_test/data/skin/cs/send_list.htm 000006229 */ 
$TPL__cfg_retrun_type_1=empty($GLOBALS["cfg_retrun_type"])||!is_array($GLOBALS["cfg_retrun_type"])?0:count($GLOBALS["cfg_retrun_type"]);
$TPL__cfg_send_type_1=empty($GLOBALS["cfg_send_type"])||!is_array($GLOBALS["cfg_send_type"])?0:count($GLOBALS["cfg_send_type"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<style>
.search_td_width{width:800px;}
</style>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form method="get">
	<table class="table table-bordered" >

		<tr>
			<th>송장번호</th>
            <td><textarea name="s_invoice" id="" cols="30" rows="3"><?php echo $_POST['s_invoice']?></textarea></td>				
			<th>주문번호</th>
			<td><input type="text" name="s_order_no" value="<?php echo $_POST['s_order_no']?>"></td>
		</tr>
		
        <tr>
            <th>교환반품</th>
            <td>
				<select name="s_return_type">
					<option value="">선택</option>
<?php if($TPL__cfg_retrun_type_1){foreach($GLOBALS["cfg_retrun_type"] as $TPL_K1=>$TPL_V1){?>
					<option value=<?php echo $TPL_K1?> <?php echo $GLOBALS["selected"]['return_type'][$TPL_K1]?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</td>
			<th>진행상태</th>
            <td>
				<select name="s_send_type">
					<option value="">선택</option>
<?php if($TPL__cfg_send_type_1){foreach($GLOBALS["cfg_send_type"] as $TPL_K1=>$TPL_V1){?>					
<?php if($TPL_K1!='0'&&$TPL_K1!='91'){?>
					<option value=<?php echo $TPL_K1?> <?php echo $GLOBALS["selected"]['send_type'][$TPL_K1]?>><?php echo $TPL_V1?></option>
<?php }?>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr>
			<th>등록일자</th>
			<td colspan=3>
			<input type="text" name="s_date" id="s_date" class="datepicker_common" autocomplete="off" value="<?php echo $GLOBALS["s_date_value"]?>"> ~ 
			<input type="text" name="e_date" id="e_date" class="datepicker_common" autocomplete="off" value="<?php echo $GLOBALS["e_date_value"]?>">
			</td>			
        </tr>
	
	</table>
	<center>
		<button class="btn btn-primary" id="">검 색</button>
	</center>
</form>

<?php }?>
<form id="sendForm" method="POST">
<input type="hidden" name="mode" value="">
<input type="hidden" name="no" value="">
<input type="hidden" name="code" value="">
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
<?php if($_GET['s_send_type']&&$_GET['s_send_type']<'90'){?>
			<th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>			
<?php }?>
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
<?php if($_GET['s_send_type']&&$_GET['s_send_type']<'90'){?>
			<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td>
<?php }?>
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
				<button type="button" class="btn btn-sm btn-warning" onclick="popup('send_reg.php?no=<?php echo $TPL_V1["no"]?>','','1100','900')">상세</button>
<?php if($TPL_V1["send_type"]=='90'){?>
				<div type="button" class="btn btn-sm btn-danger cancelCs" data-no=<?php echo $TPL_V1["no"]?>>철회</div>
<?php }?>
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>
<?php if($_GET['s_send_type']&&$_GET['s_send_type']<'90'){?>
<div class="bottom_btn_box">
	<div  class="box_left">
		선택한 항목을
		<select class="changeSelect" id="">
			<option value="">선택</option>
<?php if($TPL__cfg_send_type_1){foreach($GLOBALS["cfg_send_type"] as $TPL_K1=>$TPL_V1){?>					
<?php if($TPL_K1!='0'&&$TPL_K1!='91'&&$TPL_K1!=$_GET['s_send_type']){?>
			<option value=<?php echo $TPL_K1?>><?php echo $TPL_V1?></option>
<?php }?>
<?php }}?>
		</select>

		<div type="button" class="btn btn-primary cancelChange" id="order_settle">변경</div>
	</div>
</div>
<?php }?>
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
	}else if(!$(".changeSelect").val()){
		alert("변경항목을 선택해주세요.");
		return false;
	}else{
		if(confirm('('+$(".changeSelect option:checked").text()+') 변경하시겠습니까?')){
			$("input[name='mode']").val('allCancel');
			$("input[name='code']").val($(".changeSelect").val());
			$("#sendForm").submit();
		}
	}
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>