<?php /* Template_ 2.2.8 2017/10/11 15:27:22 /free/home/sevenwatch/wondong/vsun_tr/data/skin/goods/goods_view.htm 000002423 */ 
$TPL_model_line_1=empty($TPL_VAR["model_line"])||!is_array($TPL_VAR["model_line"])?0:count($TPL_VAR["model_line"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<style type="text/css">


</style>
<div class="goods_wrap" >
	<div style="margin:0 auto;float:none;" class="col-xs-11 col-sm-11 col-md-8 col-lg-8 ">
		
		<div class="line_model hidden-xs hidden-sm" >
<?php if($TPL_model_line_1){foreach($TPL_VAR["model_line"] as $TPL_V1){?>
			<div style="text-align:center;">
				<div><a href="../goods/goods_view.php?goodsno=<?php echo $TPL_V1["no"]?>"><img src="<?php echo $TPL_V1["img_url"]?>" alt="" style="width:150px"></a></div>
				<div><?php echo $TPL_V1["modelstock_"]?></div>
				<div>£Ü<?php echo number_format($TPL_V1["wd_marketprice"])?></div>
			</div>
<?php }}?>
		</div>

		<p><img src="<?php echo $TPL_VAR["img_url"]?>" alt="" style="width:100%;max-width:500px"></p>
		<p style="border-bottom:1px solid #ccc;margin-top:30px;text-align:right;padding-bottom:10px;"><?php echo $TPL_VAR["modelstock_"]?>&nbsp;&nbsp;&nbsp;&nbsp;£Ü<?php echo number_format($TPL_VAR["wd_marketprice"])?></p>
		<p><img src="<?php echo $TPL_VAR["img_detail_url"]?>" alt=""  style="width:100%;max-width:700px"></p>
	</div>
</div>

<div class="line_model_bottom visible-xs pull-left">
	<div class="lm_arrow" style="background:url('../data/skin/img/m_under_bg.png') repeat-x"><img src="../data/skin/img/m_under_up_02.png" alt=""></div>
	<div class="lm_open">RELATED ITEM</div>
	<div class="lm_goods">
<?php if($TPL_model_line_1){foreach($TPL_VAR["model_line"] as $TPL_V1){?>
		<div class="lm_goods_wrap"><a href="../goods/goods_view.php?goodsno=<?php echo $TPL_V1["no"]?>"><img src="<?php echo $TPL_V1["img_url"]?>" alt="" style="width:100%"></a></div>
<?php }}?>
	</div>
</div>


<script type="text/javascript">

$(function(){
	$(".lm_arrow ,.lm_open").click(function(){

		$(".lm_goods").slideToggle("slow");
	});
	
})

$(window).scroll(function(){

	if( $(document).height() - ($(window).scrollTop() +$(window).height() ) <= 100){
		$(".line_model_bottom").removeClass("visible-xs").css("display","none");
	}else{
		$(".line_model_bottom").addClass("visible-xs").css("display","block");
	}

})

</script>
<?php $this->print_("footer",$TPL_SCP,1);?>