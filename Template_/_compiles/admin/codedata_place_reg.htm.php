<?php /* Template_ 2.2.8 2021/03/11 10:48:13 /www/html/ukk_test2/data/skin/admin/codedata_place_reg.htm 000005820 */ 
$TPL__cfg_place_type_1=empty($GLOBALS["cfg_place_type"])||!is_array($GLOBALS["cfg_place_type"])?0:count($GLOBALS["cfg_place_type"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<!-- Main Contents -->
<form method="post" name="mainForm" id="mainForm">
<?php if($GLOBALS["codeno"]){?>
	<input type="hidden" name="mode" id="mode" value="mod">
	<input type="hidden" name="no" id="no" value="<?php echo $GLOBALS["codeno"]?>">
<?php }else{?>
    <input type="hidden" name="mode" id="mode" value="ins">
<?php }?>
<div class="post">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
	<div class="col-lg-12">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="15%" />
                    <col width="35%" />
                    <col width="15%" />
					<col width="35%" />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row">이름</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12">
<?php if($GLOBALS["codeno"]){?>
									<?php echo $TPL_VAR["cd"]?>

<?php }else{?>
									<input type="text" class="form-control" name="cd" id="cd"/>
<?php }?>
							</div>
                        </td>
                        <th scope="row">대분류</th>
                        <td class="receive-title no-gutters">
							<div class="col-xs-12">
								<select name="place_type" id="place_type">
								<option value="">== 선택 ==</option>
<?php if($TPL__cfg_place_type_1){foreach($GLOBALS["cfg_place_type"] as $TPL_K1=>$TPL_V1){?>
								<option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['place_type'][$TPL_K1]?>><?php echo $TPL_V1?></option>
<?php }}?>
								</select>								
							</div>
						</td>
                    </tr>
					<tr>
						<th scope="row" class="align-left">재고배치순번</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="v" id="v" value="<?php echo $TPL_VAR["v"]?>"/></div>
                        </td>
                        <th scope="row">더존장소코드</th>
                        <td class="receive-title no-gutters">
							<div class="col-xs-12"><input type="text" class="form-control" name="place_code" id="place_code" value="<?php echo $TPL_VAR["place_code"]?>"/></div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="align-left">발주가능여부</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12">
							<input type="radio" name="v2" id="v2_1" value='1' <?php echo $GLOBALS["checked"]['v2']['1']?>><label for="v2_1">가능</label>
                            <input type="radio" name="v2" id="v2_0" value='0' <?php echo $GLOBALS["checked"]['v2']['0']?>><label for="v2_0">불가능</label>
							</div>
                        </td>						
                        <th scope="row">재고위치 사용유무</th>
                        <td class="receive-title no-gutters">
							<div class="col-xs-12">
							<input type="radio" name="view_yn" id="view_y" value='y' <?php echo $GLOBALS["checked"]['view_yn']['y']?>><label for="view_y">사용</label>
                            <input type="radio" name="view_yn" id="view_n" value='n' <?php echo $GLOBALS["checked"]['view_yn']['n']?>><label for="view_n">미사용</label>
							</div>
						</td>
                    </tr>
					<!--
                    <tr>
						<th scope="row" class="align-left">가용재고 포함유무</th>
						<td class="receive-title no-gutters">
							<div class="col-xs-12">
							<input type="radio" name="stock_include_yn" id="stock_include_y" value='y' <?php echo $GLOBALS["checked"]['stock_include_yn']['y']?>><label for="stock_include_y">포함</label>
                            <input type="radio" name="stock_include_yn" id="stock_include_n" value='n' <?php echo $GLOBALS["checked"]['stock_include_yn']['n']?>><label for="stock_include_n">미포함</label>
							</div>
                        </td>
                        <th scope="row"></th>
                        <td class="receive-title no-gutters"></td>
                    </tr>
                   -->
				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<div class="btn btn-primary checkForm">등록/수정</div>
			<!-- <button class="btn btn-default" onclick="location.href ='cs_total_list.php'; return false;">초기화</button> -->
		</div>
	</div>			
</div>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(".checkForm").click(function (){
	var mode = $("#mode").val();
	var mess="";

	if(mode=="ins"){
		if(!$("#cd").val()){
			alert("이름을 입력해주세요.");
			return false;
		}
		mess="등록";
	}else{
		mess="수정";
	}


	if(!$("#place_type option:selected").val()){

		alert("대분류를 선택해주세요.");
		return false;
	}

	if(!$("#v").val()){
		alert("재고배치순번을 입력해주세요.");
		return false;
	}
	if(!$("#place_code").val()){
		alert("더존장소코드를 입력해주세요.");
		return false;
	}

	if($('input:radio[name="v2"]').is(":checked") == false){
		alert("발주가능여부를 선택해주세요.");
		return false;
	}

	if($('input:radio[name="view_yn"]').is(":checked") == false){
		alert("재고위치사용우무를 선택해주세요.");
		return false;
	}

	if(confirm(mess+" 하시겠습니까?")){
		$("#mainForm").submit();
	}
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>