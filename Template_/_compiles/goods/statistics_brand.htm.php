<?php /* Template_ 2.2.8 2020/12/01 09:47:43 /www/html/ukk_test2/data/skin/goods/statistics_brand.htm 000003252 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>

<div class="row">
    <div class="col-lg-12">
        <div class="common-table-wrapper">
            <table class="table common-table" border="<?php echo $GLOBALS["xls_border"]?>">
<?php if($GLOBALS["print_xls"]!= 1){?>
                <caption>
                    <div class="input-group col-lg-12 common-table-search2">
                        <span class="common-table-result">총 <b><?php echo number_format(count($TPL_VAR["loop"]))?></b>건</span>
                        <div class="input-group common-table-search">
                        </div>
                    </div>
                </caption>                
                <colgroup>
                    <col />
                    <col />
                    <col/>
                </colgroup>
<?php }?>
                <thead>
                    <tr>
						<th>수량</th>
                        <th>금액</th>
						<th>입예수량</th>
                        <th>입예금액</th>
                        <th>총수량</th>
                        <th>총금액</th>
                    </tr>
                </thead>
                <tbody>
					<tr>
						<td><?php echo number_format($GLOBALS["topc_totcnt"])?></td>
						<td><?php echo number_format($GLOBALS["topc_totprice"])?></td>
						<td><?php echo number_format($GLOBALS["tops_totcnt"])?></td>
						<td><?php echo number_format($GLOBALS["tops_totprice"])?></td>
						
						<td><?php echo number_format($GLOBALS["top_totcnt"])?></td>
						<td><?php echo number_format($GLOBALS["top_totprice"])?></td>
					</tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div>&nbsp;</div>
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
<?php if($GLOBALS["print_xls"]!= 1){?>
	<colgroup>	
		<col/><!-- 브랜드 -->
		<col/><!-- 분류 -->
		<col/><!-- 이미지-->	
	</colgroup>
<?php }?>
	<thead>
		<tr>
			<th>브랜드명</th>
			<th>수량</th>
			<th>금액</th>
			<th>입예수량</th>
			<th>입예금액</th>
			<th>총수량</th>
			<th>총금액</th>
		</tr>
	</thead>
	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1?></td>
			<td><?php echo number_format($GLOBALS["sumcnt"][$TPL_V1]['c'])?></td>
			<td><?php echo number_format($GLOBALS["sumprice"][$TPL_V1]['c'])?></td>
			<td><?php echo number_format($GLOBALS["sumcnt"][$TPL_V1]['s'])?></td>
			<td><?php echo number_format($GLOBALS["sumprice"][$TPL_V1]['s'])?></td>
			<td><?php echo number_format($GLOBALS["totcnt"][$TPL_V1])?></td>
			<td><?php echo number_format($GLOBALS["totprice"][$TPL_V1])?></td>
		</tr>
<?php }}?>
	</tbody>
	
</table>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>