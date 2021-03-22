<?php /* Template_ 2.2.8 2021/03/03 09:42:52 /www/html/ukk_test2/data/skin/cs/bad_list.htm 000018350 */ 
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<?php echo $this->define('tpl_include_file_1',"cs/bad_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>


<form method="get" id="badSearch">
<input type="hidden" name="step" value="<?php echo $_GET['step']?>">
<input type="hidden"name="print_xls" value="">
<div class="row">
	<div class="col-lg-12">		
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="10%" />
					<col width="25%" />
					<col width="10%" />
					<col />
				</colgroup>
				<tbody>					
					<tr>
						<th scope="row" class="align-left">모델명</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_goodsnm" value="<?php echo $_GET['s_goodsnm']?>"></div>
						</td>
						<th scope="row">
							<select name="s_date_search">
								<option value="reg_date" <?php echo $GLOBALS["selected"]['s_date_search']['reg_date']?>>등록일</option>
								<option value="mod_date" <?php echo $GLOBALS["selected"]['s_date_search']['mod_date']?>>최종수정일</option>
								<option value="send_date" <?php echo $GLOBALS["selected"]['s_date_search']['send_date']?>>본사발송일</option>
								<option value="in_date" <?php echo $GLOBALS["selected"]['s_date_search']['in_date']?>>메카입고일</option>
								<option value="calcu_date" <?php echo $GLOBALS["selected"]['s_date_search']['calcu_date']?>>본사정산일</option>
							</select>
						</th>
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
					<tr>
						<th scope="row" class="align-left">최종수정자</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_mod_admin" value="<?php echo $_GET['s_mod_admin']?>"></div>
						</td>
						<th scope="row" class="align-left">관리자메모</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_admin_memo" value="<?php echo $_GET['s_admin_memo']?>"></div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">시쿼스</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_no" value="<?php echo $_GET['s_no']?>"></div>
						</td>
						<th scope="row" class="align-left">주문번호</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_order_no" value="<?php echo $_GET['s_order_no']?>"></div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">하자내용</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_memo" value="<?php echo $_GET['s_memo']?>"></div>
						</td>
						<th scope="row" class="align-left">수리내용</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_repair_memo" value="<?php echo $_GET['s_repair_memo']?>"></div>
						</td>
					</tr>				
					<tr>
						<th scope="row" class="align-left">진행업체</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="s_repair_type" value="<?php echo $_GET['s_repair_type']?>"></div>
						</td>
						<th scope="row" class="align-left"></th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12">
<?php if(!$_GET['step']){?><label style="font-weight: normal;"><input type="checkbox" name="close_yn" value='n' <?php echo $GLOBALS["checked"]['close_yn']['n']?>> 수리완료 제외</label><?php }?>
							</div>
						</td>
					</tr>			
				</tbody>
			</table>
		</div>
		
		<div class="text-center table-btn-group">
<?php if(($_GET['step']=='1'&&$_GET['step_sub']=='1')||$_GET['step']=='60'){?>
			<select id="cs_search_loc">				
				<option value="2">wms</option>
				<option value="1">재고어드민</option>									
			</select>
			<button type="button" class="btn btn-success" id="bad_search_print_xls">선택값 엑셀 다운로드</button>
<?php }?>
<?php if($GLOBALS["pageName"]=='send_close'){?><button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button><?php }?>

			<button class="btn btn-primary" id="">검 색</button>
			<div type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</div>
		</div>
	</div>			
</div>
</form>
<?php }?>


<form id="badForm" method="POST" enctype="multipart/form-data">
<input type="hidden" name="mode" value="step">
<input type="hidden" name="step" value="">

