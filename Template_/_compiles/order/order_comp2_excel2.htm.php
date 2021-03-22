<?php /* Template_ 2.2.8 2021/02/08 14:46:52 /www/html/ukk_test2/data/skin/order/order_comp2_excel2.htm 000014311 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<table border="1">
<?php if($GLOBALS["s_mall"]=='스토어팜'){?>
	<tr>
		<td>주문번호</td>
		<td>운송장번호</td>
		<td>수취인명</td>
		<td>우편번호</td>
		<td>(기본주소)</td>
		<td>(수취인연락처1)</td>
		<td>(수취인연락처2)</td>
		<td>판매자상품코드</td>
		<td>상품명</td>
		<td>수량</td>
		<td>배송메세지</td>
		<td>상품별 총 주문금액</td>
		<td>구매자명</td>
		<td>상품주문번호</td>
		<td>브랜드</td>
		<td>입고예정</td>
		<td>사무실</td>
		<td>3자물류</td>
		<td>관리자메모</td>
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr style="background-color:<?php echo $TPL_V1["color"]?>">
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["position"]?></td>
		<td><?php echo $TPL_V1["receiver"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["zipcode"]?></td>
		<td><?php echo $TPL_V1["address"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["mobile"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["buyer_mobile"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
		<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["order_num"]?></td>
		<td><?php echo $TPL_V1["order_memo"]?></td>
		<td><?php echo $TPL_V1["settle_price"]?></td>
		<td><?php echo $TPL_V1["buyer"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["dupl_key"]?></td>
		<td><?php echo $TPL_V1["brandnm"]?></td>
		<td><?php echo $TPL_V1["codeno_3"]?></td>
		<td><?php echo $TPL_V1["codeno_1"]?></td>
		<td><?php echo $TPL_V1["codeno_51"]?></td>
		<td><?php echo $TPL_V1["memo"]?></td>
	</tr>
<?php }}?>
<?php }elseif($GLOBALS["s_mall"]=='오피셜'){?>
	<tr>
		<td>모델명</td>
		<td>위치</td>
		<td>쇼핑몰</td>
		<td>수량</td>
		<td>주문번호</td>
		<td>주소</td>
		<td>주문자</td>
		<td>수취인</td>
		<td>전화번호1</td>
		<td>전화번호2</td>
		<td>판매가</td>
		<td>총 결제금액</td>
		<td>수령인 우편번호</td>
		<td>배송메시지</td>
		<td>품목번호</td>
		<td>품목별 주문번호</td>
		<td>브랜드</td>
		<td>입고예정</td>
		<td>사무실</td>
		<td>3자물류</td>
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr style="background-color:<?php echo $TPL_V1["color"]?>">
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["position"]?></td>
		<td><?php echo $TPL_V1["upload_form_type"]?> <?php echo $TPL_V1["mall_name"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["order_num"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
		<td><?php echo $TPL_V1["address"]?></td>
		<td><?php echo $TPL_V1["buyer"]?></td>
		<td><?php echo $TPL_V1["receiver"]?></td>
		<td><?php echo $TPL_V1["buyer_mobile"]?></td>
		<td><?php echo $TPL_V1["mobile"]?></td>
		<td><?php echo $TPL_V1["settle_price"]?></td>
		<td><?php echo $TPL_V1["settle_price"]?></td>
		<td><?php echo $TPL_V1["zipcode"]?></td>
		<td><?php echo $TPL_V1["order_memo"]?></td>
		<td><?php echo $TPL_V1["mall_key2"]?></td>
		<td><?php echo $TPL_V1["mall_key"]?></td>
		<td><?php echo $TPL_V1["brandnm"]?></td>
		<td><?php echo $TPL_V1["codeno_3"]?></td>
		<td><?php echo $TPL_V1["codeno_1"]?></td>
		<td><?php echo $TPL_V1["codeno_51"]?></td>
		<td><?php echo $TPL_V1["memo"]?></td>
	</tr>
<?php }}?>
<?php }elseif($GLOBALS["s_mall"]=='셀피아'){?>
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
		<td>상품명</td>
		<td>옵션명</td>
		<td>주문총금액</td>
		<td>발송인</td>
		<td>주문품목</td>
		<td>송장번호</td>
		<td>관리자메모</td>
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr style="background-color:<?php echo $TPL_V1["color"]?>">
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
		<td><?php echo $TPL_V1["ent_name"]?></td>
		<td></td>
		<td><?php echo $TPL_V1["receiver"]?></td>
		<td><?php echo $TPL_V1["zipcode"]?></td>
		<td><?php echo $TPL_V1["address"]?></td>
		<td><?php echo $TPL_V1["buyer_mobile"]?></td>
		<td><?php echo $TPL_V1["mobile"]?></td>
		<td><?php echo $TPL_V1["deli_type"]?></td>
		<td><?php echo $TPL_V1["code1"]?></td>
		<td><?php echo $TPL_V1["order_num"]?></td>
		<td><?php echo $TPL_V1["order_memo"]?></td>
		<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
		<td><?php echo $TPL_V1["settle_price"]?></td>
		<td></td>
		<td><?php echo $TPL_V1["mall_key"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["position"]?></td>
		<td><?php echo $TPL_V1["memo"]?></td>
	</tr>
<?php }}?>
<?php }elseif($GLOBALS["s_mall"]=='타임메카'||$GLOBALS["s_mall"]==''){?>
	<tr>
		<th>주문번호</th>
		<th>운송장번호</th>
		<th>수령인</th>
		<th>수령인 우편번호</th>
		<th>수령인 주소(전체)</th>
		<th>수령인 전화번호</th>
		<th>수령인 휴대전화</th>
		<th>주문상품명</th>
		<th>공급사 상품명(매입상품명)</th>
		<th>상품옵션</th>
		<th>수량</th>
		<th>배송메시지</th>
		<th>총 결제금액</th>
		<th>주문자명</th>
		<th>품목번호</th>
		<th>품목별 주문번호</th>
		<th>브랜드</th>
		<th>브랜드</th>
		<th>입고예정</th>
		<th>사무실</th>
		<th>3자물류</th>
		<th>배송비</th>
		<th>사용한 적립금액</th>
		<th>네이버 포인트</th>
		<th>쿠폰 할인금액</th>
		<th>사용한 쿠폰명</th>
		<th>결제수단</th>
		<th>공급사명</th>
		<th>상품자체코드</th>
		<th>상품코드</th>
		<th>관리자메모</th>
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr style="background-color:<?php echo $TPL_V1["color"]?>">
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["position"]?></td>
		<td><?php echo $TPL_V1["receiver"]?></td>
		<td><?php echo $TPL_V1["zipcode"]?></td>
		<td><?php echo $TPL_V1["address"]?></td>
		<td><?php echo $TPL_V1["buyer_mobile"]?></td>
		<td><?php echo $TPL_V1["mobile"]?></td>
		<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goods_opt"]?></td>
		<td><?php echo $TPL_V1["order_num"]?></td>
		<td><?php echo $TPL_V1["order_memo"]?></td>
		<td><?php echo $TPL_V1["settle_price"]?></td>
		<td><?php echo $TPL_V1["buyer"]?></td>
		<td><?php echo $TPL_V1["mall_key2"]?></td>
		<td><?php echo $TPL_V1["mall_key"]?></td>
		<td><?php echo $TPL_V1["brandnm"]?></td>
		<td><?php echo $TPL_V1["brandnm"]?></td>
		<td><?php echo $TPL_V1["codeno_3"]?></td>
		<td><?php echo $TPL_V1["codeno_1"]?></td>
		<td><?php echo $TPL_V1["codeno_51"]?></td>
		<td><?php echo $TPL_V1["deli_price"]?></td>
		<td><?php echo $TPL_V1["use_reserve"]?></td>
		<td><?php echo $TPL_V1["use_naver_point"]?></td>
		<td><?php echo $TPL_V1["coupon_dc"]?></td>
		<td><?php echo $TPL_V1["coupon_name"]?></td>
		<td><?php echo $TPL_V1["pay_type"]?></td>
		<td>자체공급</td>
		<td></td>
		<td><?php echo $TPL_V1["goods_code"]?></td>
		<td><?php echo $TPL_V1["memo"]?></td>
	</tr>
<?php }}?>
<?php }elseif($GLOBALS["s_mall"]=='사방넷'){?>
	<tr>
		<th>주문번호</th>
		<th>쇼핑몰명</th>
		<th>구분</th>
		<th>받는분성명</th>
		<th>받는분우편번호</th>
		<th>받는분주소</th>
		<th>받는분전화번호</th>
		<th>받는분기타연락처</th>
		<th>기본운임</th>
		<th>품목명</th>
		<th>수량</th>
		<th>배송메시지1</th>
		<th>수집상품명</th>
		<th>주문금액</th>
		<th>쇼핑몰코드</th>
		<th>사방넷 주문번호</th>
		<th>관리자메모</th>
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr style="background-color:<?php echo $TPL_V1["color"]?>">
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["mall_name"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["position"]?></td>
		<td><?php echo $TPL_V1["receiver"]?></td>
		<td><?php echo $TPL_V1["zipcode"]?></td>
		<td><?php echo $TPL_V1["address"]?></td>
		<td><?php echo $TPL_V1["mobile"]?></td>
		<td><?php echo $TPL_V1["buyer_mobile"]?></td>
		<td></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
		<td><?php echo $TPL_V1["order_num"]?></td>
		<td><?php echo $TPL_V1["order_memo"]?></td>
		<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
		<td><?php echo $TPL_V1["settle_price"]?></td>
		<td><?php echo $TPL_V1["mall_code"]?></td>
		<td><?php echo $TPL_V1["code1"]?></td>
		<td><?php echo $TPL_V1["memo"]?></td>
	</tr>
<?php }}?>
<?php }elseif($GLOBALS["s_mall"]=='B2B'){?>
	<tr>
		<th>주문번호</th>
		<th>아이디</th>
		<th>주문일</th>
		<th>브랜드명</th>
		<th>모델명</th>
		<th>모델명2</th>
		<th>가격</th>
		<th>총가격</th>
		<th>수량</th>
		<th>상태</th>
		<th>송장번호</th>
		<th>이름</th>
		<th>연락처</th>
		<th>연락처2</th>
		<th>이메일</th>
		<th>주소</th>
		<th>상세주소</th>
		<th>메모</th>
		<th>관리자메모</th>
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr style="background-color:<?php echo $TPL_V1["color"]?>">
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["mall_name"]?></td>
		<td><?php echo $TPL_V1["reg_date"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["brandnm"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm_sub"]?></td>
		<td><?php echo $TPL_V1["order_price"]?></td>
		<td><?php echo $TPL_V1["settle_price"]?></td>
		<td><?php echo $TPL_V1["order_num"]?></td>
		<td>주문중</td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["position"]?></td>
		<td><?php echo $TPL_V1["receiver"]?></td>
		<td><?php echo $TPL_V1["buyer_mobile"]?></td>
		<td><?php echo $TPL_V1["mobile"]?></td>
		<td><?php echo $TPL_V1["email"]?></td>
		<td><?php echo $TPL_V1["address"]?></td>
		<td></td>
		<td><?php echo $TPL_V1["order_memo"]?></td>
		<td><?php echo $TPL_V1["memo"]?></td>
	</tr>
<?php }}?>
<?php }elseif($GLOBALS["s_mall"]=='롯데묘미'){?>
	<tr>
		<th>주문번호</th>
		<th>아이디</th>
		<th>주문일</th>
		<th>브랜드명</th>
		<th>모델명</th>
		<th>모델명2</th>
		<th>가격</th>
		<th>총가격</th>
		<th>수량</th>
		<th>상태</th>
		<th>송장번호</th>
		<th>이름</th>
		<th>연락처</th>
		<th>연락처2</th>
		<th>이메일</th>
		<th>주소</th>
		<th>상세주소</th>
		<th>메모</th>
		<th>관리자메모</th>
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr style="background-color:<?php echo $TPL_V1["color"]?>">
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["mall_name"]?></td>
		<td><?php echo $TPL_V1["reg_date"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["brandnm"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm_sub"]?></td>
		<td><?php echo $TPL_V1["order_price"]?></td>
		<td><?php echo $TPL_V1["settle_price"]?></td>
		<td><?php echo $TPL_V1["order_num"]?></td>
		<td></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["position"]?></td>
		<td><?php echo $TPL_V1["receiver"]?></td>
		<td><?php echo $TPL_V1["buyer_mobile"]?></td>
		<td><?php echo $TPL_V1["mobile"]?></td>
		<td><?php echo $TPL_V1["email"]?></td>
		<td><?php echo $TPL_V1["address"]?></td>
		<td></td>
		<td><?php echo $TPL_V1["order_memo"]?></td>
		<td><?php echo $TPL_V1["memo"]?></td>
	</tr>
<?php }}?>

<?php }elseif($GLOBALS["s_mall"]=='제3기획'){?>
	<tr>
		<th>주문번호</th>
		<th>판매처</th>
		<th>출고</th>
		<th>이름</th>
		<th>우편번호</th>
		<th>주소</th>
		<th>핸드폰번호</th>
		<th>핸드폰번호2</th>
		<th></th>
		<th>모델명</th>
		<th>수량</th>
		<th>가격</th>
		<th>배송메시지</th>
		<th>송장번호</th>
		<th>택배사</th>
		<th>관리자메모</th>
	</tr>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr style="background-color:<?php echo $TPL_V1["color"]?>">
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["mall_name"]?></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["position"]?></td>
		<td><?php echo $TPL_V1["receiver"]?></td>
		<td><?php echo $TPL_V1["zipcode"]?></td>
		<td><?php echo $TPL_V1["address"]?></td>
		<td><?php echo $TPL_V1["buyer_mobile"]?></td>
		<td><?php echo $TPL_V1["mobile"]?></td>
		<td></td>
		<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
		<td><?php echo $TPL_V1["order_num"]?></td>
		<td><?php echo $TPL_V1["settle_price"]?></td>
		<td><?php echo $TPL_V1["order_memo"]?></td>
		<td><?php echo $TPL_V1["position"]?></td>
		<td><?php echo $GLOBALS["delivery_info"][$TPL_V1["courier_code"]]?></td>
		<td><?php echo $TPL_V1["memo"]?></td>
	</tr>
<?php }}?>

<?php }?>
</table>