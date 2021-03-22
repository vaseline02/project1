<?php /* Template_ 2.2.8 2021/01/07 15:56:15 /www/html/ukk_test2/data/skin/order/order_outside_comp.htm 000015944 */ 
$TPL__uplolad_mall_1=empty($GLOBALS["uplolad_mall"])||!is_array($GLOBALS["uplolad_mall"])?0:count($GLOBALS["uplolad_mall"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div class="row"><div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div></div>
<form method="POST" id="compForm">
<input type="hidden"name="print_xls" value="">
    <div class="panel panel-default panel-stock margin20">
        <table class="table fileload-list-small">
            <colgroup>
                <col width="15%" />
                <col width="35%" />
                <col width="15%" />
                <col width="35%" />
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">주문처리완료일</th>
                    <td colspan="3" class="receive-title no-gutters">
                        
                        <div class="col-lg-4 btn-group-sm" role="group" aria-label="Small button group">
                            <button type="button" class="btn btn-default dayChange" data-int='0' data-type='day'>오늘</button>
                            <button type="button" class="btn btn-default dayChange" data-int='3' data-type='day'>3일</button>
                            <button type="button" class="btn btn-default dayChange" data-int='7' data-type='day'>7일</button>
                            <button type="button" class="btn btn-default dayChange" data-int='1' data-type='month'>1개월</button>
                            <button type="button" class="btn btn-default dayChange" data-int='3' data-type='month'>3개월</button>
                            <button type="button" class="btn btn-default dayChange" data-int='1' data-type='year'>1년</button>
                            <!-- <button type="button" class="btn btn-primary">전체</button> -->
                        </div>
                        <div class="col-md-2 date-wrap">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="order_search_comp_sdate" id="s_date" value="<?php echo $GLOBALS["s_date_value"]?>"  />
                                <span class="input-group-btn">
                                    <button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="s_date"><span class="glyphicon glyphicon-list-alt"></span></button>
                                </span>
                            </div>
                        </div>
                        
                        <p class="date-tilde">~</p>
                        <div class="col-md-2 date-wrap">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker_common" placeholder="종료 날짜" aria-describedby="basic-addon2" name="order_search_comp_edate" id="e_date" value="<?php echo $GLOBALS["e_date_value"]?>"  />
                                <span class="input-group-btn">
                                    <button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="e_date"><span class="glyphicon glyphicon-list-alt"></span></button>
                                </span>
                            </div>										
                        </div>
                        <script>
                            
                        </script>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="align-left">몰명</th>
                    <td class="receive-title no-gutters">
                        <select name="order_search_mall">
                            <option value="">선택</option>
                            <optgroup label="업로드별">
<?php if($TPL__uplolad_mall_1){foreach($GLOBALS["uplolad_mall"] as $TPL_K1=>$TPL_V1){?>
                                <option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['order_search_mall'][$TPL_K1]?> >==<?php echo $TPL_K1?>==</option>
<?php }}?>
                            </optgroup>
                            <optgroup label="상세">
<?php if($TPL__uplolad_mall_1){foreach($GLOBALS["uplolad_mall"] as $TPL_K1=>$TPL_V1){?>
                                    <option value="<?php echo $TPL_K1?>" >==<?php echo $TPL_K1?>==</option>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
                                        <option value="<?php echo $TPL_K2?>" <?php echo $GLOBALS["selected"]['order_search_mall'][$TPL_K2]?> ><?php echo $TPL_V2?></option>
<?php }}?>
<?php }}?>
                            </optgroup>
                        </select>
                    </td>
                    <th scope="row" class="align-left">옵션명</th>
                    <td class="receive-title no-gutters">                        
                        <div class="col-xs-12"><input type="text" class="form-control" name="order_search_goodsnm" value="<?php echo $_POST['order_search_goodsnm']?>"></div>
                    </td>
                </tr>
                <tr>                    
                    <th scope="row" class="align-left">브랜드</th>
                    <td class="receive-title no-gutters">
                        <div class="col-xs-12"><input type="text" class="form-control" name="order_search_brand" id="order_search_brand" value="<?php echo $_POST['order_search_brand']?>"></div>
                    </td>
                    <th scope="row" class="align-left">고객명</th>
                    <td class="receive-title no-gutters">
                        <div class="col-xs-12"><input class="form-control" type="text" name="order_search_receiver" value="<?php echo $_POST['order_search_receiver']?>"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="align-left">주문번호</th>
                    <td class="receive-title no-gutters" colspan="3">
                        <div class="col-xs-12">
                            <textarea class="form-control" name="order_search_ordno" id="" cols="30" rows="3"><?php echo $_POST['order_search_ordno']?></textarea>
                        </div>
                    </td>
                </tr>
				<tr>
                    <th scope="row" class="align-left">옵션명</th>
                    <td class="receive-title no-gutters" colspan="3">
                        <div class="col-xs-12">
                            <textarea class="form-control" name="order_search_goodsnm_all" id="" cols="30" rows="3"><?php echo $_POST['order_search_goodsnm_all']?></textarea>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-center table-btn-group">
        <button class="btn btn-primary">검색</button>
		<button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>
		<button type="button" class="btn btn-primary" onclick="popup('order_outside_refund.php','order_outside_refund','1100','900')">환불등록</button>
		<button type="button" class="btn btn-primary" onclick="popup('order_other_refund.php','order_other_refund','1100','900')">국내입고반품등록</button>
        <!--<button class="btn btn-default" onclick="location.href ='order_outside_comp.php'; return false;">초기화</button>-->

    </div>
