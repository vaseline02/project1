<?php /* Template_ 2.2.8 2021/03/10 10:05:27 /www/html/ukk_test2/data/skin/cs/send_in.htm 000011307 */ 
$TPL_bloop_1=empty($TPL_VAR["bloop"])||!is_array($TPL_VAR["bloop"])?0:count($TPL_VAR["bloop"]);
$TPL_notData_1=empty($TPL_VAR["notData"])||!is_array($TPL_VAR["notData"])?0:count($TPL_VAR["notData"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<?php echo $this->define('tpl_include_file_1',"cs/send_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<style>
.search_td_width{width:800px;}
#nav_div2 a:after{width:90%}
</style>

<?php if($GLOBALS["print_xls"]!= 1){?>
    <?php echo $this->define('tpl_include_file_2',"outline/table_width_cancel.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

<?php }?>

<form id="sendcheckForm" method="POST">
<input type="hidden" name="mode" value="">

<div class="row">
	<div class="col-lg-12">		
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="10%" />
					<col width="20%" />
					<col width="50px" />
					<col/>
					<col/>
					<col width="20%" />
				</colgroup>
				<tbody>
					<tr>
						<th>바코드</th>
						<td style="height:621px"><textarea name="s_barcode" id="" style="height:100%; width:100%"><?php echo $_POST['s_barcode']?></textarea></td>	
						<td style="text-align: center;">
							<span class="updateorder-arrow glyphicon glyphicon-menu-right" style="font-size:26px;" aria-hidden="true"></span>
	   					    <br><div type="button" class="btn btn-primary returnMerge" style="margin-top: 10px;">회수비교</div>
						</td>
						<td style="vertical-align: top;">
							<div style="overflow: auto; height:621px;">
								<table class="table common-table">
									
									<thead>										
										<tr>			
											<th>모델명</th>
											<th>이미지</th>
											<th width='100'>반품수량(<?php echo $GLOBALS["tNum"]?>)</th>
											<th>확인여부(<span style="color:red">미확인 : <?php echo $GLOBALS["notNum"]?></span>, <span style="color:blue">확인 : <?php echo $GLOBALS["okNum"]?></span>)</th>
										</tr>
									</thead>
									<tbody>
<?php if($TPL_bloop_1){foreach($TPL_VAR["bloop"] as $TPL_V1){?>     
										<tr class="<?php echo $TPL_V1["line_color"]?>">			
											<td><?php echo $TPL_V1["goodsnm"]?></td>
											<td class="td_img" style="text-align: center;"><?php echo $TPL_V1["img_url"]?></td>
											<td style="text-align: center;"><?php echo $TPL_V1["sum_egn"]?></td>
											<td style="text-align: center;"><span style="color:<?php echo $TPL_V1["confirmColor"]?>"><?php echo $TPL_V1["confirmNm"]?></span></td>
										</tr>
<?php }}?>
									</tbody>
								</table>
							</div>
						<td> </td>

						<td>
							<div style="overflow: auto; height:621px;">
							<table class="table common-table">
							<!--
								<caption>
									<div class="input-group col-lg-12 common-table-search2">
										<div class="input-group common-table-search">										
											<span class="input-group-btn">				
<?php if($TPL_VAR["allClean"]> 0){?>
												<div type="button" class="btn btn-primary confirmCheck" data-num='1'>확인</div>
<?php }elseif(count($TPL_VAR["notData"])){?>
												<div type="button" class="btn btn-primary confirmCheck" data-num='2'>확인</div>
<?php }else{?>
												<div type="button" class="btn btn-primary confirmCheck" data-num='3'>확인</div>
<?php }?>
											</span>
										</div>
									</div>
								</caption>
								-->
								<thead>
									<tr>
										<th colspan=2>리스트에없는바코드</th>
									</tr>
									<tr>
										<th>바코드</th>
										<th>수량</th>
									</tr>
								</thead>
								<tbody>
<?php if($TPL_notData_1){foreach($TPL_VAR["notData"] as $TPL_K1=>$TPL_V1){?>
									<tr>
										<td><?php echo $TPL_K1?></td>		
										<td style="text-align: center;"><?php echo $TPL_V1?></td>	                    	
									</tr>
<?php }}?>
								</tbody>
							</table>
							</div>
						</td>	                    	
					</tr>
				</tbody>
			</table>
		</div>
	</div>			
</div>
</form>

<form id="sendForm" method="POST">
<input type="hidden" name="mode" value="">
<input type="hidden" name="no" value="">
<input type="hidden" name="code" value="">


<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">	
	<thead>
		<tr>
			<th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>			
			<th>몰명</th>
			<th>주문번호</th>
			<th>고객명</th>
			<th>연락처</th>
			<th>모델명</th>
			<th>이미지</th>
			<th>구매수량</th>
			<th>반품수량</th>
			<th>송장번호</th>
			<th>교환출고송장번호</th>
			<th>사유</th>
			<th>작성자</th>
			<th>등록일</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>

			<tr class="<?php echo $TPL_V1["line_color"]?>">			
				<input type="hidden" name="account_number[<?php echo $TPL_V1["no"]?>]" value=<?php echo $TPL_V1["account_number"]?>> 
				<input type="hidden" name="account_code[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["account_code"]?>"> 
				<td>
<?php if(!$TPL_V1["goods_no"]&&$_GET['subtype']=='2'){?>
				-
<?php }else{?>
				<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>" data-return_type=<?php echo $TPL_V1["return_type"]?> data-return_type_sub=<?php echo $TPL_V1["return_type_sub"]?>>
<?php }?>
				</td>
				<td><?php echo $TPL_V1["mall_name"]?><br><?php echo $TPL_V1["upload_form_type"]?></td>
				<td><?php echo $TPL_V1["order_no"]?></td>
				<td><?php echo $TPL_V1["receiver"]?></td>
				<td><?php echo $TPL_V1["mobile"]?></td>
				<td><?php echo $TPL_V1["goodsnm"]?></td>
				<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
				<td><?php echo $TPL_V1["order_num"]?></td>
				<td><?php echo $TPL_V1["exchange_goods_num"]?></td>
				<td><?php if($TPL_V1["return_invoice"]!= 0){?><?php echo $TPL_VAR["delivery_list"][$TPL_V1["return_delivery_code"]]['name']?><br><?php echo $TPL_V1["return_invoice"]?><?php }?></td>
				<td><?php if($TPL_V1["ex_invoice"]!= 0){?><?php echo $TPL_VAR["delivery_list"][$TPL_V1["ex_courier_code"]]['name']?><br><?php echo $TPL_V1["ex_invoice"]?><?php }?></td>
				<td><?php echo $TPL_V1["return_type_nm"]?></td>
				<td><?php echo $TPL_V1["name"]?><div>(<?php echo $TPL_V1["id"]?>)</div></td>
				<td><?php echo $TPL_V1["reg_date"]?></td>
				<td>
					<button type="button" class="btn btn-sm btn-warning" onclick="popup('cs_reg.php?ordno=<?php echo $TPL_V1["order_no"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>&order_list_no=<?php echo $TPL_V1["order_list_no"]?>&view_type=1','','1100','900')">상세</button>
<?php if($TPL_V1["return_type"]=="60"&&($_SESSION['sess']['m_no']=='33'||$_SESSION['sess']['m_no']=='69'||$_SESSION['sess']['m_no']=='120')){?>
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
		<select name="codeSelect" class="codeSelect">
<?php if($_GET['subtype']=='1'){?>
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["no"]?>" <?php echo $GLOBALS["selected"]['codeSelect'][$TPL_V1["no"]]?> data-name="<?php echo $TPL_V1["cd"]?>"><?php echo $TPL_V1["cd"]?></option>
<?php }}?>
<?php }else{?>
				<option value="bad" data-name="불량접수">불량접수</option>
<?php }?>
		</select>
<?php if(!$TPL_VAR["allClean"]){?>
			<div type="button" class="btn btn-primary cancelChange" type="button" id="order_settle" data-code='4'>처리완료</div>
<?php }else{?>
			<div type="button" class="btn btn-primary cancelChange" type="button" id="order_settle" data-code='4'>처리완료</div>
			<!-- <div type="button" class="btn btn-primary" style="opacity: 0.6; cursor: not-allowed;" onclick="alert('확인되지않은 상품이있습니다.')" type="button">처리완료</div> -->
<?php }?>
	</div>
</div>

<?php }?>

</form>

<script>

<?php if($GLOBALS["_GET"]['subtype']== 1){?>
	$("#nav_div3-1").addClass('active');
<?php }else{?>
	$("#nav_div3-2").addClass('active');
<?php }?>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(".cancelChange").click(function(){
	var place_code_name=$("select[name='codeSelect']").find("option:selected").data("name");

	if(!$(".chk_no").is(":checked")){
		alert("선택된 상품이 없습니다.");
		return false;
	}else{
		
		if($(this).data('code')=='1'){
			if(confirm('이전상태(접수)로 변경하시겠습니까?')){
				$("input[name='mode']").val('allCancel');
				$("input[name='code']").val($(this).data('code'));
				$("#sendForm").submit();
			}
		}else{
			var badCount=0;
			//재고이동시 하자건이 체크되있을경우 넘기지않는다.
			$(".chk_no").each(function(index, item){
				if($(item).is(":checked")){                                       
					//교환이거나 반품일경우이고 하자일경우 체크
					if(($(item).data('return_type')=='60' || $(item).data('return_type')=='70') && $(item).data('return_type_sub')=='2'){
						badCount++;
					}
				}
			});

			if(!$(".codeSelect").val()){
				alert("재고 등록위치를 선택해주세요.");
				return false;
			}else if($(".codeSelect").val()>=1 && badCount>0){
				alert("하자건이 선택되어있습니다.");
				return false;
			}else{
				if(confirm('['+place_code_name+']처리완료로 변경하시겠습니까?')){
					$("input[name='mode']").val('allCancel');
					$("input[name='code']").val($(this).data('code'));
					$("#sendForm").submit();
				}
			}
		}
        
    }
});


$(".returnMerge").click(function(){
   $("form[id='sendcheckForm']").submit();
});
$(".confirmCheck").click(function(){
    var num=$(this).data('num');
    if(num=='1'){
        alert('확인되지않은 상품이 있습니다.');
        return false;
    }else if(num=='2'){
        if(confirm('리스트에 없는송장이 있습니다. \r\n확인처리하시겠습니까?')){
            $("input[name='mode']").val('mod');
            $("form[id='sendcheckForm']").submit();
        }
    }else if(num=='3'){
        if(confirm('확인처리하시겠습니까?')){
            $("input[name='mode']").val('mod');
            $("form[id='sendcheckForm']").submit();
        }
    }
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