<?php /* Template_ 2.2.8 2020/09/28 14:49:58 /www/html/ukk_test/data/skin/cs/cs_receipt.htm 000013699 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<!-- Main Contents -->
<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
	<div class="col-lg-12">
	<!--
		<form enctype="multipart/form-data" method="post" onsubmit="return chkform();">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small" >
				<tr>
					<th scope="row">반송장등록</th>
					<td>
						<input type="file" name="excelFile[]" required/><button class="btn btn-primary" >업로드</button>
						
					</td>
				</tr>
			</table>
		</div>
		</form>
	-->
		<form method="get">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="10%" />
					<col width="25%" />
					<col width="10%" />
					<col width="25%" />
					<col width="10%" />
					<col width="25%" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row">접수일자</th>
						<td colspan="3" class="receive-title no-gutters">
							
							<div class="col-lg-4 btn-group-sm" role="group" aria-label="Small button group">
								<button type="button" class="btn btn-default dayChange" data-int='0' data-type='day'>오늘</button>
								<button type="button" class="btn btn-default dayChange" data-int='7' data-type='day'>3일</button>
								<button type="button" class="btn btn-default dayChange" data-int='15' data-type='day'>7일</button>
								<button type="button" class="btn btn-default dayChange" data-int='1' data-type='month'>1개월</button>
								<button type="button" class="btn btn-default dayChange" data-int='3' data-type='month'>3개월</button>
								<button type="button" class="btn btn-default dayChange" data-int='1' data-type='year'>1년</button>
								<!-- <button type="button" class="btn btn-primary">전체</button> -->
							</div>
							<div class="col-md-2 date-wrap">
								<div class="input-group">
									<input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="s_date" id="s_date" value="<?php echo $GLOBALS["s_date_value"]?>" readonly />
									<span class="input-group-btn">
										<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="s_date"><span class="glyphicon glyphicon-list-alt"></span></button>
									</span>
								</div>
							</div>
							
							<p class="date-tilde">~</p>
							<div class="col-md-2 date-wrap">
								<div class="input-group">
									<input type="text" class="form-control datepicker_common" placeholder="종료 날짜" aria-describedby="basic-addon2" name="e_date" id="e_date" value="<?php echo $GLOBALS["e_date_value"]?>" readonly />
									<span class="input-group-btn">
										<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="e_date"><span class="glyphicon glyphicon-list-alt"></span></button>
									</span>
								</div>										
							</div>							
						</td>
						<th scope="row" rowspan="5">반송장접수<br><br><button type="button" class="btn btn-primary return_invoice_button" id="">접수확인</button></th>
						<td rowspan="5" class="receive-title no-gutters">
							<textarea class="form-control" name="return_invoice" style="height:200px;"></textarea>
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">모델명</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_mall_goodsnm" value="<?php echo $_GET['s_mall_goodsnm']?>"></div>
						</td>
						<th scope="row" class="align-left">송장번호</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_invoice" value="<?php echo $_GET['s_invoice']?>"></div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">고객명</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_receiver" value="<?php echo $_GET['s_receiver']?>"></div>
						</td>
						<th scope="row" class="align-left">주문번호</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_ordno" value="<?php echo $_GET['s_ordno']?>"></div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">작성자</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_admin" value="<?php echo $_GET['s_admin']?>"></div>
						</td>
						<th scope="row" class="align-left">연락처</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_mobile" value="<?php echo $_GET['s_mobile']?>"></div>
						</td>
					</tr>
					<!--
					<tr>
						<th scope="row" class="align-left">기타</th>
						<td class="receive-title no-gutters" style="height:45px;">
							<div class="col-xs-12"><label style="font-weight: normal;"><input type="checkbox" name="not_add" value='Y' <?php echo $GLOBALS["checked"]['not_add']['Y']?>>미처리건 검색</label></div>
						</td>
						<th scope="row" class="align-left"></th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"></div>
						</td>
					</tr>-->
				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<button class="btn btn-primary" id="">검 색</button>
			<div type="button" class="btn btn-primary" onclick="popup('cs_receipt_reg.php','','1100','900')">상품접수</div>
		</div>
		</form>
	</div>			
</div>
<?php }?>

<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format(count($TPL_VAR["loop"][ 0]))?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색">
							<span class="input-group-btn"><button class="btn btn-primary" type="button">검색</button></span> -->
						</div>
					</div>
				</caption>
				<colgroup>
					<col width="10%" />
					<col width="13%" />
					<col width="5%" />
					<col />
					<col width="8%" />
					<col width="8%" />
					<col width="8%" />
					<col width="8%" />
					<col width="8%" />
					<col width="5%" />
					<col width="1%" />
				</colgroup>
				<thead>
					<th>몰명</th>
					<th>주문번호</th>
					<th>이미지</th>
					<th>옵션명</th>
					<th>구매자<br>수령자</th>
					<th>연락처<br>모바일</th>
					<th>주문일자</th>
					<th>작성자</th>
					<th>접수일자</th>
					<th>접수유형</th>
					<!-- <th>진행상태</th> -->
					<th></th>
				</thead>
				<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["loop"][ 0])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<tr class="<?php echo $TPL_V1["line_color"]?>">			
						<td><?php echo $TPL_V1["mall_name"]?></td>
						<td><?php echo $TPL_V1["ordno"]?> <?php if($TPL_V1["copy_seq"]> 0){?>복사본<?php }?></td>
						<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
						<td><?php echo $TPL_V1["goodsnm"]?></td>
						<td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>
						<td><?php echo $TPL_V1["buyer_mobile"]?><br/><?php echo $TPL_V1["mobile"]?></td>
						<td><?php echo $TPL_V1["reg_date"]?></td>
						<td><?php if($TPL_V1["admin_no"]){?><?php echo $TPL_V1["name"]?><br>(<?php echo $TPL_V1["id"]?>)<?php }?></td>
						<td><?php echo $TPL_V1["cs_reg_date"]?></td>
						<td><?php echo $GLOBALS["cfg_receipt_type"][$TPL_V1["return_type"]]?></td>
						<!-- <td><?php if($TPL_V1["status"]=='0'){?>접수<?php }else{?>접수완료<?php }?></td> -->
						<td>
<?php if(!$TPL_V1["receipt_count"]){?>
								<!-- as접수건 -->
<?php if($TPL_V1["return_type"]=='3'){?>
								<div><button type="button" class="btn btn-sm btn-warning" onclick="popup('as_reg.php?receipt_no=<?php echo $TPL_V1["receipt_no"]?>&order_list_no=<?php echo $TPL_V1["order_list_no"]?>&order_seq=<?php echo $TPL_V1["no"]?>','','1100','900')">AS등록</button></div>
								<!-- 미확인건제외 -->
<?php }elseif($TPL_V1["return_type"]!='4'){?>
								<div><button type="button" class="btn btn-sm btn-warning" onclick="popup('cs_reg.php?ordno=<?php echo $TPL_V1["ordno"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>&receipt_no=<?php echo $TPL_V1["receipt_no"]?>&order_list_no=<?php echo $TPL_V1["order_list_no"]?>&order_seq=<?php echo $TPL_V1["no"]?>','cs_receipt_pop','1100','900')">CS등록</button></div>
<?php }?>	
<?php }?>			
							<div style="padding-top:5px;"><button type="button" class="btn btn-sm btn-warning" onclick="popup('cs_receipt_reg.php?receipt_no=<?php echo $TPL_V1["receipt_no"]?>','','1100','900')">수정</button></div>
<?php if(!$TPL_V1["mod_admin_no"]){?><div style="padding-top:5px;"><button type="button" class="btn btn-sm btn-danger receiptDel" data-no=<?php echo $TPL_V1["receipt_no"]?>>삭제</button></div><?php }?>
						</td>
					</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div style="height:50px;"></div>

<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format(count($TPL_VAR["loop"][ 1]))?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색">
							<span class="input-group-btn"><button class="btn btn-primary" type="button">검색</button></span> -->
						</div>
					</div>
				</caption>
				<colgroup>
					<col width="8%" />
					<col width="8%" />
					<col width="8%" />
					<col />
					<col width="8%" />
					<col width="8%" />
					<col width="8%" />
					<col width="8%" />
					<col width="5%" />
					<col width="1%" />
				</colgroup>
				<thead>						
					<th>상품명</th>
					<th>이름</th>
					<th>전화번호</th>
					<th>메모</th>
					<th>송장번호</th>
					<th>계좌번호</th>
					<th>작성자</th>
					<th>접수일자</th>
					<th>접수유형</th>
					<th></th>		
				</thead>
				<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["loop"][ 1])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<tr class="<?php echo $TPL_V1["line_color"]?>">			
						<td><?php echo $TPL_V1["cs_goodsnm"]?></td>
						<td><?php echo $TPL_V1["customer_name"]?></td>
						<td><?php echo $TPL_V1["cs_mobile"]?></td>
						<td><?php echo $TPL_V1["cs_memo"]?></td>
						<td><?php echo $TPL_VAR["delivery_list"][$TPL_V1["cs_delivery_code"]]['name']?><div><?php echo $TPL_V1["cs_invoice"]?></div></td>
						<td><?php echo $GLOBALS["cfg_account_code"][$TPL_V1["cs_account_code"]]?><div><?php echo $TPL_V1["cs_account_number"]?></div></td>
						<td><?php if($TPL_V1["admin_no"]){?><?php echo $TPL_V1["name"]?><br>(<?php echo $TPL_V1["id"]?>)<?php }?></td>
						<td><?php echo $TPL_V1["cs_reg_date"]?></td>			
						<td><?php echo $GLOBALS["cfg_receipt_type"][$TPL_V1["return_type"]]?></td>
						<!-- <td><?php if($TPL_V1["status"]=='0'){?>접수<?php }else{?>접수완료<?php }?></td> -->
						<td>
<?php if(!$TPL_V1["receipt_count"]&&$TPL_V1["return_type"]=='3'){?>
								<div><button type="button" class="btn btn-sm btn-warning" onclick="popup('as_reg.php?receipt_no=<?php echo $TPL_V1["receipt_no"]?>','','1100','900')">AS등록</button></div>
<?php }?>	
							
							<div style="padding-top:5px;"><button type="button" class="btn btn-sm btn-warning" onclick="popup('cs_receipt_reg.php?receipt_no=<?php echo $TPL_V1["receipt_no"]?>','','1100','900')">수정</button></div>
<?php if(!$TPL_V1["mod_admin_no"]){?><div style="padding-top:5px;"><button type="button" class="btn btn-sm btn-danger receiptDel" data-no=<?php echo $TPL_V1["receipt_no"]?>>삭제</button></div><?php }?>
						</td>
					</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<form method="POST" name="indbForm">
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="no">
	<input type="hidden" name="returnInvoice">
	<input type="hidden" name="returnUrl" value=<?php echo $_SERVER['REQUEST_URI']?>>
</form>
<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".receiptDel").click(function(){
	if(confirm("삭제하시겠습니까?")){
		$("input[name='mode']").val("del");
		$("input[name='no']").val($(this).data('no'));
		$("form[name='indbForm']").submit();	
	}
});

$(".return_invoice_button").click(function(){

	if(!$("textarea[name='return_invoice']").val()){
		alert("반송장접수번호를 입력해주세요.");
		return false;
	}
	if(confirm("등록하시겠습니까?")){
		$("input[name='mode']").val("cs_ins");
		$("input[name='returnInvoice']").val($("textarea[name='return_invoice']").val());
		$("form[name='indbForm']").submit();	
	}
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>