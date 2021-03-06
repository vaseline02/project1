<?php /* Template_ 2.2.8 2020/07/29 17:06:20 /www/html/ukk_test2/data/skin/cs/as_document.htm 000011637 */ ?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>타임메카AS</title>

<style>
    body {font-size:11px;}
    .board_table {border:1px solid #ddd; width:100%; border-collapse: collapse;}
    .board_table th{background-color: #f3f3f3;text-align: center;font-size: 12px; border: 1px solid #ddd; padding: 4px;}
    .board_table tr td{border: 1px solid #ddd;padding: 4px;}
    .center {text-align: center;}
    .right {text-align: right;}
    .width100 {width:100px}
    .width200 {width:200px}
    .padding_top10 {padding-top:10px}

/* 
    body {margin: 0; padding: 0;}
    * {box-sizing: border-box;-moz-box-sizing: border-box;}
    .page {width: 21cm;min-height: 29.7cm;padding: 2cm;margin: 0 auto;background:#eee;}
    .print_div {border: 2px red solid;background:#fff;height: 257mm;}
    @page {size: A4;margin: 0;}
    */
    @media print {
        html, body {width: 210mm;height: 297mm;}
        .page {margin: 0;border: initial;width: initial;min-height: initial;box-shadow: initial;background: initial;page-break-after: always;}
    } 



</style>
<script>
    function content_print(){
     
     var initBody = document.body.innerHTML;
     window.onbeforeprint = function(){
         document.body.innerHTML = document.getElementById('print_div').innerHTML;
     }
     window.onafterprint = function(){
         document.body.innerHTML = initBody;
     }
     window.print();    
 }           

</script>
</head>
<button onclick="content_print()">프린트</button>
<body>
    <div class="page">
    <div id="print_div">
        <h1 style="text-align: center;">타임메카AS</h1>
        <div>
            <table class="board_table">
                <tr>
                    <th class="width100">성함</ㅅ>
                    <td><?php echo $TPL_VAR["asData"][ 0]['receiver']?></td>
                </tr>
                <tr>
                    <th>주소</th>
                    <td><?php echo $TPL_VAR["asData"][ 0]['zipcode']?> <?php echo $TPL_VAR["asData"][ 0]['address']?></td>
                </tr>
            </table>
        </div>
        <div class="padding_top10">
            <table class="board_table center">
                <tr>
                    <th>구매처</th>
                    <th>주문번호</th>
                    <th>구매일</th>
                    <th>접수일</th>
                    <th>출고일</th>
                </tr>
                <tr>
                    <td><?php echo $TPL_VAR["asData"][ 0]['order_buy']?></td>
                    <td><?php echo $TPL_VAR["asData"][ 0]['order_no']?></td>
                    <td><?php echo $TPL_VAR["asData"][ 0]['order_reg']?></td>
                    <td><?php echo $TPL_VAR["asData"][ 0]['in_regdate']?></td>
                    <td><?php echo $TPL_VAR["asData"][ 0]['out_regdate']?></td>
                </tr>
            </table>
        </div>
        <p class="padding_top10">고객님께서 의뢰하신 제품의 정보는 다음과 같습니다.</p>
        <div>
            <table class="board_table">
                <tr>
                    <th class="width100">브랜드</th>
                    <td><?php echo $TPL_VAR["asData"][ 0]['brandnm']?></td>
                </tr>
                <tr>
                    <th>모델정보</th>
                    <td><?php echo $TPL_VAR["asData"][ 0]['goodsnm']?></td>
                    
                </tr>
            </table>
        </div>
        <p class="padding_top10"><?php echo $GLOBALS["cfg_as_cate"][$TPL_VAR["asData"][ 0]['as_cate']]?>상태 : </p>
        <p class="padding_top10">
            <div><?php echo nl2br($TPL_VAR["asData"][ 0]['product_point'])?></div>
            <!-- <div><?php echo nl2br($TPL_VAR["asData"][ 0]['repair']['99']['as_memo'])?></div> -->
        </p>
        <div class="padding_top10">
            <table class="board_table center">
                <tr>
                    <th>서비스항목</th>
                    <th>수량</th>
                    <th>단가</th>
                    <th>합계</th>
                </tr>
<?php if(is_array($TPL_R1=$TPL_VAR["asData"][ 0]['repair'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <tr>
                    <td>
<?php if($TPL_V1["as_code"]=='98'||$TPL_V1["as_code"]=='99'){?>
                            <?php echo $TPL_V1["as_memo"]?>

<?php }else{?>
                            <?php echo $GLOBALS["cfg_as_contents"][$TPL_VAR["asData"][ 0]['as_cate']][$TPL_V1["as_code"]]?>

<?php }?>
                    </td>
                    <td><?php echo $TPL_V1["as_quantity"]?></td>
                    <td><?php echo number_format($TPL_V1["as_price"])?>원</td>
                    <td><?php echo number_format($TPL_V1["sum_price"])?>원</td>
                </tr>
<?php }}?>
            </table>
        </div>
        <div class="padding_top10">
            <table class="board_table">
                <tr>
                    <th class="width200">서비스 비용(Vat포함)</th>
                    <td class="right"><?php echo number_format($TPL_VAR["asData"][ 0]['vat_price'])?>원</td>
                </tr>
            </table>
        </div>
        <div style="font-size: 9px;">
        <p class="padding_top10">서비스 보증을 위하여 본 청구서를 보관하여 주시기 바랍니다.</p>
        <p class="padding_top10">서비스 보증기간안내</p>
        <p>당사에서 진행한 서비스는, 본 서류의 발행일로부터 12개월 동안의 수리 서비스 보증 기간을 제공합니다.</p>
        <p>해당 보증 서비스를 받기 위해서는 반드시 본 서류를 제시하셔야 합니다. 보증기간 내 발생한 결함은 당 사 서비스센터에서 확인 절차가 진행되며 별도의 통보없이 이를 복구하는 서비스가 진행될수 있습니다.</p>
        <p>단, 배터리와 같은 소모성 부품 교체 또는 일반적인 사용에 의한 마모 및 부품의 노후, 사용상의 부주의 및 비 공식 서비스업체 이용으로 인하여 발생된 사항에 대해서는 해당 보증에서 제외됨을 알려드립니다.</p>
        </div>
        
<?php if($TPL_VAR["asData"][ 0]['as_cate']=='1'){?>
            <h1 class="padding_top10" style="font-size: 15px;">손목시계 사용상 주의 사항</h1>
            <div style="font-size: 8px;">
            <p><작동에 관한 주의사항></p>
            <p>1. 기계식(태엽) 손목시계는 활동량이 적을 경우 2~3일에 한 번씩 크라운(용두)를 스무 바퀴 감아서 착용해주세요.</p>
            <p>2. 기계식(태엽) 손목시계는 오차가 발생하므로 일주일에 한번 시간을 세팅한 후 착용하길 추천합니다.</p>
            <p>3. 기계식(태엽) 손목시계의 일 오차 범위는 약 10-20초 사이입니다. (일 오차는 착용 방법에 따라 다를 수 있음)</p>
            <p>4. 기계식(태엽) 손목시계는 정밀한 부품으로 구성되어있어 작은 충격에도 작동이 정지될 수 있습니다.</p>
            <p>5. 요일 및 날짜 기능이 있는 손목시계의 경우 저녁10:00-새벽4:00 사이에는 요일 및 날짜 조정시 파손될수 있습니다.</p>
            <p>6. 쿼츠(배터리) 손목시계는 사용 중 외부환경(습도, 극단적인 고온 및 저온, 강한 자기장 노출 등)에 따라 오차가 발생할 수 있습니다.</p>
            <p class="padding_top10"><방수에 관한 주의사항></p>
            <p>1. 샤워 시 착용을 금지해주세요.</p>
            <p>2. 물속에서 사용 시 크라운(용두)이 돌아가지 않게 사용해주세요.</p>
            <p>3. 물속에서 사용 시 동작 버튼(크로노 및 기능 버튼)이 눌리지 않게 사용해주세요.</p>
            <p>4. 100m 방수 이하의 손목시계를 착용하고 물에 들어가지 말아 주세요.</p>
            <p>5. 온도 변화(냉/온)가 심한 장소(사우나 등)에서는 착용을 금지해주세요.</p>
            <p>6. 손목시계의 글라스 파손 시 물에 닿지 않도록 해주세요.</p>
            <p>7. 방수 기능이 좋은 시계라도 외부의 충격 또는 구매 시기에 따라 방수 기능이 저하될 수 있습니다.</p>
            <p class="padding_top10">주의!! 반드시, 외부 충격 및 수리 후(떨어뜨림, 부딪힘, 배터리 교체 등) 진행했다면 방수 테스트가 필요합니다.</p>
            </div>
<?php }elseif($TPL_VAR["asData"][ 0]['as_cate']=='2'){?>
            <h1 class="padding_top10" style="font-size: 15px;">귀금속 사용상 주의 사항</h1>
            <div style="font-size: 8px;">
            <p><사용 시 주의사항></p>
            <p>01. 실버 제품은 내구성이 약하기 때문에 강한 힘이 발생할 경우 끊어지거나 파손의 위험이 있습니다.</p>
            <p>02. 사용자의 체질에 따라 알레르기 반응이 일어날 수 있으며 발생 시 즉시 착용을 삼가 주시기 바랍니다.</p>
            <p>03. 쥬얼리에 화장품, 향수, 약품, 스프레이 등 화학적 소재로 인해 화학반응을 일으켜 변색될 수 있습니다.</p>
            <p>04. 땀 및 습기로 인해 접촉면에 먼지 및 이물질이 쌓이면 제품이 검게 보일 수 있습니다.</p>
            <p>05. 착용 후 반드시 부드러운 천으로 닦아주시고 케이스나 보관함에 보관하여 습기 및 직사광선에 노출되지 않도록 주의해 주십시오.</p>
            <p>06. 큐빅 및 보석은 사용감에 따라 고정부위에 이물질이 껴서 변색될 수 있습니다.</p>
            <p>07. 로즈 골드 및 골드의 경우 변색 시 AS 진행이 불가하므로 참고 부탁드립니다.</p>
            <p>08. 실버 제품의 변색은 세척으로 제거 가능하며 스크래치 제거는 불가능하여 별도의 폴리싱 작업으로만 제거 가능합니다.</p>
            <p>09. 의상 탈의 시 제품에 걸려 파손되는 경우가 많으니 주의하시기 바랍니다.</p>
            <p>10. 샤워, 찜질방, 운동 시 변색 및 파손의 위험이 있습니다.</p>
            <p>11. 진주는 파손 및 스크래치 발생 시 진주 특성상 교체 및 수리가 어렵습니다.</p>
            <p>12. 여러 종류의 보석을 함께 보관할 경우 서로 부딪혀 손상될 수도 있어 반드시 개별 보관해 주시기 바랍니다.</p>
            <p>13. 골드 및 실버 특성상 잠금 장식이나 스톤 등의 세팅이 쉽게 헐거워질 수 있습니다. 수시로 점검 후 수리를 맡겨주셔야 합니다.</p>
            <p>14. 소재에 따라 습기, 마찰 등에 의해 변색되거나 도금이 벗겨질 수 있으니 주의해 주시기 바랍니다.</p>
            <p>15. 바닷물이 함유된 염분이 닿지 않도록 주의하십시오. 만약 닿았다면 빠르게 세척하시기 바랍니다.</p>
            <p>16. 강한 부딪침이나 떨어드릴 경우 제품의 손상이 있을 수 있으니 주의 바랍니다.</p>
            </div>
<?php }?>
    </div>
    </div>
</body>
</html>