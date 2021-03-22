<?php /* Template_ 2.2.8 2021/03/17 14:38:57 /www/html/ukk_test2/data/skin/stock/stock_final.htm 000002864 */ 
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
			<!--<th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>	-->
			<th>통관그룹번호</th>
			<th></th>
			<th>입고등록일</th>
			<th>입고예정일</th>
			<th>통관일</th>
			<th>입고확정일</th>
			<th></th>
		</tr>
	</thead>
	<tbody>	
<?php if($TPL_group_1){foreach($TPL_VAR["group"] as $TPL_V1){?>
		<tr>
			<!--<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["group_id"]?>"></td>-->
			<td><?php echo $TPL_V1["f_group_id"]?></td>
			<td><?php echo $TPL_V1["title"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td><?php echo $TPL_V1["calendar_date"]?></td>
			<td><?php echo $TPL_V1["pass_date"]?></td>
			<td><?php echo $TPL_V1["comp_date"]?></td>
			<td>			
				<button type="button" class="btn btn-sm btn-warning compView" data-group_id="<?php echo $TPL_V1["f_group_id"]?>">상세보기</button>			
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

	file_loc="stock_final_detail.php?group_id="+group_id;

	$("#main_form").attr("action",file_loc);
	$("#main_form").submit();
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>