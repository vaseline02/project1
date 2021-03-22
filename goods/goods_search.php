<?
include "../_header.php";

if($_GET[sword]){
	$qry = "
	select sd.*
	,sm.wd_marketprice
	,tb.wd_img_folder
	,tb.engName
	,i.wd_img_cate_folder
	,(select count(1) from wd_size_data where modelstock_ like concat(substring_index(sd.modelstock_,'-', 1 ),'%')  ) as cnt_color
	from wd_size_data sd
	join wd_sprice_modellist sm on sd.modelstock_ = sm.wd_model_name
	join itemCategory i on sd.category_id = i.id
	join tBrandName tb on sd.brand_id = tb.id and tb.deleted='default' and wd_img_folder!=''
	where sd.modelstock_ like '%".trim($_GET[sword])."%'
	and sd.sync_tricyclo = 'y'

	order by sd.modelstock_
	";
/*
	and sd.modelstock_ not like 'SAVOIR1%'
	and sd.modelstock_ not in('SAVOIR2-01','SAVOIR2-01B','SAVOIR2-02','SAVOIR2-03','SAVOIR2-05')
	and sd.modelstock_ not like 'VEUX1%'
	and sd.modelstock_ not like 'VEUX2%'
	and sd.modelstock_ not like 'THURSDAYPARTY%'
	and sd.modelstock_ not like 'LALENTA%'
	and sd.modelstock_ not like 'LAXV%'
	and sd.modelstock_ not like '%RAF1001%'
	and sd.modelstock_ not like '%RAF1002%'
	and sd.modelstock_ not like '%RAF1003%'
*/
	
	$res = $db->query($qry);
	while($row = $db->fetch($res)){
		$row['img_url']= "http://www.xgm1.com/vsun/".$row['wd_img_cate_folder']."/front/".$row['wd_img_name'].".jpg";
		$img_data = @getimagesize($row['img_url']);

		if( is_array($img_data) ){
			$loop[] = $row;
		}
	}

	$tpl->assign(array(
				'loop' => $loop
				));
}
$tpl->print_('tpl');
?>