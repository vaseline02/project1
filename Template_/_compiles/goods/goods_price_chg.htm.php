<?php /* Template_ 2.2.8 2021/02/16 13:57:14 /www/html/ukk_test2/data/skin/goods/goods_price_chg.htm 000001575 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<form method="post" id="main_form">
	<table id="" class="display " data-height="740" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
		<caption>
			<div class="input-group col-lg-12 common-table-search2">
				<span class="common-table-result"><?php echo $GLOBALS["goodsnm_title"]?></span>
				<div class="input-group common-table-search">
				</div>
			</div>
		</caption> 

		<table id="" class="display display_s" data-height="540" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
			<thead>
				<tr>
					<th>변경전</th>
					<th>변경후</th>
					<th>변경자</th>
					<th>날짜</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
				<tr>
					<td><?php echo number_format($TPL_V1["b_data"])?></td>
					<td><?php echo number_format($TPL_V1["a_data"])?></td>
					<td><?php echo $TPL_V1["name"]?></td>
					<td><?php echo $TPL_V1["reg_date"]?></td>
				</tr>
<?php }}?>
			</tbody>
		</table>		

	</table>

</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";


$(function(){

})


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>