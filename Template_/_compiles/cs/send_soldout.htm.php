<?php /* Template_ 2.2.8 2020/04/06 09:22:02 /www/html/ukk_test/data/skin/cs/send_soldout.htm 000004596 */ 
$TPL_mall_list_1=empty($TPL_VAR["mall_list"])||!is_array($TPL_VAR["mall_list"])?0:count($TPL_VAR["mall_list"]);
$TPL__cfg_ing_step_1=empty($GLOBALS["cfg_ing_step"])||!is_array($GLOBALS["cfg_ing_step"])?0:count($GLOBALS["cfg_ing_step"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<style>
.search_td_width{width:800px;}
</style>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form method="post">
	<table class="table table-bordered" >

		<tr>
			<th>고객명</th>
			<td class="search_td_width"><input type="text" name="s_receiver" value="<?php echo $_POST['s_receiver']?>"></td>
			<th>몰명</th>
			<td>
				
				<select name="s_mall_no">
					<option value="">선택</option>
<?php if($TPL_mall_list_1){foreach($TPL_VAR["mall_list"] as $TPL_V1){?>
						<option value=<?php echo $TPL_V1["no"]?> <?php echo $GLOBALS["selected"]['mall_no'][$TPL_V1["no"]]?>><?php echo $TPL_V1["mall_name"]?></option>
<?php }}?>
				</select>
				
			</td>
			
		</tr>
		<tr>
			<th>송장번호</th>
			<td class="search_td_width"><input type="text" name="s_invoice" value="<?php echo $_POST['s_invoice']?>"></td>
			<th>모델명</th>
			<td><input type="text" name="s_mall_goodsnm" value="<?php echo $_POST['s_mall_goodsnm']?>"></td>
		</tr>
			<th>주문번호</th>
			<td><input type="text" name="s_ordno" value="<?php echo $_POST['s_ordno']?>"></td>
			
			<th>등록일자</th>
			<td>
			<input type="text" name="s_date" id="s_date" class="datepicker_common" autocomplete="off" value="<?php echo $GLOBALS["s_date_value"]?>"> ~ 
			<input type="text" name="e_date" id="e_date" class="datepicker_common" autocomplete="off" value="<?php echo $GLOBALS["e_date_value"]?>">
			</td>
			
		</tr>
		</tr>
			<th>작성자</th>
			<td><input type="text" name="s_admin" value="<?php echo $_POST['s_admin']?>"></td>
			
			<th>진행상태</th>
			<td>
				<select name="s_ing_type">
					<option value="">선택</option>
<?php if($TPL__cfg_ing_step_1){foreach($GLOBALS["cfg_ing_step"] as $TPL_K1=>$TPL_V1){?>
					<option value=<?php echo $TPL_K1?> <?php echo $GLOBALS["selected"]['ing_type'][$TPL_K1]?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</td>
			
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
			<th width='50'>몰명</th>
			<th width='100'>주문번호</th>
			<th>상품명</th>
			<th>이미지</th>
			<th width='100'>옵션명</th>
			<th width='50'>수량</th>
			<th width='50'>가격</th>
			<th width='50'>구매자<br>수령자</th>
			<th width='100'>연락처<br>모바일</th>
			<th>주소</th>
			<th width='100'>송장번호</th>
			<th width='100'>작성자</th>
			<th width='70'>진행상태</th>
			<th></th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="<?php echo $TPL_V1["line_color"]?>">			
			<td><?php echo $TPL_V1["mall_name"]?></td>
			<td><?php echo $TPL_V1["ordno"]?> <?php if($TPL_V1["copy_seq"]> 0){?>복사본<?php }?></td>
			<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["order_num"]?></td>
			<td><?php echo number_format($TPL_V1["order_price"])?></td>
			<td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>
			<td><?php echo $TPL_V1["buyer_mobile"]?><br/><?php echo $TPL_V1["mobile"]?></td>
			<td><?php echo $TPL_V1["zipcode"]?> <?php echo $TPL_V1["address"]?></td>
			<td><?php if($TPL_V1["invoice"]!= 0){?><?php echo $TPL_V1["invoice"]?><?php }?></td>
			<td><?php if($TPL_V1["admin_no"]){?><?php echo $TPL_V1["name"]?><br>(<?php echo $TPL_V1["id"]?>)<?php }?></td>
			<td><?php echo $TPL_V1["ing_type"]?></td>
			<td><button type="button" class="btn btn-sm btn-warning" onclick="popup('cs_reg.php?ordno=<?php echo $TPL_V1["ordno"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>','','1100','900')">CS등록</button></td>
		</tr>
<?php }}?>
	</tbody>
</table>


<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>