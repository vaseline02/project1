<?php /* Template_ 2.2.8 2021/01/19 14:36:00 /www/html/ukk_test2/data/skin/goods/goods_detail_pop.htm 000007567 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_loop_stock_1=empty($TPL_VAR["loop_stock"])||!is_array($TPL_VAR["loop_stock"])?0:count($TPL_VAR["loop_stock"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<form method="get">
	<input type="hidden" name="goodsno" value="<?php echo $_GET['goodsno']?>">
	<table class="table table-bordered" >

		<tr>
			<th>판매데이터기간</th>
			<td>
			<input type="text" name="s_date" id="s_date" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['s_date']?>"> ~ 
			<input type="text" name="e_date" id="e_date" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['e_date']?>">
			<div style='padding-top:5px'>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='0' data-type='day'>오늘</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='7' data-type='day'>7일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='15' data-type='day'>15일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='month'>1개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='month'>3개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='year'>1년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='year'>3년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='5' data-type='year'>5년</span>
			</div>
			</td>
			<th>입고데이터기간</th>
			<td>
			<input type="text" name="s_date2" id="s_date2" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['s_date2']?>"> ~ 
			<input type="text" name="e_date2" id="e_date2" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['e_date2']?>">
			<div style='padding-top:5px'>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='0' data-type='day' data-s_date_id='s_date2' data-e_date_id='e_date2'>오늘</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='7' data-type='day' data-s_date_id='s_date2' data-e_date_id='e_date2'>7일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='15' data-type='day' data-s_date_id='s_date2' data-e_date_id='e_date2'>15일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='month' data-s_date_id='s_date2' data-e_date_id='e_date2'>1개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='month' data-s_date_id='s_date2' data-e_date_id='e_date2'>3개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='year' data-s_date_id='s_date2' data-e_date_id='e_date2'>1년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='year' data-s_date_id='s_date2' data-e_date_id='e_date2'>3년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='5' data-type='year' data-s_date_id='s_date2' data-e_date_id='e_date2'>5년</span>
			</div>
			</td>			
		</tr>		
	</table>
	<center>
	<button class="btn btn-sm btn-primary" id="">검 색</button>		
	</center>
</form>
<form method="post" id="main_form">
<!--<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->
<table id="" class="display " data-height="740" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<caption>
		<div class="input-group col-lg-12 common-table-search2">
			<span class="common-table-result"><?php echo $GLOBALS["goodsnm_title"]?></span>
			<div class="input-group common-table-search">
			</div>
		</div>
	</caption> 
	<thead>
		<tr>
			<th style="text-align:center">판매데이터</th>
			<th>|</th>
			<th style="text-align:center">입고데이터</th>	
		</tr>
	</thead>
	<tbody>
	<tr>
		<td style="vertical-align:top;width:65%">
			<table id="" class="display display_s" data-height="540" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
			<thead>
				<tr>
					<th>판매가</th>
					<th>원가</th>
					<th>수량</th>
					<th>마켓명</th>
					<th>주문번호</th>
					<th>출고일</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
				<tr>
					<td><?php echo number_format($TPL_V1["settle_price"])?></td>
					<td><?php echo number_format($TPL_V1["order_cost"])?></td>
					<td><?php echo number_format($TPL_V1["order_num"])?></td>
					<td><?php echo $TPL_V1["mall_name"]?></td>
					<td><?php echo $TPL_V1["ordno"]?></td>
					<td><?php echo $TPL_V1["mod_date"]?></td>
					
				</tr>
<?php }}?>
			</tbody>
			</table>
		</td>
		<td>|</td>
		<td style="vertical-align:top">
			<table id="" class="display display_s" data-height="540" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
			<thead>
				<tr>
					<th>수량(예정)</th>
					<th>원가</th>
					<th>입고완료</th>
					<th>입고등록</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_loop_stock_1){foreach($TPL_VAR["loop_stock"] as $TPL_V1){?>
				<tr>
					<td><?php echo number_format($TPL_V1["stock_num"])?><?php if($TPL_V1["state"]== 0||$TPL_V1["comp_chk"]=='n'){?> (입고예정 : <?php echo $TPL_V1["stock_num_reg"]-$TPL_V1["stock_num"]?>)<?php }?></td>
					<td><?php echo number_format($TPL_V1["cost"])?></td>
					<td><?php echo $TPL_V1["comp_date"]?></td>
					<td><?php echo $TPL_V1["reg_date"]?></td>					
				</tr>
<?php }}?>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?></div>


<div class="bottom_btn_box">
	<div class="box_left">
	</div>
	<div  class="box_right">
	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li></li>
  </ul>
</fieldset>

<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";


$(function(){
	
	$("#stock_comp").click(function(){
		
		var sloc=$(".stock_comp_loc option:selected").html();

		if( $(".chk_no:checked").length <=0 ){
			alert('입고예정등록할 상품을 선택해주세요.');
			return;
		}

		if( $("#cal_text").val()=='' ){
			alert('일정명을 입력해주세요.');
			$("#cal_text").focus();
			return;
		}

		if(confirm('입고예정등록 하시겠습니까?')){
			
			$("#mode").val("stock_comp");
			$("#main_form").submit();
		}
	});

	$("#chg_img_step").click(function(){

		if( $(".chk_no:checked").length <=0 ){
			alert('변경할 제품을 선택해주세요.');
			return;
		}
		
		if(confirm('변경하시겠습니까?')){
			$("#mode").val('chg_img_step');
			var formData = new FormData($("#main_form")[0]);
			
			$.ajax({
				type : "POST",
				url : "_indb.php",
				data : formData,
				processData: false,
				contentType: false,
				err : function(err) {
					alert(err.status);
				}
			}).done(function(data){
				if(data==1){
					alert('처리되었습니다.');
					location.reload();
				}
			}).fail(function(jqXHR, textStatus){
				alert( "Request failed: " + textStatus );
			});
		}
	});

})


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>