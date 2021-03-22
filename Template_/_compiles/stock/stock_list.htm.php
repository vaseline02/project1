<?php /* Template_ 2.2.8 2020/07/21 10:14:32 /www/html/ukk_test2/data/skin/stock/stock_list.htm 000002561 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>



<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><!--<span>Customer Service Management</span>--></h3></div>

<?php echo $this->define('tpl_include_file_1',"outline/search_box.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>


<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<colgroup>
		<col width="150px"/><!-- 브랜드 -->
		<col width="150px"/><!-- 분류 -->
		<col width=""/><!-- 이미지-->
		<col width=""/><!-- 모델명1-->
		<col width="150px"/><!--등록원가-->
		<col width="150px"/><!--최종원가-->
		<col width="80px"/><!--조정배율-->

		<col width="100px"/><!--입고수량-->
		<col width="100px"/><!--거래처-->
		<col width="200px"/><!--memo-->
		<col width="100px"/><!--등록사용자-->
		<col width="200px"/><!--등록일-->		
	</colgroup>
	<thead>
		<tr>
			<th>브랜드</th>
			<th>분류</th>
			<th>이미지</th>
			<th>모델명</th>
			<th>최종원가</th>
			<th>등록원가</th>
			<th>조정배율</th>
			<th>입고수량</th>
			<th>거래처</th>
			<th>메모</th>
			<th>등록ID</th>
			<th>등록일</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="text_center">
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["catenm"]?></td>
			<td class="td_img"><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo number_format($TPL_V1["cost"], 2)?></td>
			<td><?php echo number_format($TPL_V1["cost_ori"], 2)?></td>
			<td><?php echo $TPL_V1["cost_mod"]?></td>
			<td><?php echo $TPL_V1["stock_num"]?></td>
			<td><?php echo $TPL_V1["customer"]?></td>
			<td><?php echo $TPL_V1["memo"]?></td>
			<td><?php echo $TPL_V1["admin_name"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
		</tr>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>
<div><?php echo $TPL_VAR["pg"]->page['navi']?> 총 데이터 :<?php echo number_format($TPL_VAR["pg"]->recode['total'])?></div>
<?php }?>
<script>
document.title="<?php echo $GLOBALS["page_title"]?>";
$(".searchbox-default").css("display","block");
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>