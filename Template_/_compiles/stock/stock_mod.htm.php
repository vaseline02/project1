<?php /* Template_ 2.2.8 2021/03/02 14:26:12 /www/html/ukk_test2/data/skin/stock/stock_mod.htm 000002628 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>
<form method="post" >

<input type="hidden" name="no" value="<?php echo $TPL_VAR["no"]?>">
<input type="hidden" name="goodsno" value="<?php echo $TPL_VAR["goodsno"]?>">
<input type="hidden" name="goodsnm" value="<?php echo $TPL_VAR["goodsnm"]?>">
<input type="hidden" name="mode" value="<?php echo $GLOBALS["mode"]?>">
<table class="table table-bordered" >
	<tbody>
		<tr>
			<th>모델정보</th>
			<td><?php echo $TPL_VAR["brandnm"]?> / <?php echo $TPL_VAR["catenm"]?> / <?php echo $TPL_VAR["goodsnm"]?></td>
		</tr>
<?php if($GLOBALS["page_type"]!='1'){?>
		<tr>
			<th>그룹코드</th>
			<td>
				<input class="number_only" type="text" name="group_id" value="<?php echo $TPL_VAR["group_id"]?>">
				<input type="hidden" name="group_id_ori" value="<?php echo $TPL_VAR["group_id"]?>">
			</td>
		</tr>
<?php }?>
		
		<tr>
			<th>수량</th>
			<td>
				<input class="number_only" type="text" name="stock_num_reg" value="<?php echo $TPL_VAR["stock_num_reg"]?>">
			</td>
		</tr>
		<tr>
			<th>외화</th>
			<td><input class="number_only" type="text" name="cost_std" value="<?php echo $TPL_VAR["cost_std"]?>"></td>
		</tr>
		<tr>
			<th>환율</th>
			<td><input class="" type="text" name="rate" value="<?php echo number_format($TPL_VAR["rate"], 1)?>"></td>
		</tr>
		<tr>
			<th>관세율</th>
			<td><input class="number_only" type="text" name="duty_per" value="<?php echo $TPL_VAR["duty_per"]?>">%</td>
		</tr>
		<tr>
			<th>부대비용</th>
			<td><input class="number_only" type="text" name="extra_expense" value="<?php echo $TPL_VAR["extra_expense"]?>">%</td>
		</tr>
		<tr>
			<th>수수료</th>
			<td><input class="number_only" type="text" name="charge" value="<?php echo $TPL_VAR["charge"]?>">%</td>
		</tr>

<?php if($GLOBALS["page_type"]!='1'){?>
		<tr>
			<th>입고된수량</th>
			<td>
				<input class="number_only" type="text" name="stock_num" value="<?php echo $TPL_VAR["stock_num"]?>">
				<input type="hidden" name="before_stock_num" value="<?php echo $TPL_VAR["stock_num"]?>">
			</td>
		</tr>
<?php }?>
		<tr>
			<th>메모</th>
			<td><input type="text" name="memo" value="<?php echo $TPL_VAR["memo"]?>"></td>
		</tr>	
	</tbody>
</table>

<center>
	<button class="btn btn-lg btn-primary">수 정</button>
</center>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>