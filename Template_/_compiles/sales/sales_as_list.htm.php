<?php /* Template_ 2.2.8 2021/02/01 10:32:57 /www/html/ukk_test2/data/skin/sales/sales_as_list.htm 000008432 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php if($GLOBALS["print_xls"]!= 1){?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<?php echo $this->define('tpl_include_file_1',"sales/sales_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<form enctype="multipart/form-data" name="searchForm" id="searchForm" method="get">
    <input type="hidden"name="print_xls" value="">
	<table class="table table-bordered" >		
        <tr>
			<th>검색유형</th>
            <td>
                <select name="date_type">
					<option value="">== 선택 ==</option>					
                    <option value="2" <?php echo $GLOBALS["selected"]['date_type']['2']?>>정 > 불</option>					
                    <option value="1" <?php echo $GLOBALS["selected"]['date_type']['1']?>>불 > 정</option>			
					<option value="3" <?php echo $GLOBALS["selected"]['date_type']['3']?>>폐기</option>		
				</select>
            </td>
            <th>날짜</th>
            <td>                 
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
                        <input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="s_date" id="s_date" value="<?php echo $_GET['s_date']?>"  />
                        <span class="input-group-btn">
                            <button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="s_date"><span class="glyphicon glyphicon-list-alt"></span></button>
                        </span>
                    </div>
                </div>
                
                <p class="date-tilde">~</p>
                <div class="col-md-2 date-wrap">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker_common" placeholder="종료 날짜" aria-describedby="basic-addon2" name="e_date" id="e_date" value="<?php echo $_GET['e_date']?>"  />
                        <span class="input-group-btn">
                            <button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="e_date"><span class="glyphicon glyphicon-list-alt"></span></button>
                        </span>
                    </div>										
                </div>
            </td>
        </tr>
	</table>
	<center>
        <button class="btn btn-primary chkForm" id="">검색</button>
        <button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>
	</center>
</form>
<?php }?>

<form method="post" id="listForm" name="listForm">	
	<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
		<thead>
			<tr>			
				<th>조정일자</th>
				<th>창고코드</th>
				<th>장소코드</th>
				<th>조정구분</th>
				<th>품번</th>
				<th>조정수량</th>
				<th>단가</th>
				<th>비고(건)</th>
				<th>금액</th>
				<th></th>
				<th></th>				
            </tr>
<?php if($GLOBALS["print_xls"]== 1){?>
            <tr>			
				<th>ADJUST_DT</th>
				<th>WH_CD</th>
				<th>LC_CD</th>
				<th>ADJUST_FG</th>
				<th>ITEM_CD</th>
				<th>ADJUST_QT</th>
				<th>ADJUST_UM</th>
				<th>REMARK_DC</th>
				<th>ADJUST_AM</th>
				<th></th>
				<th></th>				
            </tr>
            <tr>			
				<th>
                    타입 : 문자<br>
                    길이 : 8<br>
                    필수 : True<br>
                    설명 : 영문/숫자 기준 8자리(YYYYMMDD)를 입력 하세요.
                </th>
				<th>
                    타입 : 문자<br>
                    길이 : 4<br>
                    필수 : True<br>
                    설명 : 1000 <<총재고(고정)<br>
                    영문/숫자 기준 4자리(최대)를 입력 하세요.
                </th>
				<th>
                    타입 : 문자<br>
                    길이 : 4<br>
                    필수 : True<br>
                    설명 : 우측 장소코드 참조<br>
                    영문/숫자 기준 4자리(최대)를 입력 하세요.
                </th>
				<th>
                    타입 : 문자<br>
                    길이 : 1<br>
                    필수 : True<br>
                    설명 : 0.기초조정,1.입고조정,2.출고조정
                </th>
				<th>
                    타입 : 문자<br>
                    길이 : 30<br>
                    필수 : True<br>
                    설명 : 영문/숫자 기준 30자리(최대)를 입력 하세요.
                </th>
				<th>
                    타입 : 숫자<br>
                    길이 : 17,6<br>
                    필수 : True<br>
                    설명 : 숫자 기준 17,6자리를 입력 하세요.(숫자만 입력(소숫점자리수 정확히 입력))
                </th>
				<th>
                    타입 : 숫자<br>
                    길이 : 17,6<br>
                    필수 : False<br>
                    설명 : 숫자 기준 17,6자리를 입력 하세요.(숫자만 입력(소숫점자리수 정확히 입력))
                </th>
				<th>
                    타입 : 문자<br>
                    길이 : 60<br>
                    필수 : False<br>
                    설명 : 영문/숫자 기준 60자리(최대)를 입력 하세요.
                </th>
				<th>
                    타입 : 숫자<br>
                    길이 : 17,4<br>
                    필수 : False<br>
                    설명 : 숫자 기준 17,4자리를 입력 하세요.(숫자만 입력(소숫점자리수 정확히 입력))
                    =G4*F4
                </th>
				<th></th>
				<th></th>				
            </tr>
<?php }?>
		</thead>	
		<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr>			
				<td><?php echo $TPL_V1["date"]?></td>
				<td>1000</td>
				<td><?php echo $TPL_V1["place_code"]?></td>
				<td><?php echo $TPL_V1["division"]?></td>
				<td class="text_type"><?php echo $TPL_V1["g_goodsnm"]?></td>
				<td><?php echo $TPL_V1["quantity"]?></td>
				<td><?php echo number_format($TPL_V1["cost"])?></td>
				<td><?php echo $TPL_V1["no"]?>/<?php echo $TPL_V1["etc_text"]?></td>
				<td><?php echo number_format($TPL_V1["cost"]*$TPL_V1["quantity"])?></td>
				<td></td>				
				<td><?php echo $TPL_V1["brandnm"]?>-<?php echo $TPL_V1["g_goodsnm"]?></td>				
			</tr>
<?php }}?>
		</tbody>
	</table>
</form>
<script>

document.title="<?php echo $GLOBALS["page_title"]?>";
$("#nav_div1").addClass('active');
$(".chkForm").click(function(){
	// if(!$("select[name='date_type']").val()){
	// 	alert("검색유형을 선택해주세요.");
	// 	return false;
	// }
	
	if(!$("input[name='s_date']").val() || !$("input[name='e_date']").val()){
		alert("날짜를 입력해주세요.");
		return false;
	}	
    $("#searchForm").submit();
});

$("#print_xls").click(function(){
    $("input[name='print_xls']").val("1");
    $("#searchForm").submit();
    $("input[name='print_xls']").val("0");
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>