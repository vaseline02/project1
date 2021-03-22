<?php /* Template_ 2.2.8 2020/09/23 15:34:14 /www/html/ukk_test2/data/skin/sales/sales_brand_list.htm 000008181 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div class="row"><div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div></div>
<?php }?>


<?php if($GLOBALS["print_xls"]!= 1){?>
<!-- Main Contents -->
<div class="row">

	<div class="col-lg-12">
		<form method="get">
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
						<th scope="row">주문일자</th>
						<td colspan="3" class="receive-title no-gutters">
							
							<div class="col-lg-4 btn-group-sm" role="group" aria-label="Small button group">
								<button type="button" class="btn btn-default dayChange" data-int='0' data-type='day'>오늘</button>
								<button type="button" class="btn btn-default dayChange" data-int='1' data-type='day'>어제</button>
								<button type="button" class="btn btn-default dayChange" data-int='7' data-type='day'>7일</button>
								<button type="button" class="btn btn-default dayChange" data-int='0' data-type='month_unit'>당월</button>
								<button type="button" class="btn btn-default dayChange" data-int='1' data-type='month_unit'>전월</button>
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
						<th scope="row">브랜드</th>
						<td class="receive-title no-gutters">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" id="type" value="" name="type" <?php echo $GLOBALS["checked"]['type']['']?>>
								<label class="form-check-label" for="type">전체</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" id="type_A" value="A" name="type" <?php echo $GLOBALS["checked"]['type']['A']?>>
								<label class="form-check-label" for="type_A">공통</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" id="type_I" value="I" name="type" <?php echo $GLOBALS["checked"]['type']['I']?>>
								<label class="form-check-label" for="type_I">내부</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" id="type_O" value="O" name="type" <?php echo $GLOBALS["checked"]['type']['O']?>>
								<label class="form-check-label" for="type_O">외부</label>
							</div>
                        </td>
                        <th scope="row">판매처</th>
						<td class="receive-title no-gutters">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" id="order_type" value="" name="order_type" <?php echo $GLOBALS["checked"]['order_type']['']?>>
								<label class="form-check-label" for="order_type">전체</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" id="order_type_A" value="I" name="order_type" <?php echo $GLOBALS["checked"]['order_type']['I']?>>
								<label class="form-check-label" for="order_type_A">자체</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" id="order_type_I" value="O" name="order_type" <?php echo $GLOBALS["checked"]['order_type']['O']?>>
								<label class="form-check-label" for="order_type_I">외부</label>
							</div>							
						</td>
					</tr>			
				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<button class="btn btn-primary">검색</button>
			<!-- <button class="btn btn-default" onclick="location.href ='sales_list.php'; return false;">초기화</button> -->
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
						<span class="common-table-result"><!--총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건--></span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색">
							<span class="input-group-btn"><button class="btn btn-primary" type="button">검색</button></span> -->
						</div>
					</div>
				</caption>
				<colgroup>
					<col />
					<col width="10%" />
					<col width="10%" />
					<col width="10%" />
					<col width="10%" />
					<col width="10%" />
					<col width="10%" />
				</colgroup>
				<thead>
					<tr>
						<th rowspan="2">브랜드</th>
						<th colspan="2">주문</th>
						<th colspan="2">취소</th>
						<th colspan="2">반품</th>
					</tr>
					<tr>
						<th>수량</th>
						<th>금액</th>
						<th>수량</th>
						<th>금액</th>
						<th>수량</th>
						<th>금액</th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>							
                    <tr>							
                        <td><?php echo $TPL_V1["brandnm"]?></td>
                        <td><?php echo number_format($TPL_V1["order_quantity"])?></td>
                        <td><?php echo number_format($TPL_V1["order_price"])?></td>
                        <td><?php echo number_format($TPL_V1["cancel_quantity"])?></td>
                        <td><?php echo number_format($TPL_V1["cancel_price"])?></td>
                        <td></td>
                        <td></td>
                    </tr>						
<?php }}?>
					<tr>
						<td>합계</td>
						<td><?php echo number_format($GLOBALS["sumOrderQuantity"])?></td>
						<td><?php echo number_format($GLOBALS["sumOrderPrice"])?></td>
						<td><?php echo number_format($GLOBALS["sumCancelQuantity"])?></td>
						<td><?php echo number_format($GLOBALS["sumCancelPrice"])?></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>