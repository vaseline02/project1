<?php /* Template_ 2.2.8 2021/03/15 11:35:15 /www/html/ukk_test2/data/skin/goods/goods_info.htm 000005201 */ 
$TPL_gi_1=empty($TPL_VAR["gi"])||!is_array($TPL_VAR["gi"])?0:count($TPL_VAR["gi"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form enctype="multipart/form-data" method="post">
<table class="table table-bordered" >
    <tr>
        <th>파일</th>
        <td><input type="file" name="excelFile[]" required/><button class="btn btn-primary">업로드</button></td>
    </tr>
</table>
</form>
<?php }?>
<?php echo $this->define('tpl_include_file_1',"outline/search_box.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<style>
    .mallLabel{ display:inline-block; width:180px; line-height:30px;}
</style>

<?php }?>
<?php if($GLOBALS["print_xls"]!= 1){?>

<table id="" class="display display_dt barcodeTable" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
			<th width="20"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>
			<th>브랜드</th>
			<th>분류</th>
			<th>모델명</th>
			<th>모델명2</th>
			<th>이미지</th>
<?php if($TPL_gi_1){foreach($TPL_VAR["gi"] as $TPL_V1){?>
			<th><?php echo $TPL_V1?></th>
<?php }}?>
            <th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["catenm"]?></td>
			<td><a style="cursor: pointer;"  class="goods_detail_pop" onclick="popup('goods_info_view.php?cate_code=<?php echo $GLOBALS["category_1"]?>&goodsnm=<?php echo $TPL_V1["goodsnm"]?>','','1100','900')"><?php echo $TPL_V1["goodsnm"]?></a></a></td>
			<td><?php echo $TPL_V1["goodsnm_sub"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
<?php if(is_array($TPL_R2=($TPL_VAR["gi"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
			<td><?php echo $TPL_V1["spec_data"][$TPL_K2]?></td>
<?php }}?>
			<td><div class="btn btn-sm btn-warning" onclick="popup('goods_change_reg.php?no=<?php echo $TPL_V1["no"]?>&cate_code=<?php echo $GLOBALS["category_1"]?>','','1100','900')">모델명변경</div></td>
            <!-- <td><div class="btn btn-sm btn-warning" onclick="popup('goods_barcode_reg.php?no=<?php echo $TPL_V1["no"]?>','','1100','900')">등록/수정</div></td> -->
		</tr>
<?php }}?>
	</tbody>
</table>

<div class="bottom_btn_box">
	<div class="box_left">		
	</div>
	<div  class="box_right">
		<button type="button" class="btn btn-primary cate_ins">선택모델 카테고리 등록</button> 
	</div>
</div>

<?php }else{?>
<div style="color: red; font-weight: bold;">* 빨간표시된 타이틀의 내용은 수정하지마세요.</div>
<table id="" class="display display_dt barcodeTable" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
			<th><div style="color: red;">상품코드</div></th>
			<th><div style="color: red;">브랜드</div></th>
			<th><div style="color: red;">모델명</div></th>			
<?php if($TPL_gi_1){foreach($TPL_VAR["gi"] as $TPL_K1=>$TPL_V1){?>
			<th><?php echo $TPL_V1?>(<?php echo $GLOBALS["use_filter"][$TPL_K1]?>)</th>
<?php }}?>
			
		</tr>
		<tr>
			<th></th>
			<th></th>
			<th></th>
<?php if($TPL_gi_1){foreach($TPL_VAR["gi"] as $TPL_K1=>$TPL_V1){?>
			<th><?php echo $TPL_K1?></th>
<?php }}?>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["no"]?></td>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
<?php if(is_array($TPL_R2=($TPL_VAR["gi"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
			<td><?php echo $TPL_V1["spec_data"][$TPL_K2]?></td>
<?php }}?>
		</tr>
<?php }}?>
	</tbody>
</table>
<?php }?>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$(".searchbox-default").css("display","block");
$(".searchbox-goods-detail").css("display","block");
$(".s_no_cate").css("display","block");



$(function(){
	$("#print_xls").click(function(){
		$("input[name='print_xls']").val("1");
		$("#glb_search_form").submit();
		$("input[name='print_xls']").val("0");
	});    

	$(".cate_ins").click(function(){

		if(confirm('[카테고리등록]처리하시겠습니까?')){

			var old_val='';

			if($(".chk_no:checked").length!='0'){
				
				old_val=$("#s_paste").val();
				$("#s_paste").val("");
				var chk_model='';
				$(".chk_no:checked").each(function(){
					chk_model+=$(this).closest("tr").find(".goods_detail_pop").html()+"\n";//상품명 찾기
				});

				$("#s_paste").val( chk_model);
				
			}
			
			$("#glb_search_form").append("<input type='hidden' name='mode' value='cate_ins'>");
			$("#glb_search_form").submit();
		}
	});
})

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>