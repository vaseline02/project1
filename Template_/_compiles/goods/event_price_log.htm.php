<?php /* Template_ 2.2.8 2020/09/16 14:31:34 /www/html/ukk_test2/data/skin/goods/event_price_log.htm 000001974 */ 
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
					</div>
				</caption>
                <colgroup>
                    <col width="20%"/>
                    <col/>
                    <col width="20%" />                    
					<col/>
					
				</colgroup>
				<thead>
					<tr>                       
						<th>상품명</th>
                        <th>금액</th>
                        <th>행사위치</th>
                        <th>수정자</th>
						<th>변경일</th>
						
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
					<tr>
                        
						<td><?php echo $TPL_V1["goodsnm"]?></td>
						<td><?php echo number_format($TPL_V1["price"])?></td>
						<td><?php if($TPL_V1["price_type"]=='1'){?>타임메카행사<?php }elseif($TPL_V1["price_type"]=='2'){?>ec행사<?php }?></td>
						<td><?php echo $TPL_V1["name"]?>(<?php echo $TPL_V1["id"]?>)</td>
						<td><?php echo $TPL_V1["reg_date"]?></td>
						
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