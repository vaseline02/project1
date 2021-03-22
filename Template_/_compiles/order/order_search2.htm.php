<?php /* Template_ 2.2.8 2020/08/04 17:41:57 /www/html/ukk_test/data/skin/order/order_search2.htm 000001178 */ ?>
<?php if($GLOBALS["print_xls"]!= 1){?>
<?
$mall_list=get_mall_info();

$selected['order_search_mall'][$_POST['order_search_mall']]='selected';
?>

<form method="post" id="order_search_form">
	<center class="table-btn-group">
		<div class="bottom_btn_box">
			<div class="box_left">
				
			</div>
			<div  class="box_right">
				<input type="text" name="i_memo" style="width:250px;">	
				<button type="button" class="btn btn-primary memoSubmit" id="goback">관리자메모 등록</button>
			</div>
		</div>
		
	</center>
	
</form>

<script>
$(function(){
	
	$(".memoSubmit").click(function (){
		var chk_len=$(".chk_no:checked").length;
		var memo=$("input[name='i_memo']").val();
		if( chk_len<=0 ){
			alert('메모를 등록할 주문건을 선택해주세요.');
			return false;
		}else{
			$("input[name='mode']", document.main_form).val("memoIns");

			var html='<input type="hidden" name="i_memo" value="'+memo+'" >';
			$("#main_form").append(html);
			$("#main_form").submit();
		}
	});
})
</script>
<?php }?>