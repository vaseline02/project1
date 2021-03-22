<?php /* Template_ 2.2.8 2021/03/17 11:15:07 /www/html/ukk_test2/data/skin/goods/goods_deal_list.htm 000007677 */ 
$TPL_mall_glist_1=empty($TPL_VAR["mall_glist"])||!is_array($TPL_VAR["mall_glist"])?0:count($TPL_VAR["mall_glist"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<style>
.search_td_width{width:380px;}
.mallLabel{ display:inline-block; width:200px; line-height:23px;}
</style>

<?php if($GLOBALS["print_xls"]!= 1){?>

<form enctype="multipart/form-data" method="post" onsubmit="return chkForm();">
	<input type="hidden" name="mode" value="deal_ins">
	<table class="table table-bordered" >
		<col width="10%"></col>
		<col width="38%"></col>
		<col width="10%"></col>
		<col width="38%"></col>
		<tr>
			<th>진행마켓</th>
			<td >
				<select name="mall_group" id="mall_group">
					<option value="">== 선택 ==</option>
<?php if($TPL_mall_glist_1){foreach($TPL_VAR["mall_glist"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["upload_form_type"]?>"><?php echo $TPL_V1["upload_form_type"]?></option>
<?php }}?>
				</select>
				<select name="mall_no" id="mall_no">
				</select>
			</td>
			<th>구좌위치</th>
			<td><input type="text" name="location"></td>
		</tr>
		<tr>
			<th>딜타입</th>
			<td>
				<select name="deal_type">
					<option value="1">빅딜</option>
					<option value="2">일반딜</option>
				</select>
			</td>
			<th>목표매출</th>
			<td><input type="text" name="sales_target" onkeyup='inNumber(event)'></td>
		</tr>
		<tr>
			<th>행사기간</th>
			<td>
				<input type="text" name="s_date" id="s_date" class="datepicker_common" autocomplete="off"> ~ 
				<input type="text" name="e_date" id="e_date" class="datepicker_common" autocomplete="off">
			</td>
			<th>
				배송비정보
				<select name="delivery_type" class="deliveryChange">
					<option value="">== 선택 ==</option>
					<option value="1">무료배송</option>
					<option value="2">조건부배송비</option>
					<option value="3">고정배송비</option>

				</select>
			</th>
			<td>
				<div class="delivery_price"></div>
				<!--<input type="text" name="s_delivery" onkeyup='inNumber(event)'>이하<input type="text" name="e_delivery" onkeyup='inNumber(event)'>-->
			</td>
		</tr>
		<tr>
			<th>행사URL</th>
			<td>
				<input type="text" name="event_url" style="width:100%">
			</td>
			<th>비고</th>
			<td><input type="text" name="etc" style="width:100%"></td>
		</tr>
		<tr>
			<th>딜명</th>
			<td>
				<input type="text" name="deal_name" style="width:100%">
			</td>
			<th></th>
			<td></td>
		</tr>
	</table>
	<center>
		<button class="btn btn-primary" id="">딜 등록</button>
	</center>
</form>
<?php }?>

<!-- <div class="table_title" >일반접수</div> -->
<form method="post" id="dealForm" name="dealForm">
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="no" value="">
	<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
		<thead>
			<tr>
				<th width="50">몰구분</th>
				<th width="50">진행마켓</th>
				<th>구좌위치</th>
				<th>딜타입</th>
				<th>목표매출</th>
				<th>행사기간</th>
				<th>배송비정보</th>
				<th>행사URL</th>
				<th>비고</th>
				<th>딜명</th>
				<th>등록자</th>
				<th>등록일</th>
				<th>확인일</th>
				<th></th>
				<th></th>
			</tr>
		</thead>	
		<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["upload_form_type"]?></td>
				<td><?php echo $TPL_V1["mall_name"]?></td>
				<td><?php echo $TPL_V1["location"]?></td>
				<td><?php echo $TPL_V1["deal_type_name"]?></td>
				<td><?php echo number_format($TPL_V1["sales_target"])?></td>
				<td><?php echo $TPL_V1["s_date"]?>~<?php echo $TPL_V1["e_date"]?></td>
				<td><?php echo $TPL_V1["delivery_price"]?></td>
				<td><?php echo $TPL_V1["event_url"]?></td>
				<td><?php echo $TPL_V1["etc"]?></td>
				<td><?php echo $TPL_V1["deal_name"]?></td>
				<td><?php echo $TPL_V1["admin_name"]?></td>
				<td><?php echo $TPL_V1["reg_date"]?></td>
				<td><?php echo $TPL_V1["confirm_date"]?></td>
				<td>
					<button type="button" class="btn btn-sm btn-warning" onclick="popup('goods_deal_detail.php?no=<?php echo $TPL_V1["no"]?>','goods_deal_detail','1500','700')">상품상세</button>					
				</td>
				<td>
					<button type="button" class="btn btn-sm btn-danger dealIndb" data-mode="deal_del" data-no="<?php echo $TPL_V1["no"]?>">딜삭제</button>
				</td>
			</tr>
<?php }}?>
		</tbody>
	</table>
</form>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<?php }?>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

function chkForm(){
	if(!$("select[name='mall_no']").val()){
		alert("진행마켓을 선택해주세요.");
		return false;
	}
	if(!$("input[name='location']").val()){
		alert("구좌위치를 등록해주세요.");
		return false;
	}
	if(!$("select[name='deal_type']").val()){
		alert("딜타입을 선택해주세요.");
		return false;
	}

	if(!$("input[name='sales_target']").val()){
		alert("목표매출을 등록해주세요.");
		return false;
	}
	if(!$("input[name='s_date']").val() || !$("input[name='e_date']").val()){
		alert("행사기간을 등록해주세요.");
		return false;
	}
	if(!$("select[name='delivery_type']").val()){
		alert("배송비타입을 선택해주세요.");
		return false;
	}else{
		if($("select[name='delivery_type']").val()=="2"){
			if(!$("input[name='delivery_chk_price']").val() || !$("input[name='delivery_price']").val()){
				alert("배송비정보를 등록해주세요.");
				return false;
			}
		}else if($("select[name='delivery_type']").val()=="3"){
			if(!$("input[name='delivery_price']").val()){
				alert("배송비정보를 등록해주세요.");
				return false;
			}		
		}
		
	}
	/*
	if(!$("input[name='event_url']").val()){
		alert("행사URL을 등록해주세요.");
		return false;
	}
	*/
	if(!$("input[name='deal_name']").val()){
		alert("딜명을 등록해주세요.");
		return false;
	}

	if(!confirm("등록하시겠습니까?")){
		return false;
	}

}

$(".dealIndb").click(function (){
	var mode=$(this).data("mode");
	var no=$(this).data("no");

	if(confirm("삭제하시겠습니까?")){
		$('#dealForm [name="mode"]').val(mode);
		$('#dealForm [name="no"]').val(no);

		$("form[name='dealForm']").submit();	
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

$(function(){
	
	$("#mall_group").change(function(){
		$("#mall_no").html("");
		var group_name =  $(this).val();

		$.post("../ajax/mall_select.php",{group_name:group_name},function(data){
			
			$("#mall_no").append(data);
		});
	});
});


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>