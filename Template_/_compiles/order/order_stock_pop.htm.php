<?php /* Template_ 2.2.8 2021/03/16 14:35:24 /www/html/ukk_test2/data/skin/order/order_stock_pop.htm 000001334 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["column"]?> <?php echo $GLOBALS["page_title"]?></h1>

<hr>

<table id="" class="display display_dt" style="width:100%;" >
	<colgroup>
		<col width="80px"/>
		<col width="50px"/>
		<col width="50px"/>
		<col width="50px"/>
		<col width="200px"/>
		<col width="80px"/>
	</colgroup>
	<thead>
		<tr>			
			<th>상품명</th>
			<th>재고이동 위치(전)</th>
			<th>재고이동 위치(후)</th>
			<th>이동된 수량</th>
			<th>메모</th>
			<th>변경일</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["loc_b_place"]?></td>
			<td><?php echo $TPL_V1["loc_f_place"]?></td>
			<td><?php echo $TPL_V1["cnt"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
		</tr>
<?php }}?>
	
	</tbody>
</table>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";


</script>

<?php $this->print_("footer",$TPL_SCP,1);?>