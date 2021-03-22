<?php /* Template_ 2.2.8 2020/12/03 10:11:37 /www/html/ukk_test2/data/skin/outline/table_width_cancel.htm 000013811 */ 
$TPL_mall_list_1=empty($TPL_VAR["mall_list"])||!is_array($TPL_VAR["mall_list"])?0:count($TPL_VAR["mall_list"]);
$TPL__cfg_retrun_type_1=empty($GLOBALS["cfg_retrun_type"])||!is_array($GLOBALS["cfg_retrun_type"])?0:count($GLOBALS["cfg_retrun_type"]);?>
<style>
	.search_td_width{width:380px;}
	.mallLabel{ display:inline-block; width:200px; line-height:23px;}
</style>
<form method="get">
<input type="hidden" name="subtype" value="<?php echo $_GET['subtype']?>">
<div class="row">
	<div class="col-lg-12">		
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="10%" />
					<col width="22%" />
					<col width="10%" />
					<col width="22%" />
					<col width="10%" />
					<col width="40%" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row" class="align-left">송장번호</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_return_invoice" value="<?php echo $_GET['s_return_invoice']?>"></div>
						</td>
						<th scope="row" class="align-left">주문번호</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_order_no" value="<?php echo $_GET['s_order_no']?>"></div>
						</td>
						<th scope="row" class="align-left" rowspan="5">몰명</th>
						<td class="receive-title no-gutters" rowspan="5">
							<div style="overflow: auto; height:210px; font-size: 11px;">
<?php if($TPL_mall_list_1){foreach($TPL_VAR["mall_list"] as $TPL_V1){?>
								<label class="mallLabel"><input type="checkbox" name="s_mall_no[]" value=<?php echo $TPL_V1["no"]?> <?php echo $GLOBALS["checked"]['mall_no'][$TPL_V1["no"]]?>><?php if($TPL_V1["upload_form_type"]!='사방넷'){?>(<?php echo $TPL_V1["upload_form_type"]?>)<?php }?><?php echo $TPL_V1["mall_name"]?></label>
<?php }}?>						
							</div>
						</td>
					</tr>

<?php if($TPL_VAR["csType"]=='etc'){?>
					<tr>
						<th scope="row">등록일자</th>
						<td colspan="3" class="receive-title no-gutters">
						<div class="col-lg-4 btn-group-sm" role="group" aria-label="Small button group">
							<button type="button" class="btn btn-default dayChange" data-int='0' data-type='day'>오늘</button>
							<button type="button" class="btn btn-default dayChange" data-int='7' data-type='day'>7일</button>
							<button type="button" class="btn btn-default dayChange" data-int='15' data-type='day'>15일</button>
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
						<th scope="row" class="align-left">작성자</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_admin" value="<?php echo $_GET['s_admin']?>"></div>
						</td>
					</tr>
<?php }else{?>
					<tr>
						<th scope="row" class="align-left">사유</th>
						<td class="receive-title no-gutters">
							<select name="s_return_type">
								<option value="">선택</option>
<?php if($TPL__cfg_retrun_type_1){foreach($GLOBALS["cfg_retrun_type"] as $TPL_K1=>$TPL_V1){?>
<?php if((($GLOBALS["step"]=='1'||$GLOBALS["step"]=='4')&&($TPL_K1=='60'||$TPL_K1=='70'))||(($GLOBALS["step"]=='2'||$GLOBALS["step"]=='3')&&($TPL_K1=='60'||$TPL_K1=='70'))){?>
								<option value=<?php echo $TPL_K1?> <?php echo $GLOBALS["selected"]['return_type'][$TPL_K1]?>><?php echo $TPL_V1?></option> 
<?php }?>               
<?php }}?>
							</select>
							<select name="s_return_type_sub" >
								<option value="">선택</option>
								<option value="1" <?php echo $GLOBALS["selected"]['return_type_sub']['1']?>>단순접수</option>
								<option value="2" <?php echo $GLOBALS["selected"]['return_type_sub']['2']?>>불량접수</option>
							</select>
						</td>

						<th scope="row" class="align-left">작성자</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_admin" value="<?php echo $_GET['s_admin']?>"></div>
						</td>
					</tr>					
					<tr>
						<th scope="row">접수일자</th>
						<td colspan="3" class="receive-title no-gutters">
							
							<div class="col-lg-4 btn-group-sm" role="group" aria-label="Small button group">
								<button type="button" class="btn btn-default dayChange" data-int='0' data-type='day'>오늘</button>
								<button type="button" class="btn btn-default dayChange" data-int='7' data-type='day'>7일</button>
								<button type="button" class="btn btn-default dayChange" data-int='15' data-type='day'>15일</button>
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
					</tr>
<?php if($GLOBALS["step"]=='4'){?>
					<tr>
						<th scope="row">완료일</th>
						<td colspan="3" class="receive-title no-gutters">
							
							<div class="col-lg-4 btn-group-sm" role="group" aria-label="Small button group">
								<button type="button" class="btn btn-default dayChange" data-int='0' data-type='day' data-s_date_id='s_date2' data-e_date_id='e_date2'>오늘</button>
								<button type="button" class="btn btn-default dayChange" data-int='7' data-type='day' data-s_date_id='s_date2' data-e_date_id='e_date2'>7일</button>
								<button type="button" class="btn btn-default dayChange" data-int='15' data-type='day' data-s_date_id='s_date2' data-e_date_id='e_date2'>15일</button>
								<button type="button" class="btn btn-default dayChange" data-int='1' data-type='month' data-s_date_id='s_date2' data-e_date_id='e_date2'>1개월</button>
								<button type="button" class="btn btn-default dayChange" data-int='3' data-type='month' data-s_date_id='s_date2' data-e_date_id='e_date2'>3개월</button>
								<button type="button" class="btn btn-default dayChange" data-int='1' data-type='year' data-s_date_id='s_date2' data-e_date_id='e_date2'>1년</button>
								<!-- <button type="button" class="btn btn-primary">전체</button> -->
							</div>
							<div class="col-md-2 date-wrap">
								<div class="input-group">
									<input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="s_date2" id="s_date2" value="<?php echo $_GET['s_date2']?>" readonly />
									<span class="input-group-btn">
										<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="s_date2"><span class="glyphicon glyphicon-list-alt"></span></button>
									</span>
								</div>
							</div>
							
							<p class="date-tilde">~</p>
							<div class="col-md-2 date-wrap">
								<div class="input-group">
									<input type="text" class="form-control datepicker_common" placeholder="종료 날짜" aria-describedby="basic-addon2" name="e_date2" id="e_date2" value="<?php echo $_GET['e_date2']?>" readonly />
									<span class="input-group-btn">
										<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="e_date2"><span class="glyphicon glyphicon-list-alt"></span></button>
									</span>
								</div>										
							</div>							
						</td>		
					</tr>
					<tr>
						<th scope="row">모델명</th>
						<td colspan="3" class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_goodsnm" value="<?php echo $_GET['s_goodsnm']?>"></div>
						</td>		
					</tr>

<?php }?>

<?php }?>					
				</tbody>
			</table>
		</div>
		
		<div class="text-center table-btn-group">
