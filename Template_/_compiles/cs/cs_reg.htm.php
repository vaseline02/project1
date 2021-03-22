<?php /* Template_ 2.2.8 2021/03/17 13:57:28 /www/html/ukk_test2/data/skin/cs/cs_reg.htm 000041926 */ 
$TPL_reserve_data_1=empty($TPL_VAR["reserve_data"])||!is_array($TPL_VAR["reserve_data"])?0:count($TPL_VAR["reserve_data"]);
$TPL_goodsList_1=empty($TPL_VAR["goodsList"])||!is_array($TPL_VAR["goodsList"])?0:count($TPL_VAR["goodsList"]);
$TPL__cfg_route_type_1=empty($GLOBALS["cfg_route_type"])||!is_array($GLOBALS["cfg_route_type"])?0:count($GLOBALS["cfg_route_type"]);
$TPL__cfg_retrun_type_1=empty($GLOBALS["cfg_retrun_type"])||!is_array($GLOBALS["cfg_retrun_type"])?0:count($GLOBALS["cfg_retrun_type"]);
$TPL__cfg_call_type_1=empty($GLOBALS["cfg_call_type"])||!is_array($GLOBALS["cfg_call_type"])?0:count($GLOBALS["cfg_call_type"]);
$TPL__cfg_return_delivery_type_1=empty($GLOBALS["cfg_return_delivery_type"])||!is_array($GLOBALS["cfg_return_delivery_type"])?0:count($GLOBALS["cfg_return_delivery_type"]);
$TPL__cfg_return_delivery_type2_1=empty($GLOBALS["cfg_return_delivery_type2"])||!is_array($GLOBALS["cfg_return_delivery_type2"])?0:count($GLOBALS["cfg_return_delivery_type2"]);
$TPL_delivery_list_1=empty($TPL_VAR["delivery_list"])||!is_array($TPL_VAR["delivery_list"])?0:count($TPL_VAR["delivery_list"]);
$TPL__cfg_account_code_1=empty($GLOBALS["cfg_account_code"])||!is_array($GLOBALS["cfg_account_code"])?0:count($GLOBALS["cfg_account_code"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1 class="page_title"><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<form method="post" id="csForm" name="csForm">
<input type="hidden" name="mode" value="<?php echo $GLOBALS["mode"]?>">
<input type="hidden" name="route" value="<?php echo $_GET['route']?>">
<input type="hidden" name="order_no" value="<?php echo $TPL_VAR["ordno"]?>">
<input type="hidden" name="cs_info_no" value="">
<input type="hidden" name="reserve_seq" value="">
<input type="hidden" name="ori_order_no" value="<?php echo $TPL_VAR["ori_ordno"]?>">      
<input type="hidden" name="csCount" value="<?php echo $GLOBALS["csCount"]?>">      
<input type="hidden" name="return_type_mod" value="">      
<input type="hidden" name="return_type_sub_mod" value="">      
<input type="hidden" name="receipt_no" value="<?php echo $_GET['receipt_no']?>">
<!-- <input type="hidden" name="ins_type" value="0">       -->
<input type="hidden" name="return_url" value="<?php echo $_SERVER['QUERY_STRING']?>">      
       

<h1 class="page_title">기본주문정보</h1>
<style>
    .search_td_width{width:400px;}
    
    .notice-box { padding:0px 10px 10px 10px; background-color:rgb(249, 250, 252); text-align:left;  } 
    .notice-box p { -webkit-margin-before: .3em; -webkit-margin-after: .5em; } 
    #close { float:right; display:inline-block; padding:2px 5px; font-weight: 700; text-shadow: 0 1px 0 #fff; font-size: 2.0rem; } 
    #close:hover { border: 0; cursor:pointer; opacity: .75; }
</style>
<table class="table table-bordered" >
	<tbody>
		<tr>
			<th>주문번호</th>
            <td class="search_td_width"><?php echo $TPL_VAR["upload_form_type"]?>-<?php echo $TPL_VAR["mall_name"]?>(<?php echo $TPL_VAR["ordno"]?>)</td>            
            <th>구매자/수령자</th>
            <td><?php echo $TPL_VAR["buyer"]?>/<?php echo $TPL_VAR["receiver"]?></td>   
        </tr>
        <tr>
			<th>주소</th>
            <td><?php echo $TPL_VAR["zipcode"]?> <?php echo $TPL_VAR["address"]?></td>   
            <th>연락처</th>
            <td><?php echo $TPL_VAR["mobile"]?></td>   
        </tr>
		<tr>
			<th>출고일자</th>
            <td colspan="3"><?php echo $TPL_VAR["comp_date"]?></td>   
        </tr>
	</tbody>
</table>

<hr>

<?php if($TPL_VAR["reserve_data"]){?>
<h1 class="page_title">예약재고</h1>
<table id="" style="width:100%" class="listTable">
	<thead>
		<tr>			
			<th width='150'>모델명</th>
			<th width='100'>이미지</th>
			<th width='100'>수량</th>
			<th>메모</th>
			<th width='100'>접수</th>
			<th width='100'>등록일</th>
			<th width='100'></th>			
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_reserve_data_1){foreach($TPL_VAR["reserve_data"] as $TPL_V1){?>
		<tr class="text_center">			
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["cnt"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>	
			<td><?php echo $TPL_V1["name"]?>(<?php echo $TPL_V1["admin_no"]?>)</td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td>
			<button type='button' class='btn btn-sm btn-success btn-release' data-seq=<?php echo $TPL_V1["no"]?>>예약해제</button>
			</td>			
		</tr>
<?php }}?>
	</tbody>
</table>
<hr>
<?php }?>
<h1 class="page_title">상품</h1>

<table id="" style="width:100%" class="listTable">
	<thead>
		<tr>			
<?php if(!$GLOBALS["view_type"]){?>
            <th width='50'><input type="checkbox" class="allCheck"></th>
<?php }?>
			<th width='100'>상품명</th>
			<th width='100'>모델명</th>
			<th width='100'>이미지</th>
			<th width='100'>수량</th>
			<th width='100'>가격</th>
			<th width='100'>송장번호</th>
			<th width='100'>반송장번호</th>
			<th width='100'>메모</th>			
			<th width='100'>주문상태</th>			
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_goodsList_1){foreach($TPL_VAR["goodsList"] as $TPL_V1){?>
        <input type="hidden" name="goods_no[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["goodsno"]?>">        
        <input type="hidden" name="mall_no[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["mall_no"]?>">        
        <input type="hidden" name="deli_codeno[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["deli_codeno"]?>">        
		<tr class="<?php echo $TPL_V1["line_color"]?> trNo_<?php echo $TPL_V1["no"]?>">			
<?php if(!$GLOBALS["view_type"]){?>
            <td class="centerClass"><input type="checkbox" name="order_list_no[]" id="order_list_no_<?php echo $TPL_V1["no"]?>" class="goodsTableAdd" data-wno="<?php echo $TPL_V1["wno"]?>" data-no="<?php echo $TPL_V1["no"]?>" data-mall_goodsnm='<?php echo $TPL_V1["mall_goodsnm"]?>' data-order_num='<?php echo $TPL_V1["order_num"]?>' data-order_no='<?php echo $TPL_V1["ordno"]?>' data-deli_codeno='<?php echo $TPL_V1["deli_codeno"]?>' value=<?php echo $TPL_V1["no"]?>></td>
<?php }?>
			<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td class="centerClass">
				<?php echo $TPL_V1["order_num"]?>

<?php if($TPL_V1["return_num"]){?><span style="color:red"><br>반품(<?php echo $TPL_V1["return_num"]?>)</span><?php }?>
<?php if($TPL_V1["exchange_num"]){?><span style="color:red"><br>교환(<?php echo $TPL_V1["exchange_num"]?>)</span><?php }?>
			</td>
			<td><?php echo number_format($TPL_V1["settle_price"])?>원</td>
			<td><?php if($TPL_V1["invoice"]!= 0){?><?php echo $TPL_VAR["delivery_list"][$TPL_V1["courier_code"]]['name']?><div>(<?php echo $TPL_V1["invoice"]?>)</div><?php }?></td>			
			<td><?php if($TPL_V1["return_invoice"]!= 0){?><?php echo $TPL_VAR["delivery_list"][$TPL_V1["return_courier_code"]]['name']?><div>(<?php echo $TPL_V1["return_invoice"]?>)</div><?php }?></td>			
			<td><?php echo $TPL_V1["memo"]?></td>			
			<td><?php if($TPL_V1["step"]=='5'&&$TPL_V1["courier_code"]&&$TPL_V1["invoice"]){?><a href="<?php echo $GLOBALS["delivery_list"][$TPL_V1["courier_code"]]['tracking']?><?php echo $TPL_V1["invoice"]?>" target="_blank"><?php echo $TPL_V1["step_lv"]?></a><?php }else{?><?php echo $TPL_V1["step_lv"]?><?php }?></td>			
		</tr>
<?php }}?>
	</tbody>
</table>

<hr>
<?php if(!$GLOBALS["view_type"]){?>
<div class="bottom_btn_box" style="width:100%; margin-top: 0px;">
	<div class="box_left"><h1 class="page_title">접수</h1></div>
	<div class="box_right"><div class="btn btn-sm btn-warning" onclick="popup('send_sms.php?etc_code=cs&order_no=<?php echo $TPL_VAR["ordno"]?>','','1100','900')">문자발송</div></div>
</div>
<table class="table table-bordered" >
	<tbody>				
        <tr>
            <td>
        
                <div class="bottom_btn_box" style="width:100%; margin-top: 0px;">
                    <div class="box_left">
                    <ul style="position: relative;">
                        <select name="route_type">                   
                            <option value="0">== 상담경로 ==</option>
<?php if($TPL__cfg_route_type_1){foreach($GLOBALS["cfg_route_type"] as $TPL_K1=>$TPL_V1){?>
                                <option value=<?php echo $TPL_K1?>><?php echo $TPL_V1?></option>
<?php }}?>
                        </select>
                        <select name="return_type" class="returnType">                   
                            <option value="">== 상담유형 ==</option>
<?php if($TPL__cfg_retrun_type_1){foreach($GLOBALS["cfg_retrun_type"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1!='40'&&$TPL_K1!='50'&&$TPL_K1!='60'&&$TPL_K1!='70'&&$TPL_K1!='80'&&$TPL_K1!='90'){?>
                                <option value=<?php echo $TPL_K1?>><?php echo $TPL_V1?></option>
<?php }?>
<?php }}?>
                            <option value="">== 교반접수 ==</option>
                            <option value="60"><?php echo $GLOBALS["cfg_retrun_type"]['60']?></option>
                            <option value="70"><?php echo $GLOBALS["cfg_retrun_type"]['70']?></option>
							<option value="90"><?php echo $GLOBALS["cfg_retrun_type"]['90']?></option>
							<option value="50"><?php echo $GLOBALS["cfg_retrun_type"]['50']?></option>
							<option value="40"><?php echo $GLOBALS["cfg_retrun_type"]['40']?></option>
                        </select>
                        <span id="return_sub_span"></span>
                        
                        <!-- <span style="margin-left: 50px;">
                            <input type="radio" name="ing_type" id="ing_type_0" value='0' checked><label for="ing_type_0">진행중</label>
                            <input type="radio" name="ing_type" id="ing_type_1"value='1'><label for="ing_type_1">완료</label>
                        </span>
                        <span style="padding-right: 10px; position: absolute; right:0px;">
                            <input type="checkbox" name="send_type" id="send_type" class="sendType" value="1"><label for="send_type">기타발송</label>
                        </span> -->
                    </ul>
                    </div>
                    <div class="box_right">
                        <!-- 콜백, 진행중, 완료 -->
<?php if($TPL__cfg_call_type_1){foreach($GLOBALS["cfg_call_type"] as $TPL_K1=>$TPL_V1){?>
                            <label style="font-weight: normal;"><input type="checkbox" value=<?php echo $TPL_K1?> class="callCheck" name="call_type"><?php echo $TPL_V1?></label>
<?php }}?>
                    </div>
                </div>
            </td>            
        </tr>
<?php if($GLOBALS["receipt_data"]['memo']){?>
        <tr>
            <td>
                <table class="table table-bordered" >
                    <tr>
                        <th>택배접수내용</th>
                        <td>
                            <?php echo nl2br($GLOBALS["receipt_data"]['memo'])?>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php }?>
        
        <tr>
            <td>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-sm btn-warning" onclick="textPick('강성')">강성</button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="textPick('반품접수')">반품접수</button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="textPick('하자')">하자</button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="textPick('품절')">품절</button>
					<button type="button" class="btn btn-sm btn-warning" onclick="textPick('접수')">접수</button>
                </div>
                <div>
                    <textarea style="overflow:auto; width:100%; height:120px;" name="contents" class="textPick"></textarea>
                </div>
            </td>
        </tr>
        
        <tr class="returnHide" style="display:none">
            <th style="text-align: left;">
                <div class="changeHide" style='display:none'>
                    <div>
                        수령자명     : <input type="text" value="<?php if($TPL_VAR["content_info"]['receiver']){?><?php echo $TPL_VAR["content_info"]['receiver']?><?php }else{?><?php echo $TPL_VAR["receiver"]?><?php }?>" name="receiver" style="width: 70px;"> 
                        연락처      : <input type="text" value="<?php if($TPL_VAR["content_info"]['mobile']){?><?php echo $TPL_VAR["content_info"]['mobile']?><?php }else{?><?php echo $TPL_VAR["mobile"]?><?php }?>" name="mobile" style="width: 130px;">
						
                    </div>
                    <div style="padding-top: 10px;">                    
                        주소        : <input type="text" value="<?php if($TPL_VAR["content_info"]['zipcode']){?><?php echo $TPL_VAR["content_info"]['zipcode']?><?php }else{?><?php echo $TPL_VAR["zipcode"]?><?php }?>" name="zipcode" style="width: 70px;" class="zipcode"> <input type="text" value="<?php if($TPL_VAR["content_info"]['address']){?><?php echo $TPL_VAR["content_info"]['address']?><?php }else{?><?php echo $TPL_VAR["address"]?><?php }?>" name="address" style="width: 500px;" class="address"> 
                        <button type="button" class="btn btn-sm btn-primary searchAddress">우편번호찾기</button>
                    </div>               
                </div>
                <div class="etcHide" style='display:none'>
                    <div style="padding-top: 10px;">
                        <!--신용, 선불, 착불, 즉납 - 동봉, 미동봉-->
                        
                        
                        <select name="delivery_type">      
                            <option value="">== 배송비선택 ==</option>
<?php if($TPL__cfg_return_delivery_type_1){foreach($GLOBALS["cfg_return_delivery_type"] as $TPL_K1=>$TPL_V1){?>
                                <option value=<?php echo $TPL_K1?> <?php if($TPL_VAR["content_info"]['delivery_type']==$TPL_K1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                        </select>
                        금액 : <input type="text" name="delivery_price" value="<?php echo $TPL_VAR["content_info"]['delivery_price']?>" class="onlyNumber inputClean" value="0" style="width: 130px;">        
                        <select name="delivery_type2">      
                            <option value="">== 배송비첨부선택 ==</option>
<?php if($TPL__cfg_return_delivery_type2_1){foreach($GLOBALS["cfg_return_delivery_type2"] as $TPL_K1=>$TPL_V1){?>
                                <option value=<?php echo $TPL_K1?> <?php if($TPL_VAR["content_info"]['delivery_type2']==$TPL_K1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                        </select>
                        금액 : <input type="text" name="delivery_price2" value="<?php echo $TPL_VAR["content_info"]['delivery_price2']?>" class="onlyNumber inputClean" value="0" style="width: 130px;">
						<button type="button" class="btn btn-sm btn-primary inputDelete">내용삭제</button>
                    </div>
                    <!--<input type="hidden" name="return_delivery_code" value=<?php echo $TPL_VAR["return_courier_code"]?>>
                    <input type="hidden" name="return_invoice" value=<?php echo $TPL_VAR["return_invoice"]?>>-->
                     <div style="padding-top: 10px;">
                        <select name="return_delivery_code">      
                            <option value="">== 택배사선택 ==</option>
<?php if($TPL_delivery_list_1){foreach($TPL_VAR["delivery_list"] as $TPL_V1){?>
                                <option value=<?php echo $TPL_V1["code"]?> <?php if($TPL_VAR["content_info"]['return_delivery_code']){?><?php if($TPL_V1["code"]==$TPL_VAR["content_info"]['return_delivery_code']){?>selected<?php }?><?php }elseif($TPL_VAR["return_courier_code"]){?><?php if($TPL_V1["code"]==$TPL_VAR["return_courier_code"]){?>selected<?php }?><?php }else{?><?php if($TPL_V1["code"]=='CJGLS'){?>selected<?php }?><?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
                        </select>
                        송장번호 : <input type="text" name="return_invoice" value="<?php if($TPL_VAR["content_info"]['return_invoice']){?><?php echo $TPL_VAR["content_info"]['return_invoice']?><?php }else{?><?php echo $TPL_VAR["return_invoice"]?><?php }?>" class="inputClean" style="width: 200px;"> 
                    </div>
                    <div style="padding-top: 10px;">
                        <select name="account_code">      
                            <option value="">== 은행선택 ==</option>
<?php if($TPL__cfg_account_code_1){foreach($GLOBALS["cfg_account_code"] as $TPL_K1=>$TPL_V1){?>
                                <option value=<?php echo $TPL_K1?> <?php if($TPL_VAR["content_info"]['account_code']==$TPL_K1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                        </select>
                        입금자 : <input type="text" name="account_name" value="<?php echo $TPL_VAR["content_info"]['account_name']?>" class="inputClean" style="width: 100px;"> 
                        계좌번호 : <input type="text" name="account_number" value="<?php echo $TPL_VAR["content_info"]['account_number']?>" class="inputClean" style="width: 200px;"> 
                        금액 : <input type="text" name="account_price" value="<?php echo $TPL_VAR["content_info"]['account_price']?>" class="onlyNumber inputClean" value="0"  style="width: 130px;"> 

                    </div>
                    <div style="padding-top: 10px;">
                        비고 : <input type="text" name="account_etc" value="<?php echo $TPL_VAR["content_info"]['account_etc']?>" class="inputClean" style="width: 400px;"> 
                    </div>
					<div style="padding-top: 10px;">
						상품상태 : 
						 <label><input type="radio" name="goods_bad_yn" id="goods_bad_yn" value="n"  <?php if($TPL_VAR["content_info"]['goods_bad_yn']!='y'){?>checked<?php }?>>이상없음</label>
                        <label><input type="radio" name="goods_bad_yn" id="goods_bad_yn" value="y" <?php if($TPL_VAR["content_info"]['goods_bad_yn']=='y'){?>checked<?php }?>>이상있음</label>
                       
						<input type="text" name="goods_bad_memo" value="<?php echo $TPL_VAR["content_info"]['goods_bad_memo']?>" class="inputClean" style="width: 400px;"> 
                    </div>

                    <div style="padding-top: 10px;">
                        <label><input type="checkbox" name="refund_yn" id="refund_yn" value="y" <?php if($TPL_VAR["content_info"]['refund_yn']=='y'){?>checked<?php }?>>환불완료</label>
                        <span class="changeHide" style='display:none'>
                            <label><input type="checkbox" name="receipt" id="receipt" value="1" <?php if($TPL_VAR["content_info"]['receipt']=='1'){?>checked<?php }?>>선접수</label>
                        </span>
						
                    </div>
			
                  
                </div>
            </th>
        </tr>
    </tbody>
 </table>
 <center style="padding-top:20px;">
    <label style="font-weight: normal; vertical-align: middle;"><input type="checkbox" name="ins_type" value='1'>긴급등록</label>
    <!-- <div class="btn btn-sm btn-danger exchange_button checkForm" data-ins_type='1'>긴급등록</div> -->
	<div class="btn btn-sm btn-primary csIng cs_checkForm" data-mode='cs_ing' style="display:none">처리중</div>
	<div class="btn btn-sm btn-primary receiptIns cs_checkForm" data-mode='receipt_ins' style="display:none">접수</div>
    <div class="btn btn-sm btn-primary buttonChange cs_checkForm" data-mode='ins' data-ins_type='0'>완료</div>
    <div class="btn btn-sm btn-primary" onclick="javascript:history.go('cs_reg.php?ordno=<?php echo $GLOBALS["ordno"]?>')">새로고침</div>    
</center>
<hr>
<?php }?>

<?php echo $this->define('tpl_include_file_1',"cs/receipt_view.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

</form>


<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

var textareaContents;
var textSum;
//클릭text
function textPick(text){
    textareaContents=$(".textPick").val();        
    if(textareaContents) textSum=textareaContents+' '+text;
    else textSum=text;
    
    $(".textPick").val(textSum);
}
$(".cs_checkForm").click(function(){
	var msg="";
    $("input[name='mode']").val($(this).data('mode'));
    insMode=$("input[name='mode']").val();

    if(insMode=='ins' || insMode=='mod' || insMode=='receipt_ins' || insMode=='cs_ing'){
        
        textareaContents=$(".textPick").val();

        // if(!$("select[name='route_type']").val()){
        //     alert('상담경로를 선택해주세요.');
        //     return false;
        // }

        if(!$("select[name='return_type']").val()){
            alert('상담유형을 선택해주세요.');
            return false;
        }
        
        if(!textareaContents){
            alert('내용을 입력해주세요.');
            return false;
        }
		if(($(".returnType").val()=='40' || $(".returnType").val()=='60' || $(".returnType").val()=='70' || $(".returnType").val()=='90')){
			
			if(!$("select[name='delivery_type']").val() || !$("select[name='delivery_type2']").val()){
				alert("배송비와 배송비첨부를 선택해주세요.");	
				return false;
			}
			//외부상품 완료처리안되게 수정
			var outsideCheck=0;
			if(insMode=='ins'){
				$(".goodsTableAdd").each(function(index, item){
					if($(item).is(":checked")){        		
						//외부상품 체크
						if($(this).data('deli_codeno')=='outside'){	
							outsideCheck++;
						}
					}
				});
				if(outsideCheck>0){
                    alert("외부상품은 교환접수,반품접수,상품입고,출고를 할수없습니다.");
                    return false;
                }
			}
		}

        // $("input[name='ins_type']").val($(this).data("ins_type"));
        if(insMode=="ins" || insMode=='receipt_ins' || insMode=='cs_ins'){
            //발송체크를 하였으나 상품선택을 안했을경우
            
            if(($(".returnType").val()=='40' || $(".returnType").val()=='60' || $(".returnType").val()=='70' || $(".returnType").val()=='90') && !$(".goodsTableAdd").is(":checked")){
                alert("반품,교환,발송 접수할 상품이 선택되지 않았습니다.");return false;
            }
            //교환을하는데 교환상품 선택을 안했을경우
            if($(".goodsTableAdd").is(":checked") && ($(".returnType").val()=='40' || $(".returnType").val()=='70' || ($(".returnType").val()=='90' && $("select[name='return_type_sub']").val()=='2'))){
				
                var exchangeCheck=0;
                $(".goodsTableAdd").each(function(index, item){
                    if($(item).is(":checked")){        		
						//외부상품 -> 상품입고 -> 상품반송일경우 교환모델 체크를하지않는다.
						if($(this).data('deli_codeno')=='outside' && $(".returnType").val()=='90' && $("select[name='return_type_sub']").val()=='2'){	
							if(!$("input[name='exchange_goods_nm["+$(item).val()+"]']").val()) exchangeCheck++;
						}else if(!$("input[name='exchange_goods_no["+$(item).val()+"]']").val() || $("input[name='exchange_goods_no["+$(item).val()+"]']").val()==0){
							exchangeCheck++;
						}
                    }
                });
				
                if(exchangeCheck>0){
                    alert("교환,발송할 상품이 잘못되었습니다.");
                    return false;
                }

            }
            // if(($(".returnType").val()>='20' && $(".returnType").val()<'50') && $(":input:radio[name=ing_type]:checked").val()=='1' && !$(".sendType").is(":checked")){
            //     alert("교환및반품을 완료할 경우 기타발송을 선택해주세요.");
            //     return false;
            // }
        }

		if(($(".returnType").val()=='60' || $(".returnType").val()=='70') && $("select[name='return_type_sub']").val()=='2' && insMode=='ins'){
			if($(":input:radio[name=goods_bad_yn]:checked").val()=='n' || !$("input[name='goods_bad_memo']").val()){
				alert("상품상태를 입력해주세요.");
				return false;
			}
		}

      

        if(insMode=='mod'){
            msg="[수정]";
        }else if(insMode=='ins'){
			msg="[완료]";
		}else if(insMode=='receipt_ins'){
			msg="[접수]";
		}else if(insMode=='cs_ing'){
			msg="[처리중]";
		}			
			
        $.ajax({
            url: "./cs_ajax.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: "ordno="+$("input[name='order_no']").val()+"&mode=infoCheck",
            success: function(data){
                
                if(data['cnt']!=$("input[name='csCount']").val()){
                    if(confirm('작성도중 업데이트된 내용이있습니다. 확인하시겠습니까?')){                            
                       popup('cs_reg_mod.php?ordno='+$("input[name='order_no']").val(),'','1100','900');
                    }
                }else{
					if(confirm(msg+"처리하시겠습니까?")) $("#csForm").submit();
                }

            },
            error: function (request, status, error){        
                console.log(error);
            }
        });
    }
});
//접수처리
/*
$(".receiptIns").click(function(){
	textareaContents=$(".textPick").val();

	if(!$("select[name='return_type']").val()){
		alert('상담유형을 선택해주세요.');
		return false;
	}
	
	if(!textareaContents){
		alert('내용을 입력해주세요.');
		return false;
	}

	if(!$(".goodsTableAdd").is(":checked")){
		alert("접수할 상품이 선택되지 않았습니다.");return false;
	}	

    if(confirm("접수하시곘습니까?")){
        $("input[name='mode']").val("receipt_ins");
        $("form[id='csForm']").submit();
    }
});

$(".csIng").click(function(){
	textareaContents=$(".textPick").val();

	if(!$("select[name='return_type']").val()){
		alert('상담유형을 선택해주세요.');
		return false;
	}
	
	if(!textareaContents){
		alert('내용을 입력해주세요.');
		return false;
	}

	if(!$(".goodsTableAdd").is(":checked")){
		alert("접수할 상품이 선택되지 않았습니다.");return false;
	}	

    if(confirm("[처리중]등록하시곘습니까?")){
        $("input[name='mode']").val("cs_ing");
        $("form[id='csForm']").submit();
    }
});
*/
$(".inputDelete").click(function(){
	$(".inputClean").val('');
});


function exGoodsCheck(no,data){
	$.ajax({
        url: "./cs_ajax.php",
        type: "POST",
        cache: false,
        dataType: "json",
        data: "no="+no+"&goodsnm="+data.value+"&mode=goodsCheck",
        success: function(data){
			
			$('.goodsyn_'+no+':last').empty();
			if(!data.cnt){				
				$("input[name='exchange_goods_no["+no+"]']").val("");
				$("input[name='exchange_stock_yn["+no+"]']").val("");
				$('.goodsyn_'+no+':last').append('* 해당 모델이 존재하지않습니다.');
			}else{
				$("input[name='exchange_goods_no["+no+"]']").val(data.no);
				$("input[name='exchange_stock_yn["+no+"]']").val(data.stock_yn);
				$('.goodsyn_'+no+':last').append('* 재고 : '+data.totalCnt+'개');
			}
        }
    });
}

function returnSubappend(returnNo,subNo,type){
    
    $.ajax({
        url: "./cs_ajax.php",
        type: "POST",
        cache: false,
        dataType: "json",
        data: "no="+returnNo+"&mode=returnType",
        success: function(data){
            $('#return_sub_span *').remove();
            if(data){
            addHtml="<select name='return_type_sub' onchange='returnTypesub(this)'>";
        
                $.each(data,function(index, item){
                    var selected='';
                    if(index==subNo) selected='selected';                
                    addHtml+="<option value='"+index+"' "+selected+">"+item+"</option>";
                });
            
                addHtml+="</select>";
                $('#return_sub_span').append(addHtml);
            }

            if(type=='disabled') $("select[name='return_type_sub']").attr("disabled",true);
        }
    });
}
//일반문의일경우 발송선택안되게
// $(".sendType").click(function(){    
//     if($(".returnType").val()==0){
//         alert('일반문의 상태에서는 선택하실수 없습니다.');
//         $("input:checkbox[name='send_type']").prop('checked', false);
//     }
// });

$(function(){
	$(".btn-release").click(function(){
		var no=$(this).data("seq");
		
		if(confirm('예약해제 하시겠습니까')){
			
			$("input[name='reserve_seq']").val(no);
			$("input[name='mode']").val("reserve_release");
			$("form[id='csForm']").submit();

		}
	});
})

//발송선택후 일반문의로 변경시 체크해제
$(".returnType").change(function(){    
    
    var addHtml;
	var mode=$("input[name='mode']").val();

    $(".changeHide").hide();
    $(".etcHide").hide();
    $(".returnHide").hide();
    $(".receiptIns").hide();
	$(".csIng").hide();
	$(".buttonChange").show();//checkform

    returnSubappend($(this).val());

    if($(".returnType").val()==0){        
        $("input:checkbox[name='send_type']").prop('checked', false);
    }else{       
        if($(".returnType").val()==60){
            $(".returnHide").show();
            $(".etcHide").show();   
			if(mode!='mod'){
				$(".receiptIns").show();
				$(".csIng").show();
			}
        }else if($(".returnType").val()=='40' || $(".returnType").val()==70 || $(".returnType").val()==90){
            $(".returnHide").show();
            $(".changeHide").show();
            $(".etcHide").show();          
			if(mode!='mod' && $(".returnType").val()!='40'){
				$(".receiptIns").show();
				$(".csIng").show();
			}
			if($(".returnType").val()==90 && $("input[name='mode']").val()=='ins'){
				$(".buttonChange").hide();//checkform
			}
        }
    }
});

//발송선택후 일반문의로 변경시 체크해제
function returnTypesub(data){
	if($(".returnType").val()=="90"){
		if($(data).val()=="1"){
			$(".receiptIns").show();
			$(".buttonChange").hide();//checkform
		}else if($(data).val()=="2"){
			$(".receiptIns").hide();
			$(".buttonChange").show();//checkform
		}		
	}
}



//발송요청했던 cs건을 철회하는 버튼
$(".cancelOrder").click(function(){
    if(confirm("발송철회 요청하시곘습니까?")){
        $("input[name='mode']").val("can");
        $("input[name='cs_info_no']").val($(this).data('no'));     
        $("form[id='csForm']").submit();
    }
});

//cs건 수정시 ajax
$(".claimModify").click(function (){
	var modtype=$(this).data('modtype');
    $.ajax({
        url: "./cs_ajax.php",
        type: "POST",
        cache: false,
        dataType: "json",
        data: "no="+$(this).data('no'),
        success: function(data){
            var subject = $('.goodsTableAdd');
            //상품에 클릭되있는것을 전부 해제한다.
            subject.attr( 'disabled', false );
            $(subject).each(function(index, item){
                if($(item).is(":checked")){                   
                    $(item).click(); 
                }
            });
            
            //등록된상품들을 체크한다.
            $(data['detail']).each(function(index, item){
                $("#order_list_no_"+item['order_list_no']).click(); 
                $("input[name='mall_goodsnm["+item['order_list_no']+"]']").val(item['mall_goodsnm']);
                $("input[name='exchange_goods_no["+item['order_list_no']+"]']").val(item['exchange_goods_no']);
                $("input[name='exchange_goods_nm["+item['order_list_no']+"]']").val(item['exchange_goods_nm']);
                $("input[name='exchange_goods_num["+item['order_list_no']+"]']").val(item['exchange_goods_num']);
                $("input[name='diff_price["+item['order_list_no']+"]']").val(item['diff_price']);
            });
			if(modtype!='copy'){
				//교환버튼 숨김
				$(".exchange_button").hide();
				//상품은 수정불가능하게 처리
				$(".disabled_input").attr("readonly",true);
				//상품체크안되도록 막음
				subject.attr( 'disabled', true );
			}

            //수정버튼으로 변경
			if(modtype=='copy'){
				$(".buttonChange").removeClass("btn-warning");
				$(".buttonChange").addClass("btn-primary");
				$(".buttonChange").data("mode","ins");
				$(".buttonChange").text("완료");
				$("input[name='mode']").val("ins");
				$("input[name='cs_info_no']").val('');                              
			}else{				      
				$(".buttonChange").addClass("btn-warning");
				$(".buttonChange").removeClass("btn-primary");
				$(".buttonChange").data("mode","mod");
				$(".buttonChange").text("수정");
				$("input[name='mode']").val("mod");
				$("input[name='cs_info_no']").val(data['no']);  
			}

            $("textarea[name='contents']").val(data['contents']);            
            $("select[name='return_type']").val(data['return_type']).prop("selected",true);
			$("select[name='route_type']").val(data['route_type']).prop("selected",true);
			if(modtype=='copy'){
				$("select[name='return_type']").attr("disabled",false);
				$("input[name='return_type_mod']").val('');
				$("select[name='route_type']").attr("disabled",false);
				$(".receiptIns").show();	
				$(".csIng").show();					
			}else{
				
				$("select[name='return_type']").attr("disabled",true);
				$("input[name='return_type_mod']").val(data['return_type']);
				$("select[name='route_type']").attr("disabled",true);
				$(".receiptIns").hide();	
				$(".csIng").hide();	
			}

            $(".returnType").change();
			
            $("input:checkbox[name='call_type']").prop('checked', false);
            $("input:checkbox[name='call_type']:checkbox[value="+data['call_type']+"]").prop('checked', true);
            if(data['ins_type']=='1') $("input:checkbox[name='ins_type']").prop('checked', true);
            
            if(data['return_type_sub']){
                if(modtype=='copy'){
					returnSubappend(data['return_type'],data['return_type_sub']);
					$("input[name='return_type_sub_mod']").val('');					
				}else{
					returnSubappend(data['return_type'],data['return_type_sub'],'disabled');
					$("input[name='return_type_sub_mod']").val(data['return_type_sub']);
				}
            }
            if(data['return_type']=='40' || data['return_type'] =='60' || data['return_type'] =='70' || data['return_type'] =='90'){
                $("select[name='delivery_type']").val(data['delivery_type']).prop("selected",true);
                $("input[name='delivery_price']").val(data['delivery_price']);
                $("select[name='delivery_type2']").val(data['delivery_type2']).prop("selected",true);
                $("input[name='delivery_price2']").val(data['delivery_price2']);
                $("select[name='return_delivery_code']").val(data['return_delivery_code']).prop("selected",true);
                $("input[name='return_invoice']").val(data['return_invoice']);
                $("select[name='account_code']").val(data['account_code']).prop("selected",true);
                $("input[name='account_name']").val(data['account_name']);
                $("input[name='account_number']").val(data['account_number']);
                $("input[name='account_price']").val(data['account_price']);
                $("input[name='account_etc']").val(data['account_etc']);

				$("input:radio[name='goods_bad_yn']:radio[value="+data['goods_bad_yn']+"]").prop('checked', true);
				$("input[name='goods_bad_memo']").val(data['goods_bad_memo']);

                if(data['refund_yn']=='y'){
                    $("input:checkbox[name='refund_yn']").prop('checked', true);
                }else{
                    $("input:checkbox[name='refund_yn']").prop('checked', false);
                }

                if(data['receipt']=='1'){
                    $("input:checkbox[name='receipt']").prop('checked', true);
                }else{
                    $("input:checkbox[name='receipt']").prop('checked', false);
                }

                if(data['return_type']=='40' || data['return_type']=='70' || data['return_type'] =='90'){
                    $("input[name='receiver']").val(data['receiver']);
                    $("input[name='zipcode']").val(data['zipcode']);
                    $("input[name='address']").val(data['address']);
                    $("input[name='mobile']").val(data['mobile']);
                }
            }
            // $("input:radio[name='ing_type']:radio[value="+data['ing_type']+"]").prop('checked', true);
            // if(data['send_type']){
            //     $("input:checkbox[name='send_type']").prop('checked', true);
            // }else{
            //     $("input:checkbox[name='send_type']").prop('checked', false);
            // }
            // $("input:checkbox[name='send_type']").attr("disabled",true);

        },
        error: function (request, status, error){        
            console.log(error);
        }

    });

});


//상품 체크시 교환관련 항목 노출
$(".goodsTableAdd").click(function(){
    var goodsNo=$(this).data('no');
    var mallGoodsnm=$(this).data('mall_goodsnm');
    var orderNum=$(this).data('order_num');
    var orderNo=$(this).data('order_no');
    var checkYn=($(this).is(":checked"));
    var thLength=$(".listTable th").length;
    var addHtml="";
    if(checkYn){
        addHtml="<tr class='trNo_"+goodsNo+"'>";
        addHtml+="  <input type='hidden' name='exchange_goods_no["+goodsNo+"]'>";
        addHtml+="  <input type='hidden' name='exchange_stock_yn["+goodsNo+"]'>";
        addHtml+="  <th style='text-align: left;' colspan="+thLength+">";
        addHtml+="      <div style='padding-top: 10px; display:none'>";
        addHtml+="          구매상품 : <input type='text' class='disabled_input' value='"+mallGoodsnm+"' name='mall_goodsnm["+goodsNo+"]' style='width: 500px;''> ";
        addHtml+="      </div>";
        addHtml+="      <div style='padding-top: 10px;'>";
        addHtml+="          모델명 : <input type='text' value='' name='exchange_goods_nm["+goodsNo+"]' onkeyup='exGoodsCheck("+goodsNo+",this)' style='width: 350px;'> ";
        addHtml+="          수량 : <input type='text' class='disabled_input' value='1' name='exchange_goods_num["+goodsNo+"]' style='width: 50px;' onkeyup='inNumber(event)'> ";
        addHtml+="          비용 : <input type='text' class='disabled_input' value='0' name='diff_price["+goodsNo+"]' style='width: 130px;'  onkeyup='inNumber(event)'> ";
		if($(this).data('wno')) addHtml+="          (도매환불 : <input type='text' class='disabled_input' value='0' name='wholesale_price["+goodsNo+"]' style='width: 130px;'  onkeyup='inNumber(event)'>)";
        //addHtml+="          <button type='button' class='btn btn-sm btn-warning exchange_button' onclick='popup(\"goods_search.php?goodsno="+goodsNo+"&order_no="+orderNo+"&order_list_no="+$(this).val()+"\",\"goods_search\",\"1000\",\"900\")'>교환상품선택</button>";
		//addHtml+="          <button type='button' class='btn btn-sm btn-success exchange_button' onclick='popup(\"../goods/reserve_reg.php?goodsno="+goodsNo+"&order_no="+orderNo+"&order_list_no="+$(this).val()+"\",\"goods_search\",\"1000\",\"900\")'>재고예약</button>";
        addHtml+="      </div>";
		addHtml+="      <div class='goodsyn_"+goodsNo+"' style='color:#28992C;'>";
        addHtml+="      </div>";
        addHtml+="      <div style='color:red'>";
        addHtml+="          * 교환을 할경우 교환할모델명을 작성해주세요.<br>";
        addHtml+="          * 반품을 할경우 반품할 수량만 입력해주세요.";
        addHtml+="      </div>";
        addHtml+="  </th>";
        addHtml+="</tr>";

        $('.listTable > tbody > .trNo_'+goodsNo+':last').after(addHtml);
    }else{
        $('.trNo_'+goodsNo+':last').remove();
    }
});

//전체체크        
$(".allCheck").click(function(){    
    var subject = $('.goodsTableAdd');
    
    $(subject).each(function(index, item){
        if($(".allCheck").is(":checked")){
            if(!$(item).is(":checked")){
                $(item).click(); 
            }
        }else{
            if($(item).is(":checked")){
                $(item).click(); 
            }
        }
    });
});

//전체체크        
$(".callCheck").click(function(){    
    if($(this).prop('checked')){
        $('.callCheck').prop('checked',false);
        $(this).prop('checked',true);
    }
});
$(document).ready(function(){
	$(".loadCopy").click();
});


</script>



<?php $this->print_("footer",$TPL_SCP,1);?>