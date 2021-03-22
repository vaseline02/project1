<?php /* Template_ 2.2.8 2020/11/16 14:13:26 /www/html/ukk_test2/data/skin/cs/bad_excel_tm.htm 000001117 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<table border="1">
	<tr>
		<td>품목코드<br>(필수)</td>
		<td>수량<br>(필수)</td>
		<td>REMARK</td>
		<td>업체명</td>
		<td>가격</td>
		<td>수취인</td>
		<td></td>
		<td></td>
		<td>업체코드</td>		
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<tr>
	<td style='mso-number-format:"\@";'><?php echo $TPL_V1["g_goodsnm"]?></td>
	<td><?php echo $TPL_V1["order_num"]?></td>
	<td><?php echo $TPL_V1["ordno"]?>/<?php echo $TPL_V1["company_name"]?> <?php echo $TPL_V1["return_type_nm"]?></td>
	<td><?php echo $TPL_V1["company_name"]?></td>
	<td style='mso-number-format:"\@";'><?php echo $TPL_V1["settle_price"]?></td>
	<td><?php echo $TPL_V1["receiver"]?></td>
	<td style='mso-number-format:"\@";'></td>
	<td style='mso-number-format:"\@";'></td>
	<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ent_code"]?></td>	
</tr>
<?php }}?>
</table>