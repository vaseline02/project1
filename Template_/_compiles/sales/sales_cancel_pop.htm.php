<?php /* Template_ 2.2.8 2020/09/17 16:27:05 /www/html/ukk_test/data/skin/sales/sales_cancel_pop.htm 000002852 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?></h3></div>
</div>

<form method="post" name="goodsInfoForm2">
<input type="hidden" name="mode" value="cate_update">

<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format(count($TPL_VAR["loop"]))?></b>건</span>
						<div class="input-group common-table-search">                           
						</div>
					</div>
				</caption>
                <colgroup>
                    <col width="5%" />
					<col width="7%"/>
					<col width="10%"/>
					<col width="15%"/>
					<col width="15%"/>
					<col/>
					<col width="5%"/>
					<col width="7%"/>
					<col width="6%"/>
					<col width="6%"/>
					<col width="8%"/>
					
				</colgroup>
				<thead>
					<tr>
						<th>No</th>
                        <th>상태</th>
                        <th>쇼핑몰</th>
                        <th>날짜</th>
                        <th>주문번호</th>
                        <th>모델명</th>
                        <th>수량</th>
                        <th>금액</th>
                        <th>수수료</th>
                        <th>이익율</th>
                        <th>관리자메모</th>                        
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){$TPL_I1=-1;foreach($TPL_VAR["loop"] as $TPL_V1){$TPL_I1++;?>
					<tr>                       
						<td><?php echo ($TPL_I1+ 1)?></td>                        
						<td><?php echo $GLOBALS["cfg_order_step2"][$TPL_V1["step2"]]?></td>                        
						<td><?php echo $TPL_V1["mall_name"]?></td>                        
						<td><?php echo $TPL_V1["mod_date"]?></td>                        
						<td><?php echo $TPL_V1["ordno"]?></td>                        
						<td><?php echo $TPL_V1["goodsnm"]?></td>                        
						<td><?php echo $TPL_V1["order_num"]?></td>                        
						<td><?php echo number_format($TPL_V1["settle_price"])?></td>                        
						<td></td>                        
						<td></td>                        
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
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>