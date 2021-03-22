<?php /* Template_ 2.2.8 2020/08/26 10:14:26 /www/html/ukk_test2/data/skin/order/order_tot_search.htm 000002565 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<style>
.open_link{cursor:pointer}
</style>
<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
<div class="col-lg-12"><?php echo $this->define('tpl_include_file_1',"/order/order_search.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?></div>
<form method="post" onsubmit="return checkForm('2');">

	<div class="col-lg-12">
		<div class="row">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<!--<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>-->
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색">
							<span class="input-group-btn"><button class="btn btn-primary" type="button">검색</button></span> -->
						</div>
					</div>
				</caption>
				<colgroup>
					
				</colgroup>
				<thead>
					<tr>
						<th>몰명</th>
						<th>주문번호</th>
						<th>고객명</th>
						<th>옵션명</th>
						<th>수량</th>
						<th>단계</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr>			
							<td><?php echo $TPL_V1["mall_name"]?><br/><?php echo $TPL_V1["upload_form_type"]?></td>
							<td  data-link="<?php if($GLOBALS["h_control"]['order']){?><?php echo $TPL_V1["step_lv_link"]?>&ts_ordno=<?php echo $TPL_V1["ordno"]?><?php }?>" class="open_link"><?php echo $TPL_V1["ordno"]?></td>
							<td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>
							<td><?php echo $TPL_V1["goodsnm"]?></td>
							<td><?php echo $TPL_V1["order_num"]?></td>
							<td><?php echo $TPL_V1["step_lv"]?></td>
							<td></td>
						</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>



</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
	
	$(".open_link").click(function(){
		var link=$(this).data("link");
		if(link){
			opener.location.href=link;
		}else{

		}
	});
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>