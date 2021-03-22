<?php /* Template_ 2.2.8 2021/03/17 16:26:24 /www/html/ukk_test2/data/skin/order/order_d_hold.htm 000005912 */ 
$TPL__chk_stand_stock_1=empty($GLOBALS["chk_stand_stock"])||!is_array($GLOBALS["chk_stand_stock"])?0:count($GLOBALS["chk_stand_stock"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>
<?php if($GLOBALS["nav_view"]){?>
<?php echo $this->define('tpl_include_file_1',"order/order_nav2.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<?php }else{?>
<?php echo $this->define('tpl_include_file_2',"order/order_nav.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

<?php }?>

<?php if($GLOBALS["chk_stand_stock"]){?>
<table class="table table-bordered" >
	<tr>
		<th>수량초과</th>
		<td>
<?php if($TPL__chk_stand_stock_1){foreach($GLOBALS["chk_stand_stock"] as $TPL_K1=>$TPL_V1){?>
			<div style="width:20%;margin:10px;display:inline-block;">
			<?php echo $TPL_K1?>( 주문수량:<?php echo $TPL_V1["cnt"]?>/재고수량:<?php echo $TPL_V1["s_cnt"]?> )
			</div>
<?php }}?>
		</td>
	</tr>
</table>
<?php }?>

<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode">
<!--<table id="" class="display display_dt" data-height="740" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->
<table id="" class="display display_dt" data-height="740" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">

	<?php echo $this->define('tpl_include_file_3',"outline/table_width_order.htm")?> <?php $this->print_("tpl_include_file_3",$TPL_SCP,1);?>

	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<?php echo $this->define('tpl_include_file_4',"order/_order_cols.htm")?> <?php $this->print_("tpl_include_file_4",$TPL_SCP,1);?>

			<th>총재고</th>
			<th>입고예정</th>
			<th>사무실</th>
			<th>3자물류</th>
			<th>영인터</th>
			<th>원마케팅</th>
			<th>방송</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="<?php echo $TPL_V1["line_color"]?>">
<?php if($GLOBALS["print_xls"]!= 1){?><td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td><?php }?>
			<td><?php echo $TPL_V1["mall_name"]?><br/><?php echo $TPL_V1["upload_form_type"]?></td>
			<td><?php echo $TPL_V1["ordno"]?> <?php echo $TPL_V1["order_type"]?></td>
			<td><?php echo $TPL_V1["mall_goodsnm"]?></td>
			<td>
				<?php echo $TPL_V1["goodsnm"]?>

				<input type="hidden" name="hid_ordno[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["ordno"]?>">	
				<input type="hidden" name="hid_goodsno[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["goodsno"]?>">
				
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
			<td>
			<button type="button" class="btn btn-sm btn-warning mod" onclick="popup('order_mod_pop.php?no=<?php echo $TPL_V1["no"]?>','order_mod_pop','1000','700')">수정</button>

			<button type="button" class="btn btn-sm btn-warning" onclick="popup('../cs/cs_reg.php?ordno=<?php echo $TPL_V1["ordno"]?>&mall_no=<?php echo $TPL_V1["mall_no"]?>&order_seq=<?php echo $TPL_V1["no"]?>&order_memo_add=1','','1100','900')">CS등록</button>
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>

<div class="bottom_btn_box">
	<div class="box_left">
		
		<button type="button" class="btn btn-danger submit" id="cancel">취소처리</button>
		<button type="button" class="btn btn-danger submit" id="soldout">발송대기</button>
		
	</div>
<?php if(!$GLOBALS["nav_view"]){?>
	<div  class="box_right">
		
		<button type="button" class="btn btn-warning submit" id="outside_deli">외부업체 발송</button>
		<button type="button" class="btn btn-success submit" id="go_soldout">재고부족/입고예정으로 이동</button>
		<button type="button" class="btn btn-primary submit" id="goback">단일/묶음발송 확인으로 이동</button>
	</div>
<?php }?>
</div>

</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$("#nav_div5-1").addClass('active');

$(function(){
	
	$(".submit").click(function(){

		var chk_len=$(".chk_no:checked").length;
			
		if( chk_len<=0 ){
			alert('변경할 주문을 선택해주세요.');
			return;
		}
		
		var btype=$(this).attr("id");
		var msg=msg2='';

		if( btype=='cancel' ){
			msg='주문취소 하시겠습니까? 묶음주문 취소시 관련 주문 모두가 취소처리됩니다.';
		}else if( btype=='goback' ){
			msg='단일/묶음발송 확인으로 이동하시겠습니까?';
		}else if( btype=='go_soldout' ){
			msg='재고부족/입고예정으로 이동?';
		}else if( btype=='outside_deli' ){
			msg='외부발송주문으로 이동하시겠습니까?';
		}else if( btype=='soldout' ){
			msg='발송대기로 이동하시겠습니까?';
		}		

		if(confirm(msg)){
			$("#mode").val(btype);
			$("#main_form").submit();
		}
	});
});


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>