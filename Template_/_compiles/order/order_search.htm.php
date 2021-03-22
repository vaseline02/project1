<?php /* Template_ 2.2.8 2021/02/08 11:41:43 /www/html/ukk_test2/data/skin/order/order_search.htm 000007560 */ 
$TPL__cfg_admin_memo_1=empty($GLOBALS["cfg_admin_memo"])||!is_array($GLOBALS["cfg_admin_memo"])?0:count($GLOBALS["cfg_admin_memo"]);?>
<?php if($GLOBALS["print_xls"]!= 1){?>
<?
$mall_list=get_mall_info('y');

$selected['order_search_mall'][$_POST['order_search_mall']]='selected';

foreach($mall_list as $v){
	$uplolad_mall[$v['upload_form_type']][]=$v['mall_name'];
}
?>

<form method="post" id="order_search_form">
	<table class="table table-bordered" >
		<tr>
			<th>몰명</th>
			<td>
				<select name="order_search_mall">
					<option value="">선택</option>
					<optgroup label="업로드별">
					<? 
						foreach( $uplolad_mall as $k=>$v){ 
						?>
						<option value="<?=$k?>" <?=$selected['order_search_mall'][$k]?> >==<?=$k?>==</option>
						<?
						}
					?>
					</optgroup>
					<optgroup label="상세">
					<?

						$before_malltype='';
						foreach( $mall_list as $v){ 
						
						if($before_malltype!=$v['upload_form_type']){
							?>
							<option value="<?=$v['upload_form_type']?>" >==<?=$v['upload_form_type']?>==</option>
							<?
							$before_malltype=$v['upload_form_type'];
						}
					?>
						<option value="<?=$v['no']?>" <?=$selected['order_search_mall'][$v['no']]?> ><?=$v['mall_name']?> (<?=$v['mall_code']?>)</option>
					<?}?>
					</optgroup>
				</select>
			</td>
			<th>옵션명</th>
			<td><input type="text" name="order_search_goodsnm" value="<?=$_POST['order_search_goodsnm']?>"></td>
			<th >주문번호</th>
			<td  style="min-width:200px;">
			<textarea class="form-control" name="order_search_ordno" id="" cols="30" rows="3"><?=$_POST['order_search_ordno']?></textarea>
			<!-- <input type="text" name="order_search_ordno" value="<?=$_POST['order_search_ordno']?>"> -->
			</td>

<?php if($GLOBALS["popup_chk"]){?></tr><tr><?php }?>
			<th>고객명</th>
			<td class="search_td_width"><input type="text" name="order_search_receiver" value="<?=$_POST['order_search_receiver']?>"></td>
			<th>차수</th>
			<td>
				<input type="text" name="order_search_cha_su" id="order_search_cha_su" value="<?=$_POST['order_search_cha_su']?>">
				<!-- <select name="order_search_cha_su" id="order_search_cha_su">
					<option value=''>선택</option>
					<option>20</option>
					<option>21</option>
				</select> -->
			</td>
			<th>등록일</th>
			<td  style="min-width:150px;">
			<input type="text" class="form-control datepicker_common" autocomplete="off"  placeholder="시작 날짜" aria-describedby="basic-addon2" name="order_search_sdate" id="s_date" value="<?php echo $GLOBALS["_POST"]['order_search_sdate']?>"  />
			<input type="text" class="form-control datepicker_common" autocomplete="off" placeholder="종료 날짜" aria-describedby="basic-addon2" name="order_search_edate" id="e_date" value="<?php echo $GLOBALS["_POST"]['order_search_edate']?>"  />
			
			</td>
		</tr>
			
			
			
		</tr>
	</table>
	<center class="table-btn-group" style="margin-bottom:0px">
		<div>
			<div style="text-align:center; display: inline-block; width:95%;">
			<input type="checkbox" name="order_search_adminmemo_chk" value="1"> 관리자메모 미등록
			<input type="checkbox" name="order_search_invo_chk" value="1"> 송장번호 미포함
			<select id="order_search_loc">
				<option value="0">wms(셀피아,B2B,사방넷,CN PLUS)</option>
				<option value="2">wms(타임메카,스토어팜,오피셜)</option>
				<option value="1">재고어드민</option>			
				<option value="3">wms(사무실)</option>		
			</select>
			<button type="button" class="btn btn-success" id="order_search_print_xls">선택값 엑셀 다운로드</button>
			<button class="btn btn-primary" id="">검 색</button>
			</div>
			<div style="text-align:right; display: inline-block;  width:4%;">
			<span type="button" class="btn btn-sm btn-primary dayChange" data-int='0' data-type='day'>오늘</span>
			</div>
		</div>
<?php if(!$GLOBALS["popup_chk"]){?>
		<div class="bottom_btn_box">
			<div class="box_left">
				
			</div>
			<div  class="box_right">
<?php if($TPL__cfg_admin_memo_1){foreach($GLOBALS["cfg_admin_memo"] as $TPL_V1){?>
				<button type="button" class="btn btn-warning admin_memo_input"><?php echo $TPL_V1?></button>
<?php }}?>
				<input type="text" name="i_memo" id="i_memo" style="width:200px;">	
				<button type="button" class="btn btn-primary memoSubmit">관리자메모 등록</button>
			</div>
		</div>
<?php }?>
		
		
	</center>
	
</form>


<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="mode" value="memoupdate">
	<center class="table-btn-group">
<?php if(!$GLOBALS["popup_chk"]){?>
	<div class="bottom_btn_box" style="margin-top:0px">
		<div class="box_left">
			
		</div>
		<div class="box_right">
			<div style="padding-top:5px;"><input type="file" name="excelFile[]" required/>
			<button class="btn btn-primary" >관리자메모 엑셀업데이트</button>
			</div>
		</div>
	</div>
<?php }?>
	</center>
</form>

<script>
$(function(){

	$(".admin_memo_input").click(function(){
		$("#i_memo").val($(this).html());
	});

	/*인클루드 되어있는 페이지의 체크박스 값을 가지고 넘어가야 하기때문에 메인폼을 포스트로 날림.*/ 
	$("#order_search_print_xls").click(function(){
		
		var file_loc='';
		if(	$("#order_search_loc").val()=='1' ){
			file_loc="order_settle_excel2.php";
		}else if(	$("#order_search_loc").val()=='2' ){
			file_loc="order_settle_excel_tm.php";
		}else if(	$("#order_search_loc").val()=='3' ){
			file_loc="order_settle_excel3.php";
		}else{
			file_loc="order_settle_excel.php";
		}


		var chk_len=$(".chk_no:checked").length;
		if( chk_len<=0 ){
			alert('출력할 주문을 선택해주세요.');
			return false;
		}else{
			
			var invo_chk=0;
			if($("[name='order_search_invo_chk']").is(":checked")){
				invo_chk=1;
			}

			var html='<div id="div_excel_search_val">';
			html+='<input type="hidden" name="print_xls" value="1" >';
			html+='<input type="hidden" name="order_search_cha_su" value="'+$("[name='order_search_cha_su']").val()+'">';
			html+='<input type="hidden" name="order_search_invo_chk" value="'+invo_chk+'">';
			html+='<input type="hidden" name="order_search_mall" value="'+$("[name='order_search_mall']").val()+'">';
			html+='<input type="hidden" name="order_search_goodsnm" value="'+$("[name='order_search_goodsnm']").val()+'">';
			html+='<input type="hidden" name="order_search_ordno" value="'+$("[name='order_search_ordno']").val()+'">';
			html+='<input type="hidden" name="order_search_receiver" value="'+$("[name='order_search_receiver']").val()+'">';
			html+='</div>';	
			$("#main_form").append(html);
			
			$("#main_form").attr("action",file_loc);
			$("#main_form").submit();
			$("#main_form").attr("action","");
			$("#div_excel_search_val").remove();
		}
	

	});

	$(".memoSubmit").click(function (){
		var chk_len=$(".chk_no:checked").length;
		var memo=$("input[name='i_memo']").val();
		if( chk_len<=0 ){
			alert('메모를 등록할 주문건을 선택해주세요.');
			return false;
		}else{
			$("input[name='mode']", document.main_form).val("memoIns");

			var html='<input type="hidden" name="i_memo" value="'+memo+'" >';
			$("#main_form").append(html);
			$("#main_form").submit();
		}
	});
})
</script>
<?php }?>