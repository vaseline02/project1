<?php /* Template_ 2.2.8 2020/12/03 10:25:12 /www/html/ukk_test2/data/skin/cs/as_report.htm 000006635 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_bloop_1=empty($TPL_VAR["bloop"])||!is_array($TPL_VAR["bloop"])?0:count($TPL_VAR["bloop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<h1><?php echo $GLOBALS["page_title"]?></h1>
<style>
.search_td_width{width:380px;}
.mallLabel{ display:inline-block; width:200px; line-height:23px;}
</style>
<form method="get">
	<table class="table table-bordered" >
		<tr>
			<th>기간</th>
			<td colspan='3'>
			<input type="text" name="s_date" id="s_date" class="datepicker_common_month" autocomplete="off" value="<?php echo $_GET['s_date']?>"> ~ 
            <input type="text" name="e_date" id="e_date" class="datepicker_common_month" autocomplete="off" value="<?php echo $_GET['e_date']?>">
                <span type="button" class="btn btn-sm btn-warning dayChange_month" data-int='0' data-type='month'>이번달</span>
				<span type="button" class="btn btn-sm btn-warning dayChange_month" data-int='1' data-type='month'>1개월</span>
                <span type="button" class="btn btn-sm btn-warning dayChange_month" data-int='3' data-type='month'>3개월</span>
                <span type="button" class="btn btn-sm btn-warning dayChange_month" data-int='5' data-type='month'>5개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange_month" data-int='1' data-type='year'>1년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange_month" data-int='3' data-type='year'>3년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange_month" data-int='5' data-type='year'>5년</span>
			</td>			
		</tr>		
	</table>
	<center>
		<button class="btn btn-sm btn-primary" id="">검 색</button>
		<button type="button" class="btn btn-sm btn-success" id="print_xls">엑셀 다운로드</button>
	</center>
</form>
<?php }?>
<form id="sendForm" name="sendForm" method="POST">
<input type="hidden"name="print_xls" value="">
<!--as접수,비용-->
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
        <tr>
			<th style="height:25px;" colspan='14'>AS접수</th>
			<th style="height:25px;" colspan='4'>공가</th>
			<th style="height:25px;" colspan='4'>소가</th>
		</tr>
		<tr>			
			<th style="height:25px;"></th>			
			<th style="height:25px;">고객접수건</th>
			<th style="height:25px;">고객출고건</th>
			<th style="height:25px;">상품접수건</th>
			<th style="height:25px;">상품출고건</th>
			<th style="height:25px;">자체접수건</th>
			<th style="height:25px;">조합접수건</th>
			<th style="height:25px;">본사접수건</th>
			<th style="height:25px;">총접수건</th>
			<th style="height:25px;">무한</th>
			<th style="height:25px;">은하사(쥬얼리수리)</th>
			<th style="height:25px;">도우덱</th>
			<th style="height:25px;">크리스챤</th>
			<th style="height:25px;">그외본사</th>
			<th style="height:25px;">조합</th>
			<th style="height:25px;">자체</th>
			<th style="height:25px;">본사</th>
			<th style="height:25px;">AS팀총공가금액</th>
			<th style="height:25px;">조합</th>
			<th style="height:25px;">자체</th>
			<th style="height:25px;">본사</th>
			<th style="height:25px;">AS팀총소가금액</th>
		</tr>
		
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>									
            <td class="text_type"><?php echo $TPL_V1["month_date"]?></td>
            
			<td><?php echo $TPL_V1["cnt1"]?></td>
            <td><?php echo $TPL_V1["cnt2"]?></td>
            
			<td><?php echo $TPL_V1["cnt3"]?></td>
            <td><?php echo $TPL_V1["cnt4"]?></td>
            
			<td><?php echo $TPL_V1["cnt5"]?></td>
			<td>0</td>
            <td><?php echo $TPL_V1["cnt6"]?></td>
            
            <td><?php echo $TPL_V1["t_cnt"]?></td>
            
			<td><?php echo $TPL_V1["cnt7"]?></td>
			<td><?php echo $TPL_V1["cnt8"]?></td>
			<td><?php echo $TPL_V1["cnt9"]?></td>
			<td><?php echo $TPL_V1["cnt10"]?></td>
            <td><?php echo $TPL_V1["cnt11"]?></td>
            
			<td>0</td>
			<td><?php echo number_format($TPL_V1["cnt13"])?></td>
			<td><?php echo number_format($TPL_V1["cnt15"])?></td>
            <td><?php echo number_format(($TPL_V1["cnt13"])+($TPL_V1["cnt15"]))?></td>
            
			<td>0</td>
			<td><?php echo number_format($TPL_V1["cnt12"])?></td>
			<td><?php echo number_format($TPL_V1["cnt14"])?></td>
			<td><?php echo number_format(($TPL_V1["cnt12"])+($TPL_V1["cnt14"]))?> </td>
		</tr>
<?php }}?>
		
	</tbody>		
</table>
<br>
<!--브랜드별 수리비-->
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>       
		<tr>			
			<th></th>			
			<th>날짜(출고일기준)</th>
			<th>품목(수리종류)</th>
			<th>브랜드</th>
			<th>모델명</th>
			<th>수리처</th>
			<th>유무상</th>
			<th>소가</th>
			<th>공가</th>
			<th>마진</th>
		</tr>
		
	</thead>	
	<tbody>
<?php if($TPL_bloop_1){foreach($TPL_VAR["bloop"] as $TPL_V1){?>
		<tr>									
			<td><?php echo $TPL_V1["type"]?>-<?php echo str_pad($TPL_V1["no"], 7,"0",$TPL_VAR["STR_PAD_LEFT"])?></td>
            <td class="text_type"><?php echo $TPL_V1["month_date"]?></td>            
            <td><?php echo $TPL_V1["repair_memo"]?></td>            
            <td><?php echo $TPL_V1["brandnm"]?></td>            
			<td><?php echo $TPL_V1["goodsnm"]?></td>
            <td><?php echo $TPL_V1["company_name"]?></td>            
			<td><?php echo $TPL_V1["claim_type"]?></td>
			<td><?php if($TPL_V1["report_yn"]=='n'){?>0<?php }else{?><?php echo $TPL_V1["customer_cost"]?><?php }?></td>
            <td><?php if($TPL_V1["report_yn"]=='n'){?>0<?php }else{?><?php echo $TPL_V1["real_cost"]?><?php }?></td>            
            <td><?php if($TPL_V1["report_yn"]=='n'){?>0<?php }else{?><?php echo ($TPL_V1["customer_cost"])-($TPL_V1["real_cost"])?><?php }?></td>            
		</tr>
<?php }}?>
		
	</tbody>		
</table>

</form>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){

$("#print_xls").click(function(){
    $("input[name='print_xls']").val("1");
    $("#sendForm").submit();
    $("input[name='print_xls']").val("0");
});
})

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>