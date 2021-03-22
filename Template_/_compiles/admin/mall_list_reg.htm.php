<?php /* Template_ 2.2.8 2020/09/11 08:53:45 /www/html/ukk_test2/data/skin/admin/mall_list_reg.htm 000007710 */ 
$TPL__upload_form_type_1=empty($GLOBALS["upload_form_type"])||!is_array($GLOBALS["upload_form_type"])?0:count($GLOBALS["upload_form_type"]);
$TPL_brand_list_1=empty($TPL_VAR["brand_list"])||!is_array($TPL_VAR["brand_list"])?0:count($TPL_VAR["brand_list"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<!-- Main Contents -->
<form method="post" id="main_form" onsubmit="return chk_form2();">
    <input type="hidden" name="mode" id="mode" value="">
	<input type="hidden" name="no" id="no" value="<?php echo $GLOBALS["_GET"]['no']?>">
<div class="post">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
	<div class="col-lg-12">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="15%" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row">고객코드</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="d_code" id="d_code" value="<?php echo $TPL_VAR["d_code"]?>" required <?php echo $GLOBALS["readonlay"]?>/></div>
                        </td>
                    </tr>
					<tr>
						<th scope="row">고객명</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="d_name" id="d_name" value="<?php echo $TPL_VAR["d_name"]?>" required <?php echo $GLOBALS["readonlay"]?>/></div>
                        </td>
                    </tr>
					<!--
					<tr>
						<th scope="row">구분</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="d_type" id="d_type" value="<?php echo $TPL_VAR["d_type"]?>" required <?php echo $GLOBALS["readonlay"]?>/></div>
                        </td>
                    </tr>
					-->
					<tr>
						<th scope="row">납품처코드</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="d2_code" id="d2_code" value="<?php echo $TPL_VAR["d2_code"]?>" <?php echo $GLOBALS["readonlay"]?>/></div>
                        </td>
                    </tr>
					<tr>
						<th scope="row">납품처명</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="d2_name" id="d2_name" value="<?php echo $TPL_VAR["d2_name"]?>" required <?php echo $GLOBALS["readonlay"]?>/></div>
                        </td>
                    </tr>
					<tr>
						<th scope="row">납품처코드(WMS)</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="mall_code" id="mall_code" value="<?php echo $TPL_VAR["mall_code"]?>" <?php echo $GLOBALS["readonlay"]?>/></div>
                        </td>
                    </tr>
					<tr>
						<th scope="row">납품처명(WMS)</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="wms_mallnm" id="wms_mallnm" value="<?php echo $TPL_VAR["wms_mallnm"]?>" <?php echo $GLOBALS["readonlay"]?>/></div>
                        </td>
                    </tr>

					<tr>
						<th scope="row">실적코드</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="sales_code" id="sales_code" value="<?php echo $TPL_VAR["sales_code"]?>" required <?php echo $GLOBALS["readonlay"]?>/></div>
                        </td>
                    </tr>
					<tr>
						<th scope="row">실적팀명</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="sales_team" id="sales_team" value="<?php echo $TPL_VAR["sales_team"]?>" required <?php echo $GLOBALS["readonlay"]?>/></div>
                        </td>
                    </tr>
					<tr>
						<th scope="row">업로드구분</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12">
							<select name="upload_form_type" id="" >
<?php if($TPL__upload_form_type_1){foreach($GLOBALS["upload_form_type"] as $TPL_V1){?>
								<option <?php if($TPL_VAR["upload_form_type"]==$TPL_V1){?>selected<?php }else{?><?php echo $GLOBALS["disabled"]?><?php }?> ><?php echo $TPL_V1?></option>	
<?php }}?>
							</select>
							</div>
                        </td>
                    </tr>
					<tr>
						<th scope="row">발주서몰명</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="mall_name" id="mall_name" value="<?php echo $TPL_VAR["mall_name"]?>"  required <?php echo $GLOBALS["readonlay"]?>/></div>
                        </td>
                    </tr>
					<tr>
						<th scope="row">사용유무</th>
						<td class="receive-title no-gutters">
							<select name="state" id="" >
								<option value="Y" <?php echo $GLOBALS["selected"]['state']['Y']?> <?php if($TPL_VAR["state"]!='Y'){?><?php echo $GLOBALS["disabled"]?><?php }?>>Y</option>
								<option value="N" <?php echo $GLOBALS["selected"]['state']['N']?> <?php if($TPL_VAR["state"]!='N'){?><?php echo $GLOBALS["disabled"]?><?php }?>>N</option>
							</select>
                        </td>
                    </tr>
					<tr>
						<th scope="row">본사오더담당</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="c_mem_name" id="c_mem_name" value="<?php echo $TPL_VAR["c_mem_name"]?>"/></div>
                        </td>
                    </tr>
					<tr>
						
						<th scope="row" class="align-left">브랜드</th>
						<td class="receive-title no-gutters">
							<div style="overflow: auto; height:210px; font-size: 11px;">
<?php if($TPL_brand_list_1){foreach($TPL_VAR["brand_list"] as $TPL_V1){?>
								<label style="display:inline-block; width:140px; line-height:23px;"><input type="checkbox" name="brand_no[]" value=<?php echo $TPL_V1["no"]?> <?php echo $GLOBALS["checked"]['brand'][$TPL_V1["no"]]?>><?php echo $TPL_V1["brandnm"]?></label>
<?php }}?>						
							</div>
						</td>

						<!-- <th scope="row">브랜드</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="brand" id="brand" value="<?php echo $TPL_VAR["brand"]?>"/></div>
                        </td> -->
					</tr>					

				</tbody>
			</table>
			<!-- <div>※브랜드 입력시 두개 이상이면 '|'로 구분하여 등록 ( 게스|필라|그로바나) </div> -->
		</div>
		
		<div class="text-center table-btn-group">
			<button class="btn btn-primary btn-submit">등록 / 수정</button>
		</div>
	</div>			
</div>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";


function chk_form2(){

	var mode='';
	if($("#no").val()) $("#mode").val("mod");
	else  $("#mode").val("ins");
	
	if(confirm('처리하시겠습니까?')){

		//$("#main_form").submit();

		return true;
	}else{
		return false;
	}
}
/*
$(function(){
	$(".btn-submit").click(function(){

		var mode='';
		if($("#no").val()) $("#mode").val("mod");
		else  $("#mode").val("ins");
		
		if(confirm('처리하시겠습니까?')){

			$("#main_form").submit();
		}

	});
});
*/
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>