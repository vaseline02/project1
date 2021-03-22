<?php /* Template_ 2.2.8 2020/10/21 11:34:26 /www/html/ukk_test2/data/skin/cs/as_list.htm 000018907 */ 
$TPL__cfg_as_status_1=empty($GLOBALS["cfg_as_status"])||!is_array($GLOBALS["cfg_as_status"])?0:count($GLOBALS["cfg_as_status"]);
$TPL__cfg_ing_type_1=empty($GLOBALS["cfg_ing_type"])||!is_array($GLOBALS["cfg_ing_type"])?0:count($GLOBALS["cfg_ing_type"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<?php echo $this->define('tpl_include_file_1',"cs/as_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>


<style>
.search_td_width{width:380px;}
.mallLabel{ display:inline-block; width:200px; line-height:23px;}



</style>

<?php if($GLOBALS["print_xls"]!= 1){?>

<form enctype="multipart/form-data" method="post" onsubmit="return chkform();">
<input type="hidden" name="mode" value="as_ins">
<table class="table table-bordered" >
    <tr>
        <th>AS등록</th>
        <td>
			<input type="file" name="excelFile[]" required/><button class="btn btn-primary" >업로드</button>
			<button type="button" class="btn btn-success" onclick="location.href='../xls_file/as_upload2.xls'">양식 다운로드</button>
		</td>
    </tr>
</table>
</form>
<form method="get">
	<table class="table table-bordered" >

		<tr>
			<th>입고일</th>
			<td>
			<input type="text" name="s_date" id="s_date" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['s_date']?>"> ~ 
			<input type="text" name="e_date" id="e_date" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['e_date']?>">
			<div style='padding-top:5px'>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='0' data-type='day'>오늘</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='7' data-type='day'>7일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='15' data-type='day'>15일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='month'>1개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='month'>3개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='year'>1년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='year'>3년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='5' data-type='year'>5년</span>
			</div>
			</td>
			<th>출고일</th>
			<td>
			<input type="text" name="s_date2" id="s_date2" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['s_date2']?>"> ~ 
			<input type="text" name="e_date2" id="e_date2" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['e_date2']?>">
			<div style='padding-top:5px'>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='0' data-type='day' data-s_date_id='s_date2' data-e_date_id='e_date2'>오늘</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='7' data-type='day' data-s_date_id='s_date2' data-e_date_id='e_date2'>7일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='15' data-type='day' data-s_date_id='s_date2' data-e_date_id='e_date2'>15일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='month' data-s_date_id='s_date2' data-e_date_id='e_date2'>1개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='month' data-s_date_id='s_date2' data-e_date_id='e_date2'>3개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='year' data-s_date_id='s_date2' data-e_date_id='e_date2'>1년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='year' data-s_date_id='s_date2' data-e_date_id='e_date2'>3년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='5' data-type='year' data-s_date_id='s_date2' data-e_date_id='e_date2'>5년</span>
			</div>
			</td>
			
		</tr>
		<tr>			
			<th>모델명</th>
			<td><input type="text" name="s_goodsnm" value="<?php echo $_GET['s_goodsnm']?>"></td>
			<th>송장번호</th>
			<td><input type="text" name="s_invoice" value="<?php echo $_GET['s_invoice']?>"></td>
		</tr>
		<tr>
			
			<th>고객명</th>
			<td class="search_td_width"><input type="text" name="s_receiver" value="<?php echo $_GET['s_receiver']?>"></td>
			<th>연락처</th>
			<td class="search_td_width"><input type="text" name="s_mobile" value="<?php echo $_GET['s_mobile']?>"></td>
		</tr>
		</tr>
			<th>작성자</th>
			<td><input type="text" name="s_admin" value="<?php echo $_GET['s_admin']?>"></td>
			<input type="hidden" name="s_as_status" value="<?php echo $_GET['s_as_status']?>">
			<th>통합검색</th>
			<td>
				<input type="text" name="s_total" value="<?php echo $_GET['s_total']?>">
				<div>※브랜드 ,진행업체명, 수리내용, 과거주문번호</div>
			</td>
			<!-- <th>진행단계</th>
			<td>
				<select name="s_as_status">
					<option value="">선택</option>
<?php if($TPL__cfg_as_status_1){foreach($GLOBALS["cfg_as_status"] as $TPL_K1=>$TPL_V1){?>
					<option value=<?php echo $TPL_K1?> <?php echo $GLOBALS["selected"]['as_status'][$TPL_K1]?>><?php echo $TPL_K1?></option>
<?php }}?>
				</select>
			</td> -->

			<!-- <th>진행상태</th>
			<td>
				<select name="s_ing_type">
					<option value="">선택</option>
<?php if($TPL__cfg_ing_type_1){foreach($GLOBALS["cfg_ing_type"] as $TPL_K1=>$TPL_V1){?>
					<option value=<?php echo $TPL_K1?> <?php echo $GLOBALS["selected"]['ing_type'][$TPL_K1]?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</td>
			 -->
		</tr>
		<tr>
			
			<th>기타검색</th>
			<td>
				<label style="font-weight: normal;"><input type="checkbox" name="schedule_3" value="Y" <?php echo $GLOBALS["checked"]['schedule_3']['Y']?>> 3일이하 미처리건</label>
				<label style="font-weight: normal;"><input type="checkbox" name="s_delivery" value="Y" <?php echo $GLOBALS["checked"]['s_delivery']['Y']?>> 택배접수건</label>
			</td>
			<th>주문번호</th>
			<td><input type="text" name="s_ordno" value="<?php echo $_GET['s_ordno']?>"></td>
		</tr>
	</table>
<?php if($GLOBALS["leftCount"]){?><div style="color: red; font-weight: bold;">남은기간이 <?php echo $GLOBALS["leftNum"]?>일이하 완료안된 미처리건이 <?php echo $GLOBALS["leftCount"]?>개 있습니다.</div><?php }?>
	<center>
		<button class="btn btn-sm btn-primary" id="">검 색</button>
		<div class="btn btn-sm btn-warning" onclick="popup('send_sms.php?etc_code=as','','1100','900')">문자설정</div>
		<!--<div type="button" class="btn btn-sm btn-primary" onclick="popup('cs_receipt_reg.php','','1100','900')">상품접수</div>-->
		<div type="button" class="btn btn-sm btn-primary" onclick="popup('as_reg.php','as_reg','1100','900')">상품접수</div>
<?php if($_GET['s_as_status']=='5'){?><button type="button" class="btn btn-sm btn-success" id="as_print_xls">선택값 엑셀 다운로드</button><?php }?>
	</center>
</form>
<hr>
<?php if($_GET['s_as_status']=='5'){?>
<form enctype="multipart/form-data" method="post" onsubmit="return chkform();">
<input type="hidden" name="mode" value="invoice_mod">
<table class="table table-bordered" >
    <tr>
        <th>송장업로드</th>
        <td>
			<input type="file" name="excelFile[]" required/><button class="btn btn-primary" >업로드</button>
		</td>
    </tr>
</table>
</form>
<?php }?>
<?php }?>

<!-- <div class="table_title" >일반접수</div> -->
<form method="post" id="as_form" name="as_form">
	<input type="hidden" name="mode" value="send_sms">
	<input type="hidden" name="returnUrl" value=<?php echo $_SERVER['REQUEST_URI']?>>
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th data-orderable="false"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>			
			<th>접수번호</th>
			<th>접수자</th>
			<th data-orderable="false">구매자</th>
			<th data-orderable="false">연락처</th>
			<th data-orderable="false">주소</th>
			<th>진행단계</th>
			<th>구매처</th>
			<th data-orderable="false">주문번호</th>
			<th>브랜드</th>
			<th>모델명</th>
			<th>비용</th>
			<th>실비</th>
			<th>진행업체명</th>
			<th>입고일</th>
			<th>출고일</th>
			<th>최초작성자</th>
			<th>마지막수정자</th>
			<th>수정시간</th>
			<th>남은기간</th>
			<th data-orderable="false"></th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>			
			
			<td>				
				<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>" data-as_status="<?php echo $TPL_V1["as_status"]?>" data-address_check="<?php echo $TPL_V1["address_check"]?>" data-send_invoice="<?php echo $TPL_V1["send_invoice"]?>" data-send_delivery_code="<?php echo $TPL_V1["send_delivery_code"]?>">				
			</td>
			<td><?php echo str_pad($TPL_V1["no"], 7,"0",$TPL_VAR["STR_PAD_LEFT"])?></td>
			<td><?php echo $TPL_V1["receipt_name"]?></td>
			<td><?php echo $TPL_V1["receiver"]?></td>
			<td><?php echo $TPL_V1["mobile"]?></td>
			<td><?php if($TPL_V1["zipcode"]){?>[<?php echo $TPL_V1["zipcode"]?>]<?php }?> <?php echo $TPL_V1["address"]?></td>
			<td><?php echo $TPL_V1["as_status"]?></td>			
			<td><?php echo $TPL_V1["order_buy"]?></td>			
			<td><?php echo $TPL_V1["order_no"]?></td>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo number_format($TPL_V1["customer_cost"])?>원</td>
			<td><?php echo number_format($TPL_V1["real_cost"])?>원</td>
			<td><?php echo $TPL_V1["progress_company"]?></td>
			<td><?php echo $TPL_V1["in_regdate"]?></td>
			<td><?php echo $TPL_V1["out_regdate"]?></td>
			<td><?php if($TPL_V1["admin_no"]){?><?php echo $TPL_V1["name"]?><br>(<?php echo $TPL_V1["id"]?>)<?php }?></td>
			<td><?php if($TPL_V1["mod_admin_no"]){?><?php echo $TPL_V1["mod_name"]?><br>(<?php echo $TPL_V1["mod_id"]?>)<?php }?></td>
			<td><?php if($TPL_V1["mod_admin_no"]){?><?php echo $TPL_V1["mod_reg_date"]?><?php }?></td>
			<td><?php echo $TPL_V1["leftDate"]?><?php if($TPL_V1["leftDate"]!='미등록'){?>일<?php }?></td>
			<td>
				<div><button type="button" class="btn btn-sm btn-warning" onclick="popup('as_reg.php?as_no=<?php echo $TPL_V1["no"]?>','','1100','900')">수정</button></div>
<?php if($TPL_V1["as_status"]=='6'){?>
				<div style="padding-top: 5px;"><button type="button" class="btn btn-sm btn-warning" onclick="popup('as_document.php?as_no=<?php echo $TPL_V1["no"]?>','','1100','900')">문서출력</button></div>
<?php }?>
				<!-- <div style="padding-top:5px;"><button type="button" class="btn btn-sm btn-danger receiptDel" data-no=<?php echo $TPL_V1["receipt_no"]?>>삭제</button></div> -->
			</td>
			
		</tr>
<?php }}?>
	</tbody>
</table>


<div class="bottom_btn_box">
	<div class="box_left">
<?php if($_GET['s_as_status']>='0'&&$_GET['s_as_status']<='4'){?>
		<button type="button" class="btn btn-sm btn-danger checkForm" data-mode='as_del'>삭제</button>
<?php }?>
	</div>
	<div  class="box_right">
<?php if($_GET['s_as_status']=='5'){?>
		<select name="as_status">

			<option value='6'>6</option>
		</select>
		<div class="btn btn-sm btn-primary checkForm" data-mode='step_change'>단계이동</div>
<?php }?>
<?php if($_GET['s_as_status']!='0'){?>
		<div class="btn btn-sm btn-warning checkForm" data-mode='send_sms'>문자발송</div>
<?php }?>
	</div>
</div>

</form>
<!-- <hr>
<div class="table_title">수기접수</div>
<form method="post" id="hand_as_form" name="hand_as_form">
	<input type="hidden" name="mode" value="send_sms">
	<input type="hidden" name="returnUrl" value=<?php echo $_SERVER['REQUEST_URI']?>>
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th data-orderable="false"><input type="checkbox" onclick="chk_all_box(this,'hand_chk_no')"></th>			
			<th>접수번호</th>
			<th>접수자</th>
			<th data-orderable="false">구매자</th>
			<th data-orderable="false">연락처</th>
			<th data-orderable="false">주소</th>
			<th>진행단계</th>
			<th data-orderable="false">주문번호</th>
			<th>브랜드</th>
			<th>모델명</th>
			<th>비용</th>
			<th>실비</th>
			<th>진행업체명</th>
			<th>입고일</th>
			<th>출고일</th>
			<th>최초작성자</th>
			<th>마지막수정자</th>
			<th>수정시간</th>
			<th>남은기간</th>
			<th data-orderable="false"></th>
		</tr>
	</thead>	
	<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["loop"]['hand'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<tr>			
			<td>
<?php if($TPL_V1["as_status"]){?>
				<input type="checkbox" class="hand_chk_no" name="hand_chk_no[]" value="<?php echo $TPL_V1["no"]?>">
<?php }?>
			</td>
			<td><?php echo $TPL_V1["no"]?></td>
			<td><?php echo $TPL_V1["receipt_name"]?></td>
			<td><?php echo $TPL_V1["receiver"]?></td>
			<td><?php echo $TPL_V1["mobile"]?></td>
			<td><?php if($TPL_V1["zipcode"]){?>[<?php echo $TPL_V1["zipcode"]?>]<?php }?> <?php echo $TPL_V1["address"]?></td>
			<td><?php echo $TPL_V1["as_status"]?></td>			
			<td><?php echo $TPL_V1["order_no"]?></td>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo number_format($TPL_V1["customer_cost"])?>원</td>
			<td><?php echo number_format($TPL_V1["real_cost"])?>원</td>
			<td><?php echo $TPL_V1["progress_company"]?></td>
			<td><?php echo $TPL_V1["in_regdate"]?></td>
			<td><?php echo $TPL_V1["out_regdate"]?></td>
			<td><?php if($TPL_V1["admin_no"]){?><?php echo $TPL_V1["name"]?><br>(<?php echo $TPL_V1["id"]?>)<?php }?></td>
			<td><?php if($TPL_V1["mod_admin_no"]){?><?php echo $TPL_V1["mod_name"]?><br>(<?php echo $TPL_V1["mod_id"]?>)<?php }?></td>
			<td><?php if($TPL_V1["mod_admin_no"]){?><?php echo $TPL_V1["mod_reg_date"]?><?php }?></td>
			<td><?php echo $TPL_V1["leftDate"]?><?php if($TPL_V1["leftDate"]!='미등록'){?>일<?php }?></td>
			<td>
				<div><button type="button" class="btn btn-sm btn-warning" onclick="popup('as_reg.php?as_no=<?php echo $TPL_V1["no"]?>','','1100','900')">수정</button></div>
<?php if($TPL_V1["as_status"]=='6'){?>
				<div style="padding-top: 5px;"><button type="button" class="btn btn-sm btn-warning" onclick="popup('as_document.php?as_no=<?php echo $TPL_V1["no"]?>','','1100','900')">문서출력</button></div>
<?php }?>
            </td>
		</tr>
<?php }}?>
	</tbody>
</table>
<div style="text-align: right;">
	<div class="btn btn-sm btn-warning checkForm" data-mode='hand_as'>문자발송</div>
</div>
</form> -->
<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<?php }?>

<form method="POST" name="indbForm">
	<input type="hidden" name="mode" value="del">
	<input type="hidden" name="no">
	<input type="hidden" name="returnUrl" value=<?php echo $_SERVER['REQUEST_URI']?>>
</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";
$("#nav_div<?php echo $_GET['s_as_status']?>").addClass('active');

$(".receiptDel").click(function(){
	if(confirm("삭제하시겠습니까?")){
		$("input[name='no']").val($(this).data('no'));
		$("form[name='indbForm']").submit();	
	}

});


$(".checkForm").click(function(){
	var mode=$(this).data("mode");
	var mess="";
	var status_check=0;
	var address_check=0;
	var delivery_check=0;

	if(!$(".chk_no").is(":checked")){
		alert("처리할 접수건이 선택되있지않습니다.");
		return false;
	}
	if(mode=='send_sms'){
		$(".chk_no").each(function(index, item){
			if($(item).is(":checked")){                  
				if($(this).data("as_status")=='0'){
					 status_check++;
				}
			}
		});

		if(status_check){
			alert("0단계의 접수건은 발송할수없습니다.");
			return false;
		}

		mess="[문자발송]";
	}else if(mode=='step_change'){
		if(!$("select[name='as_status']").val()){
			alert("변경할 단계가 선택되있지않습니다.");
			return false;
		}

		$(".chk_no").each(function(index, item){
			if($(item).is(":checked")){                  
				if($(this).data("address_check")=='1'){
					 address_check++;
				}

				if(!$(this).data("send_invoice") && $(this).data("send_delivery_code")!='DIRECT'){
					 delivery_check++;
				}				
			}
		});

		if($("select[name='as_status']").val()=='6'){
			if(address_check){
				alert("주소확인이 필요한 접수건이 있습니다.");
				return false;
			}

			if(delivery_check){
				alert("출고택배정보를 입력하지않은 접수건이 있습니다.");
				return false;
			}
		}


		mess="[단계변경]";
	}
	else if(mode=='as_del'){		
		mess="[삭제]";
	}

	if(confirm(mess+"처리하시겠습니까?")){
		$('#as_form [name="mode"]').val(mode);
		$("#as_form").submit();
	}
	
	// //일반접수
	// if(mode=='as'){
	// 	if(!$(".chk_no").is(":checked")){
	// 		alert("문자를 발송할 [일반접수]건이 선택되있지않습니다.");
	// 		return false;
	// 	}
	// 	if(confirm("문자를 발송하시겠습니까?")){
	// 		$("#as_form").submit();
	// 	}

	// 	//수기접수
	// }else if(mode=='hand_as'){
	// 	if(!$(".hand_chk_no").is(":checked")){
	// 		alert("문자를 발송할 [수기접수]건이 선택되있지않습니다.");
	// 		return false;
	// 	}
	// 	if(confirm("문자를 발송하시겠습니까?")){
	// 		$("#hand_as_form").submit();
	// 	}
	// }

});

/*인클루드 되어있는 페이지의 체크박스 값을 가지고 넘어가야 하기때문에 메인폼을 포스트로 날림.*/ 
$("#as_print_xls").click(function(){
		
	var file_loc='';
	
	file_loc="as_list_excel.php";	

	var chk_len=$(".chk_no:checked").length;
	if( chk_len<=0 ){
		alert('출력할 주문을 선택해주세요.');
		return false;
	}else{		
		var html='<div id="div_excel_search_val">';
		html+='<input type="hidden" name="print_xls" value="1" >';
		html+='</div>';	
		$("#as_form").append(html);
		
		$("#as_form").attr("action",file_loc);
		$("#as_form").submit();
		$("#as_form").attr("action","");
		$("#div_excel_search_val").remove();
	}

});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>