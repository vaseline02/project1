<?php /* Template_ 2.2.8 2021/02/19 16:03:38 /www/html/ukk_test2/data/skin/stock/stock_comp_detail.htm 000008079 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<form enctype="multipart/form-data" method="post">
<input type="hidden" name="group_id" value="<?php echo $GLOBALS["group_id"]?>">
<table class="table table-bordered" >
	<tr>
		<th style="width:200px;">면장/인보이스<br> 업로드</th>
		<td>
			<input type="file" name="excelFile[]" required/><button class="btn btn-primary" >업로드</button>
			<button type="button" class="btn btn-success" onclick="location.href='../xls_file/import_upload_sample.xlsx'">양식 다운로드</button>
			( 업로드시 기존 면장내용을 삭제 후 재업로드됩니다. )
		</td>
	</tr>
</table>
</form>

<?php if($TPL_VAR["import_data"]){?>
<div>
	<div class="col-lg-6">
		수입면장
		<textarea name="" id="" rows="10" style="width:100%;height:150px;">
<?php if(is_array($TPL_R1=$TPL_VAR["import_data"]["import_licence"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
			 <?php echo $TPL_I1+ 1?>. <?php echo $TPL_V1["goodsnm"]?> / <?php echo $TPL_V1["img_name"]?> / <?php echo $TPL_V1["cnt"]?> / <?php echo $TPL_V1["list_no"]?> / <?php echo $TPL_V1["import_no"]?> / <?php echo $TPL_V1["memo"]?> / <?php echo $TPL_V1["reg_date"]?>

<?php }}?>
		</textarea>
	</div>
	<div class="col-lg-6">
		인보이스
		<textarea name="" id="" rows="10" style="width:100%;height:150px;">
<?php if(is_array($TPL_R1=$TPL_VAR["import_data"]["invoice"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
			 <?php echo $TPL_I1+ 1?>. <?php echo $TPL_V1["goodsnm"]?> / <?php echo $TPL_V1["img_name"]?> / <?php echo $TPL_V1["cnt"]?> / <?php echo $TPL_V1["list_no"]?> / <?php echo $TPL_V1["import_no"]?> / <?php echo $TPL_V1["memo"]?> / <?php echo $TPL_V1["reg_date"]?>

<?php }}?>
		</textarea>
	</div>
</div>
<?php }?>

<form method="post" name="listForm" id="listForm">
<input type="hidden" name="mode" value="">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_K1=>$TPL_V1){?>
<div class="" style="clear:both">

<hr>
<table class="table table-bordered" >
	<tr>
		<th>그룹번호</th>
		<td class="table_title" style="width:60%; height:50px; text-align:left; padding-left:20px;"><?php echo $GLOBALS["title"][$TPL_K1]?> ( <?php echo $TPL_K1?> )</td>
		<th>통관일</th>
		<td style="text-align:center;"><?php echo $GLOBALS["pass_date"]?></td>
		<th>면장등록일</th>
		<td style="text-align:center;"><?php echo $GLOBALS["license_date"]?></td>
	</tr>
</table>

<!--<div class="table_title"><?php echo $GLOBALS["title"][$TPL_K1]?> ( <?php echo $TPL_K1?> ) - <?php if($GLOBALS["pass_date"]){?>통관일 : <?php echo $GLOBALS["pass_date"]?><?php }?> <?php if($GLOBALS["license_date"]){?> 면장등록일 : <?php echo $GLOBALS["license_date"]?><?php }?></div>-->
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>
<?php }?>
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
			<th>수입면장</th>			
			<th>인보이스</th>			
		</tr>
	</thead>
	<tbody>	
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
		<tr>	
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
			<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V2["no"]?>" >
			</td>
<?php }?>
			<td><?php echo $TPL_V2["brandnm"]?></td>
			<td><?php echo $TPL_V2["catenm"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?><td class="td_img"><?php echo $TPL_V2["img_url"]?></td><?php }?>
			<td><?php echo $TPL_V2["goodsnm"]?></td>
			<td><?php echo $TPL_V2["goodsnm_sub"]?></td>
			<td><?php echo $TPL_V2["origin"]?></td>
			<td><?php echo number_format($TPL_V2["cost"])?></td>
			<td>
<?php if($GLOBALS["print_xls"]!= 1){?>
					<span class="stock_num_reg"><?php echo number_format($TPL_V2["stock_num_reg"])?></span>
<?php if($GLOBALS["import_model_cnt"][$TPL_V2["goodsno"]]['import_licence']){?>
<?php if($GLOBALS["import_model_cnt"][$TPL_V2["goodsno"]]['import_licence']>$GLOBALS["ins_model_cnt"][$TPL_V2["goodsno"]]){?>
							<span style="color:red">▲</span>
<?php }elseif($GLOBALS["import_model_cnt"][$TPL_V2["goodsno"]]['import_licence']<$GLOBALS["ins_model_cnt"][$TPL_V2["goodsno"]]){?>
							<span style="color:blue">▼</span>
<?php }?>
<?php }?>
<?php if($GLOBALS["import_model_cnt"][$TPL_V2["goodsno"]]['invoice']){?>
<?php if($GLOBALS["import_model_cnt"][$TPL_V2["goodsno"]]['invoice']>$GLOBALS["ins_model_cnt"][$TPL_V2["goodsno"]]){?>
							<span style="color:red">▲</span>
<?php }elseif($GLOBALS["import_model_cnt"][$TPL_V2["goodsno"]]['invoice']<$GLOBALS["ins_model_cnt"][$TPL_V2["goodsno"]]){?>
							<span style="color:blue">▼</span>
<?php }?>
<?php }?>
<?php }else{?>
					<?php echo number_format($TPL_V2["stock_num_reg"])?>

<?php }?>
			</td>
			<td class="stock_num"><?php echo number_format($TPL_V2["stock_num"])?></td>
			
			<td><?php echo $TPL_V2["memo"]?></td>
			<td><?php echo $TPL_V2["reg_date"]?></td>
			<td><?php if($TPL_I2== 0){?><?php echo $TPL_V2["cal_date"]?><?php }?></td>
			<td>
<?php if(is_array($TPL_R3=$TPL_V2["import_licence"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
					<?php echo $TPL_V3?><br>
<?php }}?>
			</td>			
			<td>
<?php if(is_array($TPL_R3=$TPL_V2["invoice"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
					<?php echo $TPL_V3?><br>
<?php }}?>
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
		<div class="btn btn-sm btn-primary confirmCheck" data-mode='confirm' data-mess="완료처리">완료처리</div>
		|
		<select name="date_type">
			<option value="pass_date">통관일</option>
			<option value="license_date">면장등록일</option>
		</select>
		<input type="text" name="input_date" id="input_date" class="datepicker_common" autocomplete="off">
		<button type="button" class="btn btn-primary confirmCheck" data-mode='date_change' data-mess="변경">수정</button>
	</div>
	<div  class="box_right">	
		<input type="text" name="f_group_id" id="f_group_id" autocomplete="off">
		<button type="button" class="btn btn-primary confirmCheck" data-mode='f_group_id' data-mess="그룹지정">통관그룹지정</button>
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


$(".confirmCheck").click(function(){
	var mode=$(this).data("mode");
	var mess=$(this).data("mess");

	if(mode=='f_group_id'){
		if( $(".chk_no:checked").length <=0 ){
			alert('그룹지정할 상품을 선택해주세요.');
			return;
		}

		if( $("#f_group_id").val()=='' ){
			alert('그룹코드를 입력해주세요.');
			return;	
		}
	}

	if(mode=="date_change" && !$("#input_date").val()){
		alert("날짜를 입력해주세요.");
		return false;
	}else{
		if(confirm(mess+" 하시겠습니까?")){
			$("input[name='mode']").val(mode);
			$("form[name='listForm']").submit();	
		}
	}

});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>