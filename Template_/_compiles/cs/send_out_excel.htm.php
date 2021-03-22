<?php /* Template_ 2.2.8 2020/08/21 09:49:24 /www/html/ukk_test2/data/skin/cs/send_out_excel.htm 000001813 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<table border="1">
    <tr>
        <td>주문번호</td>
        <td>쇼핑몰명</td>
        <td>구분</td>
        <td>받는분성명</td>
        <td>받는분우편번호</td>
        <td>받는분주소(전체,분할)</td>
        <td>받는분전화번호</td>
        <td>받는분기타연락처</td>
        <td>기본운임</td>
        <td>품목명</td>
        <td>수량</td>
        <td>배송메세지1</td>
        <td>수집상품명</td>
        <td>주문금액</td>
        <td>쇼핑몰코드</td>
        <td>123</td>
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
        <td><?php echo $TPL_V1["deli_type"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
        <td style='mso-number-format:"\@";'><?php echo $TPL_V1["order_num"]?></td>
        <td><?php echo $TPL_V1["order_memo"]?></td>
        <td></td>
        <td><?php echo $TPL_V1["tot_price"]?></td>
        <td><?php echo $TPL_V1["mall_code"]?></td>
        <td></td>
    </tr>
<?php }}?>
    </table>