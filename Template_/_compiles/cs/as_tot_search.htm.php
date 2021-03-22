<?php /* Template_ 2.2.8 2020/10/14 09:28:27 /www/html/ukk_test2/data/skin/cs/as_tot_search.htm 000003046 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<style>
.open_link{cursor:pointer}
</style>
<div class=" statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
<form method="get">
	<table class="table table-bordered" >
		<tr>
			<th>통합검색</th>
			<td>
				<input type="text" name="s_total" value="<?php echo $_GET['s_total']?>" style="width:300px;">
				<label style="font-weight: normal;"><input type="checkbox" name="schedule_3" value="Y" <?php echo $GLOBALS["checked"]['schedule_3']['Y']?>> 3일이하 미처리건</label>			
			</td>
		</tr>		
	</table>
	<center>
		<button class="btn btn-sm btn-primary" id="">검 색</button>
	</center>
</form>
<hr>

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
						<th>접수번호</th>
						<th>몰명</th>
						<th>주문번호</th>
						<th>접수자</th>
						<th>옵션명</th>
						<th>수량</th>
						<th>단계</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr>			
							<td data-link="as_list.php?search_no=<?php echo $TPL_V1["as_no"]?>&s_as_status=<?php echo $TPL_V1["as_status"]?>" class="open_link"><?php echo $TPL_V1["as_no"]?></td>
							<td><?php echo $TPL_V1["mall_name"]?><br/><?php echo $TPL_V1["upload_form_type"]?></td>
							<!--<td  data-link="as_list.php?s_as_status=<?php echo $TPL_V1["as_status"]?>" class="open_link"><?php echo $TPL_V1["ordno"]?></td>-->
							<td><?php echo $TPL_V1["ordno"]?></td>
							<td><?php echo $TPL_V1["receipt_name"]?></td>
							<td><?php echo $TPL_V1["as_goodsnm"]?></td>
							<td>1</td>
							<td><?php echo $TPL_V1["as_status"]?>단계</td>
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