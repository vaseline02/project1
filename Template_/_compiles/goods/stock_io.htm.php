<?php /* Template_ 2.2.8 2020/12/11 11:38:37 /www/html/ukk_test2/data/skin/goods/stock_io.htm 000006376 */ 
$TPL__arr_mall_1=empty($GLOBALS["arr_mall"])||!is_array($GLOBALS["arr_mall"])?0:count($GLOBALS["arr_mall"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<?php if($GLOBALS["print_xls"]!= 1){?>
<form method="get">
<!-- Main Contents -->
<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
	<div class="col-lg-12">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="12%" />
					<col width="35%" />
					<col width="12%" />
					<col width="35%" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row">주문일자</th>
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
							<script>
								
							</script>
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">몰선택</th>
						<td class="receive-title no-gutters">
							<select name="s_mall">
                                <option value="">== 몰선택 ===</option>
<?php if($TPL__arr_mall_1){foreach($GLOBALS["arr_mall"] as $TPL_K1=>$TPL_V1){?>
                                <option value=<?php echo $TPL_K1?> <?php echo $GLOBALS["selected"]['s_mall'][$TPL_K1]?>><?php echo $TPL_K1?></option>
<?php }}?>
                            </select>
						</td>
						<th scope="row" class="align-left">모델명</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_goodsnm" id="s_goodsnm" value="<?php echo $_GET['s_goodsnm']?>"/></div>
						</td>
					</tr>



				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<button class="btn btn-primary">검색</button>
			<button class="btn btn-default" onclick="location.href ='stock_io.php'; return false;">초기화</button>
		</div>
	</div>			
</div>
</form>

<?php }?>


<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색">
							<span class="input-group-btn"><button class="btn btn-primary" type="button">검색</button></span> -->
						</div>
					</div>
				</caption>
				<colgroup>
					<col width="5%" />
					<col width="8%" />
					<col width="20%" />
					<col width="7%" />
					<col width="7%" />
					<col width="7%" />
					<col width="" />
					<col width="" />
					<col width="10%" />
					<col width="10%" />
					<col width="10%" />
					
				</colgroup>
				<thead>
					<tr>
						<th>seq</th>
						<th>상품번호</th>
						<th>상품명</th>
						<th>수량</th>
						<th>처리후재고</th>
						<th>위치</th>
						<th>형식</th>
						<th>처리페이지</th>
						<th>처리번호</th>
						<th>주문번호</th>
						<th>등록일</th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr>
							<td><?php echo $TPL_V1["no"]?></td>
							<td><?php echo $TPL_V1["goodsno"]?></td>
							<td><?php echo $TPL_V1["goodsnm"]?> </td>
							<td><?php echo $TPL_V1["cnt"]?></td>
							<td><?php echo $TPL_V1["cur_cnt"]?></td>
							<td><?php echo $TPL_V1["codename"]?></td>
							<td><?php echo $TPL_V1["io"]?></td>
							<td><?php echo $TPL_V1["reference_page"]?></td>
							<td><?php echo $TPL_V1["reference_no"]?></td>
							<td><?php echo $TPL_V1["ordno"]?></td>
							<td><?php echo $TPL_V1["reg_date"]?></td>
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

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>