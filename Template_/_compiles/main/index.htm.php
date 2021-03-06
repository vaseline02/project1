<?php /* Template_ 2.2.8 2021/01/25 15:56:39 /www/html/ukk_test2/data/skin/main/index.htm 000012736 */ 
$TPL_stockloop_1=empty($TPL_VAR["stockloop"])||!is_array($TPL_VAR["stockloop"])?0:count($TPL_VAR["stockloop"]);
$TPL_se_data_1=empty($TPL_VAR["se_data"])||!is_array($TPL_VAR["se_data"])?0:count($TPL_VAR["se_data"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<style>
#calendarModal input[type=text] { width:97%; width:calc(100% - 14px); margin:0; }
</style>

<script>
var sess_id = '<?php echo $GLOBALS["sess"]["m_id"]?>', sess_level = '<?php echo $GLOBALS["sess"]["level"]?>';

$(document).ready(function() {
	var calendar = $('#calendar').fullCalendar({
	editable:true,
	header:{
	 left: '',
	 center: 'title',
	 right: 'prev,next today'
	},
	//weekMode: 'liquid',
	aspectRatio: 2,
	titleFormat: {
		month: 'yyyy. MM'
	},
	events:function (start, end, callback) {

		$.post('load_cal.php', 'date_from='+moment(start).format('YYYY-MM-DD')+'&date_to='+moment(end).format('YYYY-MM-DD'), function(res){
			
			var aaa=$.parseJSON(res);
			
			//calendar_map = {};
			var events = [];
			for (var i in aaa) {
				
				var j = aaa[i];
				//calendar_map[j.no] = j;
				events.push({
					id: j.no,
					u_id: j.u_id,
					name: j.name,
					title: j.title,
					start: j.date_from, 
					end: j.date_to,
					type: j.type,
					group_id:j.group_id,
					alt:"sldafkjasdf",
					className: 'label-'+j.type
				});
			}
			callback(events);
		
		});
	},

	selectable:true,
	selectHelper:true,
	select: function(start, end, allDay) {

		// 필드 채우기
		$('#calendar_date_from').val(moment(start).format('YYYY-MM-DD'));
		$('#calendar_date_to').val(moment(end).format('YYYY-MM-DD'));
		$('#calendar_title').val('');

		// 색상 선택을 초기화
		$('#btn_type button').removeClass('active');
		$('#btn_type button:eq(0)').addClass('active');

		mode('new');
		$('#calendarModal').modal();
		$('#calendar_title').focus();
		// calendar.fullCalendar('unselect');
		
	},
	/*
	eventResize:function(event)
	{
	 var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
	 var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
	 var title = event.title;
	 var id = event.id;
	 $.ajax({
	  url:"update.php",
	  type:"POST",
	  data:{title:title, start:start, end:end, id:id},
	  success:function(){
	   calendar.fullCalendar('refetchEvents');
	   alert('Event Update');
	  }
	 })
	},
	*/
	eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
		if (event.u_id != sess_id && sess_level > 6) { revertFunc(); return alert('자신의 일정만 수정 가능합니다'); }
		
		var id = event.id;
		var group_id = event.group_id;
		var mode="mod_date";
		$.post("indb_cal.php",{dayDelta:dayDelta,mode:mode,no:id,group_id:group_id},function(res){
			if(res!='s'){
				alert("[ 실 패 ]"+res);	
			}
			/*
			else{
				var mode="mod_stock_date";	
				$.post("indb_cal.php",{dayDelta:dayDelta,mode:mode,no:id,group_id:group_id},function(res){

				});
			}
			*/
		});
	},
	eventClick: function(calEvent, jsEvent, view) {
		if (event.u_id != sess_id && sess_level > 6) { return alert('자신의 일정만 수정 가능합니다'); }
		// 필드 채우기
		$('#calendar_no').val(calEvent.id);
		$('#calendar_title').val(calEvent.title);
		$('#calendar_group_id').val(calEvent.group_id);

		$("#iframe_stock_list").css("display","none");
		// 색상 선택
		$('#btn_type button').removeClass('active');
		$('#btn_type button').each(function(){ if($(this).data('type') == calEvent.type) $(this).addClass('active');});
		
		mode('edit');
		$('#calendarModal').modal();
		$('#calendar_title').select();
	}
	});


	$(".view_ifm_list").click(function(){

		$("#iframe_stock_list").css("display","block");
		$("#ifm_form").attr("target","iframe_stock_list");

		$("#ifm_form").attr("action","../main/iframe_stock_list.php");
		$("#ifm_form").submit();


	});
});

// 생성모드, 수정모드 전환 
function mode(m) {
$('.mode_select').hide();
$('.'+m+'_mode').show();
}

// 일정 입력
function indb_calendar(mode) {
	// validate
	if (!(
		required([['#calendar_title', "일정 내용을 입력해주세요"]])
	) && mode!='del') return;
	
	var type = $('#btn_type button.active').data('type');

	var title=$("#calendar_title").val();
	var date_from=$("#calendar_date_from").val();
	var date_to=$("#calendar_date_to").val();
	var no=$("#calendar_no").val();

	if(mode=="del")if (!confirm("해당 일정을 삭제하시겠습니까?")) return;
	
	var mode=mode;
	$.post("indb_cal.php",{title:title,date_from:date_from,date_to:date_to,type:type,mode:mode,no:no},function(res){
		if(res=='s'){
			$('#calendarModal').modal('hide');
			$('#calendar').fullCalendar('refetchEvents');
		}else{
			alert("[ 실 패 ]"+res);
		}
	});
}



</script>

  <br />
  <div class="col-lg-12">
   <div id="calendar" class="col-lg-6 maincalendar fc fc-ltr"></div>
  </div>

<!-- set up the modal to start hidden and fade in and out -->
<div id="calendarModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="calendarModalLabel">일정 <span class="mode_select new_mode">입력</span><span class="mode_select edit_mode" style="display:none;">수정</span></h3>
			</div>
            <div class="modal-body">
                <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
               	종류 선택<br />
				<div id="btn_type" data-toggle="buttons-radio" class="btn-group">
					<button class="btn-color btn btn-small btn-success active" type="button" data-type="success">&nbsp;&nbsp;&nbsp;&nbsp;</button>
					<button class="btn-color btn btn-small btn-info" type="button" data-type="info">&nbsp;&nbsp;&nbsp;&nbsp;</button>
					<button class="btn-color btn btn-small btn-yellow" type="button" data-type="yellow">&nbsp;&nbsp;&nbsp;&nbsp;</button>
					<button class="btn-color btn btn-small btn-warning" type="button" data-type="warning">&nbsp;&nbsp;&nbsp;&nbsp;</button>
					<button class="btn-color btn btn-small btn-danger" type="button" data-type="important">&nbsp;&nbsp;&nbsp;&nbsp;</button>
				</div><br /><br />
				내용 입력<br />
				<input id="calendar_title" type="text" />
				<input id="calendar_no" type="hidden" />
				<input id="calendar_date_from" type="hidden" />
				<input id="calendar_date_to" type="hidden" />
            </div>
            
            <div class="modal-footer">
				<div class="mode_select new_mode">
				<button class="btn btn-small btn-info" onclick="indb_calendar('ins')">입력</button>
				<button class="btn btn-small btn-warning" data-dismiss="modal" aria-hidden="true">취소</button>
				<button type="button" class="btn btn-small btn-info view_ifm_list" >목록보기</button>
				</div>
				<div class="mode_select edit_mode" style="display:none;">
				<button class="btn btn-small btn-success" onclick="indb_calendar('mod')">수정</button>
				<!--<button class="btn btn-small btn-danger" onclick="indb_calendar('del')">삭제</button>-->
				<button class="btn btn-small btn-warning" data-dismiss="modal" aria-hidden="true">취소</button>
				<button type="button" class="btn btn-small btn-info view_ifm_list" >목록보기</button>
				</div>
				<div class="margin_t_def">
					<form method="post" id="ifm_form" >
					<input type="hidden" name="calendar_group_id" id="calendar_group_id">
					
					<iframe name="iframe_stock_list" class="margin_t_def" id="iframe_stock_list" width="100%" height="600px" src="" scrolling="auto" frameborder="0" style="display:none;"></iframe>
					</form>
				</div>
				
			</div>

			
        </div>
    </div>
</div>

<div class="div_blank"></div>

<div style="width:1240px;margin:auto">
	<table id="" style="width:100%">
	<tr>
		<td style="width:33%; vertical-align: top;">		
			<div style="overflow: auto; height:620px;">
			<table id="" class="display display_dt" data-height="740" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">품절</span>
						<div class="input-group common-table-search">
							<span class="input-group-btn">
							<form action="">
							<button type="button" class="btn btn-primary" onclick="location.href='../stock/stock_log.php'">전체보기</button>
							</form>
							</span>
						</div>
					</div>
				</caption>
				<thead>
				<tr>
					<th>상품명</th>
					<th>현재고</th>
					<th>날짜</th>
				</tr>
				</thead>
				<tbody>
<?php if($TPL_stockloop_1){foreach($TPL_VAR["stockloop"] as $TPL_V1){?>
				<tr>
					<td><?php echo $TPL_V1["goodsnm"]?></td>
					<td><?php echo $TPL_V1["psd_stock"]?></td>
					<td><?php echo $TPL_V1["time_group"]?> <?php echo $TPL_V1["typenm"]?><br><?php echo $TPL_V1["reg_date"]?></td>
				</tr>
<?php }}?>
				</tbody>
			</table>
			</div>
		</td>
		<td></td>
		<td style="width:33%; vertical-align: top;">	
			<div style="overflow: auto; height:620px;">
			<table id="" class="display display_dt" data-height="740" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">품절재입고</span>
						<div class="input-group common-table-search">
							<span class="input-group-btn">
							<form action="">
							<button type="button" class="btn btn-primary" onclick="location.href='../stock/stock_log2.php'">전체보기</button>
							</form>
							</span>
						</div>
					</div>
				</caption>
				<thead>
				<tr>
					<th>상품명</th>
					<th>현재고</th>
					<th>날짜</th>
				</tr>
				</thead>
				<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["goodsloop"][ 2])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<tr>
					<td><?php echo $TPL_V1["goodsnm"]?></td>
					<td><?php echo $TPL_V1["psd_stock"]?></td>
					<td><?php echo $TPL_V1["lognm"]?><br><?php echo $TPL_V1["reg_date"]?></td>
				</tr>
