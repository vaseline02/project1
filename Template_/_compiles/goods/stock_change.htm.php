<?php /* Template_ 2.2.8 2020/11/12 13:42:49 /www/html/ukk_test2/data/skin/goods/stock_change.htm 000005702 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<?php if($GLOBALS["print_xls"]!= 1){?>
<!--
<form enctype="multipart/form-data" method="post" onsubmit="return chkform();">
<input type="hidden" name="mode" value="as_ins">
<table class="table table-bordered" >
    <tr>
        <th>재고조정</th>
        <td>
			<input type="file" name="excelFile[]" required/><button class="btn btn-primary" >업로드</button>
			<button type="button" class="btn btn-success" onclick="location.href='../xls_file/as_upload2.xls'">양식 다운로드</button>
		</td>
    </tr>
</table>
</form>-->

<form method="get" name="search_form" id="search_form">
<input type="hidden"name="print_xls" value="">
	<table class="table table-bordered" >
		<colgroup>
			<col width="10%" />
			<col width="39%" />
			<col width="10%" />
			<col width="39%" />
		</colgroup>
		<tr>
			<th>등록일</th>
			<td>
			<input type="text" name="s_date" id="s_date" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['s_date']?>"> ~ 
			<input type="text" name="e_date" id="e_date" class="datepicker_common" autocomplete="off" value="<?php echo $_GET['e_date']?>">
			
			<span type="button" class="btn btn-sm btn-warning dayChange" data-int='0' data-type='day'>오늘</span>
			<span type="button" class="btn btn-sm btn-warning dayChange" data-int='7' data-type='day'>7일</span>
			<span type="button" class="btn btn-sm btn-warning dayChange" data-int='15' data-type='day'>15일</span>
			<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='month'>1개월</span>
			<!--<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='month'>3개월</span>
			<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='year'>1년</span>
			<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='year'>3년</span>
			<span type="button" class="btn btn-sm btn-warning dayChange" data-int='5' data-type='year'>5년</span>-->
			
			</td>
			<th>모델명</th>
			<td><input type="text" name="s_goodsnm" value="<?php echo $_GET['s_goodsnm']?>" style="width:250px;"></td>
		</tr>
	</table>
	<center style="padding-top:5px;">
		<button class="btn btn-sm btn-primary" id="">검 색</button>
		<div type="button" class="btn btn-sm btn-primary" onclick="popup('stock_change_reg.php','stock_change_reg','1100','900')">재고조정</div>
		<div type="button" class="btn btn-sm btn-success" id="print_xls">엑셀 다운로드</div>
	</center>
</form>

<form enctype="multipart/form-data" id="excel_form" method="post">
<input type="hidden"name="print_xls" value="">
<table class="table table-bordered" >
    <tr>
		<th>재고조정</th>
        <td><div type="button" class="btn btn-sm btn-primary" onclick="popup('stock_change_excel_reg.php','stock_change_excel_reg','1100','900')">엑셀등록팝업</div></td>		
    </tr>
</table>
</form>
<?php }?>

<form method="post" id="list_form" name="list_form">
<table class="table table-bordered">
	<colgroup>
		<col width="48%" />
		<col width="3%" />
		<col width="49%" />
	</colgroup>
	<thead>
	<tr>
		<td style="vertical-align: top;">
			<div style="overflow: auto; height:621px;">
				<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
					<thead>
						<tr>			
							<th>모델명</th>			
							<th>수량</th>		
							<th><font style='color:blue'>증가위치</font></th>
							<th>메모</th>	
							<th>관리자</th>						
							<th>변경일</th>						
						</tr>
					</thead>	
					<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["loop"][ 0])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<tr>			
							<td><?php echo $TPL_V1["g_goodsnm"]?></td>
							<td><?php echo $TPL_V1["quantity"]?></td>
							<td><?php echo $TPL_V1["cd"]?></td>
							<td><?php echo $TPL_V1["memo"]?></td>
							<td><?php echo $TPL_V1["admin_name"]?></td>
							<td><?php echo $TPL_V1["reg_date"]?></td>
						</tr>
<?php }}?>
					</tbody>
				</table>
			</div>
		</td>
		<td> </td>
		<td style="vertical-align: top;">
			<div style="overflow: auto; height:621px;">
				<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
					<thead>
						<tr>			
							<th>모델명</th>			
							<th>수량</th>		
							<th><font style='color:red'>차감위치</font></th>
							<th>메모</th>		
							<th>관리자</th>						
							<th>변경일</th>						
						</tr>
					</thead>	
					<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["loop"][ 1])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<tr>			
							<td><?php echo $TPL_V1["g_goodsnm"]?></td>
							<td><?php echo $TPL_V1["quantity"]?></td>
							<td><?php echo $TPL_V1["cd"]?></td>
							<td><?php echo $TPL_V1["memo"]?></td>
							<td><?php echo $TPL_V1["admin_name"]?></td>
							<td><?php echo $TPL_V1["reg_date"]?></td>
						</tr>
<?php }}?>
					</tbody>
				</table>
			</div>
		</td>
	</tr>
	</thead>
</table>
</form>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$("#print_xls").click(function(){
	$("#search_form").attr("action","stock_change_excel.php");
	$("input[name='print_xls']").val("1");
	$("#search_form").submit();
	$("#search_form").attr("action","");
	$("input[name='print_xls']").val("");
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>