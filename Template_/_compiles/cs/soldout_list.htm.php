<?php /* Template_ 2.2.8 2020/07/30 09:13:23 /www/html/ukk_test/data/skin/cs/soldout_list.htm 000005939 */ 
$TPL_mall_list_1=empty($TPL_VAR["mall_list"])||!is_array($TPL_VAR["mall_list"])?0:count($TPL_VAR["mall_list"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<style>
.search_td_width{width:360px;}
.mallLabel{ display:inline-block; width:200px; line-height:23px;}
</style>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form method="post">
	<table class="table table-bordered" >

		<tr>
			<th>주문일자</th>
			<td>
			<input type="text" name="s_date" id="s_date" class="datepicker_common" autocomplete="off" value="<?php echo $GLOBALS["s_date_value"]?>"> ~ 
			<input type="text" name="e_date" id="e_date" class="datepicker_common" autocomplete="off" value="<?php echo $GLOBALS["e_date_value"]?>">
			<div style='padding-top:5px'>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='0' data-type='day'>오늘</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='7' data-type='day'>7일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='15' data-type='day'>15일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='month'>1개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='month'>3개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='year'>1년</span>
			</div>
			</td>
			<th>주문번호</th>
			<td>
				
				<input type="text" name="s_ordno" value="<?php echo $_GET['s_ordno']?>">
				<!--<label style="font-weight: normal;"><input type="checkbox" name="s_complete" value="Y" <?php echo $GLOBALS["checked"]["s_complete"]["Y"]?>>품절완료건</label>-->
				
			</td>
			<th rowspan="5">몰명</th>
			<td rowspan="5">
				<div style="overflow: auto; height:210px; font-size: 11px;">
					
<?php if($TPL_mall_list_1){foreach($TPL_VAR["mall_list"] as $TPL_V1){?>
				
					<label class="mallLabel"><input type="checkbox" name="s_mall_no[]" value=<?php echo $TPL_V1["no"]?> <?php echo $GLOBALS["checked"]['mall_no'][$TPL_V1["no"]]?>><?php if($TPL_V1["upload_form_type"]!='사방넷'){?>(<?php echo $TPL_V1["upload_form_type"]?>)<?php }?><?php echo $TPL_V1["mall_name"]?></label>
				
<?php }}?>
					
			
				</div>
				<!-- <select name="s_mall_no">
					<option value="">선택</option>
<?php if($TPL_mall_list_1){foreach($TPL_VAR["mall_list"] as $TPL_V1){?>
						<option value=<?php echo $TPL_V1["no"]?> <?php echo $GLOBALS["selected"]['mall_no'][$TPL_V1["no"]]?>><?php echo $TPL_V1["mall_name"]?>(<?php echo $TPL_V1["mall_code"]?>)</option>
<?php }}?>
				</select> -->
				
			</td>
			
		</tr>
		<tr>			
			<th>상태</th>
			<td>
				<select name="s_complete" id="">
					<option value="0" <?php echo $GLOBALS["selected"]['s_complete']['0']?>>전체</option>		
					<option value="1" <?php echo $GLOBALS["selected"]['s_complete']['1']?>>미처리</option>		
					<option value="2" <?php echo $GLOBALS["selected"]['s_complete']['2']?>>처리완료</option>		
				</select>
			</td>
			<th>송장번호</th>
			<td><input type="text" name="s_invoice" value="<?php echo $_GET['s_invoice']?>"></td>
		</tr>
		<tr>
			
			<th>고객명</th>
			<td class="search_td_width"><input type="text" name="s_receiver" value="<?php echo $_GET['s_receiver']?>"></td>
			<th>모델명</th>
			<td class="search_td_width"><input type="text" name="s_mall_goodsnm" value="<?php echo $_GET['s_mall_goodsnm']?>"></td>
		</tr>
		<tr>
			<th>연락처</th>
			<td class="search_td_width"><input type="text" name="s_mobile" value="<?php echo $_GET['s_mobile']?>"></td>
			<th></th>
			<td></td>
		</tr>
		
	</table>
	<center>
		<button class="btn btn-primary" id="">검 색</button>
	</center>
</form>

<?php }?>

<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th data-orderable="false"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>			
			<th width='50'>몰명</th>
			<th width='200'>주문번호</th>
			<th>이미지</th>
			<th width='150'>옵션명</th>
			<th width='50'>수량</th>
			<th width='80'>가격</th>
			<th width='50'>구매자<br>수령자</th>
			<th width='120'>연락처<br>모바일</th>
			<th>주소</th>
			<th width='100'>주문일자</th>
			<th></th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="<?php echo $TPL_V1["line_color"]?>">			
			<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td>
			<td><?php echo $TPL_V1["mall_name"]?></td>
			<td><?php echo $TPL_V1["ordno"]?> <?php if($TPL_V1["copy_seq"]> 0){?>복사본<?php }?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["order_num"]?></td>
			<td><?php echo number_format($TPL_V1["order_price"])?></td>
			<td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>
			<td><?php echo $TPL_V1["buyer_mobile"]?><br/><?php echo $TPL_V1["mobile"]?></td>
			<td><?php echo $TPL_V1["zipcode"]?> <?php echo $TPL_V1["address"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td><button type="button" class="btn btn-sm btn-warning" onclick="popup('soldout_reg.php?ordno=<?php echo $TPL_V1["ordno"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>','','1100','900')">CS등록</button></td>
		</tr>
<?php }}?>
	</tbody>
</table>


<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>