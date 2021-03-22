<?php /* Template_ 2.2.8 2021/02/24 12:00:39 /www/html/ukk_test2/data/skin/goods/stock_quick_reg.htm 000004648 */ 
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>



<form method="post" onsubmit="return checkForm();">
<input type="hidden" name="mode" value="<?php echo $GLOBALS["mode"]?>">
<input type="hidden" name="goodscheck" class="goodscheck" value="0">
<input type="hidden" name="stockcheck" class="stockcheck" value="0">
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
						<col width="35%" />
						<col width="15%" />
						<col width="35%" />
					</colgroup>
					<tbody>
						<tr>
							<th scope="row">모델명</th>
							<td class="receive-title no-gutters" colspan=3>
								<input type='text' class="goodsnm" style="width:50%" name='goodsnm' onkeyup='quickCheck("goodsCheck",this)'>
								<select name="state" class="state">
									<option value="">==구분==</option>
									<option value="1">홀드</option>
									<option value="2">요청</option>
								</select>
								<div class="chkeckGoogs"></div>
							</td>
						</tr>
						<tr>
							<th scope="row">재고차감위치</th>
							<td class="receive-title no-gutters">
								<select name="place_code" id="" class="place_code"  onchange='quickCheck("stockCheck",this)'>
									<option value="">==선택==</option>
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
										<option value="<?php echo $TPL_V1["no"]?>" <?php echo $GLOBALS["selected"]['place_code'][$TPL_V1["no"]]?> data-name="<?php echo $TPL_V1["cd"]?>"><?php echo $TPL_V1["cd"]?></option>
<?php }}?>
								</select>
							</td>
							<th scope="row">수량</th>
							<td class="receive-title no-gutters">
								<input type='text' class="form-control quantity" style="width:50px" name='quantity' value=0  onkeyup='inNumber(event)'>
								<div class="chkeckQuantity"></div>
							</td>							
						</tr>
						<tr>
							<th scope="row">사유</th>
							<td class="receive-title no-gutters" colspan=3>
								<textarea style="width:100%; height:150px;" name="memo"></textarea>
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
	if($(".goodscheck").val()<=0){
		alert("모델명이 존재하지않습니다.");
		return false;
	}else if(!$(".state").val()){
		alert("구분을 선택해주세요.");
		return false;
	}else if(!$(".place_code").val()){
		alert("재고차감위치를 선택해주세요.");
		return false;
	}else if(Number($(".quantity").val())<=0){
		alert("수량을 입력해주세요.");
		return false;
	}else if(Number($(".stockcheck").val())<Number($(".quantity").val())){
		alert("재고가 부족합니다.");
		return false;
	}

	if(!confirm("등록하시겠습니까?")){
		return false;
	}
}

function quickCheck(mode){	
	$(".stockcheck").val(0);
	$('.chkeckQuantity').empty();
	if(mode=='goodsCheck'){
		$(".goodscheck").val(0);
		$("select[name='place_code']").val('').prop("selected",true);
	}

	$.ajax({
        url: "./stock_quick_ajax.php",
        type: "POST",
        cache: false,
        dataType: "json",
        data: "mode="+mode+"&goodsnm="+$(".goodsnm").val()+"&place_code="+$(".place_code").val(),
        success: function(data){
			if(mode=='goodsCheck'){
				$('.chkeckGoogs').empty();
				if(!data.cnt){				
					$('.chkeckGoogs').append('* 해당 모델이 존재하지않습니다.');
				}else{
					$(".goodscheck").val(1);
				}			
			}else if(mode=='stockCheck'){
				if(!data.stockno){				
					$('.chkeckQuantity').append('* 해당 위치에 재고가 존재하지않습니다.');
				}else{
					$(".stockcheck").val(data.stockno);
					$('.chkeckQuantity').append('* 재고 : '+data.stockno+'개');
				}
			}
        }
    });
}

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>