<?php }}?>
				</tbody>
			</table>		
			</div>
		</td>
		<td></td>
		<td style="width:33%; vertical-align: top;">		
			<div style="overflow: auto; height:620px;">
			<table id="" class="display display_dt" data-height="740" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">신규입고</span>
						<div class="input-group common-table-search">
							<span class="input-group-btn">
							<form action="">
							<button type="button" class="btn btn-primary" onclick="location.href='../stock/stock_log3.php'">전체보기</button>
							</form>
							</span>
						</div>
					</div>
				</caption>
				<thead>
				<tr>
					<th>상품명</th>
					<th>현재고</th>
					<th>날짜</th>
				</tr>
				</thead>
				<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["goodsloop"][ 1])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<tr>
					<td><?php echo $TPL_V1["goodsnm"]?></td>
					<td><?php echo $TPL_V1["psd_stock"]?></td>
					<td><?php echo $TPL_V1["reg_date"]?></td>
				</tr>
<?php }}?>
				</tbody>
			</table>		
			</div>
		</td>
	</tr>
	</table>
</div>
	
<div style="width:1240px;margin:auto">
	<table id="" class="display display_dt" data-height="740" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
		<caption>
			<div class="input-group col-lg-12 common-table-search2">
				<span class="common-table-result">기능추가/수정내역</span>
				<div class="input-group common-table-search">
					<span class="input-group-btn">
					<form action="">
						
						
						<button type="button" class="btn btn-primary" onclick="location.href='../bbs_default/list.php?board_id=se'">전체보기</button>
						</form>
					</span>
				</div>
			</div>
		</caption>
		<thead>
		<tr>
			<th>No</th>
			<th>제목</th>
			<th>등록일</th>
		</tr>
		</thead>
		<tbody>
<?php if($TPL_se_data_1){foreach($TPL_VAR["se_data"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["sn"]?></td>
			<td class="line_tr" id="<?php echo $TPL_V1["sn"]?>"><?php echo $TPL_V1["subject"]?></td>
			<td><?php echo $TPL_V1["regdt"]?></td>
		</tr>
<?php }}?>
		</tbody>
	</table>
</div>


<script>

$(function(){

	$(".line_tr").click(function(){

		var sn = $(this).attr("id");
		var board_id = 'se';

		var pop = window.open("../bbs_default/write.php?view=main&sn="+sn+"&board_id="+board_id,"view_pop","width=1400,height=800,scrollbars=yes");
		pop.focus();
	});
});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>