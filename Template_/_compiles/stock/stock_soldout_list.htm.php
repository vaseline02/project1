<?php /* Template_ 2.2.8 2020/12/07 16:23:34 /www/html/ukk_test2/data/skin/stock/stock_soldout_list.htm 000006500 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div class="row"><div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div></div>
<form method="GET" id="soldoutForm">
<input type="hidden"name="print_xls" value="">
    <div class="panel panel-default panel-stock margin20">
        <table class="table fileload-list-small">
            <colgroup>
                <col width="15%" />
                <col />
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">등록일</th>
                    <td colspan="3" class="receive-title no-gutters">
                        
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
                                <input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="sdate" id="s_date" value="<?php echo $GLOBALS["s_date_value"]?>"  />
                                <span class="input-group-btn">
                                    <button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="s_date"><span class="glyphicon glyphicon-list-alt"></span></button>
                                </span>
                            </div>
                        </div>
                        
                        <p class="date-tilde">~</p>
                        <div class="col-md-2 date-wrap">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker_common" placeholder="종료 날짜" aria-describedby="basic-addon2" name="edate" id="e_date" value="<?php echo $GLOBALS["e_date_value"]?>"  />
                                <span class="input-group-btn">
                                    <button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="e_date"><span class="glyphicon glyphicon-list-alt"></span></button>
                                </span>
                            </div>										
                        </div>
                        <script>
                            
                        </script>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="align-left">옵션명</th>
                    <td class="receive-title no-gutters">                        
                        <div class="col-xs-12"><input type="text" class="form-control" name="goodsnm" value="<?php echo $_GET['goodsnm']?>"></div>
                    </td>
                </tr>                
            </tbody>
        </table>
    </div>
    <div class="text-center table-btn-group">
        <button class="btn btn-primary">검색</button>
    </div>
</form>
<?php }?>

<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode">

<!--<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->

<table id="" class="display_xscroll display nowrap" data-height="740" style="width:100%;" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>
<?php }?>
			<th>상품명</th>
			<th>현재재고</th>
			<th>등록위치</th>
			<th>등록일</th>
			<th>확인자</th>			
			<th>확인일</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
<?php if(!$TPL_V1["confirm_admin"]){?><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"><?php }?>
			</td>			
<?php }?>
			<td><?php echo $TPL_V1["g_goodsnm"]?></td>
			<td><?php echo $TPL_V1["totalnum"]?></td>
			<td><?php echo $TPL_V1["typename"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td><?php echo $TPL_V1["admin_name"]?></td>
			<td><?php echo $TPL_V1["confirm_date"]?></td>
		</tr>
<?php }}?>
	</tbody>
</table>

</form>


<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">
		<button type="button" class="btn btn-primary btn_submit" id="confirm">확인</button>
	</div>
</div>


<?php }?>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$('table.display_xscroll').dataTable( {
	"aoColumnDefs": [{ 'bSortable': false, 'aTargets': ["sorting_disabled"] }],
	"scrollCollapse": true,
	"paging":   false,
	"scrollY": "800px",
    "scrollX": true,
	"order": []
} );

$(function(){
	$(".btn_submit").click(function(){
		
		var this_id = $(this).attr("id");
		var msg='';

		if( $(".chk_no:checked").length <=0 ){
			alert('항목을 선택해주세요.');
			return;
		}
		
        if(this_id=='confirm'){
			msg='[확인]';
		}

		if(confirm(msg+'처리하시겠습니까?')){
			
			$("#mode").val(this_id);
			$("#main_form").submit();
		}
		
	});

});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>