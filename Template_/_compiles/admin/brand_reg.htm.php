<?php /* Template_ 2.2.8 2021/03/03 08:50:03 /www/html/ukk_test2/data/skin/admin/brand_reg.htm 000003792 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<form method="post" onsubmit="return checkForm();">
<input type="hidden" name="mode" value="<?php echo $GLOBALS["mode"]?>">
<input type="hidden" name="no" value="<?php echo $GLOBALS["no"]?>">
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<caption>
					<div class="input-group col-lg-12 fileload-list-small-title">
						<span class="fileload-list-small-result"><b></b></span>					
						<div class="input-group fileload-list-small-button">
							<span class="input-group-btn">
<?php if($GLOBALS["mode"]=='mod'){?>
								<button class="btn btn btn-warning" >수정</button>
<?php }else{?>
								<button class="btn btn btn-primary" >등록</button>
<?php }?>								
							</span>
						</div>
						
					</div>
				</caption>
				<colgroup>
					<col width="15%" />
					<col width="85%" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row">브랜드명</th>
						<td class="receive-title no-gutters">
							<input type='text' class="form-control" name='brandnm' value="<?php echo $TPL_VAR["brandnm"]?>">								
						</td>
					</tr>
					<tr>
						<th scope="row">브랜드영문명</th>
						<td class="receive-title no-gutters">
							<input type='text' class="form-control" name='brandnm_en' value="<?php echo $TPL_VAR["brandnm_en"]?>">								
						</td>
					</tr>
					<tr>
						<th scope="row">이미지폴더명</th>
						<td class="receive-title no-gutters">
							<input type='text' class="form-control" name='brand_img_folder' value="<?php echo $TPL_VAR["brand_img_folder"]?>">								
						</td>
					</tr>
					<tr>
						<th scope="row">케이스이미지명</th>
						<td class="receive-title no-gutters">
							<input type='text' class="form-control" name='brand_img_nm' value="<?php echo $TPL_VAR["brand_img_nm"]?>">								
						</td>
					</tr>
					<tr>
						<th scope="row">메모</th>
						<td class="receive-title no-gutters">
							<input type='text' class="form-control" name='memo' value="<?php echo $TPL_VAR["memo"]?>">								
						</td>
					</tr>
					<tr>
						<th scope="row">브랜드구분</th>
						<td class="receive-title no-gutters">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type='radio' name='type' id="type_A" value='A' <?php echo $GLOBALS["checked"]['type']['A']?>>
								<label class="form-check-label" for="type_A">공통</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type='radio' name='type' id="type_I" value='I' <?php echo $GLOBALS["checked"]['type']['I']?>>
								<label class="form-check-label" for="type_I">내부</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type='radio' name='type' id="type_O" value='O' <?php echo $GLOBALS["checked"]['type']['O']?>>
								<label class="form-check-label" for="type_O">외부</label>
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
        if(!$("input[name=brandnm]").val()){
            alert('브랜드명을 입력해주세요.');
            return false;
        }
	}
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>