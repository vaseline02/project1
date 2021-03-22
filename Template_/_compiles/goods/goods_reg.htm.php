<?php /* Template_ 2.2.8 2020/10/30 14:01:58 /www/html/ukk_test2/data/skin/goods/goods_reg.htm 000002437 */ 
$TPL__brandList_1=empty($GLOBALS["brandList"])||!is_array($GLOBALS["brandList"])?0:count($GLOBALS["brandList"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<form method="post" onsubmit="return checkForm();">
<input type="hidden" name="mode" value="ins">
	<div class="row">
		<div class="col-lg-12">			
			<div class="panel panel-default panel-stock margin20">
				<table class="table fileload-list-small">
					<caption>
						<div class="input-group col-lg-12 fileload-list-small-title">
							<span class="fileload-list-small-result"><b></b></span>					
							<div class="input-group fileload-list-small-button">
								<span class="input-group-btn"><button class="btn btn-primary">등록</button></span>
							</div>
							
						</div>
					</caption>
					<colgroup>
						<col width="15%" />
						<col width="85%" />
					</colgroup>
					<tbody>
						<tr>
							<th scope="row">브랜드</th>
							<td class="receive-title no-gutters">							
								<select name="brandno" class="brandno">	
									<option value="">==브랜드선택==</option>
<?php if($TPL__brandList_1){foreach($GLOBALS["brandList"] as $TPL_V1){?>
										<option value="<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["brandnm"]?></option>
<?php }}?>										
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row">상품명</th>
							<td class="receive-title no-gutters">
								<input type='text' class="form-control" name='goodsnm'>
							</td>
						</tr>				
						<tr>
							<th scope="row">상품명2</th>
							<td class="receive-title no-gutters">
								<input type='text' class="form-control" name='goodsnm_sub'>
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

function checkForm(){
	if(!$("select[name='brandno']").val()){
		alert('브랜드를 선택해주세요.');
		return false;
	}
	if(!$("input[name=goodsnm]").val()){
		alert('상품명을 입력해주세요.');
		return false;
	}
}
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>