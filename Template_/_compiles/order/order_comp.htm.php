<?php /* Template_ 2.2.8 2020/08/06 08:45:32 /www/html/ukk_test/data/skin/order/order_comp.htm 000004617 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>

<style>
.search_td_width{width:500px;}
</style>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form method="post">
<table class="table table-bordered" >

	<tr>
		<th>몰명</th>
		<td class="search_td_width"><input type="text" name="s_mall" value="<?php echo $_POST['s_mall']?>"></td>
		<th>옵션명</th>
		<td><input type="text" name="s_model" value="<?php echo $_POST['s_model']?>"></td>
		
	</tr>
	<tr>
		<th>고객명</th>
		<td class="search_td_width"><input type="text" name="s_receiver" value="<?php echo $_POST['s_receiver']?>"></td>
		<th>연락처</th>
		<td><input type="text" name="s_mobile" value="<?php echo $_POST['s_mobile']?>"></td>
	</tr>
	<tr>
		<th>주문일자</th>
		<td>
		<input type="text" name="s_date" id="s_date" class="datepicker_common" autocomplete="off" value="<?php echo $_POST['s_date']?>"> ~ 
		<input type="text" name="e_date" id="e_date" class="datepicker_common" autocomplete="off" value="<?php echo $_POST['e_date']?>">
		</td>
		<th>주문번호</th>
		<td>
			<input type="text" name="s_ordno" value="<?php echo $_POST['s_ordno']?>">
			<label style="font-weight: normal;"><input type="checkbox" name="s_cancel" value="Y" <?php echo $GLOBALS["checked"]["s_cancel"]["Y"]?>>주문취소건</label>
		</td>
		
	</tr>
</table>
<center>
	<button class="btn btn-primary" id="">검 색</button>
</center>
</form>

<?php }?>

<?php }?>
<form method="post" id="main_form">
<?php if($GLOBALS["print_xls"]!= 1){?>
<input type="hidden" name="mode" id="mode">
<input type="hidden"name="print_xls" value="">
<?php }?>
<table id="" class="display display_dt" data-height="740" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">

	<?php echo $this->define('tpl_include_file_1',"outline/table_width_order.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<?php echo $this->define('tpl_include_file_2',"order/_order_cols.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

			<th width="100">배송지</th>
			<th width="100">송장번호</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="<?php echo $TPL_V1["line_color"]?>">
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
				<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>">
				<input type="hidden" name="hid_invoice[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["invoice"]?>">
			</td>
<?php }?>
			<td><?php echo $TPL_V1["mall_name"]?></td>
			<td><?php echo $TPL_V1["ordno"]?> <?php if($TPL_V1["copy_seq"]> 0){?>복사본<?php }?></td>
			<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
			<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["order_num"]?></td>
			<td><?php echo number_format($TPL_V1["settle_price"])?></td>
			<td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>

			<td><?php echo $TPL_V1["phone"]?><br/><?php echo $TPL_V1["mobile"]?></td>
			<td><?php echo $TPL_V1["zipcode"]?> <?php echo $TPL_V1["address"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td style="color:<?php echo $TPL_V1["bundle_color"]?>"><?php echo $TPL_V1["bundle"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td><?php echo $TPL_V1["place_name"]?></td>
			<td><?php if($TPL_V1["invoice"]!= 0){?><?php echo $TPL_V1["invoice"]?><?php }?></td>
		</tr>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>


<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>


<div class="bottom_btn_box">
	<div class="box_left">

	</div>
	<div  class="box_right">
	<!--<button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>-->
	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li></li>
  </ul>
</fieldset>
<?php }?>
</form>



<script>
	document.title="<?php echo $GLOBALS["page_title"]?>";
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>