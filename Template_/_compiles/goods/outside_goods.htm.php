<?php /* Template_ 2.2.8 2020/01/20 17:58:25 /www/html/ukk_test/data/skin/goods/outside_goods.htm 000005068 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>

<?php if($GLOBALS["print_xls"]!= 1){?>


<?php echo $this->define('tpl_include_file_1',"goods/outside_goods_tab.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<form enctype="multipart/form-data" method="post" >
<table class="table table-bordered" >
    <tr>
        <th>등록일</th>
        <td>
			<input type="text" name="reg_date" value="<?php echo $GLOBALS["_POST"]['reg_date']?>" class="datepicker_common" autocomplete="off"> 
			<!--<input type="checkbox" name="except_soldout" value="1"> 품절상품 제외-->
		</td>
    </tr>
	 <tr>
        <th>상태</th>
        <td>
			<input type="radio" name="s_condi" value="0" <?php echo $GLOBALS["checked"]['s_condi']['0']?>>전체
			<input type="radio" name="s_condi" value="1" <?php echo $GLOBALS["checked"]['s_condi']['1']?>>미승인
			<!--<input type="radio" name="s_condi" value="2">품절-->
		</td>
    </tr>
</table>
<center><button class="btn btn-primary">검 색</button></center>
</form>
<?php }?>
<form method="post" id="main_form">
<input type="hidden" name="h_s_condi" value="<?php echo $GLOBALS["_POST"]['s_condi']?>">
<!--<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->
<div>
<table id="" class="display display_dt" data-height="740" border="<?php echo $GLOBALS["xls_border"]?>">
	<?php echo $this->define('tpl_include_file_2',"outline/table_width_def.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<th>브랜드</th>
			<th>분류</th>
			<th>이미지</th>
			<th>모델명</th>
			<!--<th>보유이미지</th>-->
			<th>소비자가</th>
			<th>판매가</th>
	
			
			<th>옵션명</th>
			<th>옵션내용</th>
			<th>재고수량</th>
			
			<th>색상</th>
			<th >재질</th>
			<th>성별</th>
			<th>등록일</th>
			<!--<th>설명</th>-->
			<th>원산지</th>
			<th>시즌</th>
			<!--<th>기타정보</th>-->
			<th>현재<br/>상태</th>
			<th>승인<br/>상태</th>
			
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td><?php }?>
			<td><?php echo $TPL_V1["brand"]?></td>
			<td><?php echo $TPL_V1["first_category"]?><br/><?php echo $TPL_V1["category"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<!--<td><?php if(is_array($TPL_R2=$TPL_V1["images"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?><?php echo $TPL_V2?><br/><?php }}?></td>-->
			<td><?php echo number_format($TPL_V1["price"])?></td>
			<td><?php echo number_format($TPL_V1["discount"])?></td>
			
			<td><?php echo $TPL_V1["opt1_nm"]?></td>
			<td><?php if(is_array($TPL_R2=$TPL_V1["opt1_val"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?><?php echo $TPL_V2?><br/><?php }}?></td>
			<td><?php echo $TPL_V1["stock_cnt"]?></td>
			<td><?php echo $TPL_V1["color"]?></td>
			<td><?php echo $TPL_V1["material"]?></td>
			<td><?php echo $TPL_V1["gender"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<!--<td><?php echo $TPL_V1["description"]?></td>-->
			<td><?php echo $TPL_V1["origin"]?></td>
			<td><?php echo $TPL_V1["season"]?></td>
			<!--<td><?php echo $TPL_V1["etc_info"]?></td>-->
			<td><?php echo $TPL_V1["sync_chk"]?></td>
			<td><?php echo $TPL_V1["sync_confirm"]?></td>	
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
		<button type="button" class="btn btn-primary" id="confirm">연동승인</button>
	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li>연동된 제품중 카테고리 코드 등록이 되지않은 모델이 있는경우 상단 카테고리 등록에서 필히 등록</li>
  </ul>
</fieldset>

<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
	
	$("#confirm").click(function(){
		
		if( $(".chk_no:checked").length <=0 ){
			alert('연동승인할 상품을 선택해주세요.');
			return;
		}

		if(confirm('연동승인 하시겠습니까?')){
			
			$("#mode").val("confirm");
			$("#main_form").submit();
		}
	});
})


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>