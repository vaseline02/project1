<?php /* Template_ 2.2.8 2021/02/05 09:23:11 /www/html/ukk_test2/data/skin/order/order_cancel.htm 000004775 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>
<?php echo $this->define('tpl_include_file_1',"order/order_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<style>
#nav_div9 a:after{width:90%}
</style>

<?php }?>
<form method="post" id="main_form">
<?php if($GLOBALS["print_xls"]!= 1){?>
<input type="hidden" name="mode" id="mode">
<input type="hidden"name="print_xls" value="">
<?php }?>
<!--<table id="" class="display display_dt" data-height="740" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->
<table class="table table-bordered" style="margin-top:50px;">
	<?php echo $this->define('tpl_include_file_2',"outline/table_width_order.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<?php echo $this->define('tpl_include_file_3',"order/_order_cols.htm")?> <?php $this->print_("tpl_include_file_3",$TPL_SCP,1);?>

			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="<?php echo $TPL_V1["line_color"]?>">
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
				<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>" data-wno=<?php echo $TPL_V1["wno"]?>>
				<input type="hidden" name="hid_invoice[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["invoice"]?>">
				<input type="hidden" name="hid_ordno[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["ordno"]?>">
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
			<td>
			<button type="button" class="btn btn-warning mod" onclick="popup('order_mod_pop.php?no=<?php echo $TPL_V1["no"]?>','order_mod_pop','1000','700')">수정</button>
			</td>
			
		</tr>
<?php }}?>
	</tbody>
</table>

<div class="bottom_btn_box">
	<div class="box_left">
		<button type="button" class="btn btn-danger submit" id="hold_order">보류이동</button>
		<button type="button" class="btn btn-danger submit" id="recovery">취소복원</button>
	</div>	
</div>
</form>
<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">
	
	</div>
	<div  class="box_right">
	
	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li>취소완료되지않은 건만 취소복원됩니다.</li>
  </ul>
</fieldset>
<?php }?>


<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$("#nav_div8").addClass('active');

$(function(){

	$(".submit").click(function(){
		
		var chk_len=$(".chk_no:checked").length;
		var wnoChk=0;
			
		if( chk_len<=0 ){
			alert('변경할 주문을 선택해주세요.');
			return;
		}
		
		var msg;
		var btype=$(this).attr("id");
		$(".chk_no").each(function(index, item){
			if($(item).is(":checked")){            
				if($(item).data('wno')){						
					wnoChk++;
				}			
			}
		});
		if(wnoChk) {
			alert("도매주문건은 처리하실수없습니다.");
			return false;
		}

		if( btype=='recovery' ){			
			msg='묶음주문의경우 복원시 같은주문 전부가 복원됩니다. 복원하시겠습니까?';
		}else if(btype=='hold_order'){
			msg='보류이동 하시겠습니까?';
		}

		if(confirm(msg)){
			$("#mode").val(btype);
			$("#main_form").submit();
		}
	});

	$("#print_xls").click(function(){

		$("input[name='print_xls']").val("1");
		$("#main_form").submit();
		$("input[name='print_xls']").val("0");
	});

});


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>