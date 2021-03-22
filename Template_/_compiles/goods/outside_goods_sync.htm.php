<?php /* Template_ 2.2.8 2020/01/20 16:13:24 /www/html/ukk_test/data/skin/goods/outside_goods_sync.htm 000002977 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>

<?php if($GLOBALS["print_xls"]!= 1){?><?php echo $this->define('tpl_include_file_1',"goods/outside_goods_tab.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?><?php }?>
<form method="post" id="main_form">
<!--<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->
<div>
<table id="" class="display display_dt" border="<?php echo $GLOBALS["xls_border"]?>">

	<thead>
		<tr>
			<th width="150">종류</th>
			<th>로그</th>
			<th>등록일</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["sol_type"]?></td>
			<td><div style="height:120px;overflow:auto"><?php echo $TPL_V1["log"]?></div></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
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
	<li>최근 3일간 데이터만 기록됩니다.</li>
  </ul>
</fieldset>

<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

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