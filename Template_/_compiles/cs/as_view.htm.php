<?php /* Template_ 2.2.8 2020/10/12 15:37:53 /www/html/ukk_test/data/skin/cs/as_view.htm 000008163 */ 
$TPL_asData_1=empty($TPL_VAR["asData"])||!is_array($TPL_VAR["asData"])?0:count($TPL_VAR["asData"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<form method="post" id="asForm" name="asForm">
<input type="hidden" name="mode" value="ins">
<input type="hidden" name="return_url" value="<?php echo $_SERVER['QUERY_STRING']?>">      
    

<?php if($TPL_VAR["asData"][ 0]['order_list_no']){?>

<hr>

<table id="" style="width:100%" class="listTable">
	<thead>
		<tr>			
			<th width='100'>상품명</th>
			<th width='100'>모델명</th>
			<th width='100'>이미지</th>
			<th width='100'>송장번호</th>
			<th width='100'>주문상태</th>			
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_asData_1){foreach($TPL_VAR["asData"] as $TPL_V1){?>
		<tr>			
			<td><?php echo $TPL_V1["order_mall_goodsnm"]?></td>
			<td><?php echo $TPL_V1["g_goodsnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php if($TPL_V1["order_invoice"]!= 0){?><?php echo $TPL_VAR["delivery_list"][$TPL_V1["order_courier_code"]]['name']?><div>(<?php echo $TPL_V1["order_invoice"]?>)</div><?php }?></td>			
			<td><?php echo $GLOBALS["cfg_order_step"][$TPL_V1["step"]]?><?php if($TPL_V1["step2"]){?><div style="color: red;">(<?php echo $GLOBALS["cfg_order_step2"][$TPL_V1["step2"]]?>)</div><?php }?></td>			
		</tr>
<?php }}?>
	</tbody>
</table>
<?php }?>

<hr>
<h1 class="page_title">접수내용</h1>
<hr>       
    <table id="" style="width:100%" class="listTable">
        <tr>
            <th>카테고리</th>
            <td >
                <?php echo $GLOBALS["cfg_as_cate"][$TPL_VAR["asData"][ 0]['as_cate']]?>

<?php if($TPL_VAR["asData"][ 0]['as_sub_cate']){?>
                    (<?php echo $GLOBALS["cfg_as_sub_cate"][$TPL_VAR["asData"][ 0]['as_cate']][$TPL_VAR["asData"][ 0]['as_sub_cate']]?>)
<?php }?>
                   
            </td>
            <th>
                진행단계
            </th>
            <td>
                <?php echo $TPL_VAR["asData"][ 0]['as_status']?>

                <!-- <?php echo $GLOBALS["cfg_as_status"][$TPL_VAR["asData"][ 0]['as_status']]?> -->
            </td>
            <th>
                재수리유무
            </th>
            <td>
                <?php echo $TPL_VAR["asData"][ 0]['re_receipt']?>

            </td>
        </tr>
        
        <tr>
            <th>접수자성함</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['receipt_name']?></td>
            <th>연락처</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['mobile']?></td>
            <th>구매자성함</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['receiver']?></td>
        </tr>
        <tr>
            <th>주소</th>
            <td colspan="6">
                <div>[<?php echo $TPL_VAR["asData"][ 0]['zipcode']?>]</div>
                <div style="padding-top: 5px;"><?php echo $TPL_VAR["asData"][ 0]['address']?></div>
            </td>
        </tr>
        <tr>
            <th>구매처</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['order_buy']?></td>
            <th>주문번호</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['order_no']?></td>
            <th>구매일</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['order_reg']?></td>
        </tr>
        <tr>
            <th>케이스유무</th>
            <td>
<?php if($TPL_VAR["asData"][ 0]['case_yn']=='y'){?>있음<?php }else{?>없음<?php }?>
            </td>
            <th>택배정보</th>
            <td>
                <?php echo $TPL_VAR["delivery_list"][$TPL_VAR["asData"][ 0]['delivery_code']]['name']?>

                <div style="padding-top:5px"><?php echo $TPL_VAR["asData"][ 0]['invoice']?></div>
            </td>
            <th>동작유무</th>
            <td>
<?php if($TPL_VAR["asData"][ 0]['action_yn']=='y'){?>동작함<?php }else{?>동작안함<?php }?>
            </td>
        </tr>
        <tr>
            <th>택배비</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['delivery_price']?></td>
            <th>반송택배비</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['return_delivery_price']?></td>
            <th></th>
            <td></td>
        </tr>
        <tr>
            <th>브랜드명</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['brandnm']?></td>
            <th>모델명</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['goodsnm']?></td>
            <th>시리얼번호</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['serial_number']?></td>
        </tr>
        <tr>
            <th>제품특징(디테일)</th>
            <td colspan="6"><?php echo $TPL_VAR["asData"][ 0]['product_point']?></td>
        </tr>
    
    </table>

    <hr>
    <h1 class="page_title">수리내용</h1>
    <hr>
    <table id="" style="width:100%" class="listTable">
        <tr>
            <th>수리내용</th>
            <td class="as_contents" colspan=3>
<?php if(is_array($TPL_R1=$TPL_VAR["asData"][ 0]['ex_as'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1){?>[<?php echo $GLOBALS["cfg_as_contents"][$TPL_VAR["asData"][ 0]['as_cate']][$TPL_V1]?>]<?php }?>
<?php }}?>
            </td>
        </tr>
        
        <tr>
            <td colspan="8">
                <!-- <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-sm btn-warning" onclick="textPick('강성')">강성</button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="textPick('반품접수')">반품접수</button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="textPick('하자')">하자</button>
                </div> -->
                <div>
                    <?php echo nl2br($TPL_VAR["asData"][ 0]['memo'])?>

                </div>
            </td>
        </tr>
        
        <tr>
            <th>고객비용</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['customer_cost']?></td>
            <th>실비용</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['real_cost']?></td>
        </tr>
        <tr>
            <th>진행업체명</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['progress_company']?></td>
            <th>출고택배정보</th>
            <td>            
                <div><?php echo $TPL_VAR["delivery_list"][$TPL_VAR["asData"][ 0]['send_delivery_code']]['name']?></div>
                <div style="padding-top:5px"><?php echo $TPL_VAR["asData"][ 0]['send_invoice']?></div>
            </td>
        </tr>
        <tr>
            <th>입고일</th>
            <td><?php if($TPL_VAR["asData"][ 0]['in_regdate']){?><?php echo $TPL_VAR["asData"][ 0]['in_regdate']?><?php }else{?><?php echo $GLOBALS["now_date"]?><?php }?></td>
            <th>출고일</th>
            <td><?php echo $TPL_VAR["asData"][ 0]['out_regdate']?></td>        
        </tr>

    </table>
    <hr>
    <div class="bottom_btn_box" style="margin-top: 0px;">
        <div class="box_left">
            <div class="btn btn-sm btn-warning" onclick="popup('send_sms.php?etc_code=as&etc_no=<?php echo $GLOBALS["as_no"]?>','','1100','900')">문자발송</div>
<?php if($TPL_VAR["asData"][ 0]['as_status']=='5'){?>
            <button type="button" class="btn btn-sm btn-warning" onclick="popup('as_document.php?as_no=<?php echo $GLOBALS["as_no"]?>','','1100','900')">문서출력</button>
<?php }?>
        </div>
        <div class="box_right">
            <div class="btn btn-sm btn-primary checkForm">발송</div>
        </div>
    </div>
</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".checkForm").click(function(){
    if(confirm("발송처리 하시겠습니까?")){
        $("#asForm").submit();
    }
});
</script>

<?php $this->print_("footer",$TPL_SCP,1);?>