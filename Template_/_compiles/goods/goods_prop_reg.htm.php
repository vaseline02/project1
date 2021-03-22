<?php /* Template_ 2.2.8 2020/10/05 16:06:21 /www/html/ukk_test2/data/skin/goods/goods_prop_reg.htm 000004343 */ 
$TPL__cfg_prop_code_1=empty($GLOBALS["cfg_prop_code"])||!is_array($GLOBALS["cfg_prop_code"])?0:count($GLOBALS["cfg_prop_code"]);
$TPL_prop_list_1=empty($TPL_VAR["prop_list"])||!is_array($TPL_VAR["prop_list"])?0:count($TPL_VAR["prop_list"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?></h3></div>
</div>


<form method="post" >
<input type="hidden" name="mode" value="ins">
<input type="hidden" name="seq" value="<?php echo $GLOBALS["no"]?>">
<table class="table table-bordered" >
	<tbody>
		<tr>
			<th>분류 추가</th>
			<td>
				<select id="sel_cate">
					<option value="">분류 선택</option>
<?php if($TPL__cfg_prop_code_1){foreach($GLOBALS["cfg_prop_code"] as $TPL_K1=>$TPL_V1){?>
						<option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['sel_cate'][$TPL_K1]?>>[<?php echo $TPL_K1?>] <?php echo $TPL_V1?></option>
<?php }}?>
					<option value="">직접입력</option>
				</select>
				<input type="text" name="code" id="code" required value="<?php echo $TPL_VAR["sabang_prop_code"]?>">
				<button class="btn btn-primary">등 록</button>
			</td>
		</tr>

	</tbody>
</table>
</form>


<table id="" class="display display_dt" data-height="740" data-order="false" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<caption>
		<div class="input-group col-lg-12 common-table-search2">
			<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
			<div class="input-group common-table-search" style="color:red">
			※설정값이 없어야 공용값이 적용됨
			</div>
		</div>
	</caption> 
	<thead>
		<tr>
			<th width="50px">코드</th>
			<th>속성명</th>
			<th width="100px">설정값</th>
			<th>설정값 추가/리셋</th>
			<th>공용값</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_prop_list_1){foreach($TPL_VAR["prop_list"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["code"]?></td>
			<td><?php echo $TPL_V1["prop_name"]?></td>
			<td>
			<div style="display:inline-block">
<?php if(is_array($TPL_R2=$TPL_V1["col_data"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($GLOBALS["col_info"][$TPL_V2]){?>
				<div class="div_prop"><?php echo $GLOBALS["col_info"][$TPL_V2]?></div>
<?php }?>
<?php }}?>
			</div>	
			</td>
			
			<td>
			<select class="prop_val">
<?php if(is_array($TPL_R2=($GLOBALS["col_info"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
				<option value="<?php echo $TPL_K2?>"><?php echo $TPL_V2?></option>
<?php }}?>
			</select>	
			<button type="button" class="btn btn-sm btn-success add_prop" data-seq="<?php echo $TPL_V1["no"]?>" data-mode="ins">추가</button>
			<button type="button" class="btn btn-sm btn-danger add_prop" data-seq="<?php echo $TPL_V1["no"]?>" data-mode="reset">리셋</button>
			</td>
			
			<td>
				<textarea class="add_prop_def prop_val_def" cols="30" rows="3" data-seq="<?php echo $TPL_V1["no"]?>" data-mode="def_set"><?php echo $TPL_V1["def_val"]?></textarea>
				<button type="button" class="btn btn-sm btn-success msg_btn">등록</button>
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>






<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
	
	$("#sel_cate").change(function(){
		$("#code").val( $(this).val());
	});

	$(".add_prop_def").blur(function(){
		
		var mode=$(this).data("mode");	
		var seq=$(this).data("seq");
		var prop_val=$(this).closest("tr").find(".prop_val_def").val();

		$.post("../ajax/goods_prop_set.php",{mode:mode,seq:seq,prop_val:prop_val},function(data){
			if(data!=1){
				alert(data);
			}else{
				location.reload();
			}
		});
	});		

	$(".add_prop").click(function(){
		var mode=$(this).data("mode");	
		var seq=$(this).data("seq");

		var prop_val=$(this).closest("tr").find(".prop_val").val();
		$.post("../ajax/goods_prop_set.php",{mode:mode,seq:seq,prop_val:prop_val},function(data){
			if(data!=1){
				alert(data);
			}else{
				location.reload();
			}
		});
	});
});


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>