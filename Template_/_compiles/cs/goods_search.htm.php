<?php /* Template_ 2.2.8 2020/06/30 16:12:43 /www/html/ukk_test/data/skin/cs/goods_search.htm 000002739 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<hr>

<style>
.search_td_width{width:800px;}
</style>

<form method="post">
	<table class="table table-bordered" >

		<tr>
			<th>모델명</th>
            <td class="search_td_width"><textarea name="s_goodsnm" id="" cols="30" rows="3"><?php echo $_POST['s_goodsnm']?></textarea></td>			            
		</tr>
		
	</table>
	<center>
		<button class="btn btn-primary" id="">검 색</button>
	</center>
</form>

<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th>모델명</th>
			<th>이미지</th>
			<th width='100'>판매가</th>
			<th width='100'>소비자가</th>
			<th width='50'>수량</th>
			<th></th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="<?php echo $TPL_V1["line_color"]?>">			
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo number_format($TPL_V1["s_price"])?>원</td>
			<td><?php echo number_format($TPL_V1["c_price"])?>원</td>
			<td><?php echo $TPL_V1["totalCnt"]?></td> 
			<td>
				<div><button type="button" class="btn btn-sm btn-warning goodsClick" data-no=<?php echo $TPL_V1["no"]?> data-goodsnm='<?php echo $TPL_V1["goodsnm"]?>' data-stock_yn='<?php echo $TPL_V1["stock_yn"]?>'>선택</button></div>
				<!-- <div style="padding-top: 5px;"><button type='button' class='btn btn-sm btn-warning' onclick="popup('stock_hold.php?goodsno=<?php echo $TPL_V1["no"]?>&order_no=<?php echo $GLOBALS["order_no"]?>&order_list_no=<?php echo $GLOBALS["order_list_no"]?>','stock_hold','1000','900')">재고보류<?php if($TPL_V1["hold_count"]){?>(<?php echo $TPL_V1["hold_count"]?>)<?php }?></button></div> -->
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>


<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".goodsClick").click(function(){
	var goodsno=$(this).data('no');
	var goodsnm=$(this).data('goodsnm');
	var stock_yn=$(this).data('stock_yn');
	$("input[name='exchange_goods_no[<?php echo $GLOBALS["goodsno"]?>]']",opener.document).val(goodsno);
	$("input[name='exchange_goods_nm[<?php echo $GLOBALS["goodsno"]?>]']",opener.document).val(goodsnm);
	$("input[name='exchange_stock_yn[<?php echo $GLOBALS["goodsno"]?>]']",opener.document).val(stock_yn);
	self.close();

});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>