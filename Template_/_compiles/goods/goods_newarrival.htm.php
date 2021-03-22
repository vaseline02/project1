<?php /* Template_ 2.2.8 2019/05/25 18:45:47 /free/home/sevenwatch/wondong/ukk/data/skin/goods/goods_newarrival.htm 000002202 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<style type="text/css">

</style>

<div class="product_wrap" style="background-color:#fff;padding:0px 20px;">
<div class="title_top">WHAT'S NEW</div>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<div class="product_layer col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<div class="product_layer_inner">
			<div>
			<a href="../goods/goods_view.php?goodsno=<?php echo $TPL_V1["no"]?>">
<?php if($TPL_VAR["is_mobile"]){?>
					<img src="<?php echo $TPL_V1["img_url"]?>" alt="" style="width:70%">
<?php }else{?>
					<img class="lazy" src="../data/skin/img/white.jpg" data-original="<?php echo $TPL_V1["img_url"]?>"  width="70%">
<?php }?>

			</a>
			</div>
			<div class="list_model_info">
				<div style="text-align:<?php if($TPL_VAR["is_mobile"]){?>center<?php }else{?>center<?php }?>;margin:auto;width:<?php if($TPL_VAR["is_mobile"]){?>95%<?php }else{?>70%<?php }?>">
					<p><?php echo $TPL_V1["modelstock_"]?></p>
					<p><?php if($TPL_V1["balance"]<= 0){?><img src="../data/skin/img/soldout_price.jpg" alt=""><?php }else{?>KRW <?php echo number_format($TPL_V1["wd_marketprice"])?><?php }?></p>
					<!--
					<p><strong><?php echo $TPL_V1["title_option2"]?>&nbsp;&nbsp;&nbsp;<?php echo $TPL_V1["modelstock_"]?></strong></p>
					<p><strong>KRW<?php echo number_format($TPL_V1["wd_marketprice"])?></strong> <?php if($TPL_V1["balance"]<= 0){?><span class="soldout">SOLD OUT</span><?php }?></p>
					<p>FRAME WIDTH : <?php echo $TPL_V1["wd_fullsiz"]?>mm&nbsp;&nbsp;&nbsp;SIDE : <?php echo $TPL_V1["wd_bridgesiz"]?>mm</p>
					<p>LENS WIDTH : <?php echo $TPL_V1["wd_widthsiz"]?>mm&nbsp;&nbsp;&nbsp;LENS HEIGHT : <?php echo $TPL_V1["wd_heightsiz"]?>mm</p>
					<p>MATERIAL : <?php echo $TPL_V1["quality"]?></p>
					<p><?php echo $TPL_V1["cnt_color"]?> COLOR</p>
					-->
				</div>	
			</div>
		</div>
	</div>

<?php }}?>
</div>


<?php $this->print_("footer",$TPL_SCP,1);?>