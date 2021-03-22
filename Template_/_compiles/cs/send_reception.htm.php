<?php /* Template_ 2.2.8 2021/02/23 09:45:02 /www/html/ukk_test2/data/skin/cs/send_reception.htm 000008039 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>
<?php echo $this->define('tpl_include_file_1',"cs/send_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<style>
.search_td_width{width:800px;}
#nav_div1 a:after{width:90%}
</style>

<?php if($GLOBALS["print_xls"]!= 1){?>
    <?php echo $this->define('tpl_include_file_2',"outline/table_width_cancel.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

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
			<th>주문번호</th>
			<th>고객명</th>
			<th>연락처</th>
			<th>모델명</th>
			<th>이미지</th>
			<th>수량</th>
			<th>모델명<br>(교환)</th>
			<th>이미지<br>(교환)</th>
			<th>수량<br>(교환or반품)</th>
			<th>비용</th>
			<th>송장번호</th>
			<th>사유</th>
			<th>작성자</th>
			<th>등록일</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr>			
				
				<td>
<?php if($TPL_V1["send_type"]!='2'){?>
					<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>" data-status="<?php echo $TPL_V1["return_type"]?>" data-status2="<?php echo $TPL_V1["return_type_sub"]?>">
<?php }?>
				</td>
				<td><?php echo $TPL_V1["mall_name"]?><br><?php echo $TPL_V1["upload_form_type"]?></td>
				<td><?php echo $TPL_V1["order_no"]?></td>
				<td><?php echo $TPL_V1["receiver"]?></td>
				<td><?php echo $TPL_V1["mobile"]?></td>
				<td><?php if($TPL_V1["return_type"]!='40'){?><?php echo $TPL_V1["goodsnm"]?><?php }?></td>
				<td class="td_img"><?php if($TPL_V1["return_type"]!='40'){?><?php echo $TPL_V1["img_url"]?><?php }?></td>
				<td><?php echo $TPL_V1["exchange_goods_num"]?></td>
				<td><?php if($TPL_V1["return_type"]=='40'||$TPL_V1["return_type"]=='70'||$TPL_V1["return_type"]=='90'){?><?php echo $TPL_V1["exchange_goodsnm"]?><?php }?></td>
				<td class="td_img"><?php if($TPL_V1["return_type"]=='40'||$TPL_V1["return_type"]=='70'||$TPL_V1["return_type"]=='90'){?><?php echo $TPL_V1["exchange_img_url"]?><?php }?></td>
				<td><?php echo $TPL_V1["exchange_goods_num"]?></td>
				<td><?php echo number_format($TPL_V1["diff_price"])?></td>
				<td><?php if($TPL_V1["return_invoice"]!= 0){?><?php echo $TPL_VAR["delivery_list"][$TPL_V1["return_delivery_code"]]['name']?><br><?php echo $TPL_V1["return_invoice"]?><?php }?></td>
				<td><?php echo $TPL_V1["return_type_nm"]?><?php if($TPL_V1["receipt"]=='1'){?><div style="color: red;">선접수</div><?php }?></td>
				<td><?php echo $TPL_V1["name"]?><div>(<?php echo $TPL_V1["id"]?>)</div></td>
				<td><?php echo $TPL_V1["reg_date"]?></td>
				<td>
					<div><button type="button" class="btn btn-sm btn-warning" onclick="popup('cs_reg.php?ordno=<?php echo $TPL_V1["order_no"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>&order_list_no=<?php echo $TPL_V1["order_list_no"]?>&view_type=1','','1100','900')">상세</button></div>
					<div style="padding-top: 5px;"><div type="button" class="btn btn-sm btn-danger cancelCs" data-no=<?php echo $TPL_V1["no"]?>>철회</div></div>
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
		<select name="place_code" id="">
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["no"]?>" <?php echo $GLOBALS["selected"]['place_code'][$TPL_V1["no"]]?> data-name="<?php echo $TPL_V1["cd"]?>"><?php echo $TPL_V1["cd"]?></option>
<?php }}?>
			<!--<option value="all" data-name="통합발송">통합발송</option>-->
		</select>
		<button class="btn btn-primary changeProcess" type="button" data-mode='out' data-code='2'>교환출고</button>
		<button class="btn btn-primary changeProcess" type="button" data-mode='in' data-code='3'>반품입고</button>
		<button class="btn btn-primary changeProcess" type="button" data-mode='return' data-code='2'>상품반송</button>
		<button class="btn btn-primary changeProcess" type="button" data-mode='send' data-code='2'>출고</button>
	</div>
</div>

<?php }?>

</form>

<script>
$("#nav_div1").addClass('active');
document.title="<?php echo $GLOBALS["page_title"]?>";

$(".cancelCs").click(function(){
	if(confirm("철회하시겠습니까?")){
		$("input[name='mode']").val('cancel');
		$("input[name='code']").val('91');
		$("input[name='no']").val($(this).data("no"));
		$("#sendForm").submit();
	}
});
$(".cancelRestore").click(function(){
	if(confirm("회수확인상태의 주문을 접수로 변경하시겠습니까?")){
		$("input[name='mode']").val('restore');
		$("input[name='code']").val('1');
		$("input[name='no']").val($(this).data("no"));
		$("#sendForm").submit();
	}
});
$(".cancelChange").click(function(){
	if(!$(".chk_no").is(":checked")){
		alert("선택된 상품이 없습니다.");
		return false;
	}else{
        if(confirm('회수확인으로 변경하시겠습니까?')){
            $("input[name='mode']").val('allCancel');
            $("input[name='code']").val($(this).data('code'));
            $("#sendForm").submit();
        }
    }
});

$(".changeProcess").click(function(){
	var place_code=$("select[name='place_code']").val();
	var place_code_name=$("select[name='place_code']").find("option:selected").data("name");
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
				if(mode=="in" &&  $(item).data('status')!="60"){
					badCount++;
				}else if(mode=="out" && ($(item).data('status')=="40" || $(item).data('status')=="60" || ($(item).data('status')=="90" && $(item).data('status2')=="2"))){
					badCount++;
				}else if(mode=="return" && $(item).data('status')!="90" && $(item).data('status2')!="2"){
					badCount++;
				}else if(mode=="send" && $(item).data('status')!="40" && $(item).data('status2')!="2"){
					badCount++;
				}				
			}
		});

		if(badCount>0){
			if(mode=='in'){
				mess="반품건이 아닙니다.";
			}else if(mode=='out'){
				mess="교환건이 아닙니다.";
			}else if(mode=='return'){
				mess="상품입고(상품반송)건이 아닙니다.";
			}else if(mode=='send'){
				mess="출고건이 아닙니다.";
			} 
			alert(mess);
			return false;
		}else{
			if(mode=='in'){
				mess="입고처리 하시겠습니까?";
				
			}else if(mode=='out'){
				mess="["+place_code_name+"] 발송처리 하시겠습니까?";		
			}else if(mode=='return'){
				mess="상품반송처리 하시겠습니까?";		
			}else if(mode=='send'){
				mess="["+place_code_name+"] 출고처리 하시겠습니까?";		
			} 
			if(confirm(mess)){
				$("input[name='mode']").val(mode);
				$("input[name='code']").val(code);
				$("#sendForm").submit();
			}
		}

		
        
    }
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>