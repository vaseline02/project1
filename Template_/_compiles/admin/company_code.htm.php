<?php /* Template_ 2.2.8 2020/08/12 15:35:41 /www/html/ukk_test/data/skin/admin/company_code.htm 000007395 */ 
$TPL__delivery_list_1=empty($GLOBALS["delivery_list"])||!is_array($GLOBALS["delivery_list"])?0:count($GLOBALS["delivery_list"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<?php if($GLOBALS["print_xls"]!= 1){?>



<!-- Main Contents -->
<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
	<!-- <div class="col-lg-12">
		<form method="get">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="15%" />
					<col width="85%" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row">주문일자</th>
						<td colspan="3" class="receive-title no-gutters">
							
							<div class="col-lg-4 btn-group-sm" role="group" aria-label="Small button group">
								<button type="button" class="btn btn-default dayChange" data-int='0' data-type='day'>오늘</button>
								<button type="button" class="btn btn-default dayChange" data-int='7' data-type='day'>3일</button>
								<button type="button" class="btn btn-default dayChange" data-int='15' data-type='day'>7일</button>
								<button type="button" class="btn btn-default dayChange" data-int='1' data-type='month'>1개월</button>
								<button type="button" class="btn btn-default dayChange" data-int='3' data-type='month'>3개월</button>
								<button type="button" class="btn btn-default dayChange" data-int='1' data-type='year'>1년</button>
							</div>
							<div class="col-md-2 date-wrap">
								<div class="input-group">
									<input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="s_date" id="s_date" value="<?php echo $GLOBALS["s_date_value"]?>" readonly />
									<span class="input-group-btn">
										<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="s_date"><span class="glyphicon glyphicon-list-alt"></span></button>
									</span>
								</div>
							</div>
							
							<p class="date-tilde">~</p>
							<div class="col-md-2 date-wrap">
								<div class="input-group">
									<input type="text" class="form-control datepicker_common" placeholder="종료 날짜" aria-describedby="basic-addon2" name="e_date" id="e_date" value="<?php echo $GLOBALS["e_date_value"]?>" readonly />
									<span class="input-group-btn">
										<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="e_date"><span class="glyphicon glyphicon-list-alt"></span></button>
									</span>
								</div>										
							</div>
							<script>
								
							</script>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<button class="btn btn-primary">검색</button>
			<button class="btn btn-default" onclick="location.href ='cs_total_list.php'; return false;">초기화</button>
		</div>
		</form>
	</div>			 -->
</div>
<?php }?>

<table class="table table-bordered" >
    <tr>
		<th>택배사명 참고</th>
		<td>
			<select>
<?php if($TPL__delivery_list_1){foreach($GLOBALS["delivery_list"] as $TPL_V1){?>
				<option><?php echo $TPL_V1["name"]?></option>
<?php }}?>
			</select>
		</td>
    </tr>
</table>
<form method="post" id="listForm">
<input type="hidden" name="mode" id="mode">
<input type="hidden" name="no" id="no">
<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색"> -->
							<span class="input-group-btn"><button class="btn btn-primary" type="button" onclick="popup('company_code_reg.php','','1100','900')">등록</button></span>
						</div>
					</div>
				</caption>
				<colgroup>
					<col width="5%" />
					<col width="7%" />
					<col width="5%" />
					<col width="" />
					<col width="5%" />
					<col width="5%" />
					<col width="" />
					<col width="3%" />
					<col width="5%" />
					<col width="" />
					<col width="5%" />
					<col width="" />
					<col width="3%" />
					<col width="" />
					<col width="5%" />
					<col width="1%" />
				</colgroup>
				<thead>
					<tr>
						<th>거래처명</th>
						<th>제휴업체명</th>
						<th>업체코드</th>
						<th>제휴업체명2</th>
						<th>remark</th>
						<th>고객코드</th>
						<th>고객명</th>
						<th>구분</th>
						<th>납품처코드</th>
						<th>납품처명</th>
						<th>고객코드2</th>
						<th>고객명2</th>
						<th>구분2</th>
						<th>납품처명2</th>
						<th>매출처</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr class=" <?php echo $TPL_V1["line_color"]?>" <?php if($TPL_V1["sum_ins_type"]){?>style="color:red"<?php }?>>			
							<td><?php echo $TPL_V1["account_name"]?></td>
							<td><?php echo $TPL_V1["company_name"]?> </td>
							<td><?php echo $TPL_V1["company_code"]?></td>
							<td><?php echo $TPL_V1["company_name2"]?></td>
							<td><?php echo $TPL_V1["remark"]?></td>
							<td><?php echo $TPL_V1["member_code"]?></td>
							<td><?php echo $TPL_V1["member_name"]?></td>
							<td><?php echo $TPL_V1["status"]?></td>
							<td><?php echo $TPL_V1["delivery_code"]?></td>
							<td><?php echo $TPL_V1["delivery_name"]?></td>
							<td><?php echo $TPL_V1["member_code2"]?></td>
							<td><?php echo $TPL_V1["member_name2"]?></td>
							<td><?php echo $TPL_V1["status2"]?></td>
							<td><?php echo $TPL_V1["delivery_name2"]?></td>
							<td><input type="text" value="<?php echo $TPL_V1["sales"]?>" class="sales" data-no=<?php echo $TPL_V1["no"]?> data-colname="sales"></td>
							<td><button type="button" class="btn btn-sm btn-danger del" data-no=<?php echo $TPL_V1["no"]?>>삭제</button></td>		
						</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</form>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?></div>
<?php }?>
<script>

document.title="<?php echo $GLOBALS["page_title"]?>";


$(".sales").focusout(function(){			
    var colname=$(this).data("colname");
    var this_val=$(this).val();
    var this_no=$(this).data("no");

    $.post("../ajax/db_update.php",{dbname:"company_code",target_colname:"no",target_data:this_no,colname:colname,colname_data:this_val},function(data){
        if(data!='1'){
            alert(data);
        }
    });
});

$(".del").click(function (){
    if(confirm("삭제하시겠습니까?")){
        $("#mode").val("del");
        $("#no").val($(this).data("no"));

        $("#listForm").submit(); 
    }
});


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>