<?php /* Template_ 2.2.8 2020/07/29 08:32:42 /www/html/ukk_test/data/skin/cs/cs_total_list_test.htm 000014749 */ 
$TPL_mall_list_1=empty($TPL_VAR["mall_list"])||!is_array($TPL_VAR["mall_list"])?0:count($TPL_VAR["mall_list"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<?php if($GLOBALS["print_xls"]!= 1){?>



<!-- Main Contents -->
<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
	<div class="col-lg-12">
		<form enctype="multipart/form-data" method="post" onsubmit="return chkform();">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small" >
				<tr>
					<th scope="row">CS등록</th>
					<td>
						<input type="file" name="excelFile[]" required/><button class="btn btn-primary" >업로드</button>
						<button type="button" class="btn btn-success" onclick="location.href='../xls_file/cs_upload.xls'">양식 다운로드</button>
					</td>
				</tr>
			</table>
		</div>
		</form>
		<form method="get">
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
						<th scope="row" class="align-left">통합검색</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="total_search" id="total_search" value="<?php echo $_GET['total_search']?>"/></div>
							<div>※ 성함(구매자,수령자,접수자), 연락처, 주문번호, 송장번호, 모델명</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value=1 name="cslist" <?php echo $GLOBALS["checked"]['cslist']['1']?>>
								<label class="form-check-label" for="inlineCheckbox1">CS</label>

								&nbsp;( 
								<div style="margin:0 5px">
								<input class="form-check-input" type="checkbox" id="inlineCheckbox11" value=1 name="call_type1" <?php echo $GLOBALS["checked"]['call_type1']['1']?>>
								<label class="form-check-label" for="inlineCheckbox11">콜백</label>&nbsp;

								<input class="form-check-input" type="checkbox" id="inlineCheckbox12" value=1 name="call_type2" <?php echo $GLOBALS["checked"]['call_type2']['1']?>>
								<label class="form-check-label" for="inlineCheckbox12">진행중</label> 
								</div>)
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" id="inlineCheckbox2" value=1 name="aslist" <?php echo $GLOBALS["checked"]['aslist']['1']?>>
								<label class="form-check-label" for="inlineCheckbox2">AS</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" id="inlineCheckbox3" value=1 name="returnlist" <?php echo $GLOBALS["checked"]['returnlist']['1']?>>
								<label class="form-check-label" for="inlineCheckbox3">교환,반품</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" id="inlineCheckbox4" value=1 name="handlist" <?php echo $GLOBALS["checked"]['handlist']['1']?>>
								<label class="form-check-label" for="inlineCheckbox4">수기접수</label>
							</div>
						</td>
					</tr>
					<!-- <tr>
						<th rowspan="5">몰명</th>
						<td rowspan="5">
							<div style="overflow: auto; height:210px; font-size: 11px;">
<?php if($TPL_mall_list_1){foreach($TPL_VAR["mall_list"] as $TPL_V1){?>
							
								<label class="mallLabel"><input type="checkbox" name="s_mall_no[]" value=<?php echo $TPL_V1["no"]?> <?php echo $GLOBALS["checked"]['mall_no'][$TPL_V1["no"]]?>><?php if($TPL_V1["upload_form_type"]!='사방넷'){?>(<?php echo $TPL_V1["upload_form_type"]?>)<?php }?><?php echo $TPL_V1["mall_name"]?></label>
							
<?php }}?>
								
						</td>
					</tr> -->
				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<button class="btn btn-primary">검색</button>
			<button class="btn btn-default" onclick="location.href ='cs_total_list.php'; return false;">초기화</button>
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
						<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색">
							<span class="input-group-btn"><button class="btn btn-primary" type="button">검색</button></span> -->
						</div>
					</div>
				</caption>
				<colgroup>
					<col width="4%" />
					<col width="6%" />
					<col width="6%" />
					<col width="9%" />
					<col width="5%" />
					<col width="6%" />
					<col width="4%" />
					<col width="5%" />
					<col width="5%" />
					<col width="8%" />
					<col width="" />
					<col width="6%" />
					<col width="6%" />
					<col width="6%" />
					<col width="6%" />
					<col width="1%" />
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th>등록구분</th>
						<th>몰명</th>
						<th>주문번호</th>
						<th>이미지</th>
						<th>옵션명</th>
						<th>수량</th>
						<th>가격</th>
						<th>구매자<br>수령자</th>
						<th>연락처<br>모바일</th>
						<th>주소</th>
						<th>송장번호</th>
						<th>주문일자</th>
						<th>주문상태</th>
						<th>작성자</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr class=" <?php echo $TPL_V1["line_color"]?>" <?php if($TPL_V1["sum_ins_type"]){?>style="color:red"<?php }?>>			
							<td>
<?php if($TPL_V1["asCheck"]){?><div style="padding:0px 3px 0px 3px; color:#fff; background-color: #337ab7; font-size: 8px; text-align: center;border-radius: 4px;">AS</div><?php }?>
<?php if($TPL_V1["csCheck"]){?><div style="padding:0px 3px 0px 3px; color:#fff; background-color: #f0ad4e; font-size: 8px; text-align: center;border-radius: 4px;">CS</div><?php }?>
<?php if($TPL_V1["returnCheck"]){?><div style="padding:0px 3px 0px 3px; color:#fff; background-color: #f04ee8; font-size: 8px; text-align: center;border-radius: 4px;">교/반</div><?php }?>
							</td>
							<td><?php echo $TPL_V1["qry_type"]?> </td>
							<td><?php echo $TPL_V1["mall_name"]?></td>
							<td><?php echo $TPL_V1["orderno"]?> <?php if($TPL_V1["copy_seq"]> 0){?>복사본<?php }?></td>
							<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
							<td><?php echo $TPL_V1["goodsnm"]?></td>
							<td><?php echo $TPL_V1["quantity"]?></td>
							<td><?php echo number_format($TPL_V1["price"])?></td>
							<td><?php echo $TPL_V1["name1"]?><br/><?php echo $TPL_V1["name2"]?></td>
							<td><?php echo $TPL_V1["mobile1"]?><br/><?php echo $TPL_V1["mobile2"]?></td>
							<td><?php echo $TPL_V1["address"]?></td>
							<td><?php if($TPL_V1["invoice"]!= 0){?><?php echo $TPL_V1["delivery_name"]?> (<?php echo $TPL_V1["invoice"]?>)<?php }?></td>
							<td><?php echo $TPL_V1["date"]?></td>
							<td><?php echo $GLOBALS["cfg_order_step"][$TPL_V1["step"]]?><?php if($TPL_V1["step2"]){?><div style="color: red;">(<?php echo $GLOBALS["cfg_order_step2"][$TPL_V1["step2"]]?>)</div><?php }?></td>
							<td><?php if($TPL_V1["admin_no"]){?><?php echo $TPL_V1["name"]?><br>(<?php echo $TPL_V1["id"]?>)<?php }?></td>
							<td>
<?php if($TPL_V1["qry_type"]=="주문"){?>
								<button type="button" class="btn btn-sm btn-warning" onclick="popup('cs_reg.php?ordno=<?php echo $TPL_V1["orderno"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>&order_seq=<?php echo $TPL_V1["no"]?>','','1100','900')">CS등록</button>
<?php }elseif($TPL_V1["qry_type"]=="수기접수"){?>
								<button type="button" class="btn btn-sm btn-warning" onclick="popup('as_reg.php?as_no=<?php echo $TPL_V1["no"]?>','','1100','900')">AS수정</button>
<?php }?>
							</td>		
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

<!-- <div class="row common-table-btn">
	<div class="col-lg-12 text-center">
		<ul class="pagination">
			<li><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">6</a></li>
			<li><a href="#">7</a></li>
			<li><a href="#">8</a></li>
			<li><a href="#">9</a></li>
			<li><a href="#">10</a></li>
			<li><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
		</ul>
	</div>
</div> -->

<!-- Main Contents -->



<!-- 
<table id="" class="display display_dt" style="width:100%;" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th width='50'></th>
			<th width='100'>등록구분</th>
			<th width='50'>몰명</th>
			<th width='100' data-orderable="false">주문번호</th>
			<th data-orderable="false">이미지</th>
			<th width='100'>옵션명</th>
			<th width='50'>수량</th>
			<th width='50'>가격</th>
			<th width='50' data-orderable="false">구매자<br>수령자</th>
			<th width='100' data-orderable="false">연락처<br>모바일</th>
			<th data-orderable="false">주소</th>
			<th width='100' data-orderable="false">송장번호</th>
			<th width='100'>주문일자</th>
			<th width='100'>주문상태</th>
			<th width='100'>작성자</th>
			<th data-orderable="false"></th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class=" table_tr1">			
			<td>
<?php if($TPL_V1["asCheck"]){?><div style="padding:0px 3px 0px 3px; color:#fff; background-color: #337ab7; font-size: 8px; text-align: center;border-radius: 4px;">AS</div><?php }?>
<?php if($TPL_V1["csCheck"]){?><div style="padding:0px 3px 0px 3px; color:#fff; background-color: #f0ad4e; font-size: 8px; text-align: center;border-radius: 4px;">CS</div><?php }?>
			</td>
			<td><?php echo $TPL_V1["qry_type"]?></td>
			<td><?php echo $TPL_V1["mall_name"]?></td>
			<td><?php echo $TPL_V1["orderno"]?> <?php if($TPL_V1["copy_seq"]> 0){?>복사본<?php }?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["quantity"]?></td>
			<td><?php echo number_format($TPL_V1["price"])?></td>
			<td><?php echo $TPL_V1["name1"]?><br/><?php echo $TPL_V1["name2"]?></td>
			<td><?php echo $TPL_V1["mobile1"]?><br/><?php echo $TPL_V1["mobile2"]?></td>
			<td><?php echo $TPL_V1["address"]?></td>
			<td><?php if($TPL_V1["invoice"]!= 0){?><?php echo $TPL_V1["delivery_name"]?> (<?php echo $TPL_V1["invoice"]?>)<?php }?></td>
			<td><?php echo $TPL_V1["date"]?></td>
			<td><?php echo $GLOBALS["cfg_order_step"][$TPL_V1["step"]]?><?php if($TPL_V1["step2"]){?><div style="color: red;">(<?php echo $GLOBALS["cfg_order_step2"][$TPL_V1["step2"]]?>)</div><?php }?></td>
			<td><?php if($TPL_V1["admin_no"]){?><?php echo $TPL_V1["name"]?><br>(<?php echo $TPL_V1["id"]?>)<?php }?></td>
			<td>
<?php if($TPL_V1["qry_type"]=="주문"){?>
				<button type="button" class="btn btn-sm btn-warning" onclick="popup('cs_reg.php?ordno=<?php echo $TPL_V1["orderno"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>','','1100','900')">CS등록</button>
<?php }elseif($TPL_V1["qry_type"]=="수기접수"){?>
				<button type="button" class="btn btn-sm btn-warning" onclick="popup('as_reg.php?as_no=<?php echo $TPL_V1["no"]?>','','1100','900')">AS수정</button>
<?php }?>
			</td>		
		</tr>
<?php }}?>
	</tbody>
</table> -->
<!-- 
<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<?php }?> -->
<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>