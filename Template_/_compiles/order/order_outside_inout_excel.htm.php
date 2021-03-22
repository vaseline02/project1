<?php /* Template_ 2.2.8 2021/03/12 15:08:40 /www/html/ukk_test2/data/skin/order/order_outside_inout_excel.htm 000008578 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php if($_POST['sel_excel_type']=='in'){?>
<table border="1">	
    <tr>
        <td>거래구분</td>
        <td>과세구분</td>
        <td>환종</td>
        <td>고객코드</td>
        <td>발주일자</td>
        <td>납기일</td>
        <td>입고예정일</td>
        <td>품번</td>
        <td>발주수량</td>
        <td>비고(건)</td>
        <td>발주단가(원화)</td>
        <td>비고(내역)</td>
        <td>공급가</td>
        <td>부가세</td>
        <td>합계액</td>        
    </tr>
    <tr>
        <td>PO_FG</td>
        <td>VAT_FG</td>
        <td>EXCH_CD</td>
        <td>TR_CD</td>
        <td>PO_DT</td>
        <td>DUE_DT</td>
        <td>SHIPREQ_DT</td>
        <td>ITEM_CD</td>
        <td>PO_QT</td>
        <td>REMARK_DC</td>
        <td>PO_UM</td>
        <td>REMARKD_DC</td>
        <td>POG_AM</td>
        <td>POGV_AM</td>
        <td>POGH_AM</td>        
    </tr>
    <tr style="background-color: #eee;">
        <td>
            타입 : 문자<br>
            길이 : 1<br>
            필수 : True<br>
            설명 : 숫자만 입력하세요. (0.DOMESTIC, 1.LOCAL L/C, 2.구매승인서, 3.MASTER L/C, 4.T/T, 5.D/A, 6.D/P)
        </td>
        <td>
            타입 : 문자<br>
            길이 : 1<br>
            필수 : True<br>
            설명 : 숫자만 입력하세요. (0.과세, 1.영세, 2.면세, 3.기타)
        </td>
        <td>
            타입 : 문자<br>
            길이 : 4<br>
            필수 : True<br>
            설명 : 영문/숫자 기준 3자리(최대)를 입력 하세요.
        </td>
        <td>
            타입 : 문자<br>
            길이 : 10<br>
            필수 : False<br>
            설명 : 영문/숫자 기준 10자리(최대)를 입력 하세요.<br>
            02643 수입구매<br>
            본사경우<br>
            발주 본사거래처코드
        </td>
        <td>타입 : 문자<br>
            길이 : 8<br>
            필수 : True<br>
            설명 : 숫자 기준 8자리를 입력 하세요.(숫자만 입력)
        </td>
        <td>
            타입 : 문자<br>
            길이 : 8<br>
            필수 : True<br>
            설명 : 숫자 기준 8자리를 입력 하세요.(숫자만 입력)
        </td>
        <td>
            타입 : 문자<br>
            길이 : 8<br>
            필수 : False<br>
            설명 : 숫자 기준 8자리를 입력 하세요.(숫자만 입력)
        </td>
        <td>
            타입 : 문자<br>
            길이 : 30<br>
            필수 : True<br>
            설명 : 영문/숫자 기준 30자리(최대)를 입력 하세요.
        </td>
        <td>
            타입 : 숫자<br>
            길이 : 17,6<br>
            필수 : False<br>
            설명 : 숫자 기준 17,6자리를 입력 하세요.(숫자만 입력(소숫점자리수 정확히 입력))
        </td>
        <td>
            타입 : 문자<br>
            길이 : 60<br>
            필수 : False<br>
            설명 : 영문/숫자 기준 60자리(최대)를 입력 하세요.
        </td>
        <td>
            타입 : 숫자<br>
            길이 : 17,6<br>
            필수 : False<br>
            설명 : 숫자 기준 17,6자리를 입력 하세요.(숫자만 입력(소숫점자리수 정확히 입력))<br>
            부가세제외 단가입력=ROUND(J4/1.1,0)<br>
            소수점제외(메모장활용)
        </td>
        <td>
            타입 : 문자<br>
            길이 : 60<br>
            필수 : False<br>
            설명 : 영문/숫자 기준 60자리(최대)를 입력 하세요.
        </td>
        <td>
            타입 : 숫자<br>
            길이 : 17,4<br>
            필수 : False<br>
            설명 : 숫자 기준 17,4자리를 입력 하세요.(숫자만 입력(소숫점자리수 정확히 입력))<br>
            발주단가*수량=I4*K4
        </td>
        <td>
            타입 : 숫자<br>
            길이 : 17,4<br>
            필수 : False<br>
            설명 : 숫자 기준 17,4자리를 입력 하세요.(숫자만 입력(소숫점자리수 정확히 입력))<br>
            =ROUND(J4*I4-M4,0)
        </td>
        <td>
            타입 : 숫자<br>
            길이 : 17,4<br>
            필수 : False<br>
            설명 : 숫자 기준 17,4자리를 입력 하세요.(숫자만 입력(소숫점자리수 정확히 입력))=M4+N4
        </td>        
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>가격단위</td>
        <td>재고위치코드</td>
        <td>입고일자</td>
        <td></td>
        <td></td>
        <td>모델명</td>
        <td>수량</td>
        <td>단가(VAT포함)</td>
        <td>공급가</td>
        <td>메모</td>
        <td>총공급가</td>
        <td>부가세</td>
        <td>총단가</td>
        <td>검수1</td>
        <td>검수2</td>
        <td>모델중복</td>
        <td>거래처명</td>
		<td>브랜드명</td>
        <td>고유번호</td>
    </tr>
    
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
    <tr>
        <td></td>
        <td></td>
        <td>KRW</td>
        <td class="text_type"><?php echo $TPL_V1["d_code"]?></td>
        <td><?php echo $TPL_V1["mod_date"]?></td>
        <td><?php echo $TPL_V1["mod_date"]?></td>
        <td><?php echo $TPL_V1["mod_date"]?></td>
        <td><?php echo $TPL_V1["goodsnm"]?></td>
        <td><?php if($TPL_V1["data_type"]=='return'||($TPL_V1["data_type"]=='order'&&$TPL_V1["step"]=='61')){?>-<?php }?><?php echo $TPL_V1["order_num"]?></td>
        <td><?php echo $TPL_V1["purchase_price"]?></td>
        <td><?php echo ROUND($TPL_V1["purchase_price"]/ 1.1)?></td>
        <td><?php if($TPL_V1["stype"]=='other'){?><?php echo $TPL_V1["brandnm"]?> 사입<?php }else{?><?php echo $TPL_V1["receiver"]?><?php }?></td>
        <td><?php echo (ROUND($TPL_V1["purchase_price"]/ 1.1))*$TPL_V1["order_num"]?></td>
        <td><?php echo ROUND(($TPL_V1["purchase_price"]*$TPL_V1["order_num"])-(ROUND($TPL_V1["purchase_price"]/ 1.1)*$TPL_V1["order_num"]))?></td>
        <td><?php echo ((ROUND($TPL_V1["purchase_price"]/ 1.1))*$TPL_V1["order_num"])+(ROUND(($TPL_V1["purchase_price"]*$TPL_V1["order_num"])-(ROUND($TPL_V1["purchase_price"]/ 1.1)*$TPL_V1["order_num"])))?></td>

        <td></td>
        <td></td>
        <td></td>

        <td><?php echo $TPL_V1["d_name"]?></td>  
		<td><?php echo $TPL_V1["brandnm"]?></td>
        <td><?php if($TPL_V1["stype"]=='other'){?>o-<?php }?><?php echo $TPL_V1["no"]?></td>        
    </tr>
<?php }}?>
</table>

<?php }elseif($_POST['sel_excel_type']=='out'){?>
<table border="1">	
    <tr>
        <td>법인코드<br>(더존)</td>
        <td>쇼핑몰<br>CODE</td>
        <td>주문번호</td>
        <td>수집일</td>
        <td>주문일</td>
        <td>송장등록일</td>
        <td>-</td>
        <td>상품코드(옵션)</td>
        <td>수량</td>
        <td>판매단가</td>
        <td>매출액</td>
        <td>정산액</td>
        <td>실적코드<br>(팀구분)</td>
        <td>반품완료일</td>
        <td>쇼핑몰</td>        
        <td>브랜드</td>        
        <td>상품명/옵션명</td>        
        <td>수수료율</td>        
        <td>고유번호</td>        
    </tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
    <tr>
        <td class="text_type"><?php echo $TPL_V1["d_code"]?></td>
        <td><?php echo $TPL_V1["mall_code"]?></td>
        <td class="text_type"><?php echo $TPL_V1["ordno"]?></td>
        <td><?php echo $TPL_V1["reg_date"]?></td>
        <td><?php echo $TPL_V1["mod_date"]?></td>
        <td><?php echo $TPL_V1["mod_date"]?></td>
        <td></td>
        <td><?php echo $TPL_V1["goodsnm"]?></td>
        <td><?php if($TPL_V1["data_type"]=='order'&&$TPL_V1["step"]=='61'){?>-<?php }?><?php echo $TPL_V1["order_num"]?></td>
        <td><?php echo $TPL_V1["settle_price"]?></td>
        <td></td>
        <td></td>
        <td><?php echo $TPL_V1["sales_code"]?></td>
        <td></td>
        <td><?php echo $TPL_V1["mall_name"]?></td>

        <td></td>
        <td></td>
        <td></td>
        <td><?php if($TPL_V1["stype"]=='other'){?>o-<?php }?><?php echo $TPL_V1["no"]?></td>
    </tr>
<?php }}?>
</table>
<?php }?>