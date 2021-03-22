<?php /* Template_ 2.2.8 2020/10/26 16:07:34 /www/html/ukk_test2/data/skin/cs/cs_report_log.htm 000005910 */ 
$TPL__list_name_1=empty($GLOBALS["list_name"])||!is_array($GLOBALS["list_name"])?0:count($GLOBALS["list_name"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
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
			<th>입고일</th>
			<td colspan='3'>
			<input type="text" name="s_date" id="s_date" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['s_date']?>"> ~ 
			<input type="text" name="e_date" id="e_date" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['e_date']?>">
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='0' data-type='day'>오늘</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='7' data-type='day'>7일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='15' data-type='day'>15일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='month'>1개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='month'>3개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='year'>1년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='year'>3년</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='5' data-type='year'>5년</span>
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
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th style="height:25px;">구분</th>			
			<th style="height:25px;"></th>
<?php if($TPL__list_name_1){foreach($GLOBALS["list_name"] as $TPL_V1){?>
			<th colspan='2' style="height:25px;"><?php echo $TPL_V1?></th>
<?php }}?>
			<th style="height:25px;"></th>
		</tr>
		<tr>
			<th style="height:25px;">날짜</th>
			<th style="height:25px;">요일</th>
<?php if($TPL__list_name_1){foreach($GLOBALS["list_name"] as $TPL_V1){?>
			<th style="height:25px;">접수</th>
			<th style="height:25px;">처리</th>
<?php }}?>
			<th style="height:25px;">일별 처리 개수</th>
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_K1=>$TPL_V1){?>
		<tr>									
			<td><font <?php echo $GLOBALS["font_color"][$TPL_V1]?>><?php echo $TPL_K1?></font></td>
			<td><font <?php echo $GLOBALS["font_color"][$TPL_V1]?>><?php echo $GLOBALS["weekday"][$TPL_K1]?></font></td>
<?php if(is_array($TPL_R2=($GLOBALS["list_name"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
			<td><?php echo number_format($TPL_VAR["data"][$TPL_K1][$TPL_K2]['0']['sumcount'])?></td>
			<td><?php echo number_format($TPL_VAR["data"][$TPL_K1][$TPL_K2]['1']['sumcount'])?></td>
<?php }}?>
			<td><?php echo number_format($GLOBALS["day_sum"][$TPL_K1])?></td>
		</tr>
<?php }}?>
		
	</tbody>
		<tr style="border-top:1px solid #333">
			<td style="border-top:1px solid #333">개인별 월 접수</td>
			<td style="border-top:1px solid #333"></td>
<?php if($TPL__list_name_1){foreach($GLOBALS["list_name"] as $TPL_K1=>$TPL_V1){?>
			<td style="border-top:1px solid #333"><?php echo number_format($GLOBALS["admin_sum"][$TPL_K1][ 0])?></td>
			<td style="border-top:1px solid #333">0</td>
<?php }}?>
			<td style="border-top:1px solid #333"><?php echo number_format($GLOBALS["total_sum"][ 0])?></td>
		</tr>
		<tr>
			<td>개인별 월 처리</td>
			<td></td>
<?php if($TPL__list_name_1){foreach($GLOBALS["list_name"] as $TPL_K1=>$TPL_V1){?>
			<td>0</td>
			<td><?php echo number_format($GLOBALS["admin_sum"][$TPL_K1][ 1])?></td>
<?php }}?>
			<td><?php echo number_format($GLOBALS["total_sum"][ 1])?></td>
		</tr>
</table>
<?php if($GLOBALS["print_xls"]== 1){?>
<br>
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
    <thead>
		<tr>			
			<th>항목</th>			
			<th>수량</th>			
		</tr>
	</thead>	
	<tbody>
		<tr>
			<th>단순교환</th>
			<th><?php echo $GLOBALS["cs_sum"]['70']['1']?></th>
        </tr>
        <tr>
			<th>단순반품</th>
			<th><?php echo $GLOBALS["cs_sum"]['60']['1']?></th>
        </tr>
        <tr>
			<th>불량교환</th>
			<th><?php echo $GLOBALS["cs_sum"]['70']['2']?></th>
        </tr>
        <tr>
			<th>불량반품</th>
			<th><?php echo $GLOBALS["cs_sum"]['60']['2']?></th>
        </tr>
        <tr>
			<th>오배송</th>
			<th><?php echo ($GLOBALS["cs_sum"]['90']['1']+$GLOBALS["cs_sum"]['90']['2'])?></th>
        </tr>
        <tr>
			<th>총합</th>
			<th><?php echo ($GLOBALS["cs_sum"]['60']['1']+$GLOBALS["cs_sum"]['60']['2']+$GLOBALS["cs_sum"]['70']['1']+$GLOBALS["cs_sum"]['70']['2']+$GLOBALS["cs_sum"]['90']['1']+$GLOBALS["cs_sum"]['90']['2'])?></th>
        </tr>
    </tbody>
</table>
<?php }?>
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