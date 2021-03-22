<?php /* Template_ 2.2.8 2020/10/16 15:37:35 /www/html/ukk_test2/data/skin/goods/reserve_list.htm 000002852 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<form method="post" id="main_form">
<input type="hidden" name="mode">
<input type="hidden" name="reserve_seq" >
<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<?php echo $this->define('tpl_include_file_1',"outline/search_box.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<!--
<button type='button' class='btn btn-sm btn-success exchange_button' onclick='popup("../goods/reserve_reg.php?","goods_search","1000","900")'>재고예약</button>
-->
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
			<th>브랜드</th>
			<th>분류</th>
			<th>주문번호</th>
			<th>모델명</th>
			<th>수량</th>
			<th>메모</th>
			<th>재고차감</th>
			<th>접수</th>
			<th>해제</th>
			<th>등록일</th>
			<th>해제일</th>
			<th>상태</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["catenm"]?></td>
			<td><?php echo $TPL_V1["ordno"]?></td>
			<td class="text_type"><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["cnt"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td><?php echo $GLOBALS["place_nm"][$TPL_V1["stock_loc"]]?></td>
			<td><?php echo $TPL_V1["name"]?>(<?php echo $TPL_V1["admin_no"]?>)</td>
			<td><?php echo $TPL_V1["rel_name"]?>(<?php echo $TPL_V1["rel_admin_no"]?>)</td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td><?php echo $TPL_V1["rel_date"]?></td>
			<th><?php echo $TPL_V1["state_val"]?></th>
			<td><?php if($TPL_V1["state"]== 0&&$TPL_V1["order_hold_no"]== 0){?><button type='button' class='btn btn-sm btn-success btn-release' data-seq=<?php echo $TPL_V1["no"]?>>예약해제</button><?php }?></td>
			
		</tr>
<?php }}?>
	</tbody>
</table>
</form>
<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<?php }?>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$(".searchbox-default").css("display","block");


$(function(){
	$(".btn-release").click(function(){
		var no=$(this).data("seq");
		
		if(confirm('예약해제 하시겠습니까')){
			
			$("input[name='reserve_seq']").val(no);
			$("input[name='mode']").val("reserve_release");
			$("form[id='main_form']").submit();

		}
	});
})

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>