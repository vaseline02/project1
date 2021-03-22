<?php /* Template_ 2.2.8 2021/03/09 11:16:27 /www/html/ukk_test2/data/skin/goods/stock_quick_list.htm 000005981 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL__codedata_1=empty($GLOBALS["codedata"])||!is_array($GLOBALS["codedata"])?0:count($GLOBALS["codedata"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form enctype="multipart/form-data" method="post" onsubmit="return chkform();">
<table class="table table-bordered" >
    <tr>
        <th>엑셀업로드</th>
        <td width=40%>
			<input type="file" name="excelFile[]" required/><button class="btn btn-sm btn-primary" >업로드</button>
			<button type="button" class="btn btn-sm btn-success" onclick="location.href='../xls_file/quick_upload.xls'">양식 다운로드</button>
		</td>
		
        <td style="text-align:right">
			<div class="btn btn-sm btn-primary" onclick="popup('stock_quick_reg.php','','1100','900')">등록하기</div>			
			<button type="button" class="btn btn-sm btn-success" id="quick_print_xls">선택값 엑셀 다운로드</button>
		</td>
		
    </tr>
</table>
</form>
<?php }?>


<!-- <div class="table_title" >일반접수</div> -->
<form method="post" id="quickForm" name="quickForm">
<input type="hidden" name="mode" value="confirm">
<input type="hidden" name="no" value="">
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<colgroup>
		<col width="3%" />
		<col width="20%"/>
		<col width="3%"/>
		<col width="20%"/>
		<col width="5%"/>
		<col width="5%"/>
		<col width="5%"/>
		<col width="5%"/>
		<col width="10%"/>
		<col width="5%"/>
		<col width="5%"/>
		<col width="10%" />

	</colgroup>
	<thead>
		<tr>			
			<th data-orderable="false"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>			
			<th>모델명</th>
			<th>수량</th>
			<th data-orderable="false">사유</th>
			<th>차감위치</th>
			<th>최초작성자</th>
			<th>등록일</th>
			<th>요청자</th>
			<th>요청일</th>
			<th>등록위치</th>
			<th>수령확인자</th>
			<th>수령확인일</th>
			<!--<th data-orderable="false"></th>-->
		</tr>
	</thead>	
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>			
			<td>				
<?php if(!$TPL_V1["confirm_admin_no"]){?><input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>" data-request="<?php echo $TPL_V1["request_admin_no"]?>"><?php }?>
			</td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["quantity"]?></td>
			<td><?php if($TPL_V1["state"]){?><?php if($TPL_V1["state"]=="1"){?><font color = "red">[홀드]</font><?php }else{?><font color = "blue">[요청]</font><?php }?> <?php }?><?php echo $TPL_V1["memo"]?></td>
			<td><?php echo $TPL_V1["s_move"]?></td>
			<td><?php echo $TPL_V1["admin_name"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>			
			<td><?php echo $TPL_V1["request_admin_name"]?></td>			
			<td><?php echo $TPL_V1["request_date"]?></td>			
			<td><?php echo $TPL_V1["e_move"]?></td>
			<td><?php echo $TPL_V1["confirm_admin_name"]?></td>
			<td><?php echo $TPL_V1["confirm_admin_date"]?></td>
			<!--
			<td>
<?php if(!$TPL_V1["confirm_admin_no"]){?><div><button type="button" class="btn btn-sm btn-warning confirmCheck" data-no="<?php echo $TPL_V1["no"]?>" data-mode="confirm">수령확인</button></div><?php }?>
			</td>-->
			
		</tr>
<?php }}?>
	</tbody>
</table>


<div class="bottom_btn_box">
	<div class="box_left">		
		<div class="btn btn-sm btn-primary confirmCheck" data-mode='request_confirm' data-name="요청">요청</div>
	</div>
<?php if($GLOBALS["h_control"]['order']){?>
	<div  class="box_right">		
		<select name="place_code" id="" class="place_code" >
<?php if($TPL__codedata_1){foreach($GLOBALS["codedata"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["cd"]?></option>
<?php }}?>
		</select>
		<div class="btn btn-sm btn-primary confirmCheck" data-mode='v_confirm' data-name="수령확인">수령확인</div>
		
	</div>
<?php }?>
</div>

</form>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<?php }?>

<script>

document.title="<?php echo $GLOBALS["page_title"]?>";
$("#nav_div<?php echo $_GET['s_as_status']?>").addClass('active');

$(".confirmCheck").click(function(){
	var requestChk=0;
	if(($(this).data('mode')=='v_confirm' || $(this).data('mode')=='request_confirm') && !$(".chk_no").is(":checked")){
		alert("처리할 접수건이 선택되있지않습니다.");
		return false;
	}

	if($(this).data('mode')=='v_confirm'){
		$(".chk_no").each(function(index, item){
			if($(item).is(":checked")){  				
				if(!$(this).data('request')){
					requestChk++;					
				}
			}
		});
	}
	if(requestChk){
		alert("요청처리되지않은 접수건이 있습니다.");
		return false;
	}

	if(confirm($(this).data('name')+" 하시겠습니까?")){
		$("input[name='no']").val($(this).data('no'));
		$("input[name='mode']").val($(this).data('mode'));
		$("form[name='quickForm']").submit();	
	}

});

/*인클루드 되어있는 페이지의 체크박스 값을 가지고 넘어가야 하기때문에 메인폼을 포스트로 날림.*/ 
$("#quick_print_xls").click(function(){
		
	var file_loc='';
	
	file_loc="stock_quick_excel.php";	

	var chk_len=$(".chk_no:checked").length;
	if( chk_len<=0 ){
		alert('출력할 항목을 선택해주세요.');
		return false;
	}else{		
		var html='<div id="div_excel_search_val">';
		html+='<input type="hidden" name="print_xls" value="1" >';
		html+='</div>';	
		$("#quickForm").append(html);
		
		$("#quickForm").attr("action",file_loc);
		$("#quickForm").submit();
		$("#quickForm").attr("action","");
		$("#div_excel_search_val").remove();
	}

});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>