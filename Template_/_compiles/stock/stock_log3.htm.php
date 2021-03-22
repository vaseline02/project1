<?php /* Template_ 2.2.8 2021/01/25 11:54:34 /www/html/ukk_test2/data/skin/stock/stock_log3.htm 000004557 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php if($GLOBALS["print_xls"]!= 1){?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<?php echo $this->define('tpl_include_file_1',"stock/stock_log_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<form enctype="multipart/form-data" name="searchForm" id="searchForm" method="get">
    <input type="hidden"name="print_xls" value="">
	<table class="table table-bordered" >		
        <tr>
            <th>날짜</th>
            <td>                 
                <div class="col-lg-4 btn-group-sm" role="group" aria-label="Small button group">
                    <button type="button" class="btn btn-default dayChange" data-int='0' data-type='day'>오늘</button>
                    <button type="button" class="btn btn-default dayChange" data-int='3' data-type='day'>3일</button>
                    <button type="button" class="btn btn-default dayChange" data-int='7' data-type='day'>7일</button>
                    <button type="button" class="btn btn-default dayChange" data-int='1' data-type='month'>1개월</button>
                    <button type="button" class="btn btn-default dayChange" data-int='3' data-type='month'>3개월</button>
                    <button type="button" class="btn btn-default dayChange" data-int='1' data-type='year'>1년</button>
                    <!-- <button type="button" class="btn btn-primary">전체</button> -->
                </div>
                <div class="col-md-2 date-wrap">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="s_date" id="s_date" value="<?php echo $_GET['s_date']?>"  />
                        <span class="input-group-btn">
                            <button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="s_date"><span class="glyphicon glyphicon-list-alt"></span></button>
                        </span>
                    </div>
                </div>
                
                <p class="date-tilde">~</p>
                <div class="col-md-2 date-wrap">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker_common" placeholder="종료 날짜" aria-describedby="basic-addon2" name="e_date" id="e_date" value="<?php echo $_GET['e_date']?>"  />
                        <span class="input-group-btn">
                            <button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="e_date"><span class="glyphicon glyphicon-list-alt"></span></button>
                        </span>
                    </div>										
                </div>
            </td>
        </tr>		
	</table>
	<center>
        <button class="btn btn-primary chkForm" id="">검색</button>
        <button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>
	</center>
</form>
<?php }?>

<form method="post" id="listForm" name="listForm">	
	<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
		<thead>
			<tr>			
				<th>상품명</th>
				<th>입고유형</th>
				<th>총재고</th>
				<th>가용재고</th>
				<th>날짜</th>
            </tr>          
		</thead>	
		<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr>			
				<td class="text_type"><?php echo $TPL_V1["goodsnm"]?></td>
				<td><?php echo $TPL_V1["lognm"]?></td>
				<td><?php echo $TPL_V1["cur_cnt"]?></td>
				<td><?php echo $TPL_V1["psd_stock"]?></td>
				<td><?php echo $TPL_V1["reg_date"]?></td>				
			</tr>
<?php }}?>
		</tbody>
	</table>
</form>
<script>

document.title="<?php echo $GLOBALS["page_title"]?>";
$("#nav_div3").addClass('active');
$(".chkForm").click(function(){

	if(!$("input[name='s_date']").val() || !$("input[name='e_date']").val()){
		alert("날짜를 입력해주세요.");
		return false;
	}	
    $("#searchForm").submit();
});

$("#print_xls").click(function(){
    $("input[name='print_xls']").val("1");
    $("#searchForm").submit();
    $("input[name='print_xls']").val("0");
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>