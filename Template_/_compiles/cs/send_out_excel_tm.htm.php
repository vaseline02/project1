<?php /* Template_ 2.2.8 2020/08/21 09:49:23 /www/html/ukk_test2/data/skin/cs/send_out_excel_tm.htm 000001637 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<table border="1">
	<tr>
		<td>주문번호</td>
		<td>쇼핑몰</td>
		<td>운송장번호</td>
		<td>수령인</td>
		<td>수령인 우편번호</td>
		<td>수령인 주소</td>
		<td>수령인 전화번호</td>
		<td>수령인 핸드폰</td>
		<td>매입상품명</td>
		<td>수량</td>
		<td>배송메세지</td>
		<td>총 결제금액</td>
		<td>주문자명</td>
		<td>품목번호</td>
		<td>품목별 주문번호</td>
		<td>판매처코드</td>
		<td>선착불구분자</td>
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<tr>
	<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
	<td><?php echo $TPL_V1["company_name"]?></td>
	<td></td>
	<td><?php echo $TPL_V1["receiver"]?></td>
	<td style='mso-number-format:"\@";'><?php echo $TPL_V1["zipcode"]?></td>
	<td><?php echo $TPL_V1["address"]?></td>
	<td style='mso-number-format:"\@";'><?php echo $TPL_V1["buyer_mobile"]?></td>
	<td style='mso-number-format:"\@";'><?php echo $TPL_V1["mobile"]?></td>
	<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
	<td><?php echo $TPL_V1["order_num"]?></td>
	<td><?php echo $TPL_V1["order_memo"]?></td>
	<td style='mso-number-format:"\@";'><?php echo $TPL_V1["settle_price"]?></td>
	<td><?php echo $TPL_V1["buyer"]?></td>
	<td></td>
	<td></td>
	<td><?php echo $TPL_V1["mall_code"]?></td>
	<td>3</td>
</tr>
<?php }}?>
</table>