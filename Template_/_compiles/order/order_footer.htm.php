<?php /* Template_ 2.2.8 2020/03/19 15:34:36 /www/html/ukk_test2/data/skin/order/order_footer.htm 000000395 */ ?>
<script>
	$("#print_xls").click(function(){
		
		$("input[name='print_xls']").val("1");
		$("#main_form").attr("action","order_settle_excel.php");
		$("#main_form").submit();
		$("input[name='print_xls']").val("0");
		$("#main_form").attr("action","");
		
	});
</script>