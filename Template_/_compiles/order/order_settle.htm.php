<?php /* Template_ 2.2.8 2021/01/28 15:39:06 /www/html/ukk_test2/data/skin/order/order_settle.htm 000009474 */ 
$TPL__invo_upload_mall_1=empty($GLOBALS["invo_upload_mall"])||!is_array($GLOBALS["invo_upload_mall"])?0:count($GLOBALS["invo_upload_mall"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL__order_chk_1=empty($GLOBALS["order_chk"])||!is_array($GLOBALS["order_chk"])?0:count($GLOBALS["order_chk"]);
$TPL__log_chk_1=empty($GLOBALS["log_chk"])||!is_array($GLOBALS["log_chk"])?0:count($GLOBALS["log_chk"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>
<?php if($GLOBALS["nav_view"]){?>
<?php echo $this->define('tpl_include_file_1',"order/order_nav2.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<?php }else{?>
<?php echo $this->define('tpl_include_file_2',"order/order_nav.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

<?php }?>
<style>
#nav_div7 a:after{width:90%}
</style>


<?php if($_SESSION["sess"]['h_level']>'90'){?><!-- 주문처리 권한 -->

<div style="float:right">
<button type="button" class="btn btn-sm btn-primary" onclick="if(confirm('데이터연동')){popup('../admin/cron_0813.php','l_reg','500','500')}">데이터연동</button>
</div>

<?php }?>
<form enctype="multipart/form-data" method="post" onsubmit="return chkform();">
<table class="table table-bordered" style="margin-top:50px;">
    <tr>
        <th>송장 업로드</th>
        <td>
			<input type="file" name="excelFile[]" required/><button class="btn btn-primary" >업로드</button>
			<!--
			<button type="button" class="btn btn-success" onclick="location.href='../xls_file/order_invoice_upload_sample2.xlsx'">양식 다운로드</button>
			-->
		</td>
		
		<td >
			<select id="invo_mall">
				<option value="">선택</option>
<?php if($TPL__invo_upload_mall_1){foreach($GLOBALS["invo_upload_mall"] as $TPL_V1){?>
				<option ><?php echo $TPL_V1?></option>
<?php }}?>
			</select>
			<button type="button" class="btn btn-sm btn-success" id="invo_download">송장다운로드</button>
		</td>
		
    </tr>
</table>
</form>
<?php }?>
<div class="btn btn-warning smsSend">문자발송</div>
<form method="post" id="main_form">
<?php if($GLOBALS["print_xls"]!= 1){?>
<input type="hidden" name="get_deli_codeno">
<input type="hidden" name="sel_invo_mall" id="sel_invo_mall">
<input type="hidden" name="mode" id="mode">
<input type="hidden"name="print_xls" value="">
<?php }?>
<!--<table id="" class="display display_dt" data-height="740" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->
<table class="table table-bordered" >
	<?php echo $this->define('tpl_include_file_3',"outline/table_width_order.htm")?> <?php $this->print_("tpl_include_file_3",$TPL_SCP,1);?>

	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<?php echo $this->define('tpl_include_file_4',"order/_order_cols.htm")?> <?php $this->print_("tpl_include_file_4",$TPL_SCP,1);?>

			<th width="100">배송지</th>
			<th width="100">송장번호</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="<?php echo $TPL_V1["line_color"]?> ">
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
				<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>">
				<input type="hidden" name="hid_invoice[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["invoice"]?>">
				<?php echo $TPL_V1["list_num"]?>

			</td>
<?php }?>
			<td><?php echo $TPL_V1["mall_name"]?><br/><?php echo $TPL_V1["upload_form_type"]?></td>
			<td><?php echo $TPL_V1["ordno"]?> <?php echo $TPL_V1["order_type"]?></td>
			<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["order_num"]?></td>
			<td><?php echo number_format($TPL_V1["settle_price"])?></td>
			<td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>

			<td><?php echo $TPL_V1["phone"]?><br/><?php echo $TPL_V1["mobile"]?></td>
			<td><?php echo $TPL_V1["zipcode"]?> <?php echo $TPL_V1["address"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td style="color:<?php echo $TPL_V1["bundle_color"]?>"><?php echo $TPL_V1["bundle"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td><?php echo $TPL_V1["place_name"]?></td>
			<td><?php if($TPL_V1["invoice"]!='0'){?><?php echo $TPL_V1["delivery_name"]?><br/><?php echo $TPL_V1["invoice"]?><?php }?></td>
			<td class="text_center" >
				<button type="button" class="btn-sm btn-warning mod" onclick="popup('order_mod_pop.php?no=<?php echo $TPL_V1["no"]?>','order_mod_pop','1000','700')">수정</button>
				<button type="button" class="btn-sm btn-warning go_step" data-step="8">보류</button>
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">
		<button type="button" class="btn btn-danger submit" id="hold_order">보류이동</button>
		<button type="button" class="btn btn-danger submit" id="cancel">주문취소</button>
<?php if(!$GLOBALS["nav_view"]){?>
		<button type="button" class="btn btn-warning submit" id="goback">단일/묶음발송 최종확인으로 이동</button>
<?php }?>
	</div>
	<div  class="box_right">
	<!--<button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>-->
	<button type="button" class="btn btn-primary submit" id="order_comp">주문처리완료</button>
	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li></li>
  </ul>
</fieldset>

<div>주문서 위주 재고수량</div>
<?php if($TPL__order_chk_1){foreach($GLOBALS["order_chk"] as $TPL_K1=>$TPL_V1){?>
<div><?php echo $TPL_K1?> : <?php echo $TPL_V1?></div>
<?php }}?>

<div>로그상 재고차감</div>
<?php if($TPL__log_chk_1){foreach($GLOBALS["log_chk"] as $TPL_K1=>$TPL_V1){?>
<div><?php echo $TPL_K1?> : <?php echo $TPL_V1?></div>
<?php }}?>
<?php }?>
</form>

<form method="post" name="smsForm" id="smsForm">
<input type="text" name="order_list_no" value="">

</form>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
<?php if($_GET['gubun']== 1){?>
<?php if($_GET['deli_codeno']== 1){?>
	$("#nav_div7-1").addClass('active');
<?php }elseif($_GET['deli_codeno']== 51){?>
	$("#nav_div7-2").addClass('active');
<?php }else{?>
	$("#nav_div7-3").addClass('active');
<?php }?>
<?php }elseif($_GET['gubun']== 2){?>
	$("#nav_div5-3").addClass('active');
<?php }elseif($_GET['gubun']== 3){?>
	$("#nav_div7-3").addClass('active');
<?php }?>


//$("#nav_div7").addClass('active');
$(function(){

	$("#invo_download").click(function(){

		var chk_len=$(".chk_no:checked").length;
			
		if( chk_len<=0 ){
			alert('출력할 주문을 선택해주세요.');
			return;
		}

		if($("#invo_mall").val()==''){

			alert('출력할 몰을 선택해주세요.');

			return;
		}
		$("#sel_invo_mall").val($("#invo_mall").val());

		

		$("#main_form").attr("action","mall_invoice_excel.php");
		$("input[name='print_xls']").val("1");
		$("#main_form").submit();
		$("#main_form").attr("action","");
		$("input[name='print_xls']").val("");
	});

	$(".submit").click(function(){

		var chk_len=$(".chk_no:checked").length;
			
		if( chk_len<=0 ){
			alert('변경할 주문을 선택해주세요.');
			return;
		}
		
		var btype=$(this).attr("id");
		var msg=msg2='';
		if( btype=='soldout' ){
			msg='품절처리 하시겠습니까? 묶음주문 품절시 관련 주문 모두가 품절처리됩니다.';
		}else if( btype=='cancel' ){
			msg='주문취소 하시겠습니까? 묶음주문 취소시 관련 주문 모두가 취소처리됩니다.';
		}else if( btype=='order_comp' ){
			msg='주문처리완료 하시겠습니까? 송장번호가 등록된 주문만 처리됩니다.';
		}else if( btype=='goback' ){
			msg='단일/묶음발송 최종확인으로 이동하시겠습니까?';
		}else if(btype=='hold_order'){
			msg='보류이동 하시겠습니까?';
		}

		if(confirm(msg)){
			$("#mode").val(btype);
			$("#main_form").submit();
		}
	});

	$(".go_step").click(function(){
	
		var no=$(this).closest("tr").find(".chk_no").val();
		var step=$(this).data("step");
		var mode="go_step";
		if(confirm('보류단계로 이동')){
		
			location.href="order_settle.php?mode="+mode+"&no="+no+"&step="+step;
		}	
	});

	/*
	$("#print_xls").click(function(){
		if(!$(".chk_no").is(":checked")){
			alert('다운받을 주문건을 선택해주세요.');
			return false;
		}

		$("input[name='print_xls']").val("1");
		$("#main_form").attr("action","order_settle_excel.php");
		$("#main_form").submit();
		$("input[name='print_xls']").val("0");
		$("#main_form").attr("action","");
		
	});
	*/
});

$(".smsSend").click(function (){
	var ordno=new Array();
	
	$(".chk_no").each(function(index, item){
		if($(item).is(":checked")){                  
			ordno.push($(this).val());
		}
	});

	$("input[name='order_list_no']").val(ordno);

	var pop_title = "send_sms" ;

	var status = "width=1000, height=700, scrollbars = yes";
         
	window.open("", pop_title, status) ;
	 
	var frmData = document.smsForm ;
	frmData.target = pop_title ;
	frmData.action = "../cs/send_sms.php?etc_code=cs" ;
	 
	frmData.submit() ;

});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>