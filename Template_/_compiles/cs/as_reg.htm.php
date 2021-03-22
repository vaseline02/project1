<?php /* Template_ 2.2.8 2021/03/18 11:34:58 /www/html/ukk_test2/data/skin/cs/as_reg.htm 000022597 */ 
$TPL_asData_1=empty($TPL_VAR["asData"])||!is_array($TPL_VAR["asData"])?0:count($TPL_VAR["asData"]);
$TPL__cfg_as_cate_1=empty($GLOBALS["cfg_as_cate"])||!is_array($GLOBALS["cfg_as_cate"])?0:count($GLOBALS["cfg_as_cate"]);
$TPL__cfg_as_status_1=empty($GLOBALS["cfg_as_status"])||!is_array($GLOBALS["cfg_as_status"])?0:count($GLOBALS["cfg_as_status"]);
$TPL_delivery_list_1=empty($TPL_VAR["delivery_list"])||!is_array($TPL_VAR["delivery_list"])?0:count($TPL_VAR["delivery_list"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<form method="post" id="asForm" name="asForm">
<?php if($GLOBALS["as_no"]){?>    
<input type="hidden" name="mode" value="mod">
<?php }else{?>
<input type="hidden" name="mode" value="ins">
<?php }?>
<input type="hidden" name="return_url" value="<?php echo $_SERVER['QUERY_STRING']?>">      
<input type="hidden" name="befor_as_status" value="<?php echo $TPL_VAR["asData"][ 0]['as_status']?>">      
<input type="hidden" name="detail_no" value="<?php echo $TPL_VAR["asData"][ 0]['detail_no']?>">      
<input type="hidden" name="order_list_no" value="<?php echo $TPL_VAR["asData"][ 0]['order_list_no']?>">
    

<?php if($GLOBALS["order_list_no"]||($GLOBALS["as_no"]&&$TPL_VAR["asData"][ 0]['order_list_no'])){?>
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
        <input type="hidden" name="goods_no[<?php echo $TPL_V1["goods_no"]?>]" value="<?php echo $TPL_V1["goods_no"]?>">
        <input type="hidden" name="mall_no[<?php echo $TPL_V1["goods_no"]?>]" value="<?php echo $TPL_V1["mall_no"]?>">
        <input type="hidden" name="mall_name[<?php echo $TPL_V1["goods_no"]?>]" value="<?php echo $TPL_V1["mall_name"]?>">
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
                <select name="as_cate" class="as_cate">
                    <option value="">= 카테고리 =</option>
<?php if($TPL__cfg_as_cate_1){foreach($GLOBALS["cfg_as_cate"] as $TPL_K1=>$TPL_V1){?>
                    <option value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["asData"][ 0]['as_cate']){?><?php if($TPL_K1==$TPL_VAR["asData"][ 0]['as_cate']){?>selected<?php }?><?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                </select>
                <span class="cateSelect">
<?php if($TPL_VAR["asData"][ 0]['as_sub_cate']){?>
                    <select name="as_sub_cate" class="as_sub_cate">
<?php if(is_array($TPL_R1=$GLOBALS["cfg_as_sub_cate"][$TPL_VAR["asData"][ 0]['as_cate']])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
                        <option value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["asData"][ 0]['as_sub_cate']){?><?php if($TPL_K1==$TPL_VAR["asData"][ 0]['as_sub_cate']){?>selected<?php }?><?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                    </select>
<?php }?>
                </span>
            </td>
            <th>
                진행단계
            </th>
            <td>
                <select name="as_status" class="as_status">
<?php if($TPL__cfg_as_status_1){foreach($GLOBALS["cfg_as_status"] as $TPL_K1=>$TPL_V1){?>
                    <option value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["asData"][ 0]['as_status']){?><?php if($TPL_K1==$TPL_VAR["asData"][ 0]['as_status']){?>selected<?php }?><?php }?>><?php echo $TPL_K1?>.<?php echo $TPL_V1?></option>
<?php }}?>
                </select>
            </td>
            <th>
                재수리유무
            </th>
            <td>
                <label style="font-weight: normal;"><input type="checkbox" name="re_receipt" value="y" <?php echo $GLOBALS["checked"]['re_receipt']['y']?>> 재수리</label>
            </td>
        </tr>
        
        <tr>
            <th>접수자성함</th>
            <td><input type="text" name="receipt_name" value="<?php echo $TPL_VAR["asData"][ 0]['receipt_name']?>"></td>
            <th>연락처</th>
            <td><input type="text" name="mobile" value="<?php echo $TPL_VAR["asData"][ 0]['mobile']?>"></td>
            <th>구매자성함</th>
            <td><input type="text" name="receiver" value="<?php echo $TPL_VAR["asData"][ 0]['receiver']?>"></td>
        </tr>
        <tr>
            <th>주소</th>
            <td colspan="6">
                <div>
					<input type="text" value="<?php echo $TPL_VAR["asData"][ 0]['zipcode']?>" style="width:80px" name="zipcode" class="zipcode"> <button type="button" class="btn btn-sm btn-primary searchAddress">우편번호찾기</button>
					<label style="font-weight: normal;"><input type="checkbox" name="address_check" value="1" <?php echo $GLOBALS["checked"]['address_check']['1']?>> 주소확인필요</label>
				</div>
                <div style="padding-top: 5px;"><input type="text" value="<?php echo $TPL_VAR["asData"][ 0]['address']?>" style="width:100%" name="address" class="address"></div>
            </td>
        </tr>
        <tr>
            <th>구매처</th>
            <td>
<?php if($TPL_VAR["asData"][ 0]['order_list_no']){?>
				<input type="hidden" name="order_buy" value="<?php echo $TPL_VAR["asData"][ 0]['order_buy']?>">
				<?php echo $TPL_VAR["asData"][ 0]['order_buy']?>

<?php }else{?>
                <input type="text" name="order_buy" value="<?php echo $TPL_VAR["asData"][ 0]['order_buy']?>">
<?php }?>
            </td>
            <th>주문번호</th>
            <td>
                <input type="hidden" name="order_no" value="<?php echo $TPL_VAR["asData"][ 0]['order_no']?>">
                <?php echo $TPL_VAR["asData"][ 0]['order_no']?>

<?php if(!$TPL_VAR["asData"][ 0]['order_no']){?>
                <button type="button" class="btn btn-sm btn-warning" onclick="popup('as_order_search.php','as_order_search','1100','900')">주문번호등록</button>
				<div id="order_no_div"></div>
<?php }?>
            </td>
            <th>구매일</th>
            <td><input type="text" name="order_reg" class="datepicker_common" value="<?php echo $TPL_VAR["asData"][ 0]['order_reg']?>"></td>
        </tr>
        <tr>
            <th>케이스유무</th>
            <td>
                <label style="font-weight: normal;"><input type="radio" name="case_yn" value="y"  <?php echo $GLOBALS["checked"]['case_yn']['y']?>>있음</label>
                <label style="font-weight: normal;"><input type="radio" name="case_yn" value="n"  <?php echo $GLOBALS["checked"]['case_yn']['n']?>>없음</label>
            </td>
            <th>택배정보</th>
            <td>
                <div>
                    <select name="delivery_code">
<?php if($TPL_delivery_list_1){foreach($TPL_VAR["delivery_list"] as $TPL_V1){?> 
                        <option value=<?php echo $TPL_V1["code"]?> <?php if($TPL_VAR["asData"][ 0]['delivery_code']){?> <?php if($TPL_V1["code"]==$TPL_VAR["asData"][ 0]['delivery_code']){?>selected<?php }?><?php }else{?><?php if($TPL_V1["code"]=='CJGLS'){?>selected<?php }?><?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
                    </select>
                </div>
                <div style="padding-top:5px"><input type="text" name="invoice" value="<?php echo $TPL_VAR["asData"][ 0]['invoice']?>"></div>
            </td>
            <th>동작유무</th>
            <td>
                <label style="font-weight: normal;"><input type="radio" name="action_yn" value="y"  <?php echo $GLOBALS["checked"]['action_yn']['y']?>>동작함</label>
                <label style="font-weight: normal;"><input type="radio" name="action_yn" value="n"  <?php echo $GLOBALS["checked"]['action_yn']['n']?>>동작안함</label>
            </td>
        </tr>
        <tr>
            <th>택배비</th>
            <td><input type="text" name="delivery_price" value="<?php if($TPL_VAR["asData"][ 0]['delivery_price']){?><?php echo $TPL_VAR["asData"][ 0]['delivery_price']?><?php }else{?>0<?php }?>"></td>
            <th>반송택배비</th>
            <td><input type="text" name="return_delivery_price" value="<?php if($TPL_VAR["asData"][ 0]['return_delivery_price']){?><?php echo $TPL_VAR["asData"][ 0]['return_delivery_price']?><?php }else{?>0<?php }?>"></td>        
            <th>과거주문번호</th>    
            <td><input type="text" name="past_order_no" value="<?php echo $TPL_VAR["asData"][ 0]['past_order_no']?>"></td>
        </tr>
        <tr>
            <th>브랜드명</th>
            <td>
<?php if($TPL_VAR["asData"][ 0]['order_list_no']){?>
				<input type="hidden" name="brandnm" value="<?php echo $TPL_VAR["asData"][ 0]['brandnm']?>">
				<?php echo $TPL_VAR["asData"][ 0]['brandnm']?>

<?php }else{?>
                <input type="text" name="brandnm" value="<?php echo $TPL_VAR["asData"][ 0]['brandnm']?>">
<?php }?>
            </td>
            <th>모델명</th>
            <td>
<?php if($TPL_VAR["asData"][ 0]['order_list_no']){?>    
                <input type="hidden" name="goodsnm" value="<?php echo $TPL_VAR["asData"][ 0]['goodsnm']?>">
                <?php echo $TPL_VAR["asData"][ 0]['goodsnm']?>

<?php }else{?>
                <input type="text" name="goodsnm" value="<?php echo $TPL_VAR["asData"][ 0]['goodsnm']?>">
<?php }?>
            </td>
            <th>시리얼번호</th>
            <td><input type="text" name="serial_number" value="<?php echo $TPL_VAR["asData"][ 0]['serial_number']?>"></td>
        </tr>
        <tr>
            <th>제품특징(디테일)</th>
            <td colspan="6">
                <textarea name="product_point" style="width:100%; height: 60px;"><?php echo $TPL_VAR["asData"][ 0]['product_point']?></textarea>
            </td>
        </tr>
    
    </table>

    <hr>
    <h1 class="page_title">수리내용</h1>
    <hr>
    <table id="" style="width:100%" class="listTable">
        <tr>
            <th>수리내용</th>
            <td class="as_contents" colspan=3>
<?php if($TPL_VAR["asData"][ 0]['as_cate']){?>
                <table id="" style="width:100%" class="listTable">
                    <tr>
                        <th style="width:10px"></th>
                        <th style="width:95%">수리내용</th>
                        <th>수량</th>
                        <th>가격</th>
                        <th>실비용</th>
                    </tr>
<?php if(is_array($TPL_R1=$GLOBALS["cfg_as_contents"][$TPL_VAR["asData"][ 0]['as_cate']])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
                    <tr>
                        <td><label style='font-weight: normal;'><input type='checkbox' name='as_code[]' value='<?php echo $TPL_K1?>' <?php echo $GLOBALS["checked"]['as_code'][$TPL_K1]?>></label></td>
                        <td>
                            <?php echo $TPL_V1?>

<?php if($TPL_K1=='98'||$TPL_K1=='99'){?>
                            <input type="text" name="as_memo[<?php echo $TPL_K1?>]" value="<?php echo $TPL_VAR["asData"][ 0]['repair'][$TPL_K1]['as_memo']?>" style="width:90%">
<?php }?>
                        </td>
                        <td><input type="text" name="as_quantity[<?php echo $TPL_K1?>]" value="<?php echo $TPL_VAR["asData"][ 0]['repair'][$TPL_K1]['as_quantity']?>" style="width:50px" value='1'></td>
                        <td><input type="text" name="as_price[<?php echo $TPL_K1?>]" value="<?php echo $TPL_VAR["asData"][ 0]['repair'][$TPL_K1]['as_price']?>" style="width:100px" onkeyup="sum_price('price')" class='sumPrice' data-type='price'></td>
                        <td><input type="text" name="as_real_price[<?php echo $TPL_K1?>]" value="<?php echo $TPL_VAR["asData"][ 0]['repair'][$TPL_K1]['as_real_price']?>" style="width:100px" onkeyup="sum_price('realprice')" class='sumPrice' data-type='realprice'></td>
                    </tr>
<?php }}?>
                </table>
<?php }?>
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
                    <textarea style="overflow:auto; width:100%; height:120px;" name="memo" class="textPick"><?php echo $TPL_VAR["asData"][ 0]['memo']?></textarea>
                </div>
            </td>
        </tr>
        
        <tr>
            <th>고객비용</th>
            <td><input type="text" name="customer_cost" value="<?php if($TPL_VAR["asData"][ 0]['customer_cost']){?><?php echo $TPL_VAR["asData"][ 0]['customer_cost']?><?php }else{?>0<?php }?>"></td>
            <th>실비용</th>
            <td><input type="text" name="real_cost" value="<?php if($TPL_VAR["asData"][ 0]['real_cost']){?><?php echo $TPL_VAR["asData"][ 0]['real_cost']?><?php }else{?>0<?php }?>"></td>
        </tr>
        <tr>
            <th>진행업체명</th>
            <td>
			<input type="text" name="progress_company" value="<?php echo $TPL_VAR["asData"][ 0]['progress_company']?>" readonly>
			<select class='company_in'>
				<option value="0">==선택==</option>
				<option>자체</option>
				<option>무한</option>
				<option>은하사</option>
				<option>도우덱</option>
				<option>크리스챤</option>
				<option>시계연구소</option>
				<option>기타</option>
			</select>
			</td>
            <th>출고택배정보</th>
            <td>            
                <div>
                    <select name="send_delivery_code" class="send_delivery_code">
<?php if($TPL_delivery_list_1){foreach($TPL_VAR["delivery_list"] as $TPL_V1){?> 
                        <option value=<?php echo $TPL_V1["code"]?>  <?php if($TPL_VAR["asData"][ 0]['send_delivery_code']){?> <?php if($TPL_V1["code"]==$TPL_VAR["asData"][ 0]['send_delivery_code']){?>selected<?php }?><?php }else{?><?php if($TPL_V1["code"]=='CJGLS'){?>selected<?php }?><?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
                    </select>
                </div>
                <div style="padding-top:5px"><input type="text" name="send_invoice" value="<?php echo $TPL_VAR["asData"][ 0]['send_invoice']?>"></div>
            </td>
        </tr>
        <tr>
            <th>입고일</th>
            <td><input type="text" name="in_regdate" class="datepicker_common" value="<?php if($TPL_VAR["asData"][ 0]['in_regdate']){?><?php echo $TPL_VAR["asData"][ 0]['in_regdate']?><?php }else{?><?php echo $GLOBALS["now_date"]?><?php }?>"></td>
            <th>출고일</th>
            <td><input type="text" name="out_regdate" class="datepicker_common" value="<?php echo $TPL_VAR["asData"][ 0]['out_regdate']?>"></td>        
        </tr>
        <tr>
            <th>완료예상일</th>
            <td><input type="text" name="schedule_date" class="datepicker_common" value="<?php echo $TPL_VAR["asData"][ 0]['schedule_date']?>"> [D-Day : <?php echo $TPL_VAR["asData"][ 0]['leftDate']?><?php if($TPL_VAR["asData"][ 0]['leftDate']!='미등록'){?>일<?php }?>]</td>       
			<th>기타</th>
            <td><label style='font-weight: normal;'><input type='checkbox' name='report_yn' value='n' <?php echo $GLOBALS["checked"]['report_yn']['n']?>>결산자료제외</label></td>    
        </tr>

    </table>
    <hr>
    <div class="bottom_btn_box" style="margin-top: 0px;">
        <div class="box_left">
<?php if($GLOBALS["as_no"]){?>
            <div class="btn btn-sm btn-warning" onclick="popup('send_sms.php?etc_code=as&etc_no=<?php echo $GLOBALS["as_no"]?>','','1100','900')">문자발송</div>
<?php }else{?>
            <div class="btn btn-sm btn-warning" onclick="popup('send_sms.php?etc_code=receipt&etc_no=<?php echo $GLOBALS["receipt_no"]?>','','1100','900')">문자발송</div>
<?php }?>
        </div>
        <div class="box_right">
<?php if($GLOBALS["as_no"]){?>
            <div class="btn btn-sm btn-warning buttonChange checkForm">수정</div>
<?php }else{?>
            <div class="btn btn-sm btn-primary buttonChange checkForm">등록</div>
<?php }?>
            
        </div>
    </div>
</form>
<?php if($GLOBALS["order_list_no"]){?>
<?php echo $this->define('tpl_include_file_1',"cs/receipt_view.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<?php }?>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".company_in").change(function(){
	$("input[name='progress_company']").prop('readonly', true);
	if($(this).val()!=0){
		if($(this).val()=='기타'){
			$("input[name='progress_company']").prop('readonly', false);
		}else{
			$("input[name='progress_company']").val($(this).val());
		}
	}	
});

$(".as_cate").change(function(){
    
    $.ajax({
        url: "./as_ajax.php",
        type: "POST",
        cache: false,
        dataType: "json",
        data: "cateNo="+$(this).val(),
        success: function(data){            
            $('.as_contents *').remove();
            $('.cateSelect *').remove();
            if(data['as_contents']){
                
                var addCate2="";

                addCate2+="<table id='' style='width:100%' class='listTable'>";
                addCate2+="    <tr>";
                addCate2+="        <th style='width:10px'></th>";
                addCate2+="        <th style='width:95%'>수리내용</th>";
                addCate2+="        <th>수량</th>";
                addCate2+="        <th>가격</th>";
                addCate2+="        <th>실비용</th>";
                addCate2+="    </tr>";
                    
                $.each(data['as_contents'],function(index, item){
                    var selected='';                    
                    addCate2+="<tr>";
                    addCate2+="    <td><label style='font-weight: normal;'><input type='checkbox' name='as_code[]' value='"+index+"'></label></td>";
                    addCate2+="    <td>";
                    addCate2+=         item;
                    if(index=='98' || index=='99'){
                    addCate2+="        <input type='text' name='as_memo["+index+"]' style='width:90%'>";
                    }
                    addCate2+="    </td>";
                    addCate2+="    <td><input type='text' name='as_quantity["+index+"]' style='width:50px' value='1'></td>";
                    addCate2+="    <td><input type='text' name='as_price["+index+"]' style='width:100px' onkeyup='sum_price(\"price\")' class='sumPrice' data-type='price'></td>";
                    addCate2+="    <td><input type='text' name='as_real_price["+index+"]' style='width:100px' onkeyup='sum_price(\"realprice\")' class='sumPrice' data-type='realprice'></td>";
                    addCate2+="</tr>";
               });
               addCate2+="</table>";
               $('.as_contents').append(addCate2);
            }
            if(data['sub_cate']){
                
                var addSubcate="<select name='as_sub_cate'>";
                $.each(data['sub_cate'],function(index, item){          
                    if(!index) return;
                    addSubcate+="<option value='"+index+"'>"+item+"</option>";
                });
                addSubcate+="</select>";
                $('.cateSelect').append(addSubcate);
                
            }
        }
    });

});

$(".checkForm").click(function(){
    if(!$(".as_cate").val()){
        alert("카테고리를 선택해주세요.");return false;
    }
    textareaContents=$(".textPick").val();
    if(!textareaContents){
        alert('내용을 입력해주세요.');
        return false;
    }

	if($("input[name='address_check']").is(":checked")==true && $("select[name='as_status']").val()=='6'){
		alert('주소확인이 필요합니다.');
        return false;
	}	

    if(($(".as_status").val()=='6' && !$("input[name='send_invoice']").val()) && $(".send_delivery_code").val()!='DIRECT'){
        alert("출고택배정보를 입력해주세요.");
        return false;
    }

    $("#asForm").submit();
});
/*
$(".sumPrice").keyup(function (){
    var subject = $(".sumPrice");
    var sumprice=0;
    var sumrealprice=0;
    $(subject).each(function(index, item){
        if($(this).data("type")=="price"){
            sumprice+=Number($(this).val());
        }else if($(this).data("type")=="realprice"){
            sumrealprice+=Number($(this).val());
        }
    });

    
    $("input[name='customer_cost']").val(sumprice);
    $("input[name='real_cost']").val(sumrealprice);
});
*/
function sum_price(type){
	var subject = $(".sumPrice");
    var sumprice=0;
    var sumrealprice=0;

    $(subject).each(function(index, item){
        if($(this).data("type")=="price"){
            sumprice+=Number($(this).val());
        }else if($(this).data("type")=="realprice"){
            sumrealprice+=Number($(this).val());
        }
    });

    
    $("input[name='customer_cost']").val(sumprice);
    $("input[name='real_cost']").val(sumrealprice);
}
</script>

<?php $this->print_("footer",$TPL_SCP,1);?>