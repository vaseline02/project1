<?php /* Template_ 2.2.8 2021/03/10 16:27:54 /www/html/ukk_test2/data/skin/cs/send_out.htm 000007678 */ 
$TPL__invo_upload_mall_1=empty($GLOBALS["invo_upload_mall"])||!is_array($GLOBALS["invo_upload_mall"])?0:count($GLOBALS["invo_upload_mall"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<?php echo $this->define('tpl_include_file_1',"cs/send_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<style>
.search_td_width{width:800px;}
#nav_div2_b a:after{width:90%}
</style>

<?php if($GLOBALS["print_xls"]!= 1){?>
    <?php echo $this->define('tpl_include_file_2',"outline/table_width_cancel.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

	<form enctype="multipart/form-data" method="post" onsubmit="return chkform();">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small" >
			<colgroup>
				<col width="10%" />
				<col/>
				<col width="10%" />
			</colgroup>
				<tr>
					<th scope="row">송장 업로드</th>
					<td>
						<input type="file" name="excelFile[]" required/><button class="btn btn-primary" >업로드</button>
					</td>
					<!--
					<td>
						<select id="invo_mall">
							<option value="">선택</option>
<?php if($TPL__invo_upload_mall_1){foreach($GLOBALS["invo_upload_mall"] as $TPL_V1){?>
							<option ><?php echo $TPL_V1?></option>
<?php }}?>
						</select>
						<button type="button" class="btn btn-sm btn-success" id="invo_download">송장다운로드</button>
					</td>-->
				</tr>
			</table>
			</div>
		</div>
	</div>
	</form>
	
	<div class="btn btn-warning smsSend">문자발송</div>
<?php }?>
<form id="sendForm" method="POST">
<input type="hidden" name="mode" value="">
<input type="hidden" name="no" value="">
<input type="hidden" name="code" value="">

<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">	
	<thead>
		<tr>
			<th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>			
			<th>몰명</th>
			<th>주문번호<br><span style="color:red">교환주문번호</span></th>
			<th>모델명</th>
			<th>이미지</th>
			<th>수량</th>
			<th>모델명<br>(교환)</th>
			<th>이미지<br>(교환)</th>
			<th>수량<br>(교환)</th>
			<th>비용</th>
			<th>구매자</th>
			<th>수령자</th>
			<th>송장번호<br><span style="color:red">교환주문송장번호</span></th>
			<th>사유</th>
			<th>작성자</th>
			<th>등록일</th>
			<th>발송위치</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr>			
				<input type="hidden" name="ex_invoice[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["ex_invoice"]?>">
				<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>" data-ex_no="<?php echo $TPL_V1["ex_no"]?>"></td>
				<td><?php echo $TPL_V1["mall_name"]?><br><?php echo $TPL_V1["upload_form_type"]?></td>
				<td><?php echo $TPL_V1["order_no"]?><br><a href="javascript:popup('../order/order_mod_pop.php?no=<?php echo $TPL_V1["ex_no"]?>&model_chk=n','order_mod_pop','1000','700')"> <span style="color:red">(<?php echo $TPL_V1["ex_ordno"]?>)</span></a></td>
				<td><?php if($TPL_V1["return_type"]!='40'){?><?php echo $TPL_V1["goodsnm"]?><?php }?></td>
				<td class="td_img"><?php if($TPL_V1["return_type"]!='40'){?><?php echo $TPL_V1["img_url"]?><?php }?></td>
				<td><?php echo $TPL_V1["exchange_goods_num"]?></td>
				<td><?php echo $TPL_V1["exchange_goodsnm"]?></td>
				<td class="td_img"><?php echo $TPL_V1["exchange_img_url"]?></td>
				<td><?php echo $TPL_V1["exchange_goods_num"]?></td>
				<td><?php echo number_format($TPL_V1["diff_price"])?></td>
				<td><?php echo $TPL_V1["buyer"]?></td>
				<td><?php echo $TPL_V1["receiver"]?></td>
				<td><?php if($TPL_V1["return_invoice"]!= 0){?><?php echo $TPL_VAR["delivery_list"][$TPL_V1["return_delivery_code"]]['name']?><br><?php echo $TPL_V1["return_invoice"]?><?php }?><br>
				<span style="color:red"><?php if($TPL_V1["ex_invoice"]!= 0){?><?php echo $TPL_VAR["delivery_list"][$TPL_V1["ex_courier_code"]]['name']?><br><?php echo $TPL_V1["ex_invoice"]?><?php }?></span>
				</td>
				<td><?php echo $TPL_V1["return_type_nm"]?></td>
				<td><?php echo $TPL_V1["name"]?><div>(<?php echo $TPL_V1["id"]?>)</div></td>
				<td><?php echo $TPL_V1["reg_date"]?></td>			
				<td><?php echo $TPL_V1["ex_delinm"]?></td>			
				<td>
					<button type="button" class="btn btn-sm btn-warning" onclick="popup('cs_reg.php?ordno=<?php echo $TPL_V1["order_no"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>&order_list_no=<?php echo $TPL_V1["order_list_no"]?>&view_type=1','','1100','900')">상세</button>
<?php if($TPL_V1["return_type"]=="70"&&!$TPL_V1["ex_invoice"]&&($_SESSION['sess']['m_no']=='33'||$_SESSION['sess']['m_no']=='69'||$_SESSION['sess']['m_no']=='120')){?>
					<div style="padding-top: 5px;"><div type="button" class="btn btn-sm btn-danger cancelCs" data-no=<?php echo $TPL_V1["no"]?>>철회</div></div>
<?php }?>
				</td>
			</tr>
<?php }}?>
	</tbody>
</table>
<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?></div>
<div class="bottom_btn_box">
	<div class="box_left">		
	</div>
	<div  class="box_right">
		<button class="btn btn-primary changeProcess" type="button" data-mode='in' data-code='3'>입고처리</button>
	</div>
</div>

<?php }?>

</form>

<form method="post" name="smsForm" id="smsForm">
<input type="hidden" name="order_list_no" value="">

</form>
<script>
$("#nav_div2").addClass('active');
document.title="<?php echo $GLOBALS["page_title"]?>";

$(".changeProcess").click(function(){
	var mode=$(this).data("mode");
	var code=$(this).data("code");
	var badCount=0;
	var mess="";

	if(!$(".chk_no").is(":checked")){
		alert("선택된 상품이 없습니다.");
		return false;
	}else{			
		$(".chk_no").each(function(index, item){
			if($(item).is(":checked")){               
				if(!Number($("input[name='ex_invoice["+$(item).val()+"]']").val())){
					badCount++;
				}
			}
		});

		if(badCount>0){
			alert("교환주문송장번호가 등록되지않은 접수건이있습니다.");	
			return false;
		}else{
			if(confirm("입고처리 하시겠습니까?")){
				$("input[name='mode']").val(mode);
				$("input[name='code']").val(code);
				$("#sendForm").submit();
			}     
		}
    }
});

$(".smsSend").click(function (){
	var ordno=new Array();
	
	$(".chk_no").each(function(index, item){
		if($(item).is(":checked")){                  
			ordno.push($(this).data('ex_no'));
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

$(".cancelCs").click(function(){
	if(confirm("철회하시겠습니까?")){
		$("input[name='mode']").val('cancel');
		$("input[name='code']").val('91');
		$("input[name='no']").val($(this).data("no"));
		$("#sendForm").submit();
	}
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>