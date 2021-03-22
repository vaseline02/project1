<?php /* Template_ 2.2.8 2020/11/17 10:24:23 /www/html/ukk_test2/data/skin/order/order_outside_search.htm 000004428 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
<div>
<form method="post" id="order_search_form">
	<table class="table table-bordered" >
		<tr>
			<th >주문번호</th>
			<td>
			<input type="input" class="form-control" name="s_ordno" value="<?php echo $_POST['order_search_ordno']?>">
			<!-- <input type="text" name="order_search_ordno" value="<?=$_POST['order_search_ordno']?>"> -->
			</td>
		</tr>		
	</table>
	<center class="table-btn-group" style="margin-bottom:0px">
		<button class="btn btn-primary" id="">검 색</button>
	</center>	
</form>

</div>
<form method="post" name="outsideForm">
	<input type="hidden" name="mode" value="ins">
	<div class="col-lg-12">
		<div class="row">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<!--<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>-->
						<div class="input-group common-table-search">
							<span class="input-group-btn"><div class="btn btn-primary checkForm" id="">등록</div></span>
							<!-- <input type="text" class="form-control" placeholder="결과내 검색">
							<span class="input-group-btn"><button class="btn btn-primary" type="button">검색</button></span> -->
						</div>
					</div>
				</caption>
				<colgroup>
					
				</colgroup>
				<thead>
					<tr>		
						<th></th>
						<th>몰명</th>
						<th>주문번호</th>
						<th>고객명</th>
						<th>옵션명</th>
						<th>수량</th>
						<th>주문단계</th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr onclick="javascript:$('#chk_no_<?php echo $TPL_V1["no"]?>').prop('checked',true);">			
<?php if($GLOBALS["print_xls"]!= 1){?><td><input type="radio" style="cursor:pointer;" class="chk_no" name="chk_no" id="chk_no_<?php echo $TPL_V1["no"]?>" value="<?php echo $TPL_V1["no"]?>"></td><?php }?>
							<td><?php echo $TPL_V1["mall_name"]?><br/><?php echo $TPL_V1["upload_form_type"]?></td>
							<td><?php echo $TPL_V1["ordno"]?></td>
							<td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>
							<td><?php echo $TPL_V1["goodsnm"]?></td>
							<td><?php echo $TPL_V1["order_num"]?></td>
							<td><?php echo $TPL_V1["step_lv"]?></td>
						</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
<?php if($TPL_VAR["loop"]){?>
	<div style="padding-top:30px;">
		<table class="table table-bordered" >
			<tr>
				<th>등록유형</th>
				<td colspan='3'>
				<label style="font-weight: normal;"><input type="radio" style="cursor:pointer;" name="outside_type" id="" value="AS"> AS</label>
				<label style="font-weight: normal; padding-left:30px;"><input type="radio" style="cursor:pointer;" name="outside_type" id="" value="배송비지불"> 배송비지불</label>
				<label style="font-weight: normal; padding-left:30px;"><input type="radio" style="cursor:pointer;"  name="outside_type" id="" value="반품"> 반품</label>
				</td>
			</tr>		
			<tr>
				<th>업체배송비</th>
				<td><input type="text" name="ent_deli_price" onkeyup='inNumber(event)' value="0" ></td>
				<th>배송시작일</th>
				<td>
				<input type="text" class="datepicker_common" placeholder="배송시작일" aria-describedby="basic-addon2" name="comp_date" id="comp_date" readonly />
				</td>
			</tr>
		</table>
	</div>
	
<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
	$(".checkForm").click(function(){
		if(!$(":input:radio[name=chk_no]:checked").val()){
			alert("주문을 선택해주세요.");
			return false;
		}
		if(!$(":input:radio[name=outside_type]:checked").val()){
			alert("등록유형을 선택해주세요.");
			return false;
		}
		if(confirm("등록하시겠습니까?")){
			$("form[name='outsideForm']").submit();	
		}
	});
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>