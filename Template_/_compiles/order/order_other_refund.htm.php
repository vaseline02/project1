<?php /* Template_ 2.2.8 2020/12/03 17:57:31 /www/html/ukk_test2/data/skin/order/order_other_refund.htm 000005155 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
<div>
<form method="post" id="order_search_form">
	<table class="table table-bordered" >
		<tr>
			<th >상품명</th>
			<td>
			<input type="input" class="form-control" name="s_goodsnm" value="<?php echo $_POST['s_goodsnm']?>">
			<!-- <input type="text" name="order_search_ordno" value="<?=$_POST['order_search_ordno']?>"> -->
			</td>
		</tr>		
		<tr>
			<th scope="row">등록일</th>
			<td colspan="3" class="receive-title no-gutters">				
				<div class="col-md-2 date-wrap">
					<div class="input-group">
						<input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="s_date" id="s_date" value="<?php echo $GLOBALS["s_date_value"]?>"  />
					</div>
				</div>
				
				<p class="date-tilde">~</p>
				<div class="col-md-2 date-wrap">
					<div class="input-group">
						<input type="text" class="form-control datepicker_common" placeholder="종료 날짜" aria-describedby="basic-addon2" name="e_date" id="e_date" value="<?php echo $GLOBALS["e_date_value"]?>"  />
					</div>										
				</div>
				<script>
					
				</script>
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
						<th>옵션명</th>
						<th>수량</th>
						<th>금액</th>
						<th>입고위치(재고)</th>
						<th>재고번호</th>
						<th>차감가능수량</th>
						<th>메모</th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr onclick="javascript:$('#chk_no_<?php echo $TPL_V1["no"]?>').prop('checked',true);">			
<?php if($GLOBALS["print_xls"]!= 1){?><td><input type="radio" style="cursor:pointer;" class="chk_no" name="chk_no" id="chk_no_<?php echo $TPL_V1["no"]?>" value="<?php echo $TPL_V1["no"]?>" data-stock="<?php echo $TPL_V1["mall_stock"]?>"></td><?php }?>
							<td><?php echo $TPL_V1["goodsnm"]?></td>
							<td><?php echo $TPL_V1["num"]?></td>
							<td><?php echo number_format($TPL_V1["price"])?></td>
							<td><?php echo $TPL_V1["mall_name"]?>(<?php echo $TPL_V1["mall_stock"]?>)</td>
							<td><?php echo $TPL_V1["stock_seq"]?></td>
							<td><?php echo $TPL_V1["now_cnt"]?></td>
							<td><?php echo $TPL_V1["memo"]?></td>
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
				<th>수량</th>
				<td><input type="text" name="num" onkeyup='inNumber(event)' value="0" ></td>
				<th>적용일</th>
				<td>
				<input type="text" class="datepicker_common" placeholder="적용일" aria-describedby="basic-addon2" name="comp_date" id="comp_date" readonly />
				</td>
			</tr>		
			<tr>
				<th>메모</th>
				<td colspan='3'><input type="text" class="form-control" name="memo" value="" ></td>				
			</tr>
		</table>
	</div>
	
<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
	$(".checkForm").click(function(){
		var now_stock=$(":input:radio[name=chk_no]:checked").data('stock');
		if(!$(":input:radio[name=chk_no]:checked").val()){
			alert("주문을 선택해주세요.");
			return false;
		}		
		if(Number($("input[name=num]").val())=='0'){
			alert("수량을 입력해주세요.");
			return false;
		}
		if(Number(now_stock)<Number($("input[name=num]").val())){
			alert("수량이 부족합니다.");
			return false;
		}
		if(!$("input[name=comp_date]").val()){
			alert("적용일을 입력해주세요.");
			return false;
		}

		if(confirm("등록하시겠습니까?")){
			$("form[name='outsideForm']").submit();	
		}
	});
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>