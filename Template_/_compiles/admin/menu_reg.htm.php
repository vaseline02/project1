<?php /* Template_ 2.2.8 2020/08/04 16:00:38 /www/html/ukk_test2/data/skin/admin/menu_reg.htm 000005846 */ 
$TPL_cateLoop_1=empty($TPL_VAR["cateLoop"])||!is_array($TPL_VAR["cateLoop"])?0:count($TPL_VAR["cateLoop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>



<form method="post" onsubmit="return checkForm();">
<input type="hidden" name="mode" value="<?php echo $GLOBALS["mode"]?>">
<input type="hidden" name="sn" value="<?php echo $GLOBALS["sn"]?>">
	<input type="hidden" name="cateCheck" value="1">
	<div class="row">
		<div class="col-lg-12">
<?php if($GLOBALS["mode"]=='ins'){?>
			<div class="panel panel-default panel-stock margin20">
				<table class="table fileload-list-small">
					<caption>
						<div class="input-group col-lg-12 fileload-list-small-title">
							<span class="fileload-list-small-result"><b>1차카테고리</b></span>					
							<div class="input-group fileload-list-small-button">
								<span class="input-group-btn"><button class="btn btn-primary" onclick="javascript:clickChange('1');">등록</button>	</span>
							</div>
							
						</div>
					</caption>
					<colgroup>
						<col width="15%" />
						<col width="85%" />
					</colgroup>
					<tbody>
						<tr>
							<th scope="row">메뉴명</th>
							<td class="receive-title no-gutters">
								<input type='text' class="form-control" name='menunm'>
							</td>
						</tr>
						<tr>
							<th scope="row">순서</th>
							<td class="receive-title no-gutters">
								<input type='text' class="form-control" name='1depthSort'>
							</td>
						</tr>
						<tr>
							<th scope="row">사용유무</th>
							<td class="receive-title no-gutters">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type='radio' name='1depthState' id="1depthState_y" value='y' checked>
									<label class="form-check-label" for="1depthState_y">사용</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type='radio' name='1depthState' id="1depthState_n" value='n'>
									<label class="form-check-label" for="1depthState_n">사용안함</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
<?php }?>
			<div class="panel panel-default panel-stock margin20">
				<table class="table fileload-list-small">
					<caption>
						<div class="input-group col-lg-12 fileload-list-small-title">
							<span class="fileload-list-small-result"><b>2차카테고리</b></span>					
							<div class="input-group fileload-list-small-button">
								<span class="input-group-btn"><button class="btn btn-primary" onclick="javascript:clickChange('2');">등록/수정</button>	</span>
							</div>
							
						</div>
					</caption>
					<colgroup>
						<col width="15%" />
						<col width="85%" />
					</colgroup>
					<tbody>
						<tr>
							<th scope="row">1차카테고리</th>
							<td class="receive-title no-gutters">
								<div class="form-check form-check-inline">
									<select name="menu" id="">
											<option value="">== 1차카테고리 선택 ==</option>
<?php if($TPL_cateLoop_1){foreach($TPL_VAR["cateLoop"] as $TPL_V1){?>
											<option value="<?php echo $TPL_V1["sn"]?>" <?php echo $GLOBALS["selected"]['menu_sn'][$TPL_V1["sn"]]?>><?php echo $TPL_V1["menunm"]?></option>
<?php }}?>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<th scope="row">메뉴명</th>
							<td class="receive-title no-gutters">
								<input type='text' class="form-control" name='menu_snm' value="<?php echo $TPL_VAR["menu_snm"]?>">								
							</td>
						</tr>
						<tr>
							<th scope="row">링크</th>
							<td class="receive-title no-gutters">
								<input type='text' class="form-control" name='2depthLink' value="<?php echo $TPL_VAR["link"]?>">								
							</td>
						</tr>
						<tr>
							<th scope="row">순서</th>
							<td class="receive-title no-gutters">
								<input type='text' class="form-control" name='2depthSort' value="<?php echo $TPL_VAR["sort"]?>">								
							</td>
						</tr>
						<tr>
							<th scope="row">사용유무</th>
							<td class="receive-title no-gutters">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type='radio' name='2depthState' id="2depthState_y" value='y' <?php echo $GLOBALS["checked"]['state']['y']?>>
									<label class="form-check-label" for="2depthState_y">사용</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type='radio' name='2depthState' id="2depthState_n" value='n' <?php echo $GLOBALS["checked"]['state']['n']?>>
									<label class="form-check-label" for="2depthState_n">사용안함</label>
								</div>
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
        var cateNo=$("input[name='cateCheck']").val();

		if(cateNo=='1'){
			if(!$("input[name=menunm]").val()){
				alert('메뉴명을 입력해주세요.');
				return false;
			}
		}else{
			if(!$("select[name='menu']").val()){
				alert('1차카테고리를 선택해주세요.');
				return false;
			}
			if(!$("input[name=menu_snm]").val()){
				alert('메뉴명을 입력해주세요.');
				return false;
			}
		}

		
	}

	function clickChange(no){
		
		$("input[name='cateCheck']").val(no);
	}
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>