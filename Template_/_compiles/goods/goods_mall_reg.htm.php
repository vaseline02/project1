<?php /* Template_ 2.2.8 2021/03/15 17:00:00 /www/html/ukk_test2/data/skin/goods/goods_mall_reg.htm 000003608 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<div class="col-lg-12 statusbox-header"><h3><?php echo $GLOBALS["page_title"]?><span></span></h3></div>
<?php echo $this->define('tpl_include_file_1',"outline/search_box.htm")?> <?php $this->print_("tpl_include_file_1",$TPL_SCP,1);?>



<style>
.prop_td{width:300px;text-align:left !important;}
.prop_ul{height:80px;overflow:auto}
.impo_img{height:80px;}
</style>
<form id="listForm" name="listForm" method="POST">
<input type="hidden" name="mode" id="mode" value="">
<table id="" class="display display_dt" style="width:100%" border="<?php echo $GLOBALS["xls_border"]?>">
	<thead>
		<tr>
<?php if($GLOBALS["print_xls"]!= 1){?><th><input type="checkbox" onclick="chk_all_box(this,'chk_no')"></th><?php }?>
			<th>품번코드</th>
			<th>모델명</th>
			<th>상품명</th>
			<th>브랜드</th>
			<th>사방넷케타고리</th>
			<th>원산지</th>
			<th>소비자가</th>
			<th>가용수량</th>
			<th>이미지</th>
			<th>수입신고번호</th>
			<th>면장이미지</th>
			<th >상품정보고시</th>
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
			<td></td>
			<td class="text_type goods_detail_pop" data-goodsno="<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["goodsnm"]?></td>
			<td><?php echo $TPL_V1["mall_gnm"]?></td>
			<td><?php echo $TPL_V1["brandnm"]?></td>
			<td><?php echo $TPL_V1["sabang_cate"]?></td>
			<td><?php echo $TPL_V1["origin"]?></td>
			<td><?php echo $TPL_V1["consumer_price"]?></td>
			<td><?php echo number_format($TPL_V1["psb_stock"])?></td>
			<td class="td_img" ><?php echo $TPL_V1["img_url"]?></td>
			<td><?php echo $TPL_V1["import_no"]?></td>
			<td><img src="<?php echo $TPL_V1["invoice_img"]?>" class="impo_img"></td>
			<td class="prop_td">
			<ul class="prop_ul">
<?php if(is_array($TPL_R2=$TPL_V1["prop_val"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
				<li>-<?php echo $TPL_K2?> : <?php echo $TPL_V2?></li>
<?php }}?>
			</ul>
			
			
			</td>
			
		</tr>
<?php }}?>
	</tbody>
</table>

<?php if($GLOBALS["print_xls"]!= 1){?>

<div class="bottom_btn_box">
	<div class="box_left">		
	</div>
	<div  class="box_right">
		<div type="button" class="btn btn-primary sabang_reg" type="button" data-mode='sabang'>사방넷 전송</div>
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

$(".sabang_reg").click(function(){
	if(!$(".chk_no").is(":checked")){
		alert("선택된 상품이 없습니다.");
		return false;
	}else{
		if(confirm("사방넷 전송")){
			$("#mode").val('direct');
			$("#listForm").attr("action","../admin/sabang_api_make_xml_goods.php");
			$("#listForm").submit();
			$("#listForm").attr("action","");
		}
	}

});

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>