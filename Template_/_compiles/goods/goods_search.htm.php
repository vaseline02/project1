<?php /* Template_ 2.2.8 2019/05/25 18:45:47 /free/home/sevenwatch/wondong/ukk/data/skin/goods/goods_search.htm 000002463 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<style type="text/css">

</style>

<div style="margin:0 auto;float:none;height:100%" class="col-xs-11 col-sm-11 col-md-9 col-lg-9 ">

	<div class="title_top">SEARCH</div> 
	<form action="goods_search.php" method="get">
	<div class="search_wrap">
		<div class="col-xs-4 col-sm-3 col-md-3 col-lg-2">Model Name</div>
		<div class="col-xs-7 col-sm-6 col-md-6 col-lg-7"><input type="text" name="sword" style="width:98%" value="<?php echo $_GET["sword"]?>"></div>
		<div class="col-xs-11 col-sm-3 col-md-2 col-lg-2"><button type="submit" style="width:100%">SEARCH</button></div>
	</div>
	</form>
	<div>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<div class="product_layer col-xs-12 col-sm-12 col-md-4 col-lg-4">
			<div class="product_layer_inner">
				<div><a href="../goods/goods_view.php?goodsno=<?php echo $TPL_V1["no"]?>"><img src="<?php echo $TPL_V1["img_url"]?>" alt="" style="width:70%"></a></div>
				<div class="list_model_info">
					<div style="text-align:<?php if($TPL_VAR["is_mobile"]){?>center<?php }else{?>center<?php }?>;margin:auto;width:<?php if($TPL_VAR["is_mobile"]){?>95%<?php }else{?>70%<?php }?>">
						<p><?php echo $TPL_V1["modelstock_"]?></p>
						<p><?php if($TPL_V1["balance"]<= 0){?><div class="discontinue">Discontinue</div><?php }else{?>KRW <?php echo number_format($TPL_V1["wd_marketprice"])?><?php }?></p>
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
</div>

<?php $this->print_("footer",$TPL_SCP,1);?>