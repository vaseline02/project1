<?php /* Template_ 2.2.8 2020/09/25 08:27:11 /www/html/ukk_test2/data/skin/goods/goods_info_filter.htm 000005943 */ 
$TPL_category_1=empty($TPL_VAR["category"])||!is_array($TPL_VAR["category"])?0:count($TPL_VAR["category"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div class="row"><div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div></div>
<?php }?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<!-- Main Contents -->
<div class="row">
	<div class="col-lg-12">				
		<form method="get">
		<div class="panel panel-default panel-stock margin20">
			<table class="table fileload-list-small">
				<colgroup>
					<col width="15%" />
					<col width="85%" />
				</colgroup>
				<tbody>							
					<tr>
						<th scope="row" class="align-left">카테고리</th>
						<td class="receive-title no-gutters">
							<select name="catecode">
								<option value="">== 카테고리 선택 ==</option>
<?php if($TPL_category_1){foreach($TPL_VAR["category"] as $TPL_K1=>$TPL_V1){?>
								<option value="<?php echo $TPL_K1?>" <?php echo $GLOBALS["selected"]['catecode'][$TPL_K1]?>><?php echo $TPL_V1["catenm"]?></option>
<?php }}?>
							</select>
						</td>
					</tr>							
				</tbody>
			</table>
		</div>
		<div class="text-center table-btn-group">
			<button class="btn btn-primary">검색</button>					
		</div>
		</form>
	</div>			
</div>

<?php }?>


<form method="post" name="filterForm">
<input type="hidden" name="mode" value="ins">
<input type="hidden" name="no">
<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format(count($TPL_VAR["loop"]))?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색">
							<span class="input-group-btn"><button class="btn btn-primary" type="button">검색</button></span> -->
						</div>
					</div>
				</caption>
				<colgroup>
					<col/>
					<col width="10%" />
					<col width="50%" />
				</colgroup>
				<thead>
					<tr>
						<th>속성명</th>
						<th>컬럼명</th>
						<th>명칭</th>
						
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr>										
							<td><?php echo $TPL_V1["info_name"]?></td>							
							<td><?php echo $TPL_V1["colum_name"]?></td>							
							<td>
								<table class="table common-table">			
									<caption>
										<div class="input-group col-lg-12 common-table-search2">
											<div class="input-group common-table-search" style="width:390px">
												<div class="col-xs-12" style="width:100%">
													<input type="text" class="form-control"  style="width:150px;" name="filter_name[<?php echo $TPL_V1["no"]?>]" value=""  placeholder="한글" >
													<input type="text" class="form-control"  style="width:150px;" name="filter_name_en[<?php echo $TPL_V1["no"]?>]" value=""  placeholder="영문" >
												</div>
												<span class="input-group-btn">
													<button class="btn btn-primary checkForm" data-mode="ins" data-no="<?php echo $TPL_V1["no"]?>" type="button">등록</button>
													<span style="padding-left:1px;"> </span>
												</span>
											</div>
										</div>
									</caption>							
									<colgroup>
										<col/>
										<col/>
										<col width="20%" />
									</colgroup>
									<thead>
										<tr>
											<th>항목(한글)</th>
											<th>항목(영문)</th>
											<th></th>											
										</tr>
									</thead>
									<tbody>
<?php if(is_array($TPL_R2=$TPL_V1["filter"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>									
											<tr>										
												<td><input type="text" class="form-control"  name="mod_filter_name[<?php echo $TPL_V2["no"]?>]" value="<?php echo $TPL_V2["filter_name"]?>" ></td>							
												<td><input type="text" class="form-control"  name="mod_filter_name_en[<?php echo $TPL_V2["no"]?>]" value="<?php echo $TPL_V2["filter_name_en"]?>"></td>							
												<td>
													<div class="input-group fileload-list-small-button">
														<span class="input-group-btn">
															<button class="btn btn-warning checkForm" data-mode="mod" data-no=<?php echo $TPL_V2["no"]?> type="button">수정</button>
															<button class="btn btn-danger checkForm" data-mode="del" data-no=<?php echo $TPL_V2["no"]?> type="button">삭제</button>															
														</span>
													</div>
												</td>	
											</tr>
<?php }}?>
									</tbody>
								</table>
							</td>							
						</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</form>



<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?></div>
<?php }?>
	
<script>

document.title="<?php echo $GLOBALS["page_title"]?>";

$(".checkForm").click(function (){
	var mode=$(this).data("mode");
	var no=$(this).data("no");

	$("input[name='mode']").val(mode);
	$("input[name='no']").val(no);
	
	if(mode=="ins"){
		if(!$("input[name='filter_name["+no+"]']").val()){
			alert("항목을 등록해주세요.");
			return false;
		}
		msg="등록";		

	}else if(mode=="del"){
		msg="삭제";
	}else if(mode=="mod"){
		msg="수정";
	}
	
	if(msg){
		if(confirm(msg+'하시겠습니까?')){
			$("form[name='filterForm']").submit();
		}
	}
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>