<div class="row">
<?php if($GLOBALS["print_xls"]!= 1){?>
	<div class="bottom_btn_box" style="padding-bottom:20px;">
		<div class="box_left" style="padding-left:15px;">
<?php if($_GET['step']=='1'&&$_GET['step_sub']=='1'){?>
			<div type="button" class="btn btn-sm btn-primary" onclick="popup('bad_list_excel_reg.php','stock_move_excel_reg','1100','900')">엑셀등록팝업</div>
<?php }?>
			<!-- <input type="file" name="excelFile[]" id="excelFile" required/><div type="button" class="btn btn-sm btn-primary checkForm" type="button" data-mode='excelupload' data-title='엑셀업로드'>업로드</div>
			<button type="button" class="btn btn-sm btn-success" onclick="location.href='../xls_file/bad_upload.xls'">양식 다운로드</button> -->
		</div>
		<div  class="box_right">
			<input type="text" class="form-control" name="i_memo" id="i_memo" style="width:300px;display:inline;">	
			<div type="button" class="btn btn-sm btn-primary badChange" type="button" data-mode='memo' data-title='등록하자내용'>등록하자내용 등록</div>
			<div type="button" class="btn btn-sm btn-primary badChange" type="button" data-mode='admin_memo' data-title='관리자메모'>관리자메모 등록</div>
		</div>
	</div>	
<?php }?>
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
<?php if($GLOBALS["print_xls"]!= 1){?>
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format(count($TPL_VAR["loop"]))?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색"> -->
							<span class="input-group-btn">												
								<span style="padding-left:10px;">&nbsp;</span>
								<!--
<?php if($_GET['step']=='1'){?>
								<div type="button" class="btn btn-warning" onclick="popup('../goods/goods_reg.php','goods_reg','1100','900')">상품등록</div>
<?php }?>
								<span style="padding-right:5px;"></span>-->
<?php if($_GET['step']=='1'){?>
									<div type="button" class="btn btn-primary badChange" type="button" data-mode='step' data-step='20' data-title='접수'>접수</div>
<?php }elseif($_GET['step']=='20'){?>
									<div type="button" class="btn btn-primary badChange" type="button" data-mode='step' data-step='40' data-title='자체수리'>자체수리</div>
									<span style="padding-right:5px;"></span>
									<div type="button" class="btn btn-primary badChange" type="button" data-mode='step' data-step='41' data-title='자체수리(해외자재요청)'>자체수리(해외자재요청)</div>
									<span style="padding-right:5px;"></span>
									<div type="button" class="btn btn-primary badChange" type="button" data-mode='step' data-step='42' data-title='국내본사수리요청'>국내본사수리요청</div>
									<span style="padding-right:5px;"></span>
									<div type="button" class="btn btn-primary badChange" type="button" data-mode='step' data-step='43' data-title='해외본사수리요청'>해외본사수리요청</div>

<?php }elseif($_GET['step']>='40'&&$_GET['step']<'50'){?>
									<select name="codeSelect" class="codeSelect">		
										<option value="1">사무실</option>
										<!--
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
											<option value="<?php echo $TPL_V1["no"]?>" <?php echo $GLOBALS["selected"]['codeSelect'][$TPL_V1["no"]]?> data-name="<?php echo $TPL_V1["cd"]?>"><?php echo $TPL_V1["cd"]?></option>
<?php }}?>	-->																	
									</select>									
									<span style="padding-right:5px;"></span>
									<div type="button" class="btn btn-primary badChange" type="button" data-mode='step' data-step='60' data-title='수리완료'>수리완료</div>

<?php if($_GET['step']>='40'&&$_GET['step']<'45'){?>
									<span style="padding-right:5px;"></span>
									<div type="button" class="btn btn-primary badChange" type="button" data-mode='step' data-step='61' data-title='수리불가(폐기)'>수리불가(폐기)</div>
									<span style="padding-right:5px;"></span>
									<div type="button" class="btn btn-primary badChange" type="button" data-mode='step' data-step='62' data-title='리퍼'>리퍼</div>
									
									<span style="padding-right:20px;"></span>
									<div type="button" class="btn btn-warning badChange" type="button" data-mode='step' data-step='45' data-title='수리완료대기'>수리완료대기</div>				

									<span style="padding-right:20px;"></span>
									<div type="button" class="btn btn-danger badChange" type="button" data-mode='step' data-step='20' data-title='접수'>접수</div>				
<?php }?>
								
<?php }elseif($_GET['step']>='60'&&$_GET['step']<'70'){?>
<?php if($_GET['step']=='61'){?>
										<div type="button" class="btn btn-primary badChange" type="button" data-mode='step' data-step='80' data-title='폐기리스트'>폐기리스트</div>
<?php }elseif($_GET['step']=='62'){?>			
										<!--
										<span style="padding-right:5px;"></span>
										<div type="button" class="btn btn-danger badChange" type="button" data-mode='step' data-step='40' data-title='자체수리'>자체수리</div>
										<span style="padding-right:5px;"></span>
										<div type="button" class="btn btn-danger badChange" type="button" data-mode='step' data-step='41' data-title='자체수리(해외자재요청)'>자체수리(해외자재요청)</div>
										<span style="padding-right:5px;"></span>
										<div type="button" class="btn btn-danger badChange" type="button" data-mode='step' data-step='42' data-title='국내본사수리요청'>국내본사수리요청</div>
										<span style="padding-right:5px;"></span>
										<div type="button" class="btn btn-danger badChange" type="button" data-mode='step' data-step='43' data-title='해외본사수리요청'>해외본사수리요청</div>													
										-->							
<?php }?>
<?php }?>								
							</span>
						</div>
					</div>
				</caption>
<?php }?>
				<colgroup>
					<col width="3%"/>
					<col width="3%"/>
					<col width="8%"/>					
					<col/>
					<col width="4%"/>
					<col width="4%"/>
					<col width="4%"/>
					<col width="4%"/>
					<col width="5%"/>
					<col/>
					<col/>
					<col width="5%"/>
					<col width="5%"/>
					<col width="5%"/>
					<col width="5%"/>
					<col width="4%"/>
					<col width="4%"/>
					<col width="5%"/>
					<col width="5%"/>
				</colgroup>
				<thead>
					<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
						<th>시퀀스</th>
						<th>주문번호</th>
