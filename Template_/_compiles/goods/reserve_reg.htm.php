<?php /* Template_ 2.2.8 2020/10/15 17:13:42 /www/html/ukk_test2/data/skin/goods/reserve_reg.htm 000006432 */ 
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<style>
.search_td_width{width:800px;}
.border_fff{border:1px solid #fff}
</style>

<form method="post" id="main_form">
	<input type="hidden" name="mode" id="mode">
	<input type="hidden" name="order_list_no" id="order_list_no" value="<?php echo $GLOBALS["order_list_no"]?>">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>
	<div class="col-lg-12">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="12%" />
					<col width="24%" />
					<col width="12%" />
					<col width="15%" />
					<col width="12%" />
					<col width="25" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row" class="align-left" >모델명</th>
						<td class="receive-title no-gutters">
							<input type="hidden" name="gno" id="gno">
							<div class="col-xs-12"><input type="text" class="form-control" readonly id="gnm"/></div>
						</td>
						<th scope="row">재고차감위치</th>
						<td class="receive-title no-gutters">
							<select name="codeno" id="codeno">
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["cd"]?></option>
<?php }}?>
							</select>
						</td>
						<th scope="row">수량</th>
						<td class="receive-title no-gutters">
							3자물류 : <input type="text" id="cnt51" readonly size=4 class="border_fff">
							사무실 : <input type="text" id="cnt1" readonly size=4  class="border_fff">
							<div class="col-xs-12"><input type="text" class="form-control" name='gcnt' id='gcnt' /></div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">주문번호</th>
						<td class="receive-title no-gutters" >
							<div class="col-xs-12"><input type="text" class="form-control" name='ordno' id='ordno' value="<?php echo $GLOBALS["order_no"]?>" readonly/></div>
						</td>
						<th scope="row" class="align-left">메모</th>
						<td class="receive-title no-gutters" colspan="3">
							<div class="col-xs-12"><input type="text" class="form-control" name='memo' id='memo' /></div>
						</td>
						

					</tr>
					
				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<button type="button" class="btn btn-primary reserve_ins">예약등록</button>
		</div>
	</div>	

	<div class="col-lg-12">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="12%" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row" class="align-left">모델명 검색</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><textarea class="form-control" name="s_goodsnm" id="" cols="30" rows="2"><?php echo $_POST['s_goodsnm']?></textarea></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<button class="btn btn-primary">검색</button>
		</div>
	</div>	
</form>



<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th>모델명</th>
			<th>이미지</th>
			<th width='100'>판매가</th>
			<th width='100'>소비자가</th>
			<th width='50'>3자물류</th>
			<th width='50'>사무실</th>
			<th></th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="<?php echo $TPL_V1["line_color"]?>">			
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo number_format($TPL_V1["s_price"])?>원</td>
			<td><?php echo number_format($TPL_V1["c_price"])?>원</td>
			<td><?php echo $TPL_V1["codeno_51"]?></td> 
			<td><?php echo $TPL_V1["codeno_1"]?></td> 
			<td>
				<div><button type="button" class="btn btn-sm btn-warning goodsClick" data-no=<?php echo $TPL_V1["no"]?> data-goodsnm='<?php echo $TPL_V1["goodsnm"]?>' data-stock_yn='<?php echo $TPL_V1["stock_yn"]?>' data-cnt51='<?php echo $TPL_V1["codeno_51"]?>' data-cnt1='<?php echo $TPL_V1["codeno_1"]?>' >선택</button></div>
				<!-- <div style="padding-top: 5px;"><button type='button' class='btn btn-sm btn-warning' onclick="popup('stock_hold.php?goodsno=<?php echo $TPL_V1["no"]?>&order_no=<?php echo $GLOBALS["order_no"]?>&order_list_no=<?php echo $GLOBALS["order_list_no"]?>','stock_hold','1000','900')">재고보류<?php if($TPL_V1["hold_count"]){?>(<?php echo $TPL_V1["hold_count"]?>)<?php }?></button></div> -->
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>


<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
	
	$(".reserve_ins").click(function(){
		var gno=$("#gno").val();
		var gcnt=$("#gcnt").val();
		var memo=$("#memo").val();
		var ordno=$("#ordno").val();
		var order_list_no=$("#order_list_no").val();
		
		var codeno=$("#codeno").val();
		var cnt_chk=$("#cnt"+codeno).val();
		
		if(gno==''){
			alert('상품을 검색후 선택해주세요.');
			return false;
		}else if(gcnt==''){
			alert('수량을 입력해주세요.');
			return false;
		}else if(memo==''){
			alert('메모을 입력해주세요.');
			return false;
		}else if(ordno==''){
			alert('주문번호를 입력해주세요.');
			return false;
		}else if(Number(cnt_chk)<gcnt){
			alert('수량이 재고보다 많습니다.');
			return false;
		}else{
			if(confirm('처리하시겠습니까?')){
				
				$("#mode").val("reserve_ins");
				$("#main_form").submit();
			}
			
		}

	});

	$(".goodsClick").click(function(){
		var goodsno=$(this).data('no');
		var goodsnm=$(this).data('goodsnm');
		var cnt51=$(this).data('cnt51');
		var cnt1=$(this).data('cnt1');
		
		$("#gno").val(goodsno);
		$("#gnm").val(goodsnm);
		$("#cnt51").val(cnt51);
		$("#cnt1").val(cnt1);

		//$(window).scrollTop(0);
	});
});


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>