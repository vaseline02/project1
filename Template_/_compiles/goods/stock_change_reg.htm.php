<?php /* Template_ 2.2.8 2020/12/17 16:11:22 /www/html/ukk_test2/data/skin/goods/stock_change_reg.htm 000005386 */ 
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<form method="post" id="main_form">
<input type="hidden" name="mode" value="change">
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
								<span class="input-group-btn"><div class="btn btn-primary checkForm">등록</div></span>
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
							<th scope="row">상품명</th>
							<td class="receive-title no-gutters">
								<input type="text" name="goodsnm" class="goodsnm"  onkeyup='changeCheck("goodsCheck",this)' style="width:100%">
								<div class="chkeckGoogs"></div>
							</td>
							<th scope="row">원가</th>
							<td class="receive-title no-gutters">
								<input type='text' class="form-control" name='cost' value=0  onkeyup='inNumber(event)'>
							</td>		
						</tr>
						
						<tr>
							<th scope="row">
								<select name="stock_type">
									<option value="">== 증감선택 ==</option>
									<option value="0">증가</option>
									<option value="1">차감</option>
								</select>
							</th>
							<td class="receive-title no-gutters">
								
								<select name="code_no" class="code_no" onchange='changeCheck("stockCheck",this)'>
									<option value="">== 위치선택 ==</option>
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
									<option value=<?php echo $TPL_V1["no"]?>><?php echo $TPL_V1["cd"]?></option>
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
							<th scope="row">메모</th>
							<td class="receive-title no-gutters" colspan=3>
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
	var goodsnm=$("input[name='goodsnm']").val();
	var stock_type=$("select[name='stock_type']").val();
	var code_no=$("select[name='code_no").val();
	var quantity=$("input[name='quantity']").val();
	var cost=$("input[name='cost']").val();
	var mess="";

	if(!goodsnm){
		alert('상품명을 입력해주세요.');
		return false;
	}else if($(".goodscheck").val()<=0){
		alert("모델명이 존재하지않습니다.");
		return false;
	}else if(!stock_type){
		alert('증감을 선택해주세요.');
		return false;
	}else if(!code_no){
		alert('조정위치를 선택해주세요.');
		return false;
	}else if(quantity<=0){
		alert('수량을 등록해주세요.');
		return false;
	}else if(stock_type=='1'){
		if($(".stockcheck").val()<=0){
			alert("재고가 부족합니다.");
			return false;
		}else if($(".stockcheck").val()<quantity){
			alert("재고가 부족합니다.");
			return false;
		}
	}

	if(stock_type=='0' && cost=='0'){
		mess="[원가가 0원입니다.] ";
	}
	if(confirm(mess+'재고조정을 하시겠습니까?')){
		$("form[id='main_form']").submit();
	}
	
});

function changeCheck(mode){	
	$(".stockcheck").val(0);
	$('.chkeckQuantity').empty();
	if(mode=='goodsCheck'){
		$(".goodscheck").val(0);
		 $("select[name='code_no']").val('').prop("selected",true);
	}

	$.ajax({
        url: "./stock_ajax.php",
        type: "POST",
        cache: false,
        dataType: "json",
        data: "mode="+mode+"&goodsnm="+$(".goodsnm").val()+"&place_code="+$(".code_no").val(),
        success: function(data){
			console.log(data);
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