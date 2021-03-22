<?php /* Template_ 2.2.8 2020/07/28 13:50:12 /www/html/ukk_test/data/skin/cs/send_close_excel.htm 000001559 */ 
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
    </tr>
    
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
    <tr>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
        <td><?php echo $TPL_V1["place_name"]?></td>
        <td><?php echo $TPL_V1["inout"]?></td>
        <td><?php echo $TPL_V1["ent_name"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["order_num"]?></td>
        <td></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["order_no"]?></td>
        <td></td>
        <td><?php echo $TPL_V1["buyer"]?></td>
        <td><?php echo $TPL_V1["receiver"]?></td>
        <td><?php echo $TPL_V1["mobile"]?></td>
        <td><?php echo $TPL_V1["order_price"]?></td>
        <td></td>
        <td><?php echo $TPL_V1["ent_name"]?></td>
        <td></td>
        <td></td>
    </tr>
<?php }}?>
    </table>