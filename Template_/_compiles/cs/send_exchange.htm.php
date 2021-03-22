<?php /* Template_ 2.2.8 2020/05/19 09:25:09 /www/html/ukk_test/data/skin/cs/send_exchange.htm 000004150 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>
<?php echo $this->define('tpl_include_file_1',"cs/send_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<style>
.search_td_width{width:800px;}
#nav_div2_b a:after{width:90%}
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
			<th width='100'>사유</th>
			<th width='100'>작성자</th>
            <th width='90'>등록일</th>
            <th></th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="<?php echo $TPL_V1["line_color"]?>">			
			<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td>
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
	<div  class="box_left">		
        <!-- <div type="button" class="btn btn-danger cancelChange" id="order_settle" data-code='1'>접수</div> -->
    </div>
	<div  class="box_right">
        <div type="button" class="btn btn-primary cancelChange" id="order_settle" data-code='3'>발송</div>
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
		if($(this).data('code')=='1'){
			if(confirm('이전상태(접수)로 변경하시겠습니까?')){
				$("input[name='mode']").val('allCancel');
				$("input[name='code']").val($(this).data('code'));
				$("#sendForm").submit();
			}
		}else{			
            if(confirm('교환상품을 발송하시겠습니까?')){
                $("input[name='mode']").val('allCancel');
                $("input[name='code']").val($(this).data('code'));
                $("#sendForm").submit();
            }
		}
    }
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>