<?php /* Template_ 2.2.8 2021/03/17 16:24:16 /www/html/ukk_test2/data/skin/order/order_final_chk.htm 000006735 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>
<?php echo $this->define('tpl_include_file_1',"order/order_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>



<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode">
<input type="hidden" name="order_search_mall" value="<?php echo $_POST['order_search_mall']?>">
<!--<table id="" class="display display_dt" data-height="740" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->
<table id="" class="display display_dt" data-height="740" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">

	<?php echo $this->define('tpl_include_file_2',"outline/table_width_order.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<?php echo $this->define('tpl_include_file_3',"order/_order_cols.htm")?> <?php $this->print_("tpl_include_file_3",$TPL_SCP,1);?>

			<th>총재고</th>
			<th>입고예정</th>
			<th>사무실</th>
			<th>3자물류</th>
			<th>영인터</th>
			<th>원마케팅</th>
			<th>방송</th>
			<th>마케팅매입</th>
			<th>재고이동중</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td><?php }?>
			<td><?php echo $TPL_V1["mall_name"]?><br/><?php echo $TPL_V1["upload_form_type"]?></td>
			<td><?php echo $TPL_V1["ordno"]?> <?php echo $TPL_V1["order_type"]?></td>
			<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
			<td>
				<?php echo $TPL_V1["goodsnm"]?>

				<input type="hidden" name="hid_ordno[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["ordno"]?>">	
				<input type="hidden" name="hid_ord_num[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["order_num"]?>">	
				<input type="hidden" name="hid_goodsnm[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["goodsnm"]?>">
				
			</td>
			<td><?php echo $TPL_V1["order_num"]?></td>
			<td><?php echo number_format($TPL_V1["settle_price"])?></td>
			<td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>
			<td><?php echo $TPL_V1["phone"]?><br/><?php echo $TPL_V1["mobile"]?></td>
			<td><?php echo $TPL_V1["zipcode"]?> <?php echo $TPL_V1["address"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td style="color:<?php echo $TPL_V1["bundle_color"]?>"><?php echo $TPL_V1["bundle"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td><?php echo $TPL_V1["cur_cnt"]?></td>
			<td><?php echo $TPL_V1["codeno_3"]?></td>
			<td><?php echo $TPL_V1["codeno_1"]?></td>
			<td><?php echo $TPL_V1["codeno_51"]?></td>
			<td><?php echo $TPL_V1["codeno_91"]?></td>
			<td><?php echo $TPL_V1["codeno_125"]?></td>
			<td><?php echo $TPL_V1["codeno_87"]?></td>
			<td><?php echo $TPL_V1["codeno_55"]?></td>
			<td><?php echo $TPL_V1["codeno_130"]?></td>
			<td>
			<button type="button" class="btn btn-warning mod" onclick="popup('order_mod_pop.php?no=<?php echo $TPL_V1["no"]?>','order_mod_pop','1000','700')">수정</button>
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">
		<button type="button" class="btn btn-danger btn_sumbit" id="hold_order">보류이동</button>
		선택주문 <input type="text" class="number_only" name="cp_num" id="cp_num" style="text-align:right"> 개
		<button type="button" class="btn btn-success btn_sumbit" id="cp_order">주문 분리복제</button>
		
		 | <button type="button" class="btn btn-warning btn_sumbit" id="goback">재고부족주문 선택발송으로 이동</button>
	</div>
	<div  class="box_right">
		선택한 주문을
		<select name="place_code" id="">
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["no"]?>" <?php echo $GLOBALS["selected"]['place_code'][$TPL_V1["no"]]?>><?php echo $TPL_V1["cd"]?></option>
<?php }}?>
		<!--
		<option value="85">프리스로우(원주)</option>
		<option value="86">인비트리(프라다 위탁)</option>
		<option value="100">연예인협찬</option>
		<option value="101">마케팅 샘플(협찬)</option>
		<option value="110">한성INC</option>
		<option value="115">현대홈쇼핑</option>
		<option value="117">저스트원더</option>
		<option value="131">11번가</option>
		<option value="132">평택</option>
		-->
		</select>
		<button type="button" class="btn btn-primary btn_sumbit" id="order_settle">발송확정</button>
	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li>
	1.전체 선택후 우측 하단에서 배송위치 선택후 발송확정.<br/>
	2.남은 주문들 배송위치 다시 선택후 발송확정.<br/>
	3.주문수량때문에 한곳에서 발송 못하는 주문은 좌측하단 주문분리복제 기능으로 분리후 각각 발송확정
	</li>
	<li><button type="button" class="btn btn-success" >주문 분리복제</button>-수량을 입력하고 버튼을 누르면 선택한 주문이 정해진 수량만큼 분리되어 복사됨( 2개이상 주문을 다른 배송지에서 각각 배송해야 할 시 주문을 분리하여 발송지별로 발송확정 한다.)</li>
  </ul>
</fieldset>

<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$("#nav_div3").addClass('active');
$(function(){
	
	$(".btn_sumbit").click(function(){
		
		var btype=$(this).attr("id");

		if( $(".chk_no:checked").length <=0 ){
			alert('처리할 주문을 선택해주세요.');
			return;
		}
		
		if(btype=='cp_order' && $("#cp_num").val()=='' ){
			
			alert('수량을 입력해주세요');
			$("#cp_num").focus();
			return;
		}
		
		if( btype=='order_settle' ){
			msg='발송확정하시겠습니까?';
		}else if( btype=='cp_order' ){
			msg='주문 분리복제 하시겠습니까?';
		}else if( btype=='goback' ){
			msg='재고부족주문 선택발송으로 이동하시겠습니까?';
		}else if(btype=='hold_order'){
			msg='보류이동 하시겠습니까?';
		}
		

		if(confirm(msg)){
			
			$("#mode").val(btype);
			$("#main_form").submit();
		}
	});
});


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>