<?php /* Template_ 2.2.8 2020/12/17 10:00:18 /www/html/ukk_test2/data/skin/bbs_default/list.htm 000002974 */ 
$TPL__cate_arr_1=empty($GLOBALS["cate_arr"])||!is_array($GLOBALS["cate_arr"])?0:count($GLOBALS["cate_arr"]);
$TPL_data_1=empty($TPL_VAR["data"])||!is_array($TPL_VAR["data"])?0:count($TPL_VAR["data"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div style="width:70%;margin:auto">
<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<input type="hidden" name="board_id" id="board_id" value="<?php echo $GLOBALS["board_id"]?>">

<div style="clear:both"></div>

<form method="post" style="float:right">
<div style="width:100%;">
	<!--
	<select name="search_cate2" id="">
		<option value="">ALL</option>

<?php if($TPL__cate_arr_1){foreach($GLOBALS["cate_arr"] as $TPL_V1){?>
		<option value="<?php echo $TPL_V1?>" <?php echo $GLOBALS["selected"]['cate'][$TPL_V1]?>><?php echo $TPL_V1?></option>
<?php }}?>
	</select>
	-->

	<input type="text" name="search2" value="<?=$search?>">
	<button class="btn btn-primary">검색</button>
</div>
</form>


<!--<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->
<table id="" class="display display_dt" data-height="740" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<caption>
		<div class="input-group col-lg-12 common-table-search2">
			<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
			<div class="input-group common-table-search">
			</div>
		</div>
	</caption> 
	<thead>
		<tr>
			<th>번호</th>
			<th>분류</th>
			<th>제목</th>
			<th>내용</th>
			<th>파일</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_data_1){foreach($TPL_VAR["data"] as $TPL_V1){?>
	<tr class="line_tr" id="<?php echo $TPL_V1["sn"]?>" style="cursor:pointer;">
		<td align=center><?php echo $TPL_V1["sn"]?></td>
		<td align=center><?php echo $TPL_V1["cate_name"]?></td>
		<td style="width:300px;"><?php echo $TPL_V1["subject"]?></td>
		<td><?php echo $TPL_V1["contents"]?></td>
		<td>
		<?php echo count($TPL_V1["img"])?>

		</td>
	</tr>
<?php }}?>
	</tbody>
</table>

<div><?php echo $TPL_VAR["pg"]->page['navi']?></div>


	<div class="bottom_btn_box">
		<div class="box_left">

		</div>
		<div  class="box_right">
		<button type="button" class="btn btn-primary" onclick="popup('write.php?board_id=<?php echo $GLOBALS["board_id"]?>','reg_pop','800','700')">등록</button>
		</div>
	</div>

</div>



<script>

$(function(){

	$(".line_tr").click(function(){

		var sn = $(this).attr("id");
		var board_id = $("#board_id").val();

		var pop = window.open("write.php?sn="+sn+"&board_id="+board_id,"view_pop","width=1400,height=800,scrollbars=yes");
		pop.focus();
	});
});
</script>

<?php $this->print_("footer",$TPL_SCP,1);?>