<?php if($GLOBALS["print_xls"]== 1){?><th>브랜드</th><?php }?>
						<th>모델명</th>
<?php if($GLOBALS["print_xls"]!= 1){?><th>이미지</th><?php }?>
						<th>원가</th>
						<th>수리비용</th>
						<th>하자수량</th>
						<th>진행업체</th>
						<th>등록하자내용</th>
						<th>관리자메모</th>
						<th>수리예정일</th>
						<th>본사발송일</th>
						<th>메카입고일</th>
						<th>본사정산일</th>
						<th>등록일</th>
						<th>최종수정일</th>
						<th>최종수정자</th>
<?php if($GLOBALS["print_xls"]!= 1){?><th></th><?php }?>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>		
						<tr>			
<?php if($GLOBALS["print_xls"]!= 1){?><td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td><?php }?>
							<td><?php echo $TPL_V1["no"]?></td>
							<td class="text_type"><?php echo $TPL_V1["order_no"]?></td>
<?php if($GLOBALS["print_xls"]== 1){?><td><?php echo $TPL_V1["brandnm"]?></td><?php }?>
							<td><?php echo $TPL_V1["goodsnm"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?><td class="td_img"><?php echo $TPL_V1["img_url"]?></td><?php }?>
							<td><?php echo number_format($TPL_V1["cost"])?></td>
							<td><?php echo number_format($TPL_V1["repair_cost"])?></td>
							<td><?php echo $TPL_V1["quantity"]?></td>
							<td><?php echo $TPL_V1["repair_type"]?></td>
							<td><?php echo $TPL_V1["memo"]?></td>
							<td><?php echo $TPL_V1["admin_memo"]?></td>
							<td><?php echo $TPL_V1["repair_date"]?></td>
							<td><?php echo $TPL_V1["send_date"]?></td>
							<td><?php echo $TPL_V1["in_date"]?></td>
							<td><?php echo $TPL_V1["calcu_date"]?></td>
							<td><?php echo $TPL_V1["reg_date"]?></td>
							<td><?php echo $TPL_V1["mod_date"]?></td>
							<td><?php echo $TPL_V1["name"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?><td><button type="button" class="btn btn-sm btn-warning" onclick="popup('bad_reg.php?no=<?php echo $TPL_V1["no"]?>','bad_reg','1100','900')">정보수정</button></td><?php }?>
						</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</form>


<script>
<?php if($_GET['step']=='1'){?>
$("#nav_div<?php echo $_GET['step']?>_<?php echo $_GET['step_sub']?>").addClass('active');
<?php }else{?>
$("#nav_div<?php echo $_GET['step']?>").addClass('active');
<?php }?>

document.title="<?php echo $GLOBALS["page_title"]?>";

$("#bad_search_print_xls").click(function(){
		
	var file_loc='';
	if(	$("#cs_search_loc").val()=='1' ){
		file_loc="bad_excel2.php";
	}else if(	$("#cs_search_loc").val()=='2' ){
		file_loc="bad_excel_tm.php";
	}else{
		file_loc="bad_excel.php";
	}

	var chk_len=$(".chk_no:checked").length;
	if( chk_len<=0 ){
		alert('출력할 주문을 선택해주세요.');
		return false;
	}else{
		
		var invo_chk=0;

		var html='<div id="div_excel_search_val">';
		html+='<input type="hidden" name="print_xls" value="1" >';
		// html+='<input type="hidden" name="print_xls" value="0" >';
		// html+='<input type="hidden" name="cs_search_invo_chk" value="'+invo_chk+'">';
		html+='</div>';	
		$("#badForm").append(html);
		
		$("#badForm").attr("action",file_loc);
		$("#badForm").submit();
		$("#badForm").attr("action","");
		$("#div_excel_search_val").remove();
	}

});


$(".badChange").click(function(){
	var mode=$(this).data('mode');
	var title=$(this).data('title');

	if(!$(".chk_no").is(":checked")){
		alert("선택된 접수건이 없습니다.");
		return false;
	
	}else if((mode=="memo" || mode=="admin_memo") && !$("#i_memo").val()){
		alert("내용을 입력해주세요.");
		$("#i_memo").focus();
		return false;
	}else{		
		if(confirm('['+title+'] 변경하시겠습니까?')){
			$("input[name='mode']").val(mode);
			if(mode=='step')$("input[name='step']").val($(this).data('step'));
			$("#badForm").submit();
		}
    }
});


$(".checkForm").click(function(){
	var mode=$(this).data('mode');
	var title=$(this).data('title');
	
	if(!$("#excelFile").val()){
		alert("파일을 등록해주세요.");
		return false;
	}
	if(confirm('['+title+'] 등록하시겠습니까?')){
		$("input[name='mode']").val(mode);
		$("#badForm").submit();
	}
   
});


$("#print_xls").click(function(){
    $("input[name='print_xls']").val("1");
    $("#badSearch").submit();
    $("input[name='print_xls']").val("0");
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>