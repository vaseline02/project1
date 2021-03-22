<?php /* Template_ 2.2.8 2021/03/16 13:30:17 /www/html/ukk_test2/data/skin/goods/goods_deal_detail.htm 000010649 */ 
$TPL__err_msg_1=empty($GLOBALS["err_msg"])||!is_array($GLOBALS["err_msg"])?0:count($GLOBALS["err_msg"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form method="post" onsubmit="return chkForm();">
	<input type="hidden" name="mode" value="info_mod">
	<input type="hidden" name="no_mod" value="<?php echo $_GET['no']?>">
	<table class="table table-bordered" >
		<col width="10%"></col>
		<col width="38%"></col>
		<col width="10%"></col>
		<col width="38%"></col>
		<tr>
			<th>진행마켓</th>
			<td><?php echo $TPL_VAR["info"]["mall_name"]?></td>
			<th>구좌위치</th>
			<td><input type="text" name="location" value="<?php echo $TPL_VAR["info"]["location"]?>"></td>
		</tr>
		<tr>
			<th>딜타입</th>
			<td>
				<select name="deal_type">
					<option value="1" <?php echo $GLOBALS["selected"]["deal_type"]['1']?>>빅딜</option>
					<option value="2" <?php echo $GLOBALS["selected"]["deal_type"]['2']?>>일반딜</option>
				</select>
			</td>
			<th>목표매출</th>
			<td><input type="text" name="sales_target" onkeyup='inNumber(event)' value="<?php echo $TPL_VAR["info"]["sales_target"]?>"></td>
		</tr>
		<tr>
			<th>행사기간</th>
			<td>
				<input type="text" name="s_date" id="s_date" class="datepicker_common" autocomplete="off" value="<?php echo $TPL_VAR["info"]["s_date"]?>"> ~ 
				<input type="text" name="e_date" id="e_date" class="datepicker_common" autocomplete="off" value="<?php echo $TPL_VAR["info"]["e_date"]?>">
			</td>
			<th>
				배송비정보
				<select name="delivery_type" class="deliveryChange">
					<option value="">== 선택 ==</option>
					<option value="1" <?php echo $GLOBALS["selected"]["delivery_type"]['1']?>>무료배송</option>
					<option value="2" <?php echo $GLOBALS["selected"]["delivery_type"]['2']?>>조건부배송비</option>
					<option value="3" <?php echo $GLOBALS["selected"]["delivery_type"]['3']?>>고정배송비</option>

				</select>
			</th>
			<td>
				<div class="delivery_price">
<?php if($TPL_VAR["info"]["delivery_type"]=='2'){?><input type='text' name='delivery_chk_price' onkeyup='inNumber(event)' value="<?php echo $TPL_VAR["info"]["delivery_chk_price"]?>">이하<?php }?>
<?php if($TPL_VAR["info"]["delivery_type"]!='1'){?><input type='text' name='delivery_price' onkeyup='inNumber(event)'  value="<?php echo $TPL_VAR["info"]["delivery_price"]?>" ><?php }?>
				</div>
				<!--<input type="text" name="s_delivery" onkeyup='inNumber(event)'>이하<input type="text" name="e_delivery" onkeyup='inNumber(event)'>-->
			</td>
		</tr>
		<tr>
			<th>행사URL</th>
			<td>
				<input type="text" name="event_url" style="width:70%" value="<?php echo $TPL_VAR["info"]["event_url"]?>">
<?php if($TPL_VAR["info"]["event_url"]){?><button type="button" class="btn btn-primary" onclick="popup('<?php echo $TPL_VAR["info"]["event_url"]?>','a','1400','1000')">링크열기</button><?php }?>
			</td>
			<th>비고</th>
			<td><input type="text" name="etc" style="width:100%" value="<?php echo $TPL_VAR["info"]["etc"]?>"></td>
		</tr>
		<tr>
			<th>딜명</th>
			<td>
				<input type="text" name="deal_name" style="width:100%" value="<?php echo $TPL_VAR["info"]["deal_name"]?>">
			</td>
			<th></th>
			<td></td>
		</tr>
	</table>
	<center>
		<button class="btn btn-primary" id="">수정</button>
	</center>
</form>

<?php if($GLOBALS["viewmode"]!='cal'){?>
	<div class="row">
		<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
	</div>
	<form enctype="multipart/form-data" id="excel_form" method="post">
	<input type="hidden" name="mode" value="excel_ins">
	<table class="table table-bordered" >
		<tr>
			<th>엑셀등록</th>
			<td><input type="file" name="excelFile[]" required/><button class="btn btn-sm btn-primary">업로드</button>
			<button type="button" class="btn btn-sm btn-success" onclick="location.href='../xls_file/goods_deal_upload.xls'">양식 다운로드</button>
			</td>
		</tr>
	</table>
	</form>
<?php }?>
<form enctype="multipart/form-data" id="excel_form" method="post">	
	<input type="hidden" name="mode" value="excel_mod">
	<table class="table table-bordered" >
		<tr>
			<th>정보수정</th>
			<td>
<?php if($GLOBALS["h_control"]['md_manager']){?>
			<input type="file" name="excelFile[]" required/><button class="btn btn-sm btn-primary">업로드</button>
<?php }?>
			<div type="button" class="btn btn-sm btn-success" id="print_xls">엑셀 다운로드</div>
			[<input type="checkbox"  value="1" name='search_noimg' id='search_noimg'>
			<label class=" label label-success" for="search_noimg">이미지 제외</label>]
			*팀장메모,가격변경만 수정가능 (리스트 항목추가시 업로드 양식 변경필요)

			</td>
		</tr>
	</table>
</form>


<?php if($GLOBALS["err_msg"]){?>
<div style="overflow: auto; height:400px;">
<?php if($TPL__err_msg_1){foreach($GLOBALS["err_msg"] as $TPL_V1){?>
	<?php echo $TPL_V1?><br>
<?php }}?>
</div>
<?php }?>
<?php }?>

<form method="post" id="listForm" name="listForm">
<table class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
<input type="hidden" name="print_xls" value="">
<input type="hidden" name="search_noimg" value="">
<input type="hidden" name="mode" value="">
	<thead>
		<tr>			
			<th>브랜드</th>
			<th>모델명</th>
			<th>이미지</th>
			<th>가용수량</th>
			<th>입예수량</th>
			<th>제안수량</th>
			<th>가격</th>
			<th>EC행사가</th>
			<th>제휴몰</th>
			<th>수수료</th>
			<th>등록원가</th>
			<th>현재원가</th>
			<th>수익율</th>
			<th>수익원</th>
			<th>쿠폰율</th>
			<th>메모</th>
			<th>재고메모</th>
			<th>가격로그</th>
			<th>7일</th>
			<th>15일</th>
			<th>1달</th>
			<th>2달</th>
			<th>3달</th>
<?php if($GLOBALS["sess"]['m_no']== 24||$GLOBALS["sess"]['m_no']== 33||$GLOBALS["sess"]['m_no']== 69||$GLOBALS["sess"]['m_no']== 142){?>
			<th>최근 딜</th>
			<th>(가격)</th>
<?php }?>
			<th>팀장메모</th>
			<th>가격변경</th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>				
		<tr>			
			<input type="hidden" name="deal_no[]" value="<?php echo $TPL_V1["no"]?>">
			<input type="hidden" name="goods_no[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["goods_no"]?>">
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["g_goodsnm"]?></td>
			<td class="td_img" style="height:80px;width:80px;"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo number_format($TPL_V1["psb_stock"])?></td>
			<td><?php echo number_format($TPL_V1["codeno_3"])?></td>
			<td><?php echo $TPL_V1["quantity"]?></td>
			<td><?php echo number_format($TPL_V1["price"])?></td>
			<td><?php echo number_format($TPL_V1["ec_price"])?></td>
			<td><?php echo number_format($TPL_V1["sangsi_price"])?></td>
			<td><?php echo $TPL_V1["comm"]?>%</td>
			<td><?php echo $TPL_V1["per_cost"]?></td>
			<td><?php echo number_format($TPL_V1["now_cost"])?></td>
			<td><?php echo number_format($TPL_V1["revenue_per"], 2)?>%</td>
			<td><?php echo $TPL_V1["revenue_price"]?></td>
			<td><?php echo $TPL_V1["coupon_rate"]?>%</td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td><?php echo $TPL_V1["stock_memo"]?></td>			
			<td>
<?php if(is_array($TPL_R2=$TPL_V1["priceLog"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<?php echo number_format($TPL_V2["b_price"])?> -> <?php echo number_format($TPL_V2["a_price"])?><br>(<?php echo $TPL_V2["reg_date"]?>)<br>
<?php }}?>
			</td>
			<td><?php echo $TPL_V1["order_7day"]?></td>
			<td><?php echo $TPL_V1["order_15day"]?></td>
			<td><?php echo $TPL_V1["order_1month"]?></td>
			<td><?php echo $TPL_V1["order_2month"]?></td>
			<td><?php echo $TPL_V1["order_3month"]?></td>
<?php if($GLOBALS["sess"]['m_no']== 24||$GLOBALS["sess"]['m_no']== 33||$GLOBALS["sess"]['m_no']== 69||$GLOBALS["sess"]['m_no']== 142){?>
			<td><?php echo $TPL_V1["past_deal"]?></td>
			<td><?php echo $TPL_V1["past_price"]?></td>
<?php }?>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td><input type="text" style="width:200px;" name="leader_memo[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["leader_memo"]?>"></td>
			<td><input type="text" style="width:100px;" name="change_price[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["change_price"]?>"></td>
<?php }else{?>
			<td><?php echo $TPL_V1["leader_memo"]?></td>
			<td><?php echo $TPL_V1["change_price"]?></td>
<?php }?>
		</tr>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">
		
	</div>
	<div  class="box_right">	
<?php if($GLOBALS["h_control"]['md_manager']){?>
		<button type="button" class="btn btn-primary chkForm" data-mode="mod" data-mess="정보수정">정보수정</button>
		<button type="button" class="btn btn-primary chkForm" data-mode="confirm" data-mess="승인">승인</button>
<?php }?>
	</div>
</div>
<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(".chkForm").click(function (){
	var mode=$(this).data("mode");
	var mess=$(this).data("mess");

	if(confirm(mess+" 처리하시겠습니까?")){
		$("input[name='mode']").val(mode);
		$("#listForm").submit();
	}
	
});


$(".deliveryChange").change(function(){
	var delivery_type=$(this).val();
	var addHtml="";
	$('.delivery_price').empty();
	if(delivery_type=="1"){
		addHtml+="무료배송";
	}else if(delivery_type=="2"){
		addHtml+="<input type='text' name='delivery_chk_price' onkeyup='inNumber(event)'>이하<input type='text' name='delivery_price' onkeyup='inNumber(event)'>";
	}else if(delivery_type=="3"){
		addHtml+="<input type='text' name='delivery_price' onkeyup='inNumber(event)'>";
	}

	$('.delivery_price').append(addHtml);
});



$("#print_xls").click(function(){
	if($('#excel_form [name="search_noimg"]:checked').val()){
		$('#listForm [name="search_noimg"]').val("1");
	}else{
		$('#listForm [name="search_noimg"]').val("0");
	}
    $("input[name='print_xls']").val("1");
    $("#listForm").submit();
    $("input[name='print_xls']").val("0");
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>