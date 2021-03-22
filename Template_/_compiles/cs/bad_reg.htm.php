<?php /* Template_ 2.2.8 2020/11/05 14:42:01 /www/html/ukk_test2/data/skin/cs/bad_reg.htm 000006328 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<form method="post">
<input type="hidden" name="mode" value="mod">
<input type="hidden" name="no" value="<?php echo $TPL_VAR["data"]['no']?>">
	<div class="row">
		<div class="col-lg-12">			
			<div class="panel panel-default panel-stock margin20">
				<table class="table fileload-list-small">
					<caption>
						<div class="input-group col-lg-12 fileload-list-small-title">
							<span class="fileload-list-small-result"><b></b></span>					
							<div class="input-group fileload-list-small-button">
								<span class="input-group-btn"><button class="btn btn-primary" onclick="javascript:clickChange('2');">수정</button>	</span>
							</div>
							
						</div>
					</caption>
					<colgroup>
						<col width="15%" />
						<col width="30%" />
						<col width="15%" />
						<col width="30%" />						
					</colgroup>
					<tbody>
						
						<tr>
							<th scope="row">하자내용</th>
							<td class="receive-title no-gutters" colspan='7'>
								<textarea class="form-control" name="memo" style="widht:100%;height:150px;"><?php echo $TPL_VAR["data"]['memo']?></textarea>			
							</td>
						</tr>
						<tr>
							<th scope="row">수리내용</th>
							<td class="receive-title no-gutters" colspan='7'>
								<textarea class="form-control" name="repair_memo" style="widht:100%;height:150px;"><?php echo $TPL_VAR["data"]['repair_memo']?></textarea>			
							</td>
						</tr>
	
						<tr>
							<th scope="row">관리자메모</th>
							<td class="receive-title no-gutters" colspan='7'>
								<textarea class="form-control" name="admin_memo" style="widht:100%;height:150px;"><?php echo $TPL_VAR["data"]['admin_memo']?></textarea>				
							</td>
						</tr>
						<tr>
							<th scope="row">수리예정일자</th>
							<td class="receive-title no-gutters">								
								<div class="col-md-2 date-wrap">
									<div class="input-group">
										<input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="repair_date" id="s_date" value="<?php echo $TPL_VAR["data"]['repair_date']?>"  style="width:105px;"readonly />
										<span class="input-group-btn">
											<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="s_date"><span class="glyphicon glyphicon-list-alt"></span></button>
										</span>
									</div>
								</div>
							</td>
							<th scope="row">본사발송일</th>
							<td class="receive-title no-gutters">								
								<div class="col-md-2 date-wrap">
									<div class="input-group">
										<input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="send_date" id="send_date" value="<?php echo $TPL_VAR["data"]['send_date']?>"  style="width:105px;"readonly />
										<span class="input-group-btn">
											<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="send_date"><span class="glyphicon glyphicon-list-alt"></span></button>
										</span>
									</div>
								</div>
							</td>							
						</tr>
						<tr>
							<th scope="row">메카입고일</th>
							<td class="receive-title no-gutters">								
								<div class="col-md-2 date-wrap">
									<div class="input-group">
										<input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="in_date" id="in_date" value="<?php echo $TPL_VAR["data"]['in_date']?>"  style="width:105px;"readonly />
										<span class="input-group-btn">
											<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="in_date"><span class="glyphicon glyphicon-list-alt"></span></button>
										</span>
									</div>
								</div>
							</td>
							<th scope="row">본사정산일</th>
							<td class="receive-title no-gutters">								
								<div class="col-md-2 date-wrap">
									<div class="input-group">
										<input type="text" class="form-control datepicker_common" placeholder="시작 날짜" aria-describedby="basic-addon2" name="calcu_date" id="calcu_date" value="<?php echo $TPL_VAR["data"]['calcu_date']?>"  style="width:105px;"readonly />
										<span class="input-group-btn">
											<button class="btn btn-default datepicker_click" type="button" autocomplete="off" target="calcu_date"><span class="glyphicon glyphicon-list-alt"></span></button>
										</span>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<th scope="row">진행업체명</th>
							<td class="receive-title no-gutters">
								<input class="form-control" name="repair_type" value="<?php echo $TPL_VAR["data"]['repair_type']?>" style="width:150px; display:inline;" readonly>
								<span>
								<select class='company_in'>
									<option value="0">==선택==</option>
									<option>자체</option>
									<option>무한</option>
									<option>은하사</option>
									<option>도우덱</option>
									<option>크리스챤</option>
									<option>시계연구소</option>
									<option>기타</option>
								</select>
								</span>
							</td>
							<th scope="row">수리비용</th>
							<td class="receive-title no-gutters">
								<input class="form-control onlyNumber" name="repair_cost" value="<?php echo $TPL_VAR["data"]['repair_cost']?>">			
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>

<script>
document.title="<?php echo $GLOBALS["page_title"]?>";


$(".company_in").change(function(){
	$("input[name='repair_type']").prop('readonly', true);
	if($(this).val()!=0){
		if($(this).val()=='기타'){
			$("input[name='repair_type']").prop('readonly', false);
		}else{
			$("input[name='repair_type']").val($(this).val());
		}
	}	
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>