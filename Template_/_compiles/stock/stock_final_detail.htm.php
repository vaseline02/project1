<?php /* Template_ 2.2.8 2021/03/17 16:12:24 /www/html/ukk_test2/data/skin/stock/stock_final_detail.htm 000008115 */ 
$TPL__column_arr_1=empty($GLOBALS["column_arr"])||!is_array($GLOBALS["column_arr"])?0:count($GLOBALS["column_arr"]);
$TPL__cal_log_1=empty($GLOBALS["cal_log"])||!is_array($GLOBALS["cal_log"])?0:count($GLOBALS["cal_log"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>


<form id="calcu_form" method="post">
<input type="hidden" name="mode" value="">
<input type="hidden" name="f_group_id" value="<?php echo $GLOBALS["group_id"]?>">
<table class="table table-bordered" >
	<tr>
<?php if($TPL__column_arr_1){foreach($GLOBALS["column_arr"] as $TPL_K1=>$TPL_V1){?>
			<th><?php echo $TPL_K1?><button type="button" class="add_p" id="<?php echo $TPL_V1?>">+</button></th>	
<?php }}?>
	</tr>
	<tr>
<?php if($TPL__column_arr_1){foreach($GLOBALS["column_arr"] as $TPL_V1){?>
		<td class="text_center" id="<?php echo $TPL_V1?>_td">

<?php if($GLOBALS["d_arr"][$TPL_V1]){?>
<?php if(is_array($TPL_R2=($GLOBALS["d_arr"][$TPL_V1]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<input type="text" name="<?php echo $TPL_V1?>[]" value="<?php echo $TPL_V2?>"><br/>
<?php }}?>
<?php }else{?>
			<input type="text" name="<?php echo $TPL_V1?>[]" value=""><br/>
			<input type="text" name="<?php echo $TPL_V1?>[]" value=""><br/>
			<input type="text" name="<?php echo $TPL_V1?>[]" value=""><br/>
<?php }?>
		</td>
<?php }}?>
	</tr>
	<tr>
		<th colspan=<?php echo $TPL__column_arr_1?>></th>	</tr>
	<tr >
<?php if($TPL__column_arr_1){foreach($GLOBALS["column_arr"] as $TPL_V1){?>
		<td class="text_center" id="tt_<?php echo $TPL_V1?>">
			
<?php if($TPL_V1=='send_rate'){?>
			
			<?php echo number_format($GLOBALS["base"]['avg_rate'], 1)?>

<?php }else{?>
			<?php echo number_format($GLOBALS["base"][$TPL_V1])?>

<?php }?>
<?php if($TPL_V1=='send_money'){?>
				<div>(입예송금외화 : <?php echo number_format($GLOBALS["sum_cost"])?>)</div>
<?php }?>
		</td>
<?php }}?>
	</tr>
</table>

<table class="display display_s" data-height="250" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
	<tr>
<?php if($TPL__column_arr_1){foreach($GLOBALS["column_arr"] as $TPL_K1=>$TPL_V1){?>
			<th><?php echo $TPL_K1?></th>	
<?php }}?>
		<th>메모</th>
		<th>등록일</th>
	</tr>
	</thead>
<?php if($TPL__cal_log_1){foreach($GLOBALS["cal_log"] as $TPL_V1){?>
	<tr>
<?php if(is_array($TPL_R2=($GLOBALS["column_arr"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<td><?php echo str_replace("|","<br/>",$TPL_V1[$TPL_V2])?></td>
<?php }}?>
		<td><?php echo $TPL_V1["memo"]?></td>
		<td><?php echo $TPL_V1["name"]?> ( <?php echo $TPL_V1["reg_date"]?> )</td>
	</tr>
<?php }}?>
</table>


<div  class="text_right">
		
	<input type="text" name="calcu_memo" >
	<button type="button" class="btn btn-success confirmCheck" data-mode='calcu' data-mess="<?php if($GLOBALS["comp_yn"]=='n'){?>등록<?php }else{?>수정<?php }?>"><?php if($GLOBALS["comp_yn"]=='n'){?>등록<?php }else{?>수정<?php }?></button>
</div>
</form>


<form method="post" name="listForm" id="listForm">
<input type="hidden" name="mode" value="">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_K1=>$TPL_V1){?>
<div class="" style="clear:both">

<hr>
<table class="table table-bordered" >
	<tr>
		<th style="width:200px;">통관그룹번호</th>
		<td><?php echo $GLOBALS["_GET"]['group_id']?></td>
	</tr>
</table>

<!--<div class="table_title"><?php echo $GLOBALS["title"][$TPL_K1]?> ( <?php echo $TPL_K1?> ) - <?php if($GLOBALS["pass_date"]){?>통관일 : <?php echo $GLOBALS["pass_date"]?><?php }?> <?php if($GLOBALS["license_date"]){?> 면장등록일 : <?php echo $GLOBALS["license_date"]?><?php }?></div>-->
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th>
<?php }?>
			<th>브랜드</th>
			<th>분류</th>
<?php if($GLOBALS["print_xls"]!= 1){?><th>이미지</th><?php }?>
			<th>모델명1</th>
			<th>원산지</th>
			<th>원가</th>
			<th>환율</th>
			<th>관세</th>
			<th>수수료</th>
			<th>부대비용</th>
			<th>입고된수량</th>
			<th>최종원가</th>
			<th>최종원가<br/>(부가세제외)</th>						
			<th>등록일</th>
		</tr>
	</thead>
	<tbody>	
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<tr>	
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
			<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V2["no"]?>" >
			</td>
<?php }?>
			<td><?php echo $TPL_V2["brandnm"]?></td>
			<td><?php echo $TPL_V2["catenm"]?></td>
<?php if($GLOBALS["print_xls"]!= 1){?><td class="td_img"><?php echo $TPL_V2["img_url"]?></td><?php }?>
			<td><?php echo $TPL_V2["goodsnm"]?></td>
			<td><?php echo $TPL_V2["origin"]?></td>
			<td><?php echo number_format($TPL_V2["cost_std"])?></td>
			<td><?php echo number_format($TPL_V2["rate"], 1)?></td>
			<td><?php echo $TPL_V2["duty_per"]?>%</td>
			<td><?php echo $TPL_V2["charge"]?>%</td>
			<td><?php echo $TPL_V2["extra_expense"]?>%</td>
			<td class="stock_num"><?php echo number_format($TPL_V2["stock_num"])?></td>
			<td>
				<?php echo $GLOBALS["ea_price"][$TPL_V2["goodsno"]]?>

				<input type="hidden" name="ea_price[<?php echo $TPL_V2["no"]?>]" value="<?php echo $GLOBALS["ea_price"][$TPL_V2["goodsno"]]?>">
				<input type="hidden" name="ea_price_ori[<?php echo $TPL_V2["no"]?>]" value="<?php echo $GLOBALS["ea_price_ori"][$TPL_V2["goodsno"]]?>">
			</td>
			<td><?php echo $GLOBALS["ea_price_ori"][$TPL_V2["goodsno"]]?></td>
			<td><?php echo $TPL_V2["reg_date"]?></td>	
		</tr>
<?php }}?>
	</tbody>
</table>
</div>
<?php }}?>