</form>

<form enctype="multipart/form-data" method="post">
<table class="table table-bordered" >
    <tr>
		<td >
			<select id="excel_type">
				<option value="">선택</option>
				<option value="in">입고장</option>
				<option value="out">출고장</option>
			</select>
			<button type="button" class="btn btn-sm btn-success" id="excel_download">엑셀다운로드</button>
		</td>	
		<!--
		<td style="text-align:right">
			<input type="text" class=" datepicker_common" placeholder="변경 날짜" aria-describedby="basic-addon2" name="comp_date" id="comp_date" readonly />
			<button type="button" class="btn btn-sm btn-success" id="comp_change">날짜변경</button>
			<input type="text" id="return_deli_price">
			<button type="button" class="btn btn-sm btn-success" id="return_order">반품처리</button>
		</td>-->
    </tr>
</table>
</form>
<?php }?>

<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode">
<input type="hidden" name="return_deli_price" id="h_return_deli_price">
<input type="hidden" name="sel_excel_type" id="sel_excel_type">
<input type="hidden" name="u_comp_date" id="u_comp_date">
<input type="hidden"name="print_xls" value="">

<!--<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->

<table id="" class="display_xscroll display nowrap" data-height="740" style="width:100%;" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>
<?php }?>
			<th>담당자</th>
			<th>주문일</th>
			<th>발주일</th>
			<th>브랜드</th>
			<th>주문상품명</th>
			<th>수량</th>
			<th>소비자가</th>
			<th>매입단가</th>
			<th>업체배송비</th>
			<th>매입가*수량</th>
			<th>합계금</th>
			<th>비고</th>
			<th>품절확인</th>
			<th>판매가</th>
			<th>쇼핑몰명</th>
			<th>주문번호</th>
			<th>품목코드</th>
			<th>수령자명</th>
			<th>우편번호</th>
			<th>수령자주소</th>
			<th>수령자전화번호</th>
			<th>수령자휴대폰</th>
			<th>주문요청사항</th>
			<th>택배사</th>
			<th>운송장번호</th>
			<th>업체명</th>
			<th>업체코드</th>
			<th>고유번호</th>
			
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
				<input type="checkbox" class="chk_no" name="chk_no[<?php echo $TPL_V1["stype"]?>][]" value="<?php echo $TPL_V1["no"]?>">
				<input type="hidden" name="hid_invoice[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["invoice"]?>">
			</td>			
<?php }?>
			<td><?php echo $TPL_V1["c_mem_name"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td><?php echo $TPL_V1["mod_date"]?></td>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php if($TPL_V1["data_type"]=='return'){?>-<?php }?><?php echo $TPL_V1["order_num"]?></td>
			<td><?php echo $TPL_V1["consumer_price"]?></td>
			<td>
<?php if($GLOBALS["print_xls"]!= 1){?>
<?php if($TPL_V1["view_type"]=='text'){?>
						<?php echo number_format($TPL_V1["purchase_price"])?>

<?php }else{?>
					<textarea name="mod_purchase_price[<?php echo $TPL_V1["stype"]?>][<?php echo $TPL_V1["no"]?>]" id="" cols="15" rows="1" class="" data-no="<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["purchase_price"]?></textarea>
<?php }?>
<?php }else{?>
					<?php echo $TPL_V1["purchase_price"]?>

<?php }?>
			</td>
			<td>
<?php if($GLOBALS["print_xls"]!= 1){?>
<?php if($TPL_V1["view_type"]=='text'){?>
						<?php echo number_format($TPL_V1["ent_deli_price"])?>

<?php }else{?>
					<textarea name="mod_ent_deli_price[<?php echo $TPL_V1["stype"]?>][<?php echo $TPL_V1["no"]?>]" id="" cols="15" rows="1" class="" data-no="<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["ent_deli_price"]?></textarea>
<?php }?>
<?php }else{?>
					<?php echo $TPL_V1["ent_deli_price"]?>

<?php }?>
			</td>
			<td><?php echo $TPL_V1["purchase_price"]*$TPL_V1["order_num"]?></td>
			<td><?php echo ($TPL_V1["purchase_price"]*$TPL_V1["order_num"])+$TPL_V1["ent_deli_price"]?></td>
			<td><span style="color: red;"><?php echo $TPL_V1["memo"]?></span></td>
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
			<td class="text_type"><?php echo $TPL_V1["invoice"]?></td>
			<td><?php echo $TPL_V1["d_name"]?></td>
			<td><?php echo $TPL_V1["d_code"]?></td>			
			<td><?php if($TPL_V1["stype"]=='other'){?>ot-<?php }?><?php echo $TPL_V1["no"]?></td>			
		</tr>
<?php }}?>
	</tbody>
</table>

</form>


<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">
		<button type="button" class="btn btn-primary btn_submit" id="info_chg">정보 변경</button>
	</div>
</div>


<?php }?>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$('table.display_xscroll').dataTable( {
	"aoColumnDefs": [{ 'bSortable': false, 'aTargets': ["sorting_disabled"] }],
	"scrollCollapse": true,
	"paging":   false,
	"scrollY": "800px",
    "scrollX": true,
	"order": []
} );

$(function(){
	$(".btn_submit").click(function(){
		
		var this_id = $(this).attr("id");
		var msg='';

		if( $(".chk_no:checked").length <=0 ){
			alert('주문을 선택해주세요.');
			return;
		}
		
        if(this_id=='info_chg'){
			msg='[정보변경]';
		}

		if(confirm(msg+'처리하시겠습니까?')){
			
			$("#mode").val(this_id);
			$("#main_form").submit();
		}
		
	});


	$("#return_order").click(function(){
		var chk_len=$(".chk_no:checked").length;
			
		if( chk_len<=0 ){
			alert('반품처리할 주문을 선택해주세요.');
			return;
		}
		
		if(confirm('처리하시겠습니까?')){

			$("#h_return_deli_price").val($("#return_deli_price").val());
			$("#mode").val('return_order');
			$("#main_form").submit();

			$("#mode").val('');
			$("#h_return_deli_price").val('');
		}
	});

	$("#comp_change").click(function(){
		var chk_len=$(".chk_no:checked").length;
		
		if( chk_len<=0 ){
			alert('변경할 주문을 선택해주세요.');
			return;
		}
		if(!$("#comp_date").val()){
			alert('변경할 날짜를 입력해주세요.');
			return;
		}

		if(confirm('처리하시겠습니까?')){
			$("#u_comp_date").val($("#comp_date").val());
			$("#mode").val('comp_change');
			$("#main_form").submit();
			$("#mode").val('');
			$("#u_comp_date").val('');
		}
	});

	
	$("#excel_download").click(function(){

		var chk_len=$(".chk_no:checked").length;
			
		if( chk_len<=0 ){
			alert('출력할 주문을 선택해주세요.');
			return;
		}

		if($("#excel_type").val()==''){

			alert('출력할 타입을 선택해주세요.');

			return;
        }
     
		$("#sel_excel_type").val($("#excel_type").val());

		$("#main_form").attr("action","order_outside_inout_excel.php");
		$("input[name='print_xls']").val("1");
		$("#main_form").submit();
		$("#main_form").attr("action","");
		$("input[name='print_xls']").val("");
	});
	
	$("#print_xls").click(function(){
		$("input[name='print_xls']").val("1");
		$("#compForm").submit();
		$("input[name='print_xls']").val("0");
	});

});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>