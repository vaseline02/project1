<?php /* Template_ 2.2.8 2020/09/15 10:02:57 /www/html/ukk_test/data/skin/cs/send_reception_excel.htm 000002457 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<table border="1">
    <tr>
        <td>출고일자</td>
        <td>주문번호</td>
        <td>판매업체</td>
        <td>출고송장번호</td>
        <td>상품명</td>
        <td>수량</td>
        <td>판매금액</td>
        <td>수화주</td>
        <td>집전화</td>
        <td>핸드폰</td>
        <td>우편번호</td>
        <td>주소</td>
        <td>회수송장번호</td>
        <td>고객메모<br>(단순반품/ 단순교환/불량반품/불량교환)</td>
        <td>CS메모</td>
        <td>배송비여부</td>
        <td>접수날짜</td>
        <td>마감자</td>
        <td>사방넷주문번호</td>
        <td>123</td>
    </tr>
    
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
    <tr>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["reg_date"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
        <td><?php echo $TPL_V1["mall_name"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["invoice"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
        <td><?php echo $TPL_V1["order_num"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["settle_price"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["cs_receiver"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["buyer_mobile"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["mobile"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["zipcode"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["address"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["return_invoice"]?></td>
        <td><?php echo $TPL_V1["return_type_nm"]?></td>
        <td><?php echo $TPL_V1["cs_memo"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["delivery_info"]?></td>
        <td><?php echo reset(explode(' ',$TPL_V1["cs_reg_date"]))?></td>
        <td>재고잡음(<?php echo $TPL_V1["admin_name"]?>)</td>
        <td><?php echo $TPL_V1["code1"]?></td>
        <td></td>
    </tr>
<?php }}?>
    </table>