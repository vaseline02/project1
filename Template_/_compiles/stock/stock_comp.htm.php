<?php /* Template_ 2.2.8 2021/03/17 12:25:28 /www/html/ukk_test2/data/skin/stock/stock_comp.htm 000013710 */ 
$TPL__title_1=empty($GLOBALS["title"])||!is_array($GLOBALS["title"])?0:count($GLOBALS["title"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<?php if($GLOBALS["print_xls"]!= 1){?>
	<form method="post" id="search_form">
	<input type="hidden"name="print_xls" value="">
	<table class="table table-bordered" >
		<tr>
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

<?php if($_POST['search_stock_title']){?>
	<!--
	<form enctype="multipart/form-data" method="post" onsubmit="return chkform2();">
	<input type="hidden" name="excel_group_id" value="<?php echo $_POST['search_stock_title']?>">
	<table class="table table-bordered" >
		<tr>
			<th>면장/인보이스<br> 업로드</th>
			<td>
				<input type="file" name="excelFile[]" required/><button class="btn btn-primary" >업로드</button>
				<button type="button" class="btn btn-success" onclick="location.href='../xls_file/import_upload_sample.xlsx'">양식 다운로드</button>
				( 업로드시 기존 면장내용을 삭제 후 재업로드됩니다. )
			</td>
		</tr>
	</table>
	</form>-->
<?php }?>

<?php if($TPL_VAR["import_data"]){?>
	<div>
		<div class="col-lg-6">
			수입면장
			<textarea name="" id="" rows="10" style="width:100%;height:150px;">
<?php if(is_array($TPL_R1=$TPL_VAR["import_data"]["import_licence"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
				 <?php echo $TPL_I1+ 1?>. <?php echo $TPL_V1["goodsnm"]?> / <?php echo $TPL_V1["img_name"]?> / <?php echo $TPL_V1["cnt"]?> / <?php echo $TPL_V1["list_no"]?> / <?php echo $TPL_V1["import_no"]?> / <?php echo $TPL_V1["memo"]?>

<?php }}?>
			</textarea>
		</div>
		<div class="col-lg-6">
			인보이스
			<textarea name="" id="" rows="10" style="width:100%;height:150px;">
<?php if(is_array($TPL_R1=$TPL_VAR["import_data"]["invoice"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
				 <?php echo $TPL_I1+ 1?>. <?php echo $TPL_V1["goodsnm"]?> / <?php echo $TPL_V1["img_name"]?> / <?php echo $TPL_V1["cnt"]?> / <?php echo $TPL_V1["list_no"]?> / <?php echo $TPL_V1["import_no"]?> / <?php echo $TPL_V1["memo"]?>

<?php }}?>
			</textarea>
		</div>
	</div>
<?php }?>

	<form enctype="multipart/form-data" method="post" onsubmit="return chkform2();">
	<input type="hidden" name="excel_chk_num_up" value="1">
	<input type="hidden" name="excel_group_id" value="<?php echo $_POST['search_stock_title']?>">
	<table class="table table-bordered" >
		<tr>
			<th>등록수량 업로드</th>
			<td>
				<input type="file" name="excelFile[]" required/><button class="btn btn-primary" >업로드</button>
				<button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>
			</td>
			<th>원가조정</th>
			<td>
				<input type="text" id="cost_modify_val" value="<?php echo number_format($GLOBALS["cost_mod"], 3)?>"> <button type="button"  class="btn btn-primary" id="btn_cost_modify">등록/변경</button>

			</td>
		</tr>
	</table>
	<div class="text-center table-btn-group">
			<select name="stock_comp_loc2" class="stock_comp_loc2">
				<option value="3자물류">3자물류</option>
				<option value="사무실">사무실</option>
			</select> 
			<select id="cs_search_loc">				
				<option value="2">wms</option>
				<option value="3">재고어드민-예정수량</option>									
				<option value="1">재고어드민-입고수량</option>
			</select>
			<button type="button" class="btn btn-success" id="bad_search_print_xls">선택값 엑셀 다운로드</button>
		</div>
	</form>

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
				<input type="checkbox" onclick="chk_all_box(this,'chk_no')">
<?php }?>
			</th>
			<th>브랜드</th>
			<th>분류</th>
<?php if($GLOBALS["print_xls"]!= 1){?><th>이미지</th><?php }?>
			<th>모델명1</th>
			<th>모델명2</th>
			<th>원산지</th>
			<th>외화</th>
			<th>환율</th>
			<th>관세율</th>
			<th>수수료</th>
			<th>부대비용</th>
			<th>거래처</th>
			<th>원가</th>
			<th>예정수량</th>
			<th>입고된수량</th>
			<th>등록할수량</th>
			<th>메모</th>
			<th>등록일</th>
			<th>예정일</th>
			<th>거래처</th>
			<th></th>
			
			
		</tr>
	</thead>
	<tbody>	
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
		<tr>
			<td>
<?php if($GLOBALS["print_xls"]!= 1){?>
				<input type="checkbox" class="chk_no chk_no<?php echo $TPL_K1?>" name="chk_no[]" value="<?php echo $TPL_V2["no"]?>" <?php echo $GLOBALS["checked"]['chk_no'][$TPL_V2["no"]]?>>
<?php }else{?><?php echo $TPL_V2["no"]?><?php }?>
			</td>
			<td><?php echo $TPL_V2["brandnm"]?></td>
			<td><?php echo $TPL_V2["catenm"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?><td class="td_img"><?php echo $TPL_V2["img_url"]?></td><?php }?>
			<td><?php echo $TPL_V2["goodsnm"]?></td>
			<td><?php echo $TPL_V2["goodsnm_sub"]?></td>
			<td><?php echo $TPL_V2["origin"]?></td>
			<td><?php echo $TPL_V2["cost_std"]?></td>
			<td><?php echo $TPL_V2["rate"]?></td>
			<td><?php echo $TPL_V2["duty_per"]?></td>
			<td><?php echo $TPL_V2["charge"]?></td>
			<td><?php echo $TPL_V2["extra_expense"]?></td>
			<td><?php echo $TPL_V2["cd"]?></td>
			<td><?php echo number_format($TPL_V2["cost_ori"])?><br/><span style="color:red">( <?php echo number_format($TPL_V2["cost_ori"]*$TPL_V2["cost_mod"])?> )</span></td>
			<td>
<?php if($GLOBALS["print_xls"]!= 1){?>
					<span class="stock_num_reg"><?php echo number_format($TPL_V2["stock_num_reg"])?></span>
<?php if($GLOBALS["import_model_cnt"][$TPL_V2["goodsno"]]){?><span style="color:red"><?php if($GLOBALS["import_model_cnt"][$TPL_V2["goodsno"]]>$GLOBALS["ins_model_cnt"][$TPL_V2["goodsno"]]){?>▲<?php }elseif($GLOBALS["import_model_cnt"][$TPL_V2["goodsno"]]<$GLOBALS["ins_model_cnt"][$TPL_V2["goodsno"]]){?>▼<?php }?></span><?php }?>
<?php }else{?>
					<?php echo number_format($TPL_V2["stock_num_reg"])?>

<?php }?>
			</td>
			<td class="stock_num"><?php echo number_format($TPL_V2["stock_num"])?></td>
			<td>
<?php if($GLOBALS["print_xls"]!= 1&&$TPL_V2["stock_num"]<$TPL_V2["stock_num_reg"]){?>
				<input class="stock_add number_only" type="text" name="stock_num_add[<?php echo $TPL_V2["no"]?>]" size="4" value="<?php echo $TPL_V2["chk_num"]?>">
<?php }elseif($GLOBALS["print_xls"]== 1){?>					
					<?php echo $TPL_V2["chk_num"]?>

<?php }?>
			</td>
			<td><?php echo $TPL_V2["memo"]?></td>
			<td><?php echo $TPL_V2["reg_date"]?></td>
			<td><?php if($TPL_I2== 0){?><?php echo $TPL_V2["cal_date"]?><?php }?></td>
			<td><?php echo $GLOBALS["codedata_no"][$TPL_V2["customer"]]?></td>
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
		<button type="button" class="btn btn-danger del">선택모델삭제</button> |
		<input type="text" name="group_id" size="20" value="">
		<button type="button" class="btn btn-primary" id="group_change">그룹변경</button>
		
	</div>
	<div  class="box_right">
	원가 ×
	<?php echo number_format($GLOBALS["cost_mod"], 3)?> 조정 /
	재고위치 
	<select name="stock_comp_loc" class="stock_comp_loc">
		<option value="51">3자물류</option>
		<option value="1">사무실</option>
	</select> 로
	<button type="button" class="btn btn-primary" id="stock_comp">등록</button>
	
	</div>
</div>


<div style="width:100%;margin-top:20px;"><button type="button" class="btn btn-danger" id="stock_end" style="width:100%"><?php echo $_POST['search_stock_title']?> 종료</button></div>



<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li>입고 완료 전 면장을 업로드(기능상 제약은 없음)</li>
	<li>입고 모델 변경시 해당입고내역 삭제후 변경되는 모델명으로 새로 입고진행 후 , 그룹ID를 변경하여 함께 입고처리함.</li>
  </ul>
</fieldset>

<?php }?>

</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
	
	$(".del").click(function(){
		if( $(".chk_no:checked").length <=0 ){
			alert('삭제할 목록을 선택해주세요.');
			return;
		}

		if(confirm('삭제 하시겠습니까?')){
			
			$("#mode").val("del");
			$("#main_form").submit();
		}
	});

	$("#stock_comp").click(function(){
		
		var sloc=$(".stock_comp_loc option:selected").html();

		if( $(".chk_no:checked").length <=0 ){
			alert('등록할 목록을 선택해주세요.');
			return;
		}
		
		if(confirm('원가 조정값을 정확히 입력했는지 다시한번 확인해주세요.')){
			if(confirm(sloc+'로 등록 하시겠습니까?')){
				
				$("#mode").val("stock_comp");
				$("#main_form").submit();
			}
		}
	});

	$("#group_change").click(function(){
		var group_id=$("input[name='group_id']").val();

		if(group_id){
			$.ajax({
				url: "./stock_ajax.php",
				type: "POST",
				cache: false,
				dataType: "json",
				data: "group_id="+group_id+"&mode=groupCheck",
				success: function(data){
					console.log(data);
					if(!data['cnt']){
						alert('변경할려는 그룹아이디가 존재하지않습니다.');
						$("input[name='group_id']").focus();
						return;
					}else{
						if( $(".chk_no:checked").length <=0 ){
							alert('변경할 항목을 선택해주세요.');
							return;
						}
						
						if(confirm('그룹변경을 하시겠습니까?')){
							
							$("#mode").val("group_change");
							$("#main_form").submit();
						}
					}

				},
				error: function (request, status, error){        
					console.log(error);
				}
			});			

		}else{
			alert("그룹아이디를 입력해주세요.");
			$("input[name='group_id']").focus();
			return false;
		}
		

	});

	$("#stock_end").click(function(){

		if( $(".chk_no:checked").length <=0 ){
			alert('종료할 목록을 선택해주세요.');
			return;
		}
		
		if(confirm('원가 조정값을 정확히 입력했는지 다시한번 확인해주세요.')){
			if(confirm('종료 처리하시겠습니까?')){
				
				$("#mode").val("stock_end");
				$("#main_form").submit();
			}
		}
	});



	$("#search_stock_title").change(function(){
		$("#search_form").submit();
	});


	$(".stock_add").blur(function(){

		var add_val=$(this).val();
		var reg_val=uncomma($(this).closest("tr").find(".stock_num_reg").html());
		var now_val=uncomma($(this).closest("tr").find(".stock_num").html());	

		if( reg_val-(Number(now_val)+Number(add_val)) < 0 ){

			alert('예정수량보다 입고수량이 많아집니다.');
		}
	});

	$("#print_xls").click(function(){
		$("input[name='print_xls']").val("1");
		$("#search_form").submit();
		$("input[name='print_xls']").val("0");
	});

	$("#btn_cost_modify").click(function(){

		var cost_modify_val=$("#cost_modify_val").val();

		if(cost_modify_val){
			$("#cost_modify").val(cost_modify_val);
			$("#mode").val("cost_modify");
			$("#main_form").submit();
		}
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



$("#bad_search_print_xls").click(function(){
		
	var file_loc='';
	if(	$("#cs_search_loc").val()=='1' ){
		file_loc="stock_comp_excel2.php?";
	}else if(	$("#cs_search_loc").val()=='2' ){
		file_loc="stock_comp_excel_tm.php?";
	}else if(	$("#cs_search_loc").val()=='3' ){
		file_loc="stock_comp_excel2.php?stock_type=1";
	}

	var stock_loc=$(".stock_comp_loc2").val();
	
	file_loc=file_loc+'&stock_loc='+stock_loc;

	var chk_len=$(".chk_no:checked").length;
	if( chk_len<=0 ){
		alert('출력할 리스트를 선택해주세요.');
		return false;
	}else{
		
		var invo_chk=0;
		 
		var html='<div id="div_excel_search_val">';
		html+='<input type="hidden" name="print_xls" value="1" >';
		// html+='<input type="hidden" name="print_xls" value="0" >';
		// html+='<input type="hidden" name="cs_search_invo_chk" value="'+invo_chk+'">';
		html+='</div>';	
		$("#main_form").append(html);
		
		$("#main_form").attr("action",file_loc);
		$("#main_form").submit();
		$("#main_form").attr("action","");
		$("#div_excel_search_val").remove();
	}

});


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>