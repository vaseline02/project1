<?php /* Template_ 2.2.8 2020/09/17 11:27:30 /www/html/ukk_test2/data/skin/stock/import_licence.htm 000003227 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>

<?php echo $this->define('tpl_include_file_1',"outline/search_box.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<form method="post" id="main_form">
<table id="" class="display display_dt" data-height="" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<?php echo $this->define('tpl_include_file_2',"outline/table_width_def.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<th>브랜드</th>
			<th>분류</th>
			<th>이미지</th>
			<th>모델명</th>
			<th width="250">이미지명</th>
			<th>수량</th>
			<th>제안수량</th>	
			<th>면장위치</th>
			<th>수입신고번호</th>
			<th width="350">비고</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_K1=>$TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<tr style="background-color:<?php echo $TPL_V2["bgcolor"]?>;<?php if(!$TPL_V2["no"]){?>height:100px;<?php }?>">
<?php if($GLOBALS["print_xls"]!= 1){?><td><?php if($TPL_V2["no"]){?><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V2["no"]?>" checked><?php }?></td><?php }?>
			<td><?php echo $TPL_V2["brandnm"]?></td>
			<td><?php if($TPL_V2["brandnm"]){?><?php echo $TPL_K1?><?php }?></td>
			<td class="td_img"><?php echo $TPL_V2["img_url"]?></td>
			<td ><?php echo $TPL_V2["goodsnm"]?></td>
			<td><?php echo $TPL_V2["img_name"]?></td>
			<td style="background-color:<?php echo $GLOBALS["model_color"][$TPL_K1][$TPL_V2["goodsnm"]]?>"><?php echo $TPL_V2["cnt"]?></td>
			<td><?php echo $TPL_V2["offer_num"]?></td>
			<td><?php echo $TPL_V2["list_no"]?></td>
			<td><?php echo $TPL_V2["import_no"]?></td>
			<td><?php echo $TPL_V2["memo"]?></td>
		</tr>
<?php }}?>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div class="bottom_btn_box">
	<div class="box_left">
	</div>
	<div  class="box_right">
	<button type="button" class="btn btn-primary" id="file_down">파일 다운로드</button>

	</div>
</div>



<fieldset class="page_field_info">
  <legend>참고</legend>
  <ul>
	<li>총 수량이 부족하면 수량이 빨갛게 표시됩니다.</li>
  </ul>
</fieldset>

<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";


$(function(){
	$(".searchbox-modelNcnt").css("display","block");

	$("#file_down").click(function(){
		
		var invoice=0;
		if($("#chk_invoice").is(":checked"))invoice=1;
		
		$("#main_form").attr("action","import_licence_download.php?invoice="+invoice);
		$("#main_form").submit();	
		$("#main_form").attr("action","");
		
	});
})


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>