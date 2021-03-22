<?php /* Template_ 2.2.8 2020/09/29 15:52:24 /www/html/ukk_test2/data/skin/admin/market_solution_prop_set.htm 000002509 */ 
$TPL__cfg_prop_code_1=empty($GLOBALS["cfg_prop_code"])||!is_array($GLOBALS["cfg_prop_code"])?0:count($GLOBALS["cfg_prop_code"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>
</div>

<form method="post" name="main_form" id="main_form">
<input type="hidden" name="mode">
<input type="hidden" name="no">
<div class="row">
	<div class="col-lg-12">
		<div class="common-table-wrapper">
			<table class="table common-table">
				<caption>
					<div class="input-group col-lg-12 common-table-search2">
						<span class="common-table-result">총 <b><?php echo number_format($TPL_VAR["pg"]->recode['total'])?></b>건</span>
						<div class="input-group common-table-search">
							<!-- <input type="text" class="form-control" placeholder="결과내 검색"> -->							
							<span class="input-group-btn">
								<select name="code" id="code">
									<option value="">선택</option>
<?php if($TPL__cfg_prop_code_1){foreach($GLOBALS["cfg_prop_code"] as $TPL_K1=>$TPL_V1){?>
									<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }}?>
								</select>
							</span>
						</div>
					</div>
				</caption>
				<!--
				<colgroup>
					<col width="20%"/>
					<col/>
					<col width="20%"/>
					<col width="10%" />
					
					
				</colgroup>
				-->
				<thead>
					<tr>
						<th>카테고리코드</th>
						<th>카테고리명</th>
						<th>분류코드</th>
						<th>노출여부</th>
						<th>등록일</th>
						<th>상품수</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				

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

$("#code").change(function(){


	$("#main_form").submit();
});

$(".del").click(function(){

    var no=$(this).data("no");
    var mode=$(this).data("mode");

    $("input[name=mode]").val(mode);
    $("input[name=no]").val(no);

    if(confirm("삭제하시겠습니까?")){
        $("form[name=giftForm]").submit();
    }
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>