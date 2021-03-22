<?php /* Template_ 2.2.8 2020/12/24 14:03:16 /www/html/ukk_test2/data/skin/order/order_comp2.htm 000010363 */ 
$TPL__arr_mall_1=empty($GLOBALS["arr_mall"])||!is_array($GLOBALS["arr_mall"])?0:count($GLOBALS["arr_mall"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<?php if($GLOBALS["print_xls"]!= 1){?>
<form method="get" name="searchForm" id="searchForm">
    <input type="hidden" name="print_xls">
	<input type="hidden" name="xls_type" id="xls_type">
<!-- Main Contents -->
<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
	<div class="col-lg-12">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="15%" />
					<col width="85%" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row">주문일자</th>
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
							<script>
								
							</script>
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">검색</th>
						<td class="receive-title no-gutters">
							<input type="text" name="chasu" id="chasu" value="<?php echo $_GET["chasu"]?>" placeholder=" 차수설정 " size=10 style="margin-right:10px;">
							<select name="s_mall" id="s_mall">
                                <option value="">== 몰선택 ===</option>
<?php if($TPL__arr_mall_1){foreach($GLOBALS["arr_mall"] as $TPL_K1=>$TPL_V1){?>
                                <option value=<?php echo $TPL_K1?> <?php echo $GLOBALS["selected"]['s_mall'][$TPL_K1]?>><?php echo $TPL_K1?></option>
<?php }}?>
                            </select>
							
							<input type="checkbox" name="deli_comp" value="1">배송된 주문만
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">주문번호검색</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_ordno" id="s_ordno"" value="<?php echo $_GET['s_ordno']?>"/></div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">모델명검색</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control"  name="goodsnm" id="goodsnm" value="<?php echo $_GET["goodsnm"]?>" >	</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<button class="btn btn-primary">검색</button>
            <button class="btn btn-default" onclick="location.href ='order_comp2.php'; return false;">초기화</button>
		</div>
	</div>			
</div>
</form>

<?php }?>


<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table" border="<?php echo $GLOBALS["xls_border"]?>">
<?php if($GLOBALS["print_xls"]!= 1){?>
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
                        <span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
                        
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색">
                            <span class="input-group-btn"><button class="btn btn-primary" type="button">검색</button></span> -->
							
							
							<div class="col-xs-12 common-table-def" style="width:100%">
								<input type="checkbox" id="excel_type_soldout" > 미발송건만
							</div>
                            <span class="input-group-btn">
								
                                <button class="btn btn-success" type="button" id="print_xls">엑셀 다운로드</button>
                            </span>
						</div>
					</div>
                </caption>
<?php }?>
				<colgroup>
					<col width="8%" />
<?php if($GLOBALS["print_xls"]!= 1){?>
					<col width="3%" />
					<col width="5%" />
<?php }?>
					<col width="5%" />
					<col width="2%" />
					<col width="3%" />
					<col width="3%" />
					<col width="8%" />
					<col width="5%" />
					<col width="5%" />
					<col width="4%" />
					<col width="4%" />
					<col width="4%" />
					<col />
					<col width="5%" />
					<col width="5%" />
					<col width="4%" />
					<col width="4%" />
					<col width="5%" />
                    <col width="5%" />
<?php if($GLOBALS["print_xls"]!= 1){?>
                    <col width="5%" />
<?php }?>
				</colgroup>
				<thead>
					<tr>
						<th>주문번호</th>
<?php if($GLOBALS["print_xls"]!= 1){?>
						<th>차수</th>
						<th>wms주문번호</th>
<?php }?>
						<th>판매처</th>
						<th>임의필드</th>
						<th>수취인명</th>
						<th>우편번호</th>
						<th>주소</th>
						<th>수취인연락처</th>
						<th>수취인핸드폰</th>
						<th>운임구분</th>
						<th>사방넷주문번호</th>
						<th>주문수량</th>
						<th>주문메모</th>
						<th>상품명</th>
						<th>옵션명</th>
						<th>주문총금액</th>
						<th>발송인</th>
						<th>주문품목</th>
                        <th>송장번호</th>
<?php if($GLOBALS["print_xls"]!= 1){?>
                        <th>진행상태</th>
<?php }?>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr <?php echo $TPL_V1["color"]?>>			
							<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?>
							<td style='mso-number-format:"\@";'><?php echo $TPL_V1["cha_su"]?></td>
							<td style='mso-number-format:"\@";'><?php echo $TPL_V1["wms_ordno"]?></td>
<?php }?>
							<td><?php echo $TPL_V1["ent_name"]?></td>
							<td></td>
							<td><?php echo $TPL_V1["receiver"]?></td>
							<td style='mso-number-format:"\@";'><?php echo $TPL_V1["zipcode"]?></td>
							<td><?php echo $TPL_V1["address"]?></td>
							<td><?php echo $TPL_V1["buyer_mobile"]?></td>
							<td><?php echo $TPL_V1["mobile"]?></td>
							<td><?php echo $TPL_V1["deli_type"]?></td>
							<td><?php echo $TPL_V1["code1"]?></td>
							<td><?php echo $TPL_V1["order_num"]?></td>
							<td><?php echo $TPL_V1["order_memo"]?></td>
							<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
                            <td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?>
                            <td><?php echo number_format($TPL_V1["settle_price"])?>원</td>
<?php }else{?>
                            <td><?php echo $TPL_V1["settle_price"]?></td>
<?php }?>
                            <td></td>
                            <td><?php echo $TPL_V1["mall_key"]?></td>
                            <!-- <?php if($GLOBALS["print_xls"]!= 1){?>
                            <td><?php if($TPL_V1["courier_code"]){?><?php echo $TPL_V1["delivery_name"]?><br><?php echo $TPL_V1["invoice"]?><?php }?></td>
<?php }else{?>
                            <td><?php if($TPL_V1["courier_code"]){?><?php echo $TPL_V1["delivery_name"]?> <?php echo $TPL_V1["invoice"]?><?php }?></td>
<?php }?> -->
                            <td style='mso-number-format:"\@";'><?php echo $TPL_V1["position"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?>
							<td>
                                <?php echo $TPL_V1["step_lv"]?>

                            </td>
<?php }?>
						</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?></div>
<?php }?>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$("#print_xls").click(function(){

	var excel_type=$("#s_mall").val();
	
	$("#searchForm").attr("action","order_comp2_excel2.php");

	if($("#excel_type_soldout").is(":checked")) $("#xls_type").val('1');
	else $("#xls_type").val('0');
	
	
	$("input[name='print_xls']").val("1");
	$("#searchForm").submit();
	$("input[name='print_xls']").val("0");
	$("#searchForm").attr("action","");

	
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>