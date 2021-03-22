<?php /* Template_ 2.2.8 2020/09/04 14:42:09 /www/html/ukk_test2/data/skin/stock/photo_step_list.htm 000004023 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>
<?php echo $this->define('tpl_include_file_1',"outline/search_box.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode">
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<colgroup>
		<col width="50px"/><!-- 체크박스 -->
		<col width="150px"/><!-- 브랜드 -->
		<col width="90px"/><!-- 이미지 -->
		<col width="150px"/><!-- 모델명 -->
	</colgroup>
	<thead>
		<tr>
			<th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>
			<th>브랜드</th>
			<th>이미지</th>
			<th>모델명1</th>
			<th>모델명2</th>
			<th>촬영단계</th>
			
			<th>이미지폴더</th>
		    <th>이미지명</th>
			<th style="width:250px">메모</th>
<?php if(is_array($TPL_R1=$GLOBALS["loc_info"]['data'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
			<th><?php echo $TPL_K1?></th>
<?php }}?>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?> <input type="hidden" class="img_goodsnm" value="<?php echo $TPL_V1["goodsnm"]?>"></td>
			<td></td>
			<td><?php echo $TPL_V1["img_step"]?></td>
			
			<td><?php echo $TPL_V1["brand_img_folder"]?></td>
			<td><input type="text" class="img_name" name="img_name[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["img_name"]?>">.jpg</td>
			<td><?php echo $TPL_V1["memo"]?></td>
<?php if(is_array($TPL_R2=$TPL_V1["loc_cnt"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<td><?php echo number_format($TPL_V2)?></td>
<?php }}?>
		</tr>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>

<div class="bottom_btn_box">
	<div class="box_left">
	
	</div>
	<div  class="box_right">
	 
	<select name="img_step" class="img_step">
		<option value="1">1단계</option>
		<option value="2">2단계</option>
		<option value="3">3단계</option>
		<option value="4">4단계</option>
		<option value="5">5단계</option>
	</select>
	<button type="button" class="btn btn-primary" id="chg_img_step">촬영단계 변경</button>

	</div>
</div>
<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$(".searchbox-default").css("display","block");
$(".searchbox-img-step").css("display","block");

$(function(){

	$(".img_name").blur(function(){

		if($(this).val()==''){
			var make_imgnm = $(this).closest("tr").find(".img_goodsnm").val();
			$(this).val(make_imgnm);
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
				alert('처리되었습니다.');
				location.reload();
			}).fail(function(jqXHR, textStatus){
				alert( "Request failed: " + textStatus );
			});
		}
	});

})

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>