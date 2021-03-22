<?php /* Template_ 2.2.8 2020/11/20 15:24:44 /www/html/ukk_test2/data/skin/stock/stock_comp_excel_tm.htm 000000695 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<table border="1">
	<tr>
		<td>품목코드</td>
		<td>수량</td>
		<td>로케이션</td>
		<td>제조일자</td>
		<td>비고</td>
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<tr>
	<td style='mso-number-format:"\@";'><?php echo $TPL_V1["g_goodsnm"]?></td>
	<td><?php echo $TPL_V1["chk_num"]?></td>
	<td></td>
	<td></td>
	<td style='mso-number-format:"\@";'><?php echo $TPL_V1["invoice"]?>_재고 이동</td>	
</tr>
<?php }}?>
</table>