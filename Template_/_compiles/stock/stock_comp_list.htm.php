<?php /* Template_ 2.2.8 2021/01/13 16:49:48 /www/html/ukk_test2/data/skin/stock/stock_comp_list.htm 000004349 */ 
$TPL_group_1=empty($TPL_VAR["group"])||!is_array($TPL_VAR["group"])?0:count($TPL_VAR["group"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form method="get" id="search_form">
	<table class="table table-bordered" >
		<tr>
			<th>그룹명</th>
			<td>
				<input type="text" name="search_group" value="<?php echo $_GET['search_group']?>">
			</td>		
			<th>모델명</th>
			<td>
				<input type="text" name="search_model" value="<?php echo $_GET['search_model']?>">
			</td>	
		</tr>
		<tr>
			<th>기타</th>
			<td>
				<label style="font-weight: normal;"><input type="checkbox" name="licence_chk" value="n" <?php echo $GLOBALS["checked"]['licence_chk']['n']?>> 수입면장 미등록</label>
			</td>		
			<th>내용</th>
			<td>
				<input type="text" style="width:100%" name="search_title" value="<?php echo $_GET['search_title']?>">
			</td>	
		</tr>
	</table>
	<div class="text-center table-btn-group">
		<button class="btn btn-primary">검색</button>		
	</div>
</form>
<?php }?>


<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode" value="">
<div class="" style="clear:both">
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
			<th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>	
			<th>그룹아이디</th>
			<th>내용</th>
			<th>입고등록일</th>
			<th>입고예정일</th>
			<th>통관일</th>
			<th>입고확정일</th>
			<th>면장등록일</th>
			<th>면장완료여부</th>
			<th></th>
			
			
		</tr>
	</thead>
	<tbody>	
<?php if($TPL_group_1){foreach($TPL_VAR["group"] as $TPL_V1){?>
		<tr>
			<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["group_id"]?>"></td>
			<td><?php echo $TPL_V1["group_id"]?></td>
			<td><?php echo $TPL_V1["title"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td><?php echo $TPL_V1["calendar_date"]?></td>
			<td><?php echo $TPL_V1["pass_date"]?></td>
			<td><?php echo $TPL_V1["comp_date"]?></td>
			<td><?php echo $TPL_V1["license_date"]?></td>
			<td><?php echo $TPL_V1["confirmNm"]?></td>
			<td>			
				<button type="button" class="btn btn-sm btn-warning compView" data-group_id="<?php echo $TPL_V1["group_id"]?>">상세보기</button>			
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>
</div>

<?php if($GLOBALS["print_xls"]!= 1){?>

<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<div class="bottom_btn_box"> 
	<div class="box_left">
	
	</div>
	<div  class="box_right">
		<select name="date_type">
			<option value="pass_date">통관일</option>
			<option value="license_date">면장등록일</option>
		</select>
		<input type="text" name="input_date" id="input_date" class="datepicker_common" autocomplete="off">
		<button type="button" class="btn btn-primary dateChange" id="dateChange">수정</button>
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
$(".compView").click(function (){
	var group_id=$(this).data("group_id");

	file_loc="stock_comp_detail.php?group_id="+group_id;

	$("#main_form").attr("action",file_loc);
	$("#main_form").submit();
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
$(".dateChange").click(function(){			
	if(!$(".chk_no").is(":checked")){
		alert("선택된 상품이 없습니다.");
		return false;
	}else if(!$("#input_date").val()){
		alert("날짜를 입력해주세요.");
		return false;
	}else{

        if(confirm('변경하시겠습니까?')){
			$("input[name='mode']").val("date_change");
            $("#main_form").submit();
        }
    }
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>