<?php if($GLOBALS["print_xls"]!= 1){?>

<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<div class="bottom_btn_box">
	<div class="box_left">		
		<button type="button" class="btn btn-danger confirmCheck" data-mode='del' data-mess="삭제">삭제</button> |
		<input type="text" name="mod_f_group_id" id="mod_f_group_id"> <button type="button" class="btn btn-success confirmCheck" data-mode='mod' data-mess="통관그룹변경">통관그룹변경</button>

	</div>
	<div  class="box_right">	
		<button type="button" class="btn btn-primary confirmCheck" data-mode='comp' data-mess="<?php if($GLOBALS["comp_yn"]=='n'){?>등록<?php }else{?>재등록<?php }?>"><?php if($GLOBALS["comp_yn"]=='n'){?>등록<?php }else{?>재등록<?php }?></button>
	</div>
</div>
<fieldset class="page_field_info">
  <legend>참 고</legend>
  <ul>
	
  </ul>
</fieldset>

<?php }?>

</form>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";


$(function(){

	$(".add_p").click(function(){
		var this_id=$(this).attr("id");
		var html='';
		
		html+="<input type='text' name='"+this_id+"[]' value=''><br/>";
		$("#"+this_id+"_td").append(html);
	});

	$(".confirmCheck").click(function(){
		var mode=$(this).data("mode");
		var mess=$(this).data("mess");
		var form_nm='';

		if(mode=='del' || mode=='mod'){

			if( $(".chk_no:checked").length <=0 ){
				alert('상품을 선택해주세요.');
				return;
			}
		}

		if(mode=='mod'){

			if($("#mod_f_group_id").val()==''){
				alert('통관그룹코드를 등록해주세요.');
				$("#mod_f_group_id").focus();
				return;
			}
		}

		
		if(mode=='calcu'){
			form_nm=mode+'_form';
		}else{
			form_nm='listForm';
		}


		if(confirm(mess+" 하시겠습니까?")){
			$("input[name='mode']").val(mode);
			$("#"+form_nm).submit();	
		}


	});


});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>