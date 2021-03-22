<?php /* Template_ 2.2.8 2020/12/03 14:46:33 /www/html/ukk_test2/data/skin/cs/bad_excel2.htm 000001343 */ 
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
        
    </tr>
    
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
    <tr>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["g_goodsnm"]?></td>
        <td>사무실</td>
        <td>IN</td>
        <td>재고이동</td>
        <td><?php echo $TPL_V1["order_num"]?></td>
        <td><?php echo $TPL_V1["tot_price"]?></td>
        <td style='mso-number-format:"\@";'></td>
        <td></td>
        <td></td>
        <td></td>
        <td style='mso-number-format:"\@";'></td>
        <td></td>
        <td></td>
        <td>상품AS완료</td>
        <td><?php echo $TPL_V1["bad_memo"]?></td>
        
    </tr>
<?php }}?>
    </table>