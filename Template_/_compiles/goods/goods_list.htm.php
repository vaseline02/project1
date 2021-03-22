<?php /* Template_ 2.2.8 2021/03/11 16:51:05 /www/html/ukk_test2/data/skin/goods/goods_list.htm 000008111 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>
<?php echo $this->define('tpl_include_file_1',"outline/search_box.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>

<?php if($GLOBALS["print_xls"]!= 1){?><button type="button" class="btn btn-success" onclick="popup('statistics_brand.php','statistics_brand','1100','900')">브랜드통계</button><?php }?>
<form id="listForm" name="listForm" method="POST">
<input type="hidden" name="mode" value="">
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
<?php if($GLOBALS["print_xls"]!= 1){?>
	<colgroup>
<?php if($GLOBALS["print_xls"]!= 1){?><col width="10px"/><!-- 브랜드 --><?php }?>
		<col width="150px"/><!-- 브랜드 -->
		<col width="100px"/><!-- 분류 -->
		<col width="70px"/><!-- 이미지-->
		<col width="150px"/><!-- 모델명1-->
		<col width="150px"/><!-- 모델명2-->
		<!--<col width="100px"/><!--판매가-->
		<col width="60px"/><!--수량-->
		<col width="100px"/>
		<col width="100px"/><!--입고예정-->
		<!--사무실-->
		<!--3자물류
		<col width="80px"/>
		<col width="90px"/>
		-->

		<col width="100px"/><!--소비자가-->
		<col width="150px" class="level7" /><!--입고이력 -->
		<col width="100px" class="level7" /><!--평균금액-->
		<col width="100px" class="level7" /><!--최고원가-->
		<col width="100px" class="level7" /><!--최소원가-->
		<col width="120px" class="level7"/><!--합계-->
<?php if($GLOBALS["h_control"]['test_hide']){?><col width="320px"/><?php }?><!--딜정보-->
		<col width="30px"/><!--촬영단계-->
		<!--<col width="100px"/>모델메모-->
		<col width="100px"/><!--악성재고-->
		<col/><!--7일-->
		<col/><!--15일-->
		<col/><!--1달-->
		<col/><!--2달-->
		<col/><!--3달-->
	
	</colgroup>
<?php }?>
	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<th>브랜드</th>
			<th>분류</th>
			<th>이미지</th>
			<th>모델명1</th>
			<th>모델명2</th>
			<!--<th>판매가</th>-->
			<th>수량</th>
			<th>가용수량</th>
			<th>입고예정<br/>주문입예</th>
			<!--
			<th>사무실</th>
			<th>3자물류</th>
			-->
			<th>소비자가</th>
			<th class="level7">입고이력</th>
			<th class="level7">원가평균</th>
<?php if($GLOBALS["h_control"]['calcu']){?><th class="level7">원가평균<br/>(부가세제외)</th><?php }?>
			<th class="level7">최고원가</th>
			<th class="level7">최소원가</th>
			<th class="level7">합계</th>
<?php if($GLOBALS["h_control"]['test_hide']){?><th>딜정보</th><?php }?>
			<th>촬영단계</th>
			<!--<th>모델메모</th>-->
			<th>악성재고</th>
			<th>7일</th>
			<th>15일</th>
			<th>1달</th>
			<th>2달</th>
			<th>3달</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td>
				<input type="checkbox" class="chk_no" name="chk_no[]" value="<?php echo $TPL_V1["no"]?>">				
			</td>
<?php }?>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["prod_type"]?></td>
			<td class="td_img" ><?php echo $TPL_V1["img_url"]?></td>
			<td class="text_type goods_detail_pop" data-goodsno="<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["goodsnm"]?></td>
			<td class="text_type"><?php echo $TPL_V1["goodsnm_sub"]?></td>
			<!--<td><?php echo number_format($TPL_V1["s_price"])?></td>-->
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td><a href="#1" onclick="popup('goods_stock_location.php?goodsno=<?php echo $TPL_V1["no"]?>','goods_stock_location','1100','900')"><?php echo number_format($TPL_V1["cur_cnt"])?></a></td>
<?php }else{?>
			<td><?php echo number_format($TPL_V1["cur_cnt"])?></td>
<?php }?>
			
			<td><?php echo number_format($TPL_V1["psb_stock"])?></td>
			<td><?php echo number_format($TPL_V1["codeno_3"])?> <?php if($TPL_V1["stand_cnt"]> 0){?><br/>(<?php echo $TPL_V1["stand_cnt"]?>)<?php }?></td>
			<!--
			<td><?php echo number_format($TPL_V1["codeno_1"])?></td>
			<td><?php echo number_format($TPL_V1["codeno_51"])?></td>
			-->
<?php if($GLOBALS["print_xls"]!= 1){?>
			<td><a href="#1" onclick="popup('goods_price_chg.php?goodsno=<?php echo $TPL_V1["no"]?>','goods_price_chg','1100','900')"><?php echo number_format($TPL_V1["consumer_price"])?></a></td>
<?php }else{?>
			<td><?php echo number_format($TPL_V1["consumer_price"])?></td>
<?php }?>
			
			<td class="text_type">
				<?php echo $TPL_V1["last_stock_date"]?><br/>
<?php if(is_array($TPL_R2=$TPL_V1["stock_list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<?php echo $TPL_V2["now_cnt"]?><?php if($TPL_V2["state"]== 0){?>(<?php echo $TPL_V2["stock_num_reg"]?>)<?php }?> / <?php echo number_format($TPL_V2["cost"])?>

					<br>
<?php }}?>

<?php if(!$TPL_V1["stock_list"]){?>0 / <?php echo number_format($TPL_V1["last_stock_cost"])?><?php }?>
				<button type="button" onclick="popup('return_stock_pop.php?no=<?php echo $TPL_V1["no"]?>','return_stock_pop','1100','900')">반품입고(<?php echo number_format($TPL_V1["return_order_cnt"])?>)</button>
			</td>
			<td><?php echo number_format($TPL_V1["stock_average"])?></td>
<?php if($GLOBALS["h_control"]['calcu']){?><td><?php echo number_format($TPL_V1["stock_average2"])?></td><?php }?>
			<td><?php echo number_format($TPL_V1["max_cost"])?></td>
			<td><?php echo number_format($TPL_V1["min_cost"])?></td>
			<td><?php echo number_format($TPL_V1["total_cost"])?></td>
<?php if($GLOBALS["h_control"]['test_hide']){?>
			<td>

<?php if(is_array($TPL_R2=$TPL_V1["deal_loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<?php echo $TPL_V2["mall_name"]?> / <?php echo number_format($TPL_V2["price"])?> / <?php echo $TPL_V2["s_date"]?>~<?php echo $TPL_V2["e_date"]?> <?php if($TPL_V2["confirm_admin_no"]> 0){?>(완)<?php }?>
					<br>
<?php }}?>
			</td>
<?php }?>
			<td><?php echo $TPL_V1["img_step"]?></td>
			<!--<td><?php echo $TPL_V1["memo"]?></td>-->
			<td><?php echo $TPL_V1["bad_stock_date"]?></td>
			<td><?php echo $TPL_V1["order_7day"]?></td>
			<td><?php echo $TPL_V1["order_15day"]?></td>
			<td><?php echo $TPL_V1["order_1month"]?></td>
			<td><?php echo $TPL_V1["order_2month"]?></td>
			<td><?php echo $TPL_V1["order_3month"]?></td>
		</tr>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">		
	</div>
	<div  class="box_right">
<?php if($GLOBALS["h_control"]['md_manager']){?><div type="button" class="btn btn-primary hiddenChk" type="button" data-mode='hidden'>숨김/해제</div><?php }?>
	</div>
</div>

<?php }?>

</form>
<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<?php }?>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$(".searchbox-default").css("display","block");
$(".s_no_limit_div").css("display","block");
$(".searchbox-goods-detail").css("display","block");

$(".hiddenChk").click(function(){
	if(!$(".chk_no").is(":checked")){
		alert("선택된 상품이 없습니다.");
		return false;
	}else{
		if(confirm("숨김/해제처리 하시겠습니까?")){
			$("#mode").val('chg_img_step');
			var formData = new FormData($("#listForm")[0]);
			$.ajax({
				type : "POST",
				url : "ajax_goods_hide.php",
				data : formData,
				processData: false,
				contentType: false,
				err : function(err) {
					alert(err.status);
				}
			}).done(function(data){
				if(data==1){
					alert('처리되었습니다.');
					location.reload();
				}else{
					alert('처리실패.');
				}
			}).fail(function(jqXHR, textStatus){
				alert( "Request failed: " + textStatus );
			});
		}
	}

});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>