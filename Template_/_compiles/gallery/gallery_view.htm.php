<?php /* Template_ 2.2.8 2019/04/10 11:23:27 /free/home/sevenwatch/wondong/vsun_tr/data/skin/gallery/gallery_view.htm 000001003 */ 
$TPL_img_url_1=empty($TPL_VAR["img_url"])||!is_array($TPL_VAR["img_url"])?0:count($TPL_VAR["img_url"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div style="margin:0 auto;float:none;height:100%" class=" col-xs-11 col-sm-11 col-md-9 col-lg-9 ">
	<div class="title_top">
		<div style="float:left">CELEBRITY</div>
		<div style="float:right"></div>
	</div> 

	<div style="border-bottom:1px solid #ccc;padding-bottom:5px;"><?php echo $TPL_VAR["subject"]?> - <?php echo $TPL_VAR["goodsname"]?></div>
<?php if($TPL_img_url_1){foreach($TPL_VAR["img_url"] as $TPL_V1){?>
	<div style="text-align:center;margin:20px auto ;float:none;" class=" col-xs-12 col-sm-12 col-md-10 col-lg-10 ">
		<img src="http://112.175.245.35/GENE/bbs_ppl/img/<?php echo $TPL_V1?>" alt="" style="width:100%">
	</div>
<?php }}?>
</div>

<?php $this->print_("footer",$TPL_SCP,1);?>