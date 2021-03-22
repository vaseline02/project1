<?php /* Template_ 2.2.8 2021/03/16 16:38:11 /www/html/ukk_test2/data/skin/order/order_outside_mat.htm 000006534 */ 
$TPL__brandList_1=empty($GLOBALS["brandList"])||!is_array($GLOBALS["brandList"])?0:count($GLOBALS["brandList"]);
$TPL__err_msg_1=empty($GLOBALS["err_msg"])||!is_array($GLOBALS["err_msg"])?0:count($GLOBALS["err_msg"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div class="row">
	<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?></h3></div>
</div>

<form method="GET" name="searchForm" id="searchForm">	
	<input type="hidden" name="print_xls" value="">
	<table class="table table-bordered" >
		<tr>			
			<th>모델명</th>
			<td><input type="text" class="form-control" name="s_goodsnm" value="<?php echo $_REQUEST['s_goodsnm']?>"></td>			
			<th rowspan='2'>모델명 다중검색</th>
			<td rowspan='2'><textarea class="form-control" name="s_multi_goodsnm" id="s_multi_goodsnm" cols="30" rows="3"><?php echo $_REQUEST['s_multi_goodsnm']?></textarea></td>
		</tr>		
		<tr>			
			<th>브랜드</th>
			<td><input type="text" class="form-control" name="s_brand" value="<?php echo $_REQUEST['s_brand']?>"></td>			
		</tr>		
	</table>
	<center>		
		<input type="checkbox" name="pagelimit" id="pagelimit" value='y' <?php echo $GLOBALS["checked"]['pagelimit']['y']?>><label for="pagelimit">페이징해제</label>
		<button class="btn btn-primary" id="">검 색</button>
	</center>
</form>
<hr>
<form enctype="multipart/form-data" method="post" name="addForm">
<table class="table table-bordered" >
	<!--<input type="hidden" name="mode" value="ins">	-->
    <tr>
		<!--
		<th>등록</th>
        <td>
			<input type="text"  name="goodsnm" placeholder="상품명">
			<select name="brandno">
				<option value="">== 선택 ==</option>
<?php if($TPL__brandList_1){foreach($GLOBALS["brandList"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["brandnm"]?></option>
<?php }}?>
			</select>
			<div class="btn btn-sm btn-primary chkForm" id="">등록</div>
		</td>
-->
        <th>등록/수정</th>
        <td>
			<input type="file" name="excelFile[]" required/><button class="btn btn-primary">등록/수정</button>
			<button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>
		</td>
<?php if($GLOBALS["err_msg"]){?>
		<td>
			<div style="overflow: auto; height:200px;">
<?php if($TPL__err_msg_1){foreach($GLOBALS["err_msg"] as $TPL_V1){?>
				<?php echo $TPL_V1?><br>
<?php }}?>
			</div>					
		</td>
<?php }?>		
    </tr>
</table>
</form>
<?php }?>
<form method="post" name="listForm" id="listForm">
<table id="" class="display display_dt" style="width:100%;" border="<?php echo $GLOBALS["xls_border"]?>">
<input type="hidden" name="mode" value="">
<input type="hidden" name="no" value="">
	<thead>
		<tr>
			<!--<th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>	-->
			<th>상품명</th>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<th>업체명</th>
<?php }?>
			<th>브랜드</th>
			<th>소비자가</th>
			<th>매입단가</th>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<th></th>
<?php }?>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr>		
		<!--<td><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>"></td>-->
		<td><?php echo $TPL_V1["goodsnm"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?>
		<td class="mallNm_<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["mall_name"]?></td>
<?php }?>
		<td>
			<?php echo $TPL_V1["brandnm"]?>

			<!--
			<select name="outside_brand[<?php echo $TPL_V1["no"]?>]" class="brandChg" data-no="<?php echo $TPL_V1["no"]?>">

<?php if(is_array($TPL_R2=($GLOBALS["brandList"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<option value="<?php echo $TPL_V2["no"]?>" <?php echo $GLOBALS["selected"]['outside_brand'][$TPL_V1["no"]][$TPL_V2["no"]]?>><?php echo $TPL_V2["brandnm"]?></option>
<?php }}?>

			</select>
			-->
		</td>
		<td><?php echo $TPL_V1["consumer_price"]?></td>
		<td><?php echo $TPL_V1["purchase_price"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?>
		<td>
			<div type="button" class="btn btn-sm btn-danger indbSubmit" data-mode='del' data-no='<?php echo $TPL_V1["no"]?>'>삭제</div>
		</td>	
<?php }?>
	</tr>
<?php }}?>
	</tbody>
</table>
</form>
<?php if($GLOBALS["print_xls"]!= 1){?>

<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>

<?php }?>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(".chkForm").click(function(){
    var goodsnm=$("input[name='goodsnm']").val();
    var brand=$("select[name='brandno']").val();

	if(!goodsnm){
		alert('상품명을 입력해주세요.');
		return false;
	}else if(!brand){
		alert('브랜드를 선택해주세요.');
		return false;
	}else{        
		if(confirm("등록하시겠습니까?")){
			$("form[name=addForm]").submit();
		}
	}
});

$(".indbSubmit").click(function(){
    var mode=$(this).data('mode');
	var no=$(this).data('no');

	if(confirm("삭제 하시겠습니까?")){
		$("form[name='listForm']").find("input[name='mode']").val(mode);	
		$("form[name='listForm']").find("input[name='no']").val(no);	

		$("form[name=listForm]").submit();
	}
});

$(".brandChg").change(function(){
	var no =$(this).data("no");
	var brandno=$(this).val();

	if(confirm("브랜드를 변경하시겠습니까?")){
		$.ajax({
            url: "./order_outside_ajax.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: "no="+no+"&brandno="+brandno+"&mode=mod",
            success: function(data){				
				if(data){
					$(".mallNm_"+no).text(data['mall_name']);
				}else{
					$(".mallNm_"+no).text("");
				}
                //alert("처리되었습니다.");
            },
            error: function (request, status, error){        
                console.log(error);
            }
        });
	}
});

$("#print_xls").click(function(){
	$("input[name='print_xls']").val("1");
    $("#searchForm").submit();
    $("input[name='print_xls']").val("0");
});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>