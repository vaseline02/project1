<?php /* Template_ 2.2.8 2020/12/03 10:14:19 /www/html/ukk_test2/data/skin/cs/send_close.htm 000005002 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>
<?php echo $this->define('tpl_include_file_1',"cs/send_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<style>
.search_td_width{width:800px;}
#nav_div4 a:after{width:90%}
</style>

<?php if($GLOBALS["print_xls"]!= 1){?>
    <?php echo $this->define('tpl_include_file_2',"outline/table_width_cancel.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

<?php }?>
<form id="sendForm" name="sendForm" method="POST">

<input type="hidden"name="print_xls" value="">
<input type="hidden" name="mode" value="">
<input type="hidden" name="no" value="">
<input type="hidden" name="code" value="">

<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>						
<?php if($GLOBALS["print_xls"]!= 1){?><th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<th>몰명</th>
			<th>주문번호<br><span style="color:red">교환주문번호</span></th>
			<th>모델명</th>
<?php if($GLOBALS["print_xls"]!= 1){?><th>이미지</th><?php }?>
			<th>수량</th>
			<th>모델명<br>(교환)</th>
<?php if($GLOBALS["print_xls"]!= 1){?><th>이미지<br>(교환)</th><?php }?>
			<th>수량<br>(교환or반품)</th>
			<th>비용</th>
			<th>송장번호<br><span style="color:red">교환주문송장번호</span></th>
			<th>사유</th>
<?php if($GLOBALS["print_xls"]== 1){?><th>상품이상내용</th><?php }?>
			<th>작성자</th>
			<th>등록일</th>
			<th>완료일</th>
			<th>하자등록번호</th>
<?php if($GLOBALS["print_xls"]!= 1){?><th></th><?php }?>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr class="<?php echo $TPL_V1["line_color"]?>">			
<?php if($GLOBALS["print_xls"]!= 1){?>
				<td>
					<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>">
				</td>
<?php }?>
				<td><?php echo $TPL_V1["mall_name"]?><br><?php echo $TPL_V1["upload_form_type"]?></td>
				<td  style='mso-number-format:"\@";'><?php echo $TPL_V1["order_no"]?><?php if($TPL_V1["ex_ordno"]){?><br><span style="color:red">(<?php echo $TPL_V1["ex_ordno"]?>)</span><?php }?></td>
				<td><?php echo $TPL_V1["goodsnm"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?><td class="td_img"><?php echo $TPL_V1["img_url"]?></td><?php }?>
				<td><?php echo $TPL_V1["order_num"]?></td>
				<td><?php if($TPL_V1["return_type"]=='70'||$TPL_V1["return_type"]=='90'){?><?php echo $TPL_V1["exchange_goodsnm"]?><?php }?></td>
<?php if($GLOBALS["print_xls"]!= 1){?><td class="td_img"><?php if($TPL_V1["return_type"]=='70'||$TPL_V1["return_type"]=='90'){?><?php echo $TPL_V1["exchange_img_url"]?><?php }?></td><?php }?>
				<td><?php echo $TPL_V1["exchange_goods_num"]?></td>
				<td><?php echo number_format($TPL_V1["diff_price"])?></td>
				<td><?php if($TPL_V1["return_invoice"]!= 0){?><?php echo $TPL_VAR["delivery_list"][$TPL_V1["return_delivery_code"]]['name']?><br><?php echo $TPL_V1["return_invoice"]?><?php }?>
<?php if($TPL_V1["ex_invoice"]!= 0){?><br><span style="color:red"><?php echo $TPL_VAR["delivery_list"][$TPL_V1["ex_courier_code"]]['name']?><br><?php echo $TPL_V1["ex_invoice"]?></span><?php }?>
				</td>
				<td><?php echo $TPL_V1["return_type_nm"]?></td>
<?php if($GLOBALS["print_xls"]== 1){?><td><?php echo $TPL_V1["goods_bad_memo"]?></td><?php }?>
				<td><?php echo $TPL_V1["name"]?><br>(<?php echo $TPL_V1["id"]?>)</td>
				<td><?php echo $TPL_V1["reg_date"]?></td>
				<td><?php echo $TPL_V1["end_reg_date"]?></td>
				<td><?php echo str_pad($TPL_V1["cb_seq"], 7,"0",$TPL_VAR["STR_PAD_LEFT"])?></td>
<?php if($GLOBALS["print_xls"]!= 1){?>
				<td>
					<button type="button" class="btn btn-sm btn-warning" onclick="popup('cs_reg.php?ordno=<?php echo $TPL_V1["order_no"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>&order_list_no=<?php echo $TPL_V1["order_list_no"]?>&view_type=1','','1100','900')">상세</button>
				</td>
<?php }?>
			</tr>
<?php }}?>
	</tbody>
</table>


<?php if($GLOBALS["print_xls"]!= 1){?>
<div> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?><?php echo $TPL_VAR["pg"]->page['navi']?></div>
<?php }?>
</form>

<script>
$("#nav_div4").addClass('active');
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){

	$("#print_xls").click(function(){
		$("input[name='print_xls']").val("1");
		$("#sendForm").submit();
		$("input[name='print_xls']").val("0");
	});
})

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>