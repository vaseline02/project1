<?php /* Template_ 2.2.8 2020/11/26 14:26:39 /www/html/ukk_test2/data/skin/main/iframe_stock_list.htm 000005062 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<form method="POST" id="schedule_form">
<input type="hidden"name="print_xls" value="">
<input type="hidden"name="calendar_group_id" value="<?php echo $GLOBALS["group_id"]?>">

<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table" border="<?php echo $GLOBALS["xls_border"]?>">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo count($TPL_VAR["loop"])?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색"> -->
<?php if($GLOBALS["print_xls"]!= 1){?><span class="input-group-btn"><button class="btn btn-primary" type="button" id="print_xls">엑셀다운로드</button></span><?php }?>
						</div>
					</div>
				</caption>
				<colgroup>
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
				</colgroup>
				<thead>
					<tr>
						<th>브랜드</th>
						<th>분류</th>
						<th>이미지</th>
						<th>모델명</th>
						<!--<th>판매가</th>-->
<?php if($GLOBALS["print_xls"]!= 1){?>
						<th>예정원가<br>(확정원가)</th>
						<th>최근원가<br>(평균원가)</th>
						<th>예정수량<br>(확정수량)</th>
<?php }else{?>
						<th>예정원가</th>
						<th>확정원가</th>
						<th>최근원가</th>
						<th>평균원가</th>
						<th>예정수량</th>
						<th>확정수량</th>
<?php }?>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr>
							<td><?php echo $TPL_V1["brandnm"]?></td>
							<td><?php echo $TPL_V1["catenm"]?></td>
							<td class="td_img_sm" style="height:110px; width:110px;"><?php echo $TPL_V1["img_url"]?></td>
							<td><?php echo $TPL_V1["goodsnm"]?></td>
							<!--<td><?php echo number_format($TPL_V1["c_price"])?></td>-->
<?php if($GLOBALS["print_xls"]!= 1){?>
								<td><?php echo number_format($TPL_V1["cost_ori"])?>원<br>(<?php echo number_format($TPL_V1["cost"])?>원)</td>			
								<td>
<?php if(is_array($TPL_R2=$TPL_V1["stock_list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
									<?php echo number_format($TPL_V2["cost"])?>원<br>
<?php }}?>
									<span style="color:#d9534f">(<?php echo number_format($TPL_V1["average"])?>원)</span>
								</td>						
								<td><?php echo $TPL_V1["stock_num_reg"]?><br>(<?php echo $TPL_V1["stock_num"]?>)</td>
<?php }else{?>
								<td style="width:110px;"><?php echo number_format($TPL_V1["cost_ori"])?></td>			
								<td style="width:110px;"><?php echo number_format($TPL_V1["cost"])?></td>
								<td style="width:110px;">
<?php if(is_array($TPL_R2=$TPL_V1["stock_list"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_I2== 0){?>
										<?php echo number_format($TPL_V2["cost"])?>

<?php }else{?>
										<br><?php echo number_format($TPL_V2["cost"])?>

<?php }?>									
<?php }}?>
								</td>						
								<td style="width:110px;"><?php echo number_format($TPL_V1["average"])?></td>
								<td style="width:110px;"><?php echo $TPL_V1["stock_num_reg"]?></td>
								<td style="width:110px;"><?php echo $TPL_V1["stock_num"]?></td>
<?php }?>
						</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?/*?>
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<colgroup>
		<col width="90px"/><!-- 체크박스 -->
		<col width="90px"/><!-- 브랜드 -->
		<col width="90px"/><!-- 이미지 -->
		<col width="150px"/><!-- 모델명 -->
	</colgroup>
	<thead>
		<tr>
			<th>브랜드</th>
			<th>분류</th>
			<th>이미지</th>
			<th>모델명</th>
			<th>판매가</th>
			<th>원가</th>
			<th>수량</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["catenm"]?></td>
			<td class=""><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo number_format($TPL_V1["c_price"])?></td>
			<td><?php echo $TPL_V1["cost"]?></td>						
			<td><?php echo $TPL_V1["stock_num_reg"]?>(<?php echo $TPL_V1["stock_num"]?>)</td>
		</tr>
<?php }}?>
	</tbody>
</table>
<?*/?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
	$("#print_xls").click(function(){
		$("input[name='print_xls']").val("1");
		$("#schedule_form").submit();
		$("input[name='print_xls']").val("0");
	});    
})

</script>

<?php $this->print_("footer",$TPL_SCP,1);?>