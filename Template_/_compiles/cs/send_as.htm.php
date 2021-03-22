<?php /* Template_ 2.2.8 2020/10/12 15:36:24 /www/html/ukk_test/data/skin/cs/send_as.htm 000008717 */ 
$TPL__cfg_ing_type_1=empty($GLOBALS["cfg_ing_type"])||!is_array($GLOBALS["cfg_ing_type"])?0:count($GLOBALS["cfg_ing_type"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>
<?php echo $this->define('tpl_include_file_1',"cs/send_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>


<style>
.search_td_width{width:380px;}
.mallLabel{ display:inline-block; width:200px; line-height:23px;}
#nav_div3_c a:after{width:90%}


</style>

<?php if($GLOBALS["print_xls"]!= 1){?>
<form method="get">
	<table class="table table-bordered" >

		<tr>
			<th>입고일</th>
			<td>
			<input type="text" name="s_date" id="s_date" class="datepicker_common" autocomplete="off" value="<?php echo $GLOBALS["s_date_value"]?>"> ~ 
			<input type="text" name="e_date" id="e_date" class="datepicker_common" autocomplete="off" value="<?php echo $GLOBALS["e_date_value"]?>">
			<div style='padding-top:5px'>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='0' data-type='day'>오늘</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='7' data-type='day'>7일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='15' data-type='day'>15일</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='month'>1개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='3' data-type='month'>3개월</span>
				<span type="button" class="btn btn-sm btn-warning dayChange" data-int='1' data-type='year'>1년</span>
			</div>
			</td>
			<th>주문번호</th>
			<td><input type="text" name="s_ordno" value="<?php echo $_GET['s_ordno']?>"></td>
			
			
		</tr>
		<tr>			
			<th>모델명</th>
			<td><input type="text" name="s_goodsnm" value="<?php echo $_GET['s_goodsnm']?>"></td>
			<th>송장번호</th>
			<td><input type="text" name="s_invoice" value="<?php echo $_GET['s_invoice']?>"></td>
		</tr>
		<tr>
			
			<th>고객명</th>
			<td class="search_td_width"><input type="text" name="s_receiver" value="<?php echo $_GET['s_receiver']?>"></td>
			<th>연락처</th>
			<td class="search_td_width"><input type="text" name="s_mobile" value="<?php echo $_GET['s_mobile']?>"></td>
		</tr>
		</tr>
			<th>작성자</th>
			<td><input type="text" name="s_admin" value="<?php echo $_GET['s_admin']?>"></td>
			<th></th>
			<td></td>

			<!-- <th>진행상태</th>
			<td>
				<select name="s_ing_type">
					<option value="">선택</option>
<?php if($TPL__cfg_ing_type_1){foreach($GLOBALS["cfg_ing_type"] as $TPL_K1=>$TPL_V1){?>
					<option value=<?php echo $TPL_K1?> <?php echo $GLOBALS["selected"]['ing_type'][$TPL_K1]?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</td>
			 -->
		</tr>
	</table>
	<center>
		<button class="btn btn-primary" id="">검 색</button>
	</center>
</form>

<?php }?>
<div class="table_title">일반접수</div>
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th>접수번호</th>
			<th>접수자</th>
			<th data-orderable="false">구매자</th>
			<th data-orderable="false">연락처</th>
			<th data-orderable="false">주소</th>
			<th>진행단계</th>
			<th data-orderable="false">주문번호</th>
			<th>브랜드</th>
			<th>모델명</th>
			<th>비용</th>
			<th>실비</th>
			<th>진행업체명</th>
			<th>입고일</th>
			<th>출고일</th>
			<th>최초작성자</th>
			<th>마지막수정자</th>
			<th>수정시간</th>
			<th data-orderable="false"></th>
		</tr>
	</thead>	
	<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["loop"]['order'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<tr>			
			<td><?php echo $TPL_V1["no"]?></td>
			<td><?php echo $TPL_V1["receipt_name"]?></td>
			<td><?php echo $TPL_V1["receiver"]?></td>
			<td><?php echo $TPL_V1["mobile"]?></td>
			<td>[<?php echo $TPL_V1["zipcode"]?>] <?php echo $TPL_V1["address"]?></td>
			<td><?php echo $GLOBALS["cfg_as_status"][$TPL_V1["as_status"]]?></td>			
			<td><?php echo $TPL_V1["order_no"]?></td>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo number_format($TPL_V1["customer_cost"])?>원</td>
			<td><?php echo number_format($TPL_V1["real_cost"])?>원</td>
			<td><?php echo $TPL_V1["progress_company"]?></td>
			<td><?php echo $TPL_V1["in_regdate"]?></td>
			<td><?php echo $TPL_V1["out_regdate"]?></td>
			<td><?php if($TPL_V1["admin_no"]){?><?php echo $TPL_V1["name"]?><br>(<?php echo $TPL_V1["id"]?>)<?php }?></td>
			<td><?php if($TPL_V1["mod_admin_no"]){?><?php echo $TPL_V1["mod_name"]?><br>(<?php echo $TPL_V1["mod_id"]?>)<?php }?></td>
			<td><?php if($TPL_V1["mod_admin_no"]){?><?php echo $TPL_V1["mod_reg_date"]?><?php }?></td>
			<td>
				<div><button type="button" class="btn btn-sm btn-warning" onclick="popup('as_view.php?as_no=<?php echo $TPL_V1["no"]?>','','1100','900')">상세</button></div>
<?php if($TPL_V1["as_status"]=='5'){?>
				<div style="padding-top: 5px;"><button type="button" class="btn btn-sm btn-warning" onclick="popup('as_document.php?as_no=<?php echo $TPL_V1["no"]?>','','1100','900')">문서출력</button></div>
<?php }?>
            </td>
		</tr>
<?php }}?>
	</tbody>
</table>
<hr>
<div class="table_title">수기접수</div>
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>			
			<th>접수번호</th>
			<th>접수자</th>
			<th data-orderable="false">구매자</th>
			<th data-orderable="false">연락처</th>
			<th data-orderable="false">주소</th>
			<th>진행단계</th>
			<th data-orderable="false">주문번호</th>
			<th>브랜드</th>
			<th>모델명</th>
			<th>비용</th>
			<th>실비</th>
			<th>진행업체명</th>
			<th>입고일</th>
			<th>출고일</th>
			<th>최초작성자</th>
			<th>마지막수정자</th>
			<th>수정시간</th>
			<th data-orderable="false"></th>
		</tr>
	</thead>	
	<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["loop"]['hand'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<tr>			
			<td><?php echo $TPL_V1["no"]?></td>
			<td><?php echo $TPL_V1["receipt_name"]?></td>
			<td><?php echo $TPL_V1["receiver"]?></td>
			<td><?php echo $TPL_V1["mobile"]?></td>
			<td>[<?php echo $TPL_V1["zipcode"]?>] <?php echo $TPL_V1["address"]?></td>
			<td><?php echo $GLOBALS["cfg_as_status"][$TPL_V1["as_status"]]?></td>			
			<td><?php echo $TPL_V1["order_no"]?></td>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo number_format($TPL_V1["customer_cost"])?>원</td>
			<td><?php echo number_format($TPL_V1["real_cost"])?>원</td>
			<td><?php echo $TPL_V1["progress_company"]?></td>
			<td><?php echo $TPL_V1["in_regdate"]?></td>
			<td><?php echo $TPL_V1["out_regdate"]?></td>
			<td><?php if($TPL_V1["admin_no"]){?><?php echo $TPL_V1["name"]?><br>(<?php echo $TPL_V1["id"]?>)<?php }?></td>
			<td><?php if($TPL_V1["mod_admin_no"]){?><?php echo $TPL_V1["mod_name"]?><br>(<?php echo $TPL_V1["mod_id"]?>)<?php }?></td>
			<td><?php if($TPL_V1["mod_admin_no"]){?><?php echo $TPL_V1["mod_reg_date"]?><?php }?></td>
			<td>
                <div><button type="button" class="btn btn-sm btn-warning" onclick="popup('as_view.php?as_no=<?php echo $TPL_V1["no"]?>','','1100','900')">상세</button></div>
<?php if($TPL_V1["as_status"]=='5'){?>
				<div style="padding-top: 5px;"><button type="button" class="btn btn-sm btn-warning" onclick="popup('as_document.php?as_no=<?php echo $TPL_V1["no"]?>','','1100','900')">문서출력</button></div>
<?php }?>
            </td>
		</tr>
<?php }}?>
	</tbody>
</table>
<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<?php }?>


<form method="POST" name="indbForm">
	<input type="hidden" name="mode" value="del">
	<input type="hidden" name="no">
	<input type="hidden" name="returnUrl" value=<?php echo $_SERVER['REQUEST_URI']?>>
</form>

<script>
$("#nav_div3_c").addClass('active');
document.title="<?php echo $GLOBALS["page_title"]?>";


$(".receiptDel").click(function(){
	if(confirm("삭제하시겠습니까?")){
		$("input[name='no']").val($(this).data('no'));
		$("form[name='indbForm']").submit();	
	}

});
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>