<?php if($GLOBALS["pageName"]=='send_out'||$GLOBALS["pageName"]=='send_in'||$GLOBALS["pageName"]=='send_reception'){?>
			<!-- <input type="checkbox" name="cs_search_invo_chk" value="1"> 송장번호 미포함 -->
<?php if($GLOBALS["pageName"]=='send_in'||$GLOBALS["pageName"]=='send_out'){?>
			<select id="cs_search_loc">				
<?php if($GLOBALS["pageName"]=='send_out'){?>
				<option value="0">wms(셀피아,B2B,사방넷,교반품)</option>				
				<!--<option value="2">wms(타임메카,스토어팜,오피셜)</option>-->
<?php }else{?>
				<option value="2">wms</option>
<?php }?>
				<option value="1">재고어드민</option>									
			</select>
<?php }?>
<?php if($GLOBALS["pageName"]=='send_out'){?>
			<button type="button" class="btn btn-success" id="cs_search_print_xls" data-mode="out">선택값 엑셀 다운로드</button>
<?php }elseif($GLOBALS["pageName"]=='send_in'){?>
			<button type="button" class="btn btn-success" id="cs_search_print_xls" data-mode="in">선택값 엑셀 다운로드</button>
<?php }else{?>
			<button type="button" class="btn btn-success" id="cs_search_print_xls" data-mode="reception">선택값 엑셀 다운로드</button>
<?php }?>
<?php }?>
			<button class="btn btn-primary" id="">검 색</button>
<?php if($GLOBALS["pageName"]=='send_close'){?><button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button><?php }?>
		</div>
	</div>			
</div>

</form>

<script>
	
$(function(){
	/*인클루드 되어있는 페이지의 체크박스 값을 가지고 넘어가야 하기때문에 메인폼을 포스트로 날림.*/ 
	$("#cs_search_print_xls").click(function(){
			
		var file_loc='';
		if($(this).data('mode')=="out"){
			if(	$("#cs_search_loc").val()=='1' ){
				file_loc="send_out_excel2.php";
			}else if(	$("#cs_search_loc").val()=='2' ){
				file_loc="send_out_excel_tm.php";
			}else{
				file_loc="send_out_excel.php";
			}
		}else if($(this).data('mode')=="in"){
			if(	$("#cs_search_loc").val()=='1' ){
				file_loc="send_in_excel2.php";
			}else if(	$("#cs_search_loc").val()=='2' ){
				file_loc="send_in_excel_tm.php";
			}else{
				file_loc="send_in_excel.php";
			}
		}else{
			file_loc="send_reception_excel.php";
		}


		var chk_len=$(".chk_no:checked").length;
		if( chk_len<=0 ){
			alert('출력할 주문을 선택해주세요.');
			return false;
		}else{
			
			var invo_chk=0;
			// if($("[name='cs_search_invo_chk']").is(":checked")){
			// 	invo_chk=1;
			// }

			var html='<div id="div_excel_search_val">';
			html+='<input type="hidden" name="print_xls" value="1" >';
			// html+='<input type="hidden" name="print_xls" value="0" >';
			// html+='<input type="hidden" name="cs_search_invo_chk" value="'+invo_chk+'">';
			html+='</div>';	
			$("#sendForm").append(html);
			
			$("#sendForm").attr("action",file_loc);
			$("#sendForm").submit();
			$("#sendForm").attr("action","");
			$("#div_excel_search_val").remove();
		}

	});
})
</script>