<?php /* Template_ 2.2.8 2019/05/25 18:45:47 /free/home/sevenwatch/wondong/ukk/data/skin/gallery/gallery_list.htm 000002088 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?
$cate_en = array(
"¿¬¿¹ÀÎ Âø¿ë"=>"ENTERTAINER"
,"TV¹æ¼Û"=>"TV SHOW"
,"·¹ÀÌ½Ì¸ðµ¨"=>"RACING MODEL"	
,"ÆÐ¼Ç¸ðµ¨"=>"FASHION MODEL"	
,"´º½º±â»ç"=>"ARTICLE"	
,"SNS"=>"SNS"
,"°í°´Âø¿ë"=>"CUSTOMER"
);
$i=1;
?>
<div style="margin:0 auto;float:none;height:100%" class="col-xs-11 col-sm-11 col-md-9 col-lg-9 ">
	<div class="title_top">
		<div style="float:left">CELEBRITY</div>
			<div style="display:inline;float:right;padding-right:8px">

				<a href="#1" onclick="submit_list('');">ALL</a> |
				<?
					foreach($cate_en as $k => $cv){

					if($_REQUEST['cate'] == $cv) $cv_style = "style='font-size:13px;font-weight:bold'";
					else $cv_style ="";
				?>
					<a href="#1" onclick="submit_list('<?=$k?>');"><span <?=$cv_style?>><?=$cv?></span></a> 
				<?
						if( $i != count($cate_en)) echo " | ";
						$i++;
					}
				?>
			</div>
	</div> 
	<div>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<div class="gal_img_wrap col-xs-12 col-sm-6 col-md-6 col-lg-3 ">
			<p><a href="../gallery/gallery_view.php?sn=<?php echo $TPL_V1["sn"]?>"><img src="<?php echo $TPL_V1["img_url"]?>" alt="" style="width:100%;"></a></p>
			<p>[<?php echo $TPL_V1["goodsname"]?>]</p>
			<p><?php echo $TPL_V1["cate_name"]?> : <?php echo $TPL_V1["subject"]?></p>
		</div>
<?php }}?>
	</div>
	<div style="clear:both"></div>

	<div style="margin:50px 0px;text-align:center;width:100%"><?php echo $TPL_VAR["pg"]->page['navi']?></div>

	<form >
	<div style="float:right">
		<input type="text" name="sword" value="<?php echo $_GET["sword"]?>"> <button type="submit">search</button>
	</div>
	</form>
</div>
<script type="text/javascript">
	function submit_list(cate){
		location.href='gallery_list.php?cate='+cate;
	}	
</script>
<?php $this->print_("footer",$TPL_SCP,1);?>