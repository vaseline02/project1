<?php /* Template_ 2.2.8 2020/10/08 15:11:47 /www/html/ukk_test2/data/skin/order/order_outside_excel.htm 000003042 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<div style="color:red">※빨간색으로 표시된 값만 업로드 가능</div>
<table border="1">
	
    <tr>
        <td></td>
        <td>담당자</td>
        <td>주문일</td>
        <td style="color:red">발주일</td>
        <td style="color:red">브랜드</td>
        <td>주문상품명</td>
        <td>수량</td>
        <td style="color:red">소비자가</td>
        <td style="color:red">매입단가</td>
        <td style="color:red">업체배송비</td>
        <td>매입가*수량</td>
        <td>합계금</td>
		<td style="color:red">비고(추가)</td>
        <td>품절확인</td>
        <td>판매가</td>
        <td>쇼핑몰명</td>
        <td>주문번호</td>
        <td>품목코드</td>
        <td>수령자명</td>
        <td>우편번호</td>
        <td>수령자주소</td>
        <td>수령자전화번호</td>
        <td>수령자휴대폰</td>
        <td>주문요청사항</td>
        <td style="color:red">택배사</td>
        <td style="color:red">운송장번호</td>
        <td>업체명</td>
        <td style="color:red">업체코드</td>
    </tr>
    
<?php if($TPL_loop_1){$TPL_I1=-1;foreach($TPL_VAR["loop"] as $TPL_V1){$TPL_I1++;?>
    <tr>
        <td><?php echo ($TPL_I1+ 1)?></td>
        <td><?php echo $TPL_V1["c_mem_name"]?></td>
        <td><?php echo $TPL_V1["reg_date"]?></td>
        <td><?php echo $TPL_V1["mod_date"]?></td>
        <td><?php echo $TPL_V1["brandnm"]?></td>
        <td><?php echo $TPL_V1["goodsnm"]?></td>
        <td><?php echo $TPL_V1["order_num"]?></td>
        <td><?php echo $TPL_V1["consumer_price"]?></td>
        <td><?php echo $TPL_V1["purchase_price"]?></td>
        <td><?php echo $TPL_V1["ent_deli_price"]?></td>
        <td><?php echo $TPL_V1["purchase_price"]*$TPL_V1["order_num"]?></td>
        <td><?php echo ($TPL_V1["purchase_price"]*$TPL_V1["order_num"])+$TPL_V1["ent_deli_price"]?></td>
		<td></td>
        <td></td>
        <td><?php echo $TPL_V1["settle_price"]?></td>
        <td><?php echo $TPL_V1["mall_name"]?></td>
        <td class="text_type"><?php echo $TPL_V1["ordno"]?></td>
        <td><?php echo $TPL_V1["mall_key"]?></td>
        <td><?php echo $TPL_V1["receiver"]?></td>
        <td class="text_type"><?php echo $TPL_V1["zipcode"]?></td>
        <td><?php echo $TPL_V1["address"]?></td>
        <td><?php echo $TPL_V1["buyer_mobile"]?></td>
        <td><?php echo $TPL_V1["mobile"]?></td>
        <td><?php echo $TPL_V1["order_memo"]?></td>
        <td><?php echo $GLOBALS["delivery_list"][$TPL_V1["courier_code"]]['name']?></td>
        <td><?php echo $TPL_V1["invoice"]?></td>
        <td><?php echo $TPL_V1["d_name"]?></td>
        <td class="text_type"><?php echo $TPL_V1["d_code"]?></td>
    </tr>
<?php }}?>
    </table>