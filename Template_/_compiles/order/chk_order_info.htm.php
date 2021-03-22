<?php /* Template_ 2.2.8 2021/03/17 16:23:39 /www/html/ukk_test2/data/skin/order/chk_order_info.htm 000009190 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
<h1><?php echo $GLOBALS["page_title"]?></h1>
<hr>
<?php echo $this->define('tpl_include_file_1',"order/order_nav.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<?php }?>

<?php if($GLOBALS["print_xls"]== 1){?>
<div style="color:red">※엑셀업로드시 주문고유번호는 삭제하시면안됩니다.<br>※엑셀업로드시 옵션명, 수량, 결제가만 업데이트됩니다.</div>
<?php }?>
<?php if($GLOBALS["print_xls"]!= 1){?>
<form enctype="multipart/form-data" method="post">
<table class="table table-bordered" >
    <tr>
        <th>파일</th>
        <td>
			<input type="file" name="excelFile[]" required/><button class="btn btn-primary">업데이트</button>
			<button type="button" class="btn btn-success" id="print_xls">엑셀 다운로드</button>
		</td>
    </tr>
</table>
</form>
<button class="btn btn-primary" type="button" onclick="popup('order_outside_mat.php','order_outside_mat','1100','900')">상품매칭정보</button>
<?php }?>
<form method="post" id="main_form">
<input type="hidden" name="mode" id="mode">

<!--<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">-->
<table id="" class="display display_dt" data-height="740" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">

	<?php echo $this->define('tpl_include_file_2',"outline/table_width_order.htm")?> <?php $this->print_("tpl_include_file_2",$TPL_SCP,1);?>

	<thead>		
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?>
				<th class="sorting_disabled"><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>
<?php }else{?>
				<th style="color:red">주문고유번호</th>
<?php }?>
			<?php echo $this->define('tpl_include_file_3',"order/_order_cols.htm")?> <?php $this->print_("tpl_include_file_3",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?>
			<th></th>
<?php }?>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
				<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>">
				<input type="hidden" name="hid_ordno[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["ordno"]?>">
				<input type="hidden" name="hid_bundle[<?php echo $TPL_V1["no"]?>]" value="<?php echo $TPL_V1["bundle"]?>">
				<input type="hidden" name="chk_goodsnm[<?php echo $TPL_V1["no"]?>]" id="chk_goodsnm[<?php echo $TPL_V1["no"]?>]" value="0">
				
			</td>
<?php }else{?>
			<td><?php echo $TPL_V1["no"]?></td>
<?php }?>
			<td>
				<?php echo $TPL_V1["mall_name"]?>

				<br/><?php echo $TPL_V1["upload_form_type"]?>

			</td>
			<td style='mso-number-format:"\@";'><?php echo $TPL_V1["ordno"]?> <?php echo $TPL_V1["order_type"]?></td>
			<td style='mso-number-format:"\@";'><?php echo $TPL_V1["mall_goodsnm"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
				<textarea name="mod_goodsnm[<?php echo $TPL_V1["no"]?>]" id="" cols="30" rows="3" class="model_check" data-no="<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["goodsnm"]?></textarea>
				<div class="model_notice_<?php echo $TPL_V1["no"]?>" style="color: red;"></div>
			</td>
			<td><input type="text" class="order_num auto_save" data-colname="order_num" value="<?php echo $TPL_V1["order_num"]?>" size='3'></td>
			<td><input type="text" class="order_price auto_save" data-colname="settle_price" value="<?php echo $TPL_V1["settle_price"]?>"></td>
<?php }else{?>
			<td style='mso-number-format:"\@";'><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["order_num"]?></td>
			<td><?php echo $TPL_V1["settle_price"]?></td>
<?php }?>
			<td><?php echo $TPL_V1["buyer"]?><br/><?php echo $TPL_V1["receiver"]?></td>
			<td><?php echo $TPL_V1["phone"]?><br/><?php echo $TPL_V1["mobile"]?></td>
			<td><?php echo $TPL_V1["zipcode"]?> <?php echo $TPL_V1["address"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td style="color:<?php echo $TPL_V1["bundle_color"]?>"><?php echo $TPL_V1["bundle"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
				<button type="button" class="btn btn-sm btn-warning mod" onclick="popup('order_mod_pop.php?no=<?php echo $TPL_V1["no"]?>','order_mod_pop','1000','700')">수정</button>
			</td>
<?php }?>
		</tr>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">
		<button type="button" class="btn btn-danger btn_submit" id="hold_order">보류이동</button>
		<button type="button" class="btn btn-danger btn_submit" id="del_cp_order">주문삭제</button>
		<button type="button" class="btn btn-success btn_submit" id="cp_order">주문복제</button>
	</div>
	<div  class="box_right">
		<button type="button" class="btn btn-warning btn_submit" id="outside_deli">외부업체 발송</button>
		<button type="button" class="btn btn-primary btn_submit" id="goodsnm_chg">상품명 변경등록</button>
		<br>
		<br>
		<!--<button type="button" class="btn btn-primary auto_confirm" id="auto_confirm">우선순위 자동 주문처리</button> 품절등록모델을 픽스로 변경하여 사용불가-->
	</div>
</div>

<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	<li>모델명이 등록되면 아직 처리되지 않은(재고가 빠지지않은)주문수량까지 포함하여 재고부족주문 재계산.(현재 정상발송으로 분류된 주문이 재고부족주문으로 이동될 수 있음)</li>
	<li><button type="button" class="btn btn-warning ">외부 발송</button> -외부업체 상품발송. 처리시 묶음주문이라면 묶음상품에서 제외됨.</li>
	<li><button type="button" class="btn btn-success" id="cp_order">주문복제</button> -옵션분리를 위해서 복제. 묶음갯수가 하나 증가됨 </li>
  </ul>
</fieldset>

<?php }?>
</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";

$(function(){
<?php if($GLOBALS["_GET"]['gubunb']== 0){?>
		$("#nav_div1-1").addClass('active');
<?php }else{?>
		$("#nav_div1-2").addClass('active');
<?php }?>
	

	$(".model_check").keyup(function (){
		var no=$(this).data('no');
		var modelName=$(this).val();
		$.ajax({
            url: "./chk_model.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: "model_name="+modelName,
            success: function(data){
				if(data=='N'){
					$(".model_notice_"+no).text('상품이 존재하지않습니다.');
					$("input[name='chk_goodsnm["+no+"]']").val("1");
				}else{
					$(".model_notice_"+no).text('');
					$("input[name='chk_goodsnm["+no+"]']").val("0");
				}
            },
            error: function (request, status, error){        
                console.log(error);
            }
		});
	});
	
	$(".auto_save").focusout(function(){			
		var colname=$(this).data("colname");
		var this_val=$(this).val();
		var this_no=$(this).closest("tr").find(".chk_no").val();

		$.post("../ajax/db_update.php",{dbname:"order_list",target_colname:"no",target_data:this_no,colname:colname,colname_data:this_val},function(data){
			if(data!='1'){
				alert(data);
			}
		});
	});


	$(".auto_confirm").click(function(){
		
		if(confirm('처리하시겠습니까?')){
			var this_id = $(this).attr("id");
			$("#mode").val(this_id);
			$("#main_form").submit();
		}
	});

	$(".btn_submit").click(function(){
		
		var this_id = $(this).attr("id");
		var msg='';

		if( $(".chk_no:checked").length <=0 ){
			alert('주문을 선택해주세요.');
			return;
		}
		
		if(this_id=='outside_deli'){
			msg='[외부발송]';
		}else if(this_id=='goodsnm_chg'){
			msg='[상품명변경]';
		}else if(this_id=='cp_order'){
			msg='[주문복제]';
		}else if(this_id=='del_cp_order'){
			msg='[복제주문 삭제]';
		}else if(this_id=='hold_order'){
			var goodsnmcnk=0;
			$(".chk_no").each(function(index, item){
				if($(item).is(":checked")){              
					//교환이거나 반품일경우이고 불량접수일경우 체크
					if(!$("textarea[name='mod_goodsnm["+$(item).val()+"]']").val()) goodsnmcnk++;
					if($("input[name='chk_goodsnm["+$(item).val()+"]']").val()=="1")  goodsnmcnk++;
				}
			});

			if(goodsnmcnk>0){
				alert("존재하지않는 상품이 선택되어있습니다.");
				return false;
			}

			msg='[보류이동]';
		}


		if(confirm(msg+' 처리하시겠습니까?')){
			
			$("#mode").val(this_id);
			$("#main_form").submit();
		}
	});


	$("#print_xls").click(function(){
		$("input[name='print_xls']").val("1");
		$("#order_search_form").submit();
		$("input[name='print_xls']").val("0");
	});
	

});


</script>
<?php $this->print_("footer",$TPL_SCP,1);?>