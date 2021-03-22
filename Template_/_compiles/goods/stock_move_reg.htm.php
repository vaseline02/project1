<?php /* Template_ 2.2.8 2020/11/11 09:21:16 /www/html/ukk_test2/data/skin/goods/stock_move_reg.htm 000003522 */ 
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<form method="post" id="main_form">
<input type="hidden" name="mode" value="move">
<input type="hidden" name="no" value="<?php echo $TPL_VAR["data"]['no']?>">
<input type="hidden" name="goodsnm" value="<?php echo $TPL_VAR["data"]['goodsnm']?>">
<input type="hidden" name="chk_cnt" value="0">
	<div class="row">
		<div class="col-lg-12">			
			<div class="panel panel-default panel-stock margin20">
				<table class="table fileload-list-small">
					<caption>
						<div class="input-group col-lg-12 fileload-list-small-title">
							<span class="fileload-list-small-result"><b></b></span>					
							<div class="input-group fileload-list-small-button">
								<span class="input-group-btn"><div class="btn btn-primary checkForm">이동</div></span>
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
							<th scope="row">재고이동</th>
							<td class="receive-title no-gutters">
								<select name="s_cnt" class="s_change">
									<option value="">== 차감 ==</option>
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
									<option value=<?php echo $TPL_V1["no"]?> data-cnt=<?php echo $TPL_V1["cnt"]?> <?php if(!$TPL_V1["cnt"]){?>disabled<?php }?>><?php echo $TPL_V1["cd"]?>(<?php echo $TPL_V1["cnt"]?>)</option>
<?php }}?>
								</select>
								<select name="e_cnt">
									<option value="">== 증가 ==</option>
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
									<option value=<?php echo $TPL_V1["no"]?>><?php echo $TPL_V1["cd"]?>(<?php echo $TPL_V1["cnt"]?>)</option>
<?php }}?>
								</select>
								<input type="text" name="moveCnt" style="width:70px;" placeholder="수량">
							</td>
						</tr>
						<tr>
							<th scope="row">메모</th>
							<td class="receive-title no-gutters">
								<textarea name="memo" style="width:100%; height:100px;"></textarea>
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
$(".checkForm").click(function(){
	var scnt=$("select[name='s_cnt']").val();
	var ecnt=$("select[name='e_cnt").val();
	var movecnt=$("input[name='moveCnt']").val();
	
	if(!scnt){
		alert('차감위치를 선택해주세요.');
		return false;
	}else if(!ecnt){
		alert('증가위치를 선택해주세요.');
		return false;
	}else if(!movecnt){
		alert('수량을 등록해주세요.');
		return false;
	}else if($("input[name='chk_cnt']").val()<movecnt){
		alert('차감될 위치의 재고가 부족합니다.');
		return false;
	}else{
		if(confirm('재고이동을 하시겠습니까?')){
			$("form[id='main_form']").submit();
		}
	}
});
$(".s_change").change(function(){
	$("input[name='chk_cnt']").val($(this).find("option:selected").data('cnt'));
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>