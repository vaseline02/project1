<?php /* Template_ 2.2.8 2020/08/26 10:55:50 /www/html/ukk_test2/data/skin/order/mall_invoice_excel.htm 000003834 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<table border="1">

<?php if($GLOBALS["sel_invo_mall"]=='셀피아'){?>

	<tr>
		<td>주문번호</td>
		<td>판매처</td>
		<td>임의필드</td>
		<td>수취인명</td>
		<td>우편번호</td>
		<td>주소</td>
		<td>수취인연락처</td>
		<td>수취인핸드폰</td>
		<td>운임구분</td>
		<td>자사코드</td>
		<td>주문수량</td>
		<td>주문메모</td>
		<td>판매처상품명</td>
		<td>판매처옵션명</td>
		<td>주문총금액</td>
		<td>발송인(상호)</td>
		<td>주문품목No</td>
		<td>송장번호</td>
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
		<td><?php echo $TPL_V1["mall_name"]?></td>
		<td></td>
		<td><?php echo $TPL_V1["receiver"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["zipcode"]?></td>
		<td><?php echo $TPL_V1["address"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["buyer_mobile"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["mobile"]?></td>
		<td><?php echo $TPL_V1["deli_type"]?></td>
		<td><?php echo $TPL_V1["code1"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["order_num"]?></td>
		<td><?php echo $TPL_V1["order_memo"]?></td>
		<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
		<td><?php echo $TPL_V1["goodsnm"]?></td>
		<td><?php echo $TPL_V1["settle_price"]?></td>
		<td>(주)트랜드메카</td>
		<td><?php echo $TPL_V1["mall_key"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["invoice"]?></td>
	</tr>
<?php }}?>
<?php }elseif($GLOBALS["sel_invo_mall"]=='스토어팜'){?>
	<tr>
		<td>상품주문번호</td>
		<td>배송방법</td>
		<td>택배사</td>
		<td>송장번호</td>
	</tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["dupl_key"]?></td>
		<td>택배,등기,소포</td>
		<td>CJ대한통운</td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["invoice"]?></td>
	</tr>
<?php }}?>
<?php }elseif($GLOBALS["sel_invo_mall"]=='오피셜'){?>
	<tr>
		<td>상품주문번호</td>
		<td>품목번호</td>
		<td>품목별 주문번호</td>
		<td>운송장번호</td>
		<td>브랜드</td>
	</tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
		<td><?php echo $TPL_V1["mall_key2"]?></td>
		<td><?php echo $TPL_V1["mall_key"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["invoice"]?></td>
		<td><?php echo $TPL_V1["mall_name"]?></td>
	</tr>
<?php }}?>
<?php }elseif($GLOBALS["sel_invo_mall"]=='타임메카'){?>
	<tr>
		<td>상품주문번호</td>
		<td>품목번호</td>
		<td>품목별 주문번호</td>
		<td>운송장번호</td>
	</tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
		<td><?php echo $TPL_V1["mall_key2"]?></td>
		<td><?php echo $TPL_V1["mall_key"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["invoice"]?></td>
	</tr>
<?php }}?>

<?php }elseif($GLOBALS["sel_invo_mall"]=='사방넷'){?>
	<tr>
		<td>사방넷 주문번호</td>
		<td>운송장번호</td>
	</tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["code1"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["invoice"]?></td>
	</tr>
<?php }}?>

<?php }?>
</table>