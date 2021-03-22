<?php /* Template_ 2.2.8 2020/07/14 14:37:49 /www/html/ukk_test/data/skin/cs/send_exchange_b.htm 000006179 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>
<?php echo $this->define('tpl_include_file_1',"cs/send_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<style>
.search_td_width{width:800px;}
#nav_div3 a:after{width:90%}
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
			<th width='100'>몰명</th>
			<th width='200'>주문번호</th>
			<th width='150'>모델명</th>
			<th>이미지</th>
			<th>수량</th>
			<th width='150'>모델명<br>(교환)</th>
			<th>이미지<br>(교환)</th>
			<th>수량<br>(교환)</th>
			<th width='50'>비용</th>
			<th width='100'>송장번호</th>
			<th width='100'>계좌번호</th>
			<th width='100'>사유</th>
			<th width='100'>작성자</th>
            <th width='90'>등록일</th>
            <th></th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="<?php echo $TPL_V1["line_color"]?>">		
			<input type="hidden" name="account_number[<?php echo $TPL_V1["no"]?>]" value=<?php echo $TPL_V1["account_number"]?>> 
			<input type="hidden" name="account_code[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["account_code"]?>"> 	
			<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>" data-return_type=<?php echo $TPL_V1["return_type"]?> data-return_type_sub=<?php echo $TPL_V1["return_type_sub"]?>></td>
			<td><?php echo $TPL_V1["mall_name"]?></td>
			<td><?php echo $TPL_V1["order_no"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["order_num"]?></td>
			<td><?php echo $TPL_V1["exchange_goodsnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["exchange_img_url"]?></td>
			<td><?php echo $TPL_V1["exchange_goods_num"]?></td>
			<td><?php echo number_format($TPL_V1["diff_price"])?></td>
			<td><?php if($TPL_V1["return_invoice"]!= 0){?><?php echo $TPL_VAR["delivery_list"][$TPL_V1["return_delivery_code"]]['name']?><br><?php echo $TPL_V1["return_invoice"]?><?php }?></td>
			<td><?php if($TPL_V1["account_number"]&&$TPL_V1["account_code"]){?><?php echo $GLOBALS["cfg_account_code"][$TPL_V1["account_code"]]?><br><?php echo $TPL_V1["account_number"]?><?php }?></td>
			<td><?php echo $TPL_V1["return_type_nm"]?></td>
			<td><?php echo $TPL_V1["name"]?><div>(<?php echo $TPL_V1["id"]?>)</div></td>
            <td><?php echo $TPL_V1["reg_date"]?></td>			
            <td>
				<button type="button" class="btn btn-sm btn-warning" onclick="popup('cs_reg.php?ordno=<?php echo $TPL_V1["order_no"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>&order_list_no=<?php echo $TPL_V1["order_list_no"]?>&view_type=1','','1100','900')">상세</button>
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>

<div class="bottom_btn_box">
    <div  class="box_left"></div>
    <div  class="box_right">
		재고이동 : 
		<select name="codeSelect" class="codeSelect">
			<option value="">선택</option>
			<option value="bad">불량접수</option>
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1['no']?>"><?php echo $TPL_V1['cd']?></option>
<?php }}?>
		</select>
		<div type="button" class="btn btn-primary cancelChange" id="order_settle" data-code='4'>처리완료</div>
	</div>
</div>

</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".cancelChange").click(function(){
	if(!$(".chk_no").is(":checked")){
		alert("선택된 상품이 없습니다.");
		return false;
	}else{
		// var accountCheck=0;
		// $(".chk_no").each(function(index, item){
		// 	if($(item).is(":checked")){             
		// 		if(!$("input[name='account_number["+$(item).val()+"]']").val() || !$("input[name='account_code["+$(item).val()+"]']").val()){
		// 			accountCheck++;
		// 		}				
		// 	}
		// });
		// if(accountCheck>0){
		// 	alert('계좌번호가없는 접수건이 있습니다.');
		// 	return false;
		// }
		
		if($(this).data('code')=='1'){
			if(confirm('이전상태(접수)로 변경하시겠습니까?')){
				$("input[name='mode']").val('allCancel');
				$("input[name='code']").val($(this).data('code'));
				$("#sendForm").submit();
			}
		}else{			
			var badCount=0;
			//재고이동시 불량접수건이 체크되있을경우 넘기지않는다.
			$(".chk_no").each(function(index, item){
				if($(item).is(":checked")){                                       
					//교환이거나 반품일경우이고 불량접수일경우 체크
					if(($(item).data('return_type')=='60' || $(item).data('return_type')=='70') && $(item).data('return_type_sub')=='2'){
						badCount++;
					}
				}
			});
            if(!$(".codeSelect").val()){
				alert("재고 등록위치를 선택해주세요.");
				return false;
			}else if($(".codeSelect").val()>=1 && badCount>0){
				alert("불량접수건이 선택되어있습니다.");
				return false;
			}else{
				if(confirm('처리완료로 변경하시겠습니까?')){
					$("input[name='mode']").val('allCancel');
					$("input[name='code']").val($(this).data('code'));
					$("#sendForm").submit();
				}
			}
		}
    }
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>