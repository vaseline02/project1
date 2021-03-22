<?php /* Template_ 2.2.8 2020/12/03 11:26:53 /www/html/ukk_test2/data/skin/stock/stock_comp_excel2.htm 000002869 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<table border="1">
    <tr>
        <td>모델명</td>
        <td>위치</td>
        <td>(IN,OUT)</td>
        <td>거래처</td>
        <td>수량</td>
        <td>원가</td>
        <td>주문번호</td>
        <td>주소</td>
        <td>주문자</td>
        <td>수취인</td>
        <td>전화번호</td>
        <td>판매가</td>
        <td>수수료율</td>
        <td>송장번호</td>
        <td>메모</td>
        <td>고객유형</td>
        <td>관리자메모(추가)</td>
		<td>총재고</td>
		<td>입고예정</td>
		<td>사무실</td>
		<td>3자물류</td>
		<td>몰명</td>
    </tr>
    
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<?php if($GLOBALS["stock_type"]!= 1){?>
		<tr>
			<td style='mso-number-format:"\@";'><?php echo $TPL_V1["g_goodsnm"]?></td>
			<td>입고 예정</td>
			<td>OUT</td>        
			<td>재고이동</td>
			<td style='mso-number-format:"\@";'><?php echo $TPL_V1["chk_num"]?></td>
			<td></td>
			<td style='mso-number-format:"\@";'></td>
			<td></td>
			<td></td>
			<td></td>
			<td style='mso-number-format:"\@";'></td>
			<td></td>
			<td></td>
			<td><?php echo $TPL_V1["invoice"]?>_재고 이동</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td style='mso-number-format:"\@";'><?php echo $TPL_V1["g_goodsnm"]?></td>
			<td><?php echo $_GET['stock_loc']?></td>
			<td>IN</td>
			<td><?php echo $GLOBALS["codedata_no"][$TPL_V1["customer"]]?></td>		
			<td style='mso-number-format:"\@";'><?php echo $TPL_V1["chk_num"]?></td>
			<td><?php echo round($TPL_V1["cost"]*$TPL_V1["cost_mod"])?></td>
			<td style='mso-number-format:"\@";'></td>
			<td></td>
			<td></td>
			<td></td>
			<td style='mso-number-format:"\@";'></td>
			<td></td>
			<td></td>
			<td><?php echo $TPL_V1["invoice"]?>_재고 입고</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
<?php }else{?>
		<tr>
			<td style='mso-number-format:"\@";'><?php echo $TPL_V1["g_goodsnm"]?></td>
			<td>입고 예정</td>
			<td>IN</td>
			<td><?php echo $GLOBALS["codedata_no"][$TPL_V1["customer"]]?></td>		
			<td style='mso-number-format:"\@";'><?php echo $TPL_V1["stock_num_reg"]?></td>
			<td><?php echo round($TPL_V1["cost"]*$TPL_V1["cost_mod"])?></td>
			<td style='mso-number-format:"\@";'></td>
			<td></td>
			<td></td>
			<td></td>
			<td style='mso-number-format:"\@";'></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
<?php }?>
<?php }}?>
    </table>