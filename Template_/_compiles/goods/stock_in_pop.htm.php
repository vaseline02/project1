<?php /* Template_ 2.2.8 2020/11/19 09:24:33 /www/html/ukk_test2/data/skin/goods/stock_in_pop.htm 000001212 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<form method="post" id="excelForm" name="excelForm">
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th>모델명</th>
			<th>미입고수량</th>
			<th data-orderable="false">내용</th>
			<th>날짜</th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>		
		<tr>			
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["stock_num_reg"]-$TPL_V1["stock_num"]?></td>
			<td><?php echo $TPL_V1["title"]?></td>
			<td><?php echo $TPL_V1["calendar_date"]?></td>
		</tr>
<?php }}?>
	</tbody>
</table>
</form>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>