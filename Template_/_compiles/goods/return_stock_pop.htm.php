<?php /* Template_ 2.2.8 2020/08/25 11:23:41 /www/html/ukk_test2/data/skin/goods/return_stock_pop.htm 000000934 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
			<th>상품명</th>
			<th>등록원가</th>
			<th>수량</th>
			<th>메모</th>
			<th>등록일</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $TPL_VAR["goodsnm"]?></td>
			<td><?php echo $TPL_VAR["cost"]?></td>
			<td><?php echo $TPL_VAR["now_cnt"]?></td>
			<td><?php echo $TPL_VAR["memo"]?></td>
			<td><?php echo $TPL_VAR["reg_date"]?></td>
		</tr>
	</tbody>
</table>

</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>