<?php /* Template_ 2.2.8 2020/10/07 14:41:33 /www/html/ukk_test/data/skin/member/bform.htm 000005688 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<?php echo $this->define('tpl_include_file_1',"outline/search_box.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form enctype="multipart/form-data" action="./excel_read.php" method="post" onsubmit="return chkform();">
<table class="table table-bordered" >
    <tr>
        <th>파일</th>
        <td>
			<input type="file" name="excelFile[]" required/><button class="btn btn-primary">업로드</button>
			<button type="button" class="btn btn-success" onclick="location.href='../xls_file/stock_sample.xlsx'">양식 다운로드</button>
		</td>
    </tr>
</table>
</form>
<input type="text" name="cal_date" class="datepicker_common" autocomplete="off">
<?php }?>
<form method="post" id="main_form">
<!--<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->
<table id="" class="display display_dt" data-height="740" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<caption>
		<div class="input-group col-lg-12 common-table-search2">
			<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
			<div class="input-group common-table-search">
			</div>
		</div>
	</caption> 

	<?php echo $this->define('tpl_include_file_2',"outline/table_width_def.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<th>브랜드</th>
			<th>분류</th>
			<th>이미지</th>
			<th>모델명1</th>
			<th>모델명2</th>
			<th>판매가</th>
			<th>수량</th>
			<th>촬영단계</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td><?php }?>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["catenm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td></td>
			<td><?php echo number_format($TPL_V1["c_price"])?></td>
			<td></td>
			<td><?php echo $TPL_V1["img_step"]?></td>
			<td><button type="button" class="btn btn-warning mod" onclick="popup('stock_mod.php?no=<?php echo $TPL_V1["no"]?>','stock_mod','600','600')">수정</button></td>
		</tr>
<?php }}?>
	</tbody>
		<tfoot>
		<tr style="border-top:1px solid black;">
			<td></td>
		</tr>
	</tfoot>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?></div>


<div class="bottom_btn_box">
	<div class="box_left">
	<button type="button" class="btn btn-danger del">삭 제</button>
	</div>
	<div  class="box_right">
	<select class="ex-select" name="cal_type">
		<option value="success" data-color="#449d44">green</option>
		<option value="info" data-color="#5bc0de">lightblue</option>
		<option value="yellow" data-color="#dddddd">gray</option>
		
		<option value="warning" data-color="#f0ad4e">yellow</option>
		<option value="important" data-color="#d9534f">red</option>
		
	</select>
	<input type="text" name="cal_date" class="datepicker_common" autocomplete="off">
	재고위치 
	<select name="stock_comp_loc" class="stock_comp_loc">
		<option value="51">3자물류</option>
		<option value="1">사무실</option>
	</select> 로
	<button type="button" class="btn btn-primary" id="stock_comp">면장파일 다운</button>

	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li>총 수량이 부족하면 수량이 빨갛게 표시됩니다.</li>
  </ul>
</fieldset>

<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$(".searchbox-default").css("display","block");
$(".searchbox-img-step").css("display","block");



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