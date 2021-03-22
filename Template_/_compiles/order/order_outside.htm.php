<?php /* Template_ 2.2.8 2020/10/07 09:16:41 /www/html/ukk_test2/data/skin/order/order_outside.htm 000010667 */ 
$TPL__invo_upload_mall_1=empty($GLOBALS["invo_upload_mall"])||!is_array($GLOBALS["invo_upload_mall"])?0:count($GLOBALS["invo_upload_mall"]);
$TPL__delivery_list_1=empty($GLOBALS["delivery_list"])||!is_array($GLOBALS["delivery_list"])?0:count($GLOBALS["delivery_list"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>
<?php if($GLOBALS["nav_view"]){?>
<?php echo $this->define('tpl_include_file_1',"order/order_nav2.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<?php }else{?>
<?php echo $this->define('tpl_include_file_2',"order/order_nav.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

<?php }?>
<style>
#nav_div8 a:after{width:90%}
.oinput{width:220px;}
</style>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form enctype="multipart/form-data" method="post">
<table class="table table-bordered" >
    <tr>
        <th>송장등록</th>
        <td>
			<input type="file" name="excelFile[]" required/><button class="btn btn-primary">업데이트</button>
			<button type="button" class="btn btn-success" id="print_xls">양식 다운로드</button>
		</td>
		<td >
			<select id="invo_mall">
				<option value="">선택</option>
<?php if($TPL__invo_upload_mall_1){foreach($GLOBALS["invo_upload_mall"] as $TPL_V1){?>
				<option ><?php echo $TPL_V1?></option>
<?php }}?>
			</select>
			<button type="button" class="btn btn-sm btn-success" id="invo_download">송장다운로드</button>
		</td>
		<th>택배사명 참고</th>
		<td>
			<select>
<?php if($TPL__delivery_list_1){foreach($GLOBALS["delivery_list"] as $TPL_V1){?>
				<option><?php echo $TPL_V1["name"]?></option>
<?php }}?>
			</select>
		</td>
    </tr>
</table>
</form>
<?php }?>

<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode">
<input type="hidden" name="sel_invo_mall" id="sel_invo_mall">
<input type="hidden"name="print_xls" value="">
<!--<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->

<table id="" class="display_xscroll display nowrap" data-height="740" style="width:100%;" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>
			<th></th>
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
				<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>">
				<input type="hidden" name="hid_invoice[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["invoice"]?>">
			</td>
			
			<td>
				<button type="button" class="btn btn-sm btn-warning mod" onclick="popup('order_mod_pop.php?no=<?php echo $TPL_V1["no"]?>&model_chk=n','order_mod_pop','1000','700')">수정</button>
				<button type="button" class="btn btn-sm btn-warning" onclick="popup('../cs/cs_reg.php?ordno=<?php echo $TPL_V1["ordno"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>&order_seq=<?php echo $TPL_V1["no"]?>&order_memo_add=1','','1100','900')">CS등록</button>
			</td>
<?php }?>
			<td><?php echo $TPL_V1["c_mem_name"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td><?php echo $TPL_V1["mod_date"]?></td>
			<td>
				<input type="text" name="mod_brand[<?php echo $TPL_V1["no"]?>]" id="" class="brand_check oinput" data-no="<?php echo $TPL_V1["no"]?>" value="<?php echo $TPL_V1["brandnm"]?>">
				<div class="brand_notice_<?php echo $TPL_V1["no"]?> brand_notice" style="color: red;"></div>
			</td>

			<td>
				<input type="text" name="mod_goodsnm[<?php echo $TPL_V1["no"]?>]" id="" class="oinput" data-no="<?php echo $TPL_V1["no"]?>" value="<?php echo $TPL_V1["goodsnm"]?>">
				<div class="model_notice_<?php echo $TPL_V1["no"]?>" style="color: red;"></div>
			</td>
			<td><?php echo $TPL_V1["order_num"]?></td>
			<td><?php echo $TPL_V1["consumer_price"]?></td>
			<td><?php echo $TPL_V1["purchase_price"]?></td>
			<td><?php echo $TPL_V1["ent_deli_price"]?></td>
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
			<td><?php echo $TPL_V1["invoice"]?></td>
			<td><?php echo $TPL_V1["d_name"]?></td>
			<td><?php echo $TPL_V1["d_code"]?></td>			
			<td><?php echo $TPL_V1["no"]?></td>			
		</tr>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">
		<button type="button" class="btn btn-primary btn_submit" id="info_chg">정보 변경</button>
		<!--<button type="button" class="btn btn-primary btn_submit" id="goodsnm_chg">상품명 변경</button>-->
<?php if(!$GLOBALS["nav_view"]){?>
		<button type="button" class="btn btn-warning btn_submit" id="goback">모델명 매칭으로 이동</button>
		<button type="button" class="btn btn-danger btn_submit" id="hold_order">보류이동</button>
<?php }?>
		<button type="button" class="btn btn-danger btn_submit" id="cancel">주문취소</button>
	</div>
	<div  class="box_right">
		<button type="button" class="btn btn-primary btn_submit" id="order_comp">주문처리완료</button>
	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li>페이지 기능 발주팀과 회의필요</li>
  </ul>
</fieldset>

<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$("#nav_div6").addClass('active');

function brandNmin(no, brandnm){
	$("input[name='mod_brand["+no+"]']").val(brandnm);

}
$(function(){
	
	$(".brand_check").keyup(function (){
		var no=$(this).data('no');
		var brandName=$(this).val();
		var noticeValue="";

		//$('.brand_notice_'+no).remove();
		
		$.ajax({
            url: "./chk_brand.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: "brand_name="+brandName,
            success: function(data){
				$('.brand_notice').empty();
				$(data).each(function(index, item){
					noticeValue+="<div><a href=\"javascript:brandNmin("+no+",'"+item+"')\" style='color: red;'>"+item+"</a></div>";

				});
				$('.brand_notice_'+no).append(noticeValue);
//				$(".brand_notice_"+no).text(noticeValue);

				/*
				if(data=='N'){
					$(".brand_notice_"+no).text('브랜드가 존재하지않습니다.');
				}else{
					$(".brand_notice_"+no).text('');
				}
				*/
            },
            error: function (request, status, error){        
                console.log(error);
            }
		});
	});
	
	$(".btn_submit").click(function(){
		
		var this_id = $(this).attr("id");
		var msg='';

		if( $(".chk_no:checked").length <=0 ){
			alert('주문을 선택해주세요.');
			return;
		}
		
		if(this_id=='goback'){
			msg='[단계 1로 이동]';
		}else if(this_id=='goodsnm_chg'){
			msg='[상품명변경]';
		}else if(this_id=='cancel'){
			msg='[주문취소]';
		}else if(this_id=='hold_order'){
			msg='[보류이동]';
		}else if(this_id=='order_comp'){
			msg='[주문처리완료]';
		}else if(this_id=='info_chg'){
			msg='[정보변경]';
		}


		if(confirm(msg+'처리하시겠습니까?')){
			
			$("#mode").val(this_id);
			$("#main_form").submit();
		}
		
	});

	/*인클루드 되어있는 페이지의 체크박스 값을 가지고 넘어가야 하기때문에 메인폼을 포스트로 날림.*/ 
	$("#print_xls").click(function(){
		
		var file_loc='order_outside_excel.php';

		var chk_len=$(".chk_no:checked").length;
		if( chk_len<=0 ){
			alert('출력할 주문을 선택해주세요.');
			return false;
		}else{			
			var html='<div id="div_excel_search_val">';
			html+='<input type="hidden" name="print_xls" value="1" >';
			html+='</div>';	
			$("#main_form").append(html);

			$("#main_form").attr("action",file_loc);
			$("#main_form").submit();
			$("#main_form").attr("action","");
			$("#div_excel_search_val").remove();
		}
	
	});

	
	$("#invo_download").click(function(){

		var chk_len=$(".chk_no:checked").length;
			
		if( chk_len<=0 ){
			alert('출력할 주문을 선택해주세요.');
			return;
		}

		if($("#invo_mall").val()==''){

			alert('출력할 몰을 선택해주세요.');

			return;
		}
		$("#sel_invo_mall").val($("#invo_mall").val());

		

		$("#main_form").attr("action","mall_invoice_excel.php");
		$("input[name='print_xls']").val("1");
		$("#main_form").submit();
		$("#main_form").attr("action","");
		$("input[name='print_xls']").val("");
	});


});
$('table.display_xscroll').dataTable( {
	"aoColumnDefs": [{ 'bSortable': false, 'aTargets': ["sorting_disabled"] }],
	"scrollCollapse": true,
	"paging":   false,
	"scrollY": "800px",
    "scrollX": true,
	"order": []
} );

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>