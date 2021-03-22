<?php /* Template_ 2.2.8 2021/03/17 16:22:17 /www/html/ukk_test2/data/skin/order/order_stock_shortage.htm 000010526 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>
<?php if($GLOBALS["nav_view"]){?>
<?php echo $this->define('tpl_include_file_1',"order/order_nav2.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<?php }else{?>
<?php echo $this->define('tpl_include_file_2',"order/order_nav.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

<?php }?>


<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_K1=>$TPL_V1){?>
<div class="table_title" ><?php if($TPL_K1=='stock'){?>재고부족주문<?php }else{?>품절주문<?php }?></div>
<?php if($GLOBALS["print_xls"]!= 1){?>
<?php if($TPL_K1=='stock'&&!$GLOBALS["nav_view"]){?>
<button type="button" class="btn btn-primary chk_order" id="single">단품주문 일괄선택</button>
<button type="button" class="btn btn-primary chk_order" id="bundle">묶음주문 일괄선택</button>
<?php }?>
<?php }?>
<div class="btn btn-warning smsSend">문자발송</div>
<table id="" class="display display_dt" style="width:100%;" border="<?php echo $GLOBALS["xls_border"]?>">

	<?php echo $this->define('tpl_include_file_3',"outline/table_width_order.htm")?> <?php $this->print_("tpl_include_file_3",$TPL_SCP,1);?>

	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no_<?php echo $TPL_K1?>')"></th><?php }?>
			<?php echo $this->define('tpl_include_file_4',"order/_order_cols.htm")?> <?php $this->print_("tpl_include_file_4",$TPL_SCP,1);?>

			<th>총주문</th>
			<th>총재고</th>
			<th>입고예정</th>
			<th>사무실</th>
			<th>3자물류</th>
			<th>영인터</th>
			<th>원마케팅</th>
			<th>방송</th>
			<th>마케팅매입</th>
			<th>재고이동중</th>
			<th>외부샘플</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
				<input type="checkbox" class="chk_no chk_no_<?php echo $TPL_K1?> <?php if($TPL_K1=='stock'){?>bundle_<?php if($TPL_V2["bundle"]> 0){?>1<?php }else{?>0<?php }?><?php }?>" name="chk_no[]" value="<?php echo $TPL_V2["no"]?>">
				<input type="hidden" name="hid_goodsno[<?php echo $TPL_V2["no"]?>]" value="<?php echo $TPL_V2["goodsno"]?>">
				<input type="hidden" name="hid_goodsnm[<?php echo $TPL_V2["no"]?>]" value="<?php echo $TPL_V2["goodsnm"]?>">
				<input type="hidden" name="hid_ordno[<?php echo $TPL_V2["no"]?>]" value="<?php echo $TPL_V2["ordno"]?>">
				<input type="hidden" name="hid_bundle[<?php echo $TPL_V2["no"]?>]" value="<?php echo $TPL_V2["bundle"]?>">

			</td>
<?php }?>
			<td><?php echo $TPL_V2["mall_name"]?><br/><?php echo $TPL_V2["upload_form_type"]?></td>
			<td><?php echo $TPL_V2["ordno"]?> <?php echo $TPL_V2["order_type"]?></td>
			<td><?php echo $TPL_V2["mall_goodsnm"]?></td>
			<td><font <?php if($TPL_V2["cs_chk"]){?>color='blue'<?php }elseif($TPL_V2["cal_chk"]){?>color='red'<?php }?>><?php echo $TPL_V2["goodsnm"]?></font></td>
			<td><?php echo $TPL_V2["order_num"]?><input type="hidden" name="hid_ord_num[<?php echo $TPL_V2["no"]?>]" value="<?php echo $TPL_V2["order_num"]?>"></td>
			<td><?php echo number_format($TPL_V2["settle_price"])?></td>
			<td><?php echo $TPL_V2["buyer"]?><br/><?php echo $TPL_V2["receiver"]?></td>
			<td><?php echo $TPL_V2["buyer_mobile"]?><br/><?php echo $TPL_V2["mobile"]?></td>
			<td><?php echo $TPL_V2["zipcode"]?> <?php echo $TPL_V2["address"]?></td>
			<td><?php echo $TPL_V2["memo"]?></td>
			<td style="color:<?php echo $TPL_V2["bundle_color"]?>"><?php echo $TPL_V2["bundle"]?></td>
			<td><?php echo $TPL_V2["reg_date"]?></td>
			<td><?php echo $TPL_VAR["goods_order_cnt"][$TPL_V2["goodsnm"]]?></td>
			<td><?php echo $TPL_V2["cur_cnt"]?></td><!-- 총재고(현재고) -->
			<td><?php echo $TPL_V2["codeno_3"]?></td><!-- 입고예정 -->
			<td><?php echo $TPL_V2["codeno_1"]?></td><!-- 사무실 -->
			<td><?php echo $TPL_V2["codeno_51"]?></td><!-- 3자물류 -->
			<td><?php echo $TPL_V2["codeno_91"]?></td><!-- 영인터 -->
			<td><?php echo $TPL_V2["codeno_125"]?></td><!-- 원마케팅 -->
			<td style="cursor:pointer;" onclick="popup('order_stock_pop.php?codeno=87&no=<?php echo $TPL_V2["goodsno"]?>','order_stock_pop','1500','1000')"><?php echo $TPL_V2["codeno_87"]?></td><!-- 방송 -->
			<td style="cursor:pointer;" onclick="popup('order_stock_pop.php?codeno=55&no=<?php echo $TPL_V2["goodsno"]?>','order_stock_pop','1500','1000')"><?php echo $TPL_V2["codeno_55"]?></td><!-- 마케팅매입 -->
			<td><?php echo $TPL_V2["codeno_130"]?></td><!-- 재고이동중 -->
			<td style="cursor:pointer;" onclick="popup('order_stock_pop.php?codeno=104&no=<?php echo $TPL_V2["goodsno"]?>','order_stock_pop','1500','1000')"><?php echo $TPL_V2["codeno_104"]?></td><!-- 외부샘플 -->
			<td>
				<button type="button" class="btn btn-warning mod" onclick="popup('order_mod_pop.php?no=<?php echo $TPL_V2["no"]?>','order_mod_pop','1000','700')">수정</button>
				<button type="button" class="btn btn-sm btn-warning" onclick="popup('../cs/cs_reg.php?ordno=<?php echo $TPL_V2["ordno"]?>&mall_no=<?php echo $TPL_V2["mall_no"]?>&order_seq=<?php echo $TPL_V2["no"]?>&order_memo_add=1','','1100','900')">CS등록</button>
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>
<?php }}?>

<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">
		<button type="button" class="btn btn-success submit" id="stand">입고예정대기</button>
<?php if(!$GLOBALS["nav_view"]){?>
		<button type="button" class="btn btn-danger submit" id="hold_order">보류이동</button>
		<button type="button" class="btn btn-danger submit" id="soldout">발송대기(예약재고잡힘)</button>
	
		<!--<button type="button" class="btn btn-warning submit" id="hold">발송대기</button>-->
		<!--<button type="button" class="btn btn-success submit" id="copy">주문복제</button>-->
<?php }?>
		<button type="button" class="btn btn-danger submit" id="cancel">주문취소</button>
		선택한 주문을
		<select name="place_code" id="">
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["no"]?>" <?php echo $GLOBALS["selected"]['place_code'][$TPL_V1["no"]]?>><?php echo $TPL_V1["cd"]?></option>
<?php }}?>
			<!--<option value="all">통합발송</option>-->
		</select>
		<button type="button" class="btn btn-danger submit" id="change">변경출고</button>
	</div>
	<div  class="box_right">
<?php if(!$GLOBALS["nav_view"]){?>
		<button type="button" class="btn btn-primary submit" id="deli">발송최종확인</button>
<?php }?>
	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>

	<li>등록된 총 주문수량이 3개 현재고가 2개면 해당 모델의 모든 주문이 현재 페이지에 표시됨(발송 우선순위대로 발송하기 위해)</li>
	<li>품절처리 주문은 CS페이지로 노출. 고객 응대까지 판매대기 / 취소처리는 완전취소.</li>
	<li>묶음주문 품절처리시 동일몰,동일 주문번호의 주문이 함께 품절/발송대기 처리됨.</li>
	<li>발송대기 - 묶음 품절시 묶음중 재고가 있는 모델이 있으면 재고를 우선 발송대기재고로 돌려놓고 cs후 처리함.</li>
	<li>모델명 색상 구분 : (RED) 입고일자 임박[3일 이내) | (BLUE) 반품확정예정(당일분)</li>
  </ul>
</fieldset>

<?php }?>
</form>

<form method="post" name="smsForm" id="smsForm">
<input type="hidden" name="order_list_no" value="">

</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

<?php if($GLOBALS["_GET"]['gubunb']== 0){?>
<?php if($GLOBALS["_GET"]['tday']== 1){?>
	$("#nav_div2-1-1").addClass('active');
<?php }else{?>
	$("#nav_div2-1-2").addClass('active');
<?php }?>
<?php }else{?>
<?php if($GLOBALS["_GET"]['tday']== 1){?>
	$("#nav_div2-2-1").addClass('active');
<?php }else{?>
	$("#nav_div2-2-2").addClass('active');
<?php }?>
<?php }?>
$(function(){
	
	$(".chk_order").click(function(){
		$(".chk_no_stock").prop("checked",false);

		if( $(this).attr("id")=="bundle" ){
			$(".bundle_1").prop("checked",true);
		}else{
			$(".bundle_0").prop("checked",true);
		}
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
			msg='품절처리';
			msg2="묶음주문 품절시 관련 주문 모두가 품절처리됩니다.(cs 등록)";
		}else if( btype=='deli' ){
			msg='발송최종확인 단계로 이동';
		}else if( btype=='stand' ){
			msg='입고예정대기 단계로 이동';
		}else if( btype=='cancel' ){
			msg='주문취소';
			//msg2="묶음주문 주문취소시 관련 주문 모두가 주문취소됩니다.";
		}else if(btype=='hold_order'){
			msg='보류이동';
		}else if(btype=='copy'){
			msg='주문복제';
		}else if(btype=='change'){
			msg='변경출고';
		}


		if(confirm(msg+' 하시겠습니까?'+msg2)){
			
			$("#mode").val(btype);
			$("#main_form").submit();
		}
	});
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

<?php echo $this->define('tpl_include_file_5',"order/order_footer.htm")?> <?php $this->print_("tpl_include_file_5",$TPL_SCP,1);?>

<?php $this->print_("footer",$TPL_SCP,1);?>