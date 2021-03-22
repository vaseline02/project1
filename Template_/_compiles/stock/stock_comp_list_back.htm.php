<?php /* Template_ 2.2.8 2020/11/20 09:39:42 /www/html/ukk_test2/data/skin/stock/stock_comp_list_back.htm 000006152 */ 
$TPL__title_1=empty($GLOBALS["title"])||!is_array($GLOBALS["title"])?0:count($GLOBALS["title"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<?php if($GLOBALS["print_xls"]!= 1){?>
	<form method="post" id="search_form">
	<input type="hidden"name="print_xls" value="">
	<table class="table table-bordered" >
		<tr>
			<th>모델명</th>
			<td>
				<input type="text" name="search_model" value="<?php echo $_POST['search_model']?>">
				<button class="btn btn-primary">검색</button>
			</td>
			<th>입고목록</th>
			<td>
				<select name="search_stock_title" id="search_stock_title">
					<option value="">== 선택 ==</option>
<?php if($TPL__title_1){foreach($GLOBALS["title"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['search_stock_title'][$TPL_K1]?>><?php echo $TPL_V1?></option>	
<?php }}?>
				</select>
				(<?php echo $TPL__title_1?>)
			</td>
		</tr>
	</table>
	</form>


<?php if($TPL_VAR["import_data"]){?>
	<div>
		<div class="col-lg-6">
			수입면장
			<textarea name="" id="" rows="10" style="width:100%">
<?php if(is_array($TPL_R1=$TPL_VAR["import_data"]["import_licence"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
				 <?php echo $TPL_I1+ 1?>. <?php echo $TPL_V1["goodsnm"]?> / <?php echo $TPL_V1["img_name"]?> / <?php echo $TPL_V1["cnt"]?> / <?php echo $TPL_V1["list_no"]?> / <?php echo $TPL_V1["import_no"]?> / <?php echo $TPL_V1["memo"]?>

<?php }}?>
			</textarea>
		</div>
		<div class="col-lg-6">
			인보이스
			<textarea name="" id="" rows="10" style="width:100%">
<?php if(is_array($TPL_R1=$TPL_VAR["import_data"]["invoice"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
				 <?php echo $TPL_I1+ 1?>. <?php echo $TPL_V1["goodsnm"]?> / <?php echo $TPL_V1["img_name"]?> / <?php echo $TPL_V1["cnt"]?> / <?php echo $TPL_V1["list_no"]?> / <?php echo $TPL_V1["import_no"]?> / <?php echo $TPL_V1["memo"]?>

<?php }}?>
			</textarea>
		</div>
	</div>
<?php }?>

<?php }?>


<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode">
<input type="hidden" name="cost_modify" id="cost_modify" >
<input type="hidden" name="excel_group_id" value="<?php echo $_POST['search_stock_title']?>">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_K1=>$TPL_V1){?>
<div class="" style="clear:both">
<div class="table_title"><?php echo $GLOBALS["title"][$TPL_K1]?> ( <?php echo $TPL_K1?> )</div>
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
			<th>
<?php if($GLOBALS["print_xls"]!= 1){?>
				<!--<input type="checkbox" onclick="chk_all_box(this,'chk_no')">-->
<?php }?>
			</th>
			<th>브랜드</th>
			<th>분류</th>
<?php if($GLOBALS["print_xls"]!= 1){?><th>이미지</th><?php }?>
			<th>모델명1</th>
			<th>모델명2</th>
			<th>원산지</th>
			<th>원가</th>
			<th>예정수량</th>
			<th>입고된수량</th>
			
			<th>메모</th>
			<th>등록일</th>
			<th>예정일</th>
			<th></th>
			
			
		</tr>
	</thead>
	<tbody>	
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
		<tr>
			<td>
<?php if($GLOBALS["print_xls"]!= 1){?>
				<!--<input type="checkbox" class="chk_no chk_no<?php echo $TPL_K1?>" name="chk_no[]" value="<?php echo $TPL_V2["no"]?>">-->
<?php }else{?><?php echo $TPL_V2["no"]?><?php }?>
			</td>
			<td><?php echo $TPL_V2["brandnm"]?></td>
			<td><?php echo $TPL_V2["catenm"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?><td class="td_img"><?php echo $TPL_V2["img_url"]?></td><?php }?>
			<td><?php echo $TPL_V2["goodsnm"]?></td>
			<td><?php echo $TPL_V2["goodsnm_sub"]?></td>
			<td><?php echo $TPL_V2["origin"]?></td>
			<td><?php echo number_format($TPL_V2["cost"])?> ( *<?php echo number_format($TPL_V2["cost_mod"], 3)?> )</td>
			<td>
<?php if($GLOBALS["print_xls"]!= 1){?>
					<span class="stock_num_reg"><?php echo number_format($TPL_V2["stock_num_reg"])?></span>
					<span style="color:red"><?php if($GLOBALS["import_model_cnt"][$TPL_V2["goodsno"]]>$GLOBALS["ins_model_cnt"][$TPL_V2["goodsno"]]){?>▲<?php }elseif($GLOBALS["import_model_cnt"][$TPL_V2["goodsno"]]<$GLOBALS["ins_model_cnt"][$TPL_V2["goodsno"]]){?>▼<?php }?></span>
<?php }else{?>
					<?php echo number_format($TPL_V2["stock_num_reg"])?>

<?php }?>
			</td>
			<td class="stock_num"><?php echo number_format($TPL_V2["stock_num"])?></td>
			
			<td><?php echo $TPL_V2["memo"]?></td>
			<td><?php echo $TPL_V2["reg_date"]?></td>
			<td><?php if($TPL_I2== 0){?><?php echo $TPL_V2["cal_date"]?><?php }?></td>
			<td>
			<!--
				<button type="button" class="btn btn-warning mod" onclick="popup('stock_mod.php?no=<?php echo $TPL_V2["no"]?>&mode=comp','stock_mod','600','600')">수정</button>
			-->
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>
</div>
<?php }}?>



<?php if($GLOBALS["print_xls"]!= 1){?>

<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<div class="bottom_btn_box"> 
	<div class="box_left">
	
	</div>
	<div  class="box_right">
	
	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	
  </ul>
</fieldset>

<?php }?>

</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){

	$("#search_stock_title").change(function(){
		$("#search_form").submit();
	});
});





function chkform2(){
	if($("#search_stock_title").val()==''){
		alert('목록을 선택해주세요.');
		$("#search_stock_title").focus();
		return false;
	}else{
		return true;
	}

}
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>