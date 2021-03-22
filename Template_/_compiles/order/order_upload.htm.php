<?php /* Template_ 2.2.8 2021/02/05 20:27:25 /www/html/ukk_test2/data/skin/order/order_upload.htm 000005463 */ 
$TPL_arr_mall_1=empty($TPL_VAR["arr_mall"])||!is_array($TPL_VAR["arr_mall"])?0:count($TPL_VAR["arr_mall"]);
$TPL__cfg_mall_detail_1=empty($GLOBALS["cfg_mall_detail"])||!is_array($GLOBALS["cfg_mall_detail"])?0:count($GLOBALS["cfg_mall_detail"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<hr>
<?php echo $this->define('tpl_include_file_1',"order/order_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>

<style>
.tabletext-center td{text-align:center !important;}
.tabletext-center td.thcolor{background-color:#f3f3f3;}
.upload_input{width:100px;}
table.table th{width:50px;}
</style>


<form id="upload_form" enctype="multipart/form-data" method="post" action="_order_indb.php" >
<input type="hidden" name="upload_form_type" id="upload_form_type">

<?php if($TPL_arr_mall_1){$TPL_I1=-1;foreach($TPL_VAR["arr_mall"] as $TPL_V1){$TPL_I1++;?>
<table class="table table-bordered tabletext-center" >
    <tr>
        <th rowspan="2">구분</th>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
        <td  colspan="<?php echo count($TPL_V2)?>" class="thcolor">
		<?php echo $TPL_K2?> <?php if($TPL_VAR["today_order_type"][$TPL_K2]){?>(<?php echo $TPL_VAR["today_order_type"][$TPL_K2]?>)<?php }?>
		<button type="button" class="del_today_order" id="<?php echo $TPL_K2?>" > 삭제 </button>	
		<input type="hidden" class="up_name" value="<?php echo $TPL_K2?>">
		<br/><input type="file" name="excelFile[]" class="upload_input" ><button type="button" class="btn-sm btn-primary btn_order_upload">등록</button>
<?php if($TPL_K2=='B2B'){?>
		<br/><button type="button" class="btn-sm btn-primary btn_order_upload nonexcel_b2b">도매주문 가져오기( <?php echo $GLOBALS["b2b_cnt"]?>건 )</button>
<?php }?>
		</td>
<?php }}?>
<?php if($TPL_I1== 2){?><th style="width:60px">합계</th><?php }?>
    </tr>
	<tr>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if(is_array($TPL_R3=$TPL_V2)&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
				<td>
				<?php echo $TPL_V3?>

				</td>
<?php }}?>
<?php }}?>
<?php if($TPL_I1== 2){?><td></td><?php }?>
    </tr>
	<tr>
        <th>수량</th>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if(is_array($TPL_R3=$TPL_V2)&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
				<td >
					<?php echo number_format($TPL_VAR["today_order"][$TPL_K2][$TPL_V3])?><br/>
					
				</td>

<?php }}?>
<?php }}?>
<?php if($TPL_I1== 2){?><td><?php echo $GLOBALS["tot_order"]?></td><?php }?>
    </tr>

</table>
<?php }}?>



</form>
<!--
<form id="upload_form" enctype="multipart/form-data" method="post" action="_order_indb.php" onsubmit="return chkform();">
<table class="table table-bordered" >
    <tr>
        <th>파일</th>
        <td>
			<select name="upload_form_type" id="upload_form_type">
				<option>==몰명==</option>
<?php if($TPL__cfg_mall_detail_1){foreach($GLOBALS["cfg_mall_detail"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option>
<?php }}?>
			</select>
			<input type="file" name="excelFile[]" required/><button class="btn-sm btn-primary">업로드</button>
			(업로드가 안될시 엑셀 형식으로 새로 저장 후 업로드 )
		</td>
    </tr>
</table>
</form>
-->
<?php }?>
</div>


<form method="post" id="main_form">
</form>
<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li>몰명선택-> 파일등록(파일명 규정대로 체크)-> 업로드 순으로 등록하면 단계별로 자동 구분되어 등록됨.</li>
	<li>파일명을 해당 몰명-**으로 등록(ex. 타임메카-날짜 또는 타임메카-번호 등 **부분은 없거나 무엇이어도 상관없음. '-' 의 앞부분을 정확하게 기입. 그외 등록실패됨)</li>
	<li>업로드가 안될시 엑셀 형식으로 새로 저장 후 업로드 </li>
	<li><button type="button">삭제</button>버튼은 금일 등록분 중 재고차감이 되지않은 주문과 취소주문이 삭제됨 (1,2,3,4,6)</li>
	<li>주문수량은 "발송확정" 단계에서 주문처리완료 처리시 사라짐.</li>
  </ul>
</fieldset>


<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$("#nav_div0").addClass('active');

$(function(){

	$(".btn_order_upload").click(function(){
		$("#upload_form_type").val( $(this).closest("td").find(".up_name").val());


		if(  $(this).hasClass("nonexcel_b2b") ) $("#upload_form_type").val("nonexcel_b2b");

		if(confirm('등록하시겠습니까?')){

			$(".upload_input").not($(this).closest("td").find(".upload_input")).attr("disabled","disabled");
			$("#upload_form").submit();
		}
	});

	$(".del_today_order").click(function(){
		
		var mall=$(this).attr("id");

		if(confirm('금일 '+mall+' 주문이 삭제됩니다. 삭제하시겠습니까? (재고차감이 된 주문은 삭제되지 않음)')){
			
			location.href="order_upload.php?mode=del_today_order&del_mall="+mall;	
		}
		
	});